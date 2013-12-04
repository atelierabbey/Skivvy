<?php echo '<!DOCTYPE html>'; // HTML5 Doctype
	// HTML Tag
		$htmltag = '<html dir="ltr" lang="en-US" class="'; 
			if (function_exists('css_browser_selector')){ $htmltag .= css_browser_selector() . ' '; }
			if (function_exists('skinfo')){ $htmltag .= skinfo('Version'); }
		$htmltag .= '">'; echo $htmltag;
	
	// Meta data
		echo '<meta charset=utf-8>';
		echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
		echo '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';
		# echo '<meta name="description" content="' . '' .'">';

	// Site Title
		echo '<title>' . wp_title( '|', FALSE, 'right' ) . '</title>';
    
    // Shortcut Icon - Favicon    
		$iconversion = 1;
		echo '<link rel="shortcut icon" type="image/png" href="' . get_template_directory_uri() . '/img/favicon.png?v=' . $iconversion . '" />';

	// RSS Link
		echo '<link rel="alternate" type="application/rss+xml" title="RSS 2.0 Feed" href="' . get_bloginfo('rss2_url') . '" />';

	// Standard Stylesheets
		echo '<link rel="stylesheet" href="' . get_template_directory_uri() . '/css/func.css?ver=1" type="text/css" />';
		echo '<link rel="stylesheet" href="' . get_template_directory_uri() . '/style.css?ver=1" type="text/css" />';

	// HTML5 Shiv for less than IE9
		echo '<!--[if lt IE 9]><script src="' . get_template_directory_uri() . '/js/html5.js"></script><![endif]-->';
		
	// Load Jquery
		wp_enqueue_script("jquery");
	
	// wp_head - Obviously... don't touch....
		wp_head();
	
	// Body tag
		echo '<body id="page-' . get_the_ID();  body_class(); echo '>';
		echo '<div id="preloader"></div>';
?>

<div class="wrapper">

<?php echo // Header Chunk

	'<header>'.
	
			// Logo Chunk
			'<div class="logo">' .
				'<a href="' . home_url( '/' ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">' .
					'<img src="' . bloginfo('template_url') . '/img/logo.png" alt="Logo">' .
				'</a>' .
			'</div>' .
		
			// Main Nav Chunk
			'<nav class="access">' .
					wp_nav_menu( array(
						'theme_location'  => 'main',
						'menu'            => '',
						'container'       => FALSE,
						'container_class' => '',
						'container_id'    => '',
						'menu_class'      => '',
						'menu_id'         => '',
						'echo'            => FALSE,
						'fallback_cb'     => 'wp_page_menu',
						'before'          => '',
						'after'           => '',
						'link_before'     => '',
						'link_after'      => '',
						'items_wrap'      => '<ul>%3$s</ul>',
						'depth'           => 3, // 0 = all. Default, -1 = displays links at any depth and arranges them in a single, flat list.
						'walker'          => ''
					)) . 
				'</nav>' .
			
	'</header>' .
	'<div class="clear"></div>';
?>