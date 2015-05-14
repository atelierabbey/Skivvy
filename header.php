<!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php if (function_exists('html_classes')){ html_classes(); } ?>">
<head><?php

	echo (
			'<meta charset="'. get_bloginfo( 'charset' ).'">'.
			'<meta content="' . get_bloginfo( 'description', 'display' ) . '" name="description">'. // Meta description, important for SEO. Defaults to blog's description.
			'<meta content="width=device-width, initial-scale=1.0" name="viewport">'. // Sets default width and scale to be dependent on the device.
			'<link rel="shortcut icon" type="image/png" href="' . get_stylesheet_directory_uri() . '/img/favicon.png?v=1">'.
		#	'<link rel="apple-touch-icon" href="' . get_stylesheet_directory_uri() . '/apple-touch-icon.png">'.


		// Paste Google Fonts here
			"<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>"

	);

	wp_head();
?></head>
<body id="page-<?php the_ID(); ?>" <?php body_class(); ?>>
<header role="banner" id="header">
	<div class="page-wrapper"><?php

		echo (
			// Logo
				'<a id="logo" class="alignleft" href="' . home_url( '/' ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">' .
					'<img src="' . get_stylesheet_directory_uri() . '/img/logo.png" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '">' .
				'</a>'.

			// Mobile Toggle
				'<button id="toggle-mobile" class="alignright"></button>'.

			// Main Menu
				wp_nav_menu( array(
					'container'       => 'nav',
					'container_class' => 'alignright',
					'container_id'    => 'nav-main',
					'menu_class'      => 'nobull dropdown animated flyoutright', // Menu functionality classes
					'menu_id'         => 'main-menu',
					'items_wrap'      => '<ul role="navigation" id="%1$s" class="%2$s">%3$s</ul>',
					'theme_location'  => 'main',
					'depth'           => 3, // 0 = all. Default, -1 = displays links at any depth and arranges them in a single, flat list.
					'echo'            => false
				)).

			'<div class="clear"></div>'.

			// Mobile Menu
				wp_nav_menu( array(
					'container'       => 'nav',
					'container_class' => 'hidden clearfix',
					'container_id'    => 'nav-mobile',
					'menu_class'      => 'nobull textcenter',
					'menu_id'         => '',
					'items_wrap'      => '<ul role="navigation" id="%1$s" class="%2$s">%3$s</ul>',
					'theme_location'  => 'mobile',
					'depth'           => -1,
					'echo'            => false
				))
		);

	?></div>
</header>