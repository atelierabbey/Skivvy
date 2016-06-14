<?php # 10Nov15
//		Menu
//		WP_HEAD()
//		Javascripts & Styles
//		HTML Classes
//		Body Classes
//		WP_FOOT()
//		Widgets Area
//		MIME Types
//		Theme Setup




// Menus
	register_nav_menus( array(
		'main' => __( 'Main Menu' ),
		'mobile' =>  __( 'Mobile Menu' ),
		'sitemap' => __( 'Site Map' ),
	) );



// WP_HEAD()
	function skivvy_head() {

		$head_meta = array(
			// Standard Meta
				'<meta charset="'. get_bloginfo( 'charset' ). '">', // HTML character set encoding. NOTE - Needs to be close to the opening HEAD tag
				'<meta name="description" content="' . get_bloginfo( 'description', 'display' ) . '">'. // Meta description, important for SEO. Defaults to blog's description.

			// Mobile Meta
				'<meta content="width=device-width, initial-scale=1.0" name="viewport">', // Sets default width and scale to be dependent on the device.
			#	'<meta name="format-detection" content="telephone=no"><meta http-equiv="x-rim-auto-match" content="none">', // Don't autodetect phonenumbers and create links in iphone safari & blackberry

			// IE specific
				'<!--[if IE]><meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible"><![endif]-->', // Force IE to render most recent engine for installed browser. And enable Chrome Frame
				'<!--[if lt IE 9]><script src="' . get_template_directory_uri() . '/js/html5.js"></script><![endif]-->', // HTML5 Shiv for < IE9

			// WordPress items
			#	'<link rel="profile" href="http://gmpg.org/xfn/11">',

			// Google fonts
				"<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>",


			// BROWSER COLORS - https://developers.google.com/web/fundamentals/design-and-ui/browser-customization/theme-color?hl=en
				'<meta name="theme-color" content="#4285f4">', // Chrome, Firefox OS and Opera
				'<meta name="msapplication-navbutton-color" content="#4285f4">',  // Windows Phone
			#	'<meta name="apple-mobile-web-app-capable" content="yes">', // iOS Safari
			#	'<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">', // iOS Safari

		);

		// Prevent Duplicate Content - Source: http://perishablepress.com/seo-experiment-let-google-sort-it-out/
			if ((is_home() && ($paged < 2 )) || is_single() || is_page() || is_category()) {
				$head_meta[] = '<meta name="robots" content="index,archive,follow" />';
			} else {
				$head_meta[] = '<meta name="robots" content="noindex,noarchive,follow" />';
			}

		// Echo each with a linebreak every line
		foreach ($head_meta as $meta) {
			echo $meta. "\r\n";
		}



	} add_action( 'wp_head', 'skivvy_head', 0 );
	  add_action( 'wp_head', 'wp_site_icon');



// Javascripts & Styles
	function skivvy_scriptnstyle_enqueuer() {

		// SCRIPTS - wp_register_script( $handle, $src, $deps, $ver, $in_footer );
			wp_register_script( 'skivvy-custom', get_stylesheet_directory_uri(). '/js/custom.js', array('jquery'), '1', true );

		// STYLES - wp_register_style( $handle, $src, $deps, $ver, $media );
			wp_register_style( 'skivvy-func',  get_template_directory_uri() . '/css/func.css', false, '4May15', 'all');
			wp_register_style( 'skivvy-print', get_template_directory_uri() . '/css/print.css', array('skivvy-func'), '4May15', 'print');
			wp_register_style( 'skivvy-style', get_template_directory_uri() . '/style.css', array('skivvy-func'), '1', 'all');

		// ENQUEUE
			// NOTE: Comment out here if undesired.
				wp_enqueue_script('skivvy-custom');
				wp_enqueue_style ('skivvy-print');
				wp_enqueue_style ('skivvy-style');

	} add_action('wp_enqueue_scripts', 'skivvy_scriptnstyle_enqueuer');



