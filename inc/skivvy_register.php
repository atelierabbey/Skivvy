<?php

// http://generatewp.com
//		Menu
//		Javascripts & Styles
//		Widgets Area
//		MIME Types
//		Post Types




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
			wp_register_style( 'skivvy-func',  get_stylesheet_directory_uri() . '/css/func.css', false, '4May15', 'all');
			wp_register_style( 'skivvy-print',  get_stylesheet_directory_uri() . '/css/print.css', array('skivvy-func'), '4May15', 'print');
			wp_register_style( 'skivvy-icons', get_stylesheet_directory_uri() . '/css/font-awesome.min.css', array('skivvy-func'), '4.3.0', 'all');
			wp_register_style( 'skivvy-font', 'http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic', array('skivvy-func'), '1', 'all');
			wp_register_style( 'skivvy-style', get_stylesheet_directory_uri() . '/style.css', array('skivvy-func'), '1', 'all');

		// ENQUEUE | NOTE: Comment out here if undesired.
			wp_enqueue_script('skivvy-custom');
			wp_enqueue_style('skivvy-print');
			wp_enqueue_style('skivvy-icons');
			wp_enqueue_style('skivvy-font');
			wp_enqueue_style('skivvy-style');


	} add_action('wp_enqueue_scripts', 'skivvy_scriptnstyle_enqueuer');




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







?>