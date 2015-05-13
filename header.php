<!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php if (function_exists('html_classes')){ html_classes(); } ?>">
<head><?php

	echo (
			'<meta charset="'. get_bloginfo( 'charset' ).'">'.
			'<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">'. // Force IE to render most recent engine for installed browser. And enable Chrome Frame
			'<meta content="width=device-width, initial-scale=1.0" name="viewport">'. // Sets default width and scale to be dependent on the device.
		#	'<meta name="format-detection" content="telephone=no"><meta http-equiv="x-rim-auto-match" content="none">'. // Don't autodetect phonenumbers and create links in iphone safari & blackberry
			'<meta content="' . get_bloginfo( 'description', 'display' ) . '" name="description">'. // Meta description, important for SEO. Defaults to blog's description.
			'<link rel="shortcut icon" type="image/png" href="' . get_stylesheet_directory_uri() . '/img/favicon.png?v=1">'.
		#	'<link rel="apple-touch-icon" href="' . get_stylesheet_directory_uri() . '/apple-touch-icon.png">'.

			'<!--[if lt IE 9]><script src="' . get_template_directory_uri() . '/js/html5.js"></script><![endif]-->'// HTML5 Shiv for < IE9

	);

	wp_head();
?></head>
<body id="page-<?php echo get_the_ID(); ?>" <?php body_class(); ?>>
<header role="banner" id="header">
	<div class="page-wrapper">
		<?php

			// Logo
				echo (
					'<a id="logo" class="alignleft" href="' . home_url( '/' ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">' .
						'<img src="' . get_stylesheet_directory_uri() . '/img/logo.png" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '">' .
					'</a>'
				);

			// Main Menu
				wp_nav_menu( array(
					'items_wrap'      => '<nav role="navigation" id="nav-main" class="access animated dropdown alignright"><ul class="nobull main-menu">%3$s</ul></nav>',
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
					'depth'           => 3, // 0 = all. Default, -1 = displays links at any depth and arranges them in a single, flat list.
					'walker'          => ''
				));

			// Mobile Menu
				echo (
						'<button id="toggle-mobile" class="alignright"></button>'.
						'<div class="clear"></div>'.
						wp_nav_menu( array(
							'items_wrap'      => '<nav role="navigation" id="nav-mobile" style="display:none;"><ul class="nobull textcenter">%3$s</ul></nav>',
							'theme_location'  => 'mobile',
							'container'       => FALSE,
							'echo'            => FALSE,
							'fallback_cb'     => 'main',
							'depth'           => -1
						))
					);
		?>
		<div class="clear"></div>
	</div>
</header>
