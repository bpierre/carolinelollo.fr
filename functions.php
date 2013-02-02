<?php

// Remove meta generator
remove_action('wp_head', 'wp_generator');

// Attachment auto display by @bpierre
function get_post_images($post) {
	$args = array(
		'post_type' => 'attachment', // Images attached to the post
		'numberposts' => -1, // Get all attachments
		'post_status' => null, // I don't care about status for gallery images
		'post_parent' => $post->ID, // The parent post
		'post_mime_type' => 'image', // The attachment type
		'order' => 'ASC',
		'orderby' => 'menu_order ID', // Order by menu_order then by ID
	);
	return get_posts($args);
}

// Gallery shortcode
remove_shortcode('gallery');
add_shortcode('gallery', function($attr) use($post, $wp_locale) {

	// from wp-includes/media.php

	static $instance = 0;
	$instance++;

	$output = '';

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) )
			$attr['orderby'] = 'post__in';
		$attr['include'] = $attr['ids'];
	}

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => 3,
		'size'       => 'large',
		'include'    => '',
		'exclude'    => ''
	), $attr));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$columns = intval($columns);
	$selector = "gallery-{$instance}";

	$size_class = sanitize_html_class( $size );

	// Unused
	$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";

	$i = 1;
	$output .= '<div class="gallery-row">';
	foreach ( $attachments as $id => $attachment ) {
		$output .= wp_get_attachment_image($id, 'large');
		if ($i % $columns === 0 && $i !== count($attachments)) {
			$output .= '</div><div class="gallery-row">';
		}
		$i++;
	}
	$output .= '</div>';

	// An container is necessary, otherwise WP will add a <p>...
	return '<div>'.$output.'</div>';
});

// Remove the gallery shortcode from the content
add_filter('the_content', function($content) {

	if (!is_single()) return $content; // Posts only

	$gallery_regex = '/\[gallery[^\]]*\]/';

	$output = '';

	if (preg_match($gallery_regex, $content, $galleries)) {
		$output .= do_shortcode($galleries[0]);
	}

	$output .= '<div id="desc">'."\n\n";
	$output .= preg_replace($gallery_regex, '', $content)."\n\n";
	// $output .= $content."\n";
	$output .= '</div>'."\n\n";

	return $output;
}, 0 );

// Utility function for WP Galleries < 3.5 support
function has_gallery_shortcode(&$post) {
	return preg_match('/\[gallery[^\]]*\]/', $post->post_content);
}

// post thumbnail support
add_theme_support( 'post-thumbnails' );


// category id in body and post class
function category_id_class($classes) {
	global $post;
	foreach((get_the_category($post->ID)) as $category)
		$classes [] = 'cat-' . $category->cat_ID . '-id';
		return $classes;
}
add_filter('post_class', 'category_id_class');
add_filter('body_class', 'category_id_class');

// widgets
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
	));
}

// Customizable menu
function register_my_menus() {
  register_nav_menus(
	array('header-menu' => __( 'Header Menu' ) )
  );
}

// /project/99 => /?p=99
add_filter('rewrite_rules_array', function($rules) use($wp_rewrite) {
	$new_rules = array('^project\/(\d+)?$' => 'index.php?post_redirect=$matches[1]');
	return $new_rules + $rules;
});
add_filter('query_vars', function($qvars) {
	$qvars[] = 'post_redirect';
	return $qvars;
});
add_action('template_redirect', function(){
	if (get_query_var('post_redirect')) {
		wp_redirect(home_url('/?p='.get_query_var('post_redirect')), 301);
		exit;
	}
});
