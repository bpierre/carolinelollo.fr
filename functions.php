<?php

// Remove meta generator
remove_action('wp_head', 'wp_generator');

//	Attachment auto display by @bpierre
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


	// Reset gallery CSS
	add_filter('gallery_style',
	create_function(
		'$css',
		'return preg_replace("#<style type=\'text/css\'>(.*?)</style>#s", "", $css);'
		)
	);

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
	if ( function_exists('register_sidebar') )
	register_sidebar(array(
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
	));

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
