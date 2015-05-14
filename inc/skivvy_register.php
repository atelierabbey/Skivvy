<?php
// http://generatewp.com
//		Menu
//		Javascripts & Styles
//		Widgets Area
//		MIME Types
//		Post Types
//		Theme Setup




//	REGISTER - Menus
	register_nav_menus( array(
		'main' => __( 'Main Menu' ),
		'mobile' =>  __( 'Mobile Menu' ),
		'sitemap' => __( 'Site Map' ),
	) );




//	REGISTER - Javascripts & Styles
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


//  WP_HEAD()
	function skivvy_head() {
		echo (
			'<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">' // Force IE to render most recent engine for installed browser. And enable Chrome Frame
		#	'<meta name="format-detection" content="telephone=no"><meta http-equiv="x-rim-auto-match" content="none">'. // Don't autodetect phonenumbers and create links in iphone safari & blackberry

		#	.'<link rel="profile" href="http://gmpg.org/xfn/11">'

			.'<!--[if lt IE 9]><script src="' . get_template_directory_uri() . '/js/html5.js"></script><![endif]-->' // HTML5 Shiv for < IE9

		);
	} add_action( 'wp_head', 'skivvy_head' );


//  WP_FOOT()
	function skivvy_foot() {
		// includes Analytics.php code
			get_template_part( '/js/analytics' );
	} add_action( 'wp_footer', 'skivvy_foot' );



// REGISTER - Widget Areas
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




// REGISTER - MIME types
		// Added wp-upload MIME types  - https://www.sitepoint.com/web-foundations/mime-types-complete-list/
	function skivvy_add_custom_mime_types($mimes){
		return array_merge($mimes,array (
			'swf' => 'application/x-shockwave-flash',
			'svg' => 'image/svg+xml'
		));
	} add_filter('upload_mimes','skivvy_add_custom_mime_types');




//  REGISTER - Post Types
//		http://justintadlock.com/archives/2013/09/13/register-post-type-cheat-sheet
/*
	function register_skivvy_posttype() {

	} add_action( 'init', 'register_skivvy_posttype' ); //*/





// Basic Theme Setup Setup
	function skivvy_setup() {

		// WP-Theme Support - http://codex.wordpress.org/Function_Reference/add_theme_support
				add_theme_support( 'title-tag' );
				add_theme_support( 'post-thumbnails' );
				add_theme_support( 'html5', array('search-form','comment-form','comment-list','gallery','caption','widgets') );
				add_theme_support( 'automatic-feed-links' );
			#	add_theme_support( 'post-formats', array('aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video') );
			#	add_theme_support( 'woocommerce' );

		// Customizable options that run at Theme activation. in inc/skivvy_simple.php
			#	skivvy_autooptions();

		// Add Widget/sidebar functionality
			#	add_filter('widget_text', 'do_shortcode'); // Widget Support - Shortcodes
			#	add_filter('widget_text', array( $wp_embed, 'run_shortcode' ), 8 );
			#	add_filter('widget_text', array( $wp_embed, 'autoembed'), 8 ); // Widget Support - oEmbed & oEmbed 2

	} add_action( 'after_setup_theme', 'skivvy_setup' );


?>