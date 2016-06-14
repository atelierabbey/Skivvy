<!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php html_classes(); ?>">
<head><?php wp_head(); ?></head>
<body id="page-<?php the_ID(); ?>" <?php body_class(); ?>>
<?php
$output .= '<header role="banner" id="header">';
	$output .= '<div class="page-wrapper">';

			// Logo
				$output .= get_skivvy_logo( array(
					'class' => 'alignleft',
				));

			// Mobile Toggle
				$output .= '<button id="mobile-toggle" class="alignright dont-print"></button>';

			// Main Menu
				$output .= '<nav role="navigation" class="dont-print">';
					$output .= wp_nav_menu( array(
							'echo'            => false,
							'container'       => false,
							'theme_location'  => 'main',
							'menu_id'         => 'main-menu',
							'menu_class'      => 'clearfix nobull dropdown animated flyoutleft justified', // Menu functionality classes
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
							'menu_id'         => 'mobile-nav',
							'menu_class'      => 'nobull textcenter clearfix',
							'items_wrap'      => '<ul style="display:none;" id="%1$s" class="%2$s">%3$s</ul>',
							'depth'           => -1,
					));
				$output .= '</nav>';


	$output .= '</div>';
$output .= '</header>';
echo $output;
?>