// HTML Classes 
	function skivvy_html_classes( $classes ) {

		// Adds .autohide-adminbar when logged in
			if ( is_user_logged_in() ) {
				#	$classes[] = 'autohide-adminbar';
			}

		// break query string into a classes
		$query = $_SERVER["QUERY_STRING"];
		if ( $query != '' ) {
			$classes = array_merge( $classes, explode( '&', str_replace( '=' , '_' , $query ) ) );
		}


		// Adds Skivvy version
			if (function_exists('skinfo')){
				$classes[] = skinfo('Version');
			}

			return $classes;

	} add_filter('html_classes','skivvy_html_classes');



// Body Classes
	function skivvy_body_classes($classes) {
		global $wpdb, $post;

		// .subpage for all non-front_page
			if ( ! is_front_page() ) {
				$classes[] = 'subpage';
			}

		// page classes
		if (is_page()) {

			// .section-{$parentpage} - Parent Page Post class -- Add the top level parent page to the body class
				if ($post->post_parent) {
					$parent  = end(get_post_ancestors($current_page_id));
				} else {
					$parent = $post->ID;
				}
				$post_data = get_post($parent, ARRAY_A);
				$classes[] = 'section-' . $post_data['post_name'];

		}

		return $classes;

	} add_filter('body_class','skivvy_body_classes');



// WP_FOOT()
	function skivvy_foot() {

	} add_action( 'wp_footer', 'skivvy_foot' );



// Widget Areas
	/*
	function skivvy_register_sidebars() {
		register_sidebar( array(
			'name' => __( 'Sidebar name', 'skivvy' ),
			'id' => 'primary-widget-area',
			'description' => 'The primary widget area',
			'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
			'after_widget' => '</li>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	} add_action( 'widgets_init', 'skivvy_register_sidebars' ); //*/



// MIME Types
	function skivvy_add_mime_types($mimes){
		// Added wp-upload MIME types - http://skivvy.atelierabbey.org/filters/mime-types/
		return array_merge($mimes,array (
			'swf' => 'application/x-shockwave-flash',
			'eps' => 'application/postscript',
			'svg' => 'image/svg+xml',
		));
	} add_filter('upload_mimes','skivvy_add_mime_types');



// Theme Setup
	function skivvy_setup() {

		// WP-Theme Support - http://codex.wordpress.org/Function_Reference/add_theme_support
				add_theme_support( 'custom-logo', array(
				#	'height'      => 175,
				#	'width'       => 400,
				#	'flex-height' => true,
				#	'flex-width'  => true,
				#	'header-text' => array( 'site-title', 'site-description' ),
				) ); //*/

				/*add_theme_support( 'custom-header', array(
				#	'default-image'          => '',
				#	'width'                  => 0,
				#	'height'                 => 0,
				#	'flex-height'            => false,
				#	'flex-width'             => false,
				#	'uploads'                => true,
				#	'random-default'         => false,
				#	'header-text'            => true,
				#	'default-text-color'     => '',
				#	'wp-head-callback'       => '',
				#	'admin-head-callback'    => '',
				#	'admin-preview-callback' => '',
				) ); //*/
				add_theme_support( 'title-tag' );
				add_theme_support( 'post-thumbnails' );
				add_theme_support( 'html5', array('search-form','comment-form','comment-list','gallery','caption','widgets') );
				add_theme_support( 'automatic-feed-links' );
			#	add_theme_support( 'post-formats', array('aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video') );
			#	add_theme_support( 'woocommerce' );



		// Add Widget/sidebar functionality
			#	add_filter('widget_text', 'do_shortcode'); // Widget Support - Shortcodes
			#	add_filter('widget_text', array( $wp_embed, 'run_shortcode' ), 8 );
			#	add_filter('widget_text', array( $wp_embed, 'autoembed'), 8 ); // Widget Support - oEmbed & oEmbed 2

	} add_action( 'after_setup_theme', 'skivvy_setup' );

