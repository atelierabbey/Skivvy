<!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php if (function_exists('html_classes')){ html_classes(); } ?>">
<head><?php

	echo (
			'<meta charset="'. get_bloginfo( 'charset' ).'">'.
			'<meta content="' . get_bloginfo( 'description', 'display' ) . '" name="description">'. // Meta description, important for SEO. Defaults to blog's description.
			

		// Paste Google Fonts here
			"<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>"

	);

	wp_head();
?></head>
<body id="page-<?php the_ID(); ?>" <?php body_class(); ?>>
<?php
$output .= '<header role="banner" id="header">';
	$output .= '<div class="page-wrapper">'

			// Logo
				$output .= '<a id="logo" class="alignleft" href="' . home_url( '/' ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">';
					$output .= '<img src="' . get_stylesheet_directory_uri() . '/img/logo.png" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '">';
				$output .= '</a>';

			// Mobile Toggle
				$output .= '<button id="mobile-toggle" class="alignright dont-print"></button>';

			// Main Menu
				$output .= '<nav role="navigation" class="dont-print">';
					$output .= wp_nav_menu( array(
							'menu_class'      => 'alignright nobull dropdown animated flyoutleft', // Menu functionality classes
							'menu_id'         => 'main-menu',
							'theme_location'  => 'main',
							'container'       => false,
							'echo'            => false,
							'fallback_cb'     => false,
							'depth'           => 3, // 0 = all. Default, -1 = displays links at any depth and arranges them in a single, flat list.
							'walker'          => new skivvy_walker_main

					));

					$output .= '<div class="clear"></div>';

					// Mobile Menu
					$output .= wp_nav_menu( array(
							'container'       => false,
							'menu_class'      => 'nobull textcenter clearfix',
							'menu_id'         => 'mobile-nav',
							'items_wrap'      => '<ul style="display:none;" id="%1$s" class="%2$s">%3$s</ul>',
							'theme_location'  => 'mobile',
							'depth'           => -1,
							'echo'            => false
					));
				$output .= '</nav>';


	$output .= '</div>';
$output .= '</header>';
echo $output;
?>