<!DOCTYPE html><html dir="ltr" lang="en-US" class="<?php if (function_exists('html_classes')){ html_classes(); } ?>"><head><?php
	// Meta data
		echo '<meta charset="utf-8">';
		echo '<meta content="' . get_bloginfo( 'description', 'display' ) . '" name="description">';
		echo '<meta content="width=device-width, initial-scale=1.0" name="viewport">';
		echo '<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">';
		echo '<meta name="format-detection" content="telephone=no"><meta http-equiv="x-rim-auto-match" content="none">'; // Don't autodetect phonenumbers and create links in iphone safari & blackberry

	// Site Title
		echo '<title>' . wp_title( '|', FALSE, 'right' ) . '</title>';

	// Shortcut Icon - Favicon
		echo '<link rel="shortcut icon" type="image/png" href="' . get_template_directory_uri() . '/img/favicon.png?v=1">';

	// RSS Link
		#echo '<link rel="alternate" type="application/rss+xml" title="RSS 2.0 Feed" href="' . get_bloginfo('rss2_url') . '">';

	// Standard Stylesheets
		echo '<link rel="stylesheet" href="' . get_template_directory_uri() . '/css/func.css?ver=1" type="text/css">';
		echo '<link rel="stylesheet" href="' . get_template_directory_uri() . '/style.css?ver=1" type="text/css">';

	// HTML5 Shiv for < IE9
		echo '<!--[if lt IE 9]><script src="' . get_template_directory_uri() . '/js/html5.js"></script><![endif]-->';

	// Load Jquery
		if ( ! wp_script_is( 'jquery' , 'queue' ) ) {
				wp_enqueue_script( 'jquery' );
		}
		

wp_head(); ?></head>
<body id="page-<?php echo get_the_ID(); ?>" <?php body_class(); ?>>
<div class="preloader"></div>
<header>
	<div class="page-wrapper">
		<div class="logo"><?php

			// LOGO
				echo 
				'<a href="' . home_url( '/' ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">' .
					'<img src="' . get_bloginfo('template_url') . '/img/logo.png" alt="Logo">' .
				'</a>';


		?></div>
		<nav class="access animated"><?php

			// MAIN NAV MENU
				wp_nav_menu( array(
					'theme_location'  => 'main',
					'menu'            => '',
					'container'       => FALSE,
					'container_class' => '',
					'container_id'    => '',
					'menu_class'      => '',
					'menu_id'         => '',
					'echo'            => TRUE,
					'fallback_cb'     => 'wp_page_menu',
					'before'          => '',
					'after'           => '',
					'link_before'     => '',
					'link_after'      => '',
					'items_wrap'      => '<ul>%3$s</ul>',
					'depth'           => 3, // 0 = all. Default, -1 = displays links at any depth and arranges them in a single, flat list.
					'walker'          => ''
				));

		?></nav>
		<div class="clear"></div>
	</div>
</header>
