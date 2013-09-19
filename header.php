<!DOCTYPE html>
<html <?php language_attributes(); ?>  <?php body_class(); ?>>
<head>
	<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '–', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' – ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );

	?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="generator" content="WordPress" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<meta name="viewport" content="width=device-width; initial-scale=1"/><?php /* Add "maximum-scale=1" to fix the Mobile Safari auto-zoom bug on orientation changes, but keep in mind that it will disable user-zooming completely. Bad for accessibility. */ ?>
	<link rel="index" title="<?php bloginfo( 'name' ); ?>" href="<?php echo get_option('home'); ?>/" />
	<link rel="icon" href="<?php bloginfo('template_url'); ?>/i/favicon.ico" type="image/x-icon" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'rss2_url' ); ?>" />
	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'atom_url' ); ?>" />
	<?php /* The HTML5 Shim is required for older browsers, mainly older versions IE */ ?>
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link  href="http://fonts.googleapis.com/css?family=Lato:100,100italic,300,300italic,400,400italic,700,700italic,900,900italic" rel="stylesheet" type="text/css" >
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<?php wp_head(); ?> <?php /* this is used by many Wordpress features and for plugins to work proporly */ ?>
</head>

<body>


<div id="main"><!-- this encompasses the entire Web site -->
	<div class="doubleHeader" id="header">
	<header>
		<?php 	if ( is_single() || is_page()) {
			echo '<a class="fat" href="';
			bloginfo('url');
			echo '">';
			echo 'back';
			echo '</a>';
		} else{
			echo '<h1>';
			echo '<a class="fat" href="';
			bloginfo('url');
			echo '">';
			bloginfo('name');
			echo '</a></h1>';
			wp_nav_menu();
		}?>

		<?php 	if ( is_single() || is_page() ) {
			edit_post_link("✎");
		}?>

	</header>
	</div><!--#header-->


	<div class="container">
