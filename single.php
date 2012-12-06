<?php get_header(); ?>
<div id="content">
	<div id="postnav">
		<?php previous_post_link('%link', '⇠'); ?>
		<?php next_post_link('%link', '⇢'); ?>
	</div>
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
			<article>
				<?php
					$images = get_post_images($post);
					foreach ($images as $image):
				?>
				<?php echo wp_get_attachment_image($image->ID, 'large'); ?>
				<?php endforeach; ?>
				<div id="desc">
					<?php the_content() ?>
				</div>
			</article>
		</div><!-- #post-## -->
	<?php endwhile; /* end loop */ ?>

</div><!--#content-->
<?php get_footer(); ?>