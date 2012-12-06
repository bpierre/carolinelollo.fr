<?php get_header(); ?>
	<div id="content">
		<?php if ( ! dynamic_sidebar( 'Alert' ) ) : ?>
			<!--Wigitized 'Alert' for the home page -->
		<?php endif ?>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="thumb">
				<a href="<?php
					$external_meta = get_post_meta($post->ID, 'external', TRUE);
					echo ($external_meta)? $external_meta : get_permalink();
					?>">
					<?php if ( has_post_thumbnail() ) { 
					  the_post_thumbnail('thumbnail');} ?>
				</a>
			</div><!--.single-post-->
		<?php endwhile; else: ?>
				<p>There has been an error.</p>
		<?php endif; ?>
	</div><!--#content-->

	<?php 	if ( is_home() ) {
		// Gifsy Kings integration (tumblr widget)
		get_sidebar('left');
	}?>


<?php get_footer(); ?>
