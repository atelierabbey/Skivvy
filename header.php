<!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php html_classes(); ?>">
<head><?php wp_head(); ?></head>
<body id="page-<?php the_ID(); ?>" <?php body_class(); ?>>
<?php

	$output .= '<header id="header">';
		$output .= '<div class="page-wrapper">';

			// Logo
				$output .= '<a id="logo" class="alignleft imgreplace" href="' . home_url( '/' ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">';
					$output .= get_bloginfo( 'name', 'display' );
					#$output .= '<img src="' . get_stylesheet_directory_uri() . '/img/logo.png" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '">';
				$output .= '</a>';

			// Mobile Toggle
				$output .= '<button id="mobile-toggle" class="alignright dont-print"></button>';

				$output .= '<nav id="main-nav" class="dont-print">';

					// Main Menu
						$output .= wp_nav_menu( array(
							'echo'            => false,
							'container'       => false,
							'theme_location'  => 'main',
							'menu_id'         => 'main-menu',
							'menu_class'      => 'clearfix nobull dropdown animated flyout-right justified', // Menu functionality classes
							'fallback_cb'     => false,
							'depth'           => 3, // 0 = all. Default, -1 = displays links at any depth and arranges them in a single, flat list.
							'walker'          => new skivvy_walker_main,
						));

					$output .= '<div class="clear"></div>';

					// Mobile Menu
						$output .= wp_nav_menu( array(
							'echo'            => false,
							'container'       => false,
							'theme_location'  => 'mobile',
							'menu_id'         => 'mobile-menu',
							'menu_class'      => 'nobull textcenter clearfix',
							'items_wrap'      => '<ul style="display:none;" id="%1$s" class="%2$s">%3$s</ul>',
							'depth'           => 2,
						));

				$output .= '</nav>';


		$output .= '</div>';
	$output .= '</header>';

echo $output;