<?php #16Jun14

	include 'inc/skivvy_register.php'; // Registry for theme specific posttypes, taxonomy, menus, widget areas, scripts, styles, etc.
	include 'inc/skivvy_simple.php'; // Various areas of clean up code, admin area, and various other functions of unneeded defaults
	include 'inc/admin/skivvy_branding.php'; // Custom developer branding
	include 'inc/lib/skivvy_shortcodes.php'; // Shortcodes
	include 'inc/lib/skivvy_func_user.php'; // Usable Functions 
#	include 'inc/lib/skivvy_func_auto.php'; // Auto Functions 

// Added wp-upload MIME types  - https://www.sitepoint.com/web-foundations/mime-types-complete-list/
function skivvy_add_custom_mime_types($mimes){
	return array_merge($mimes,array (
		'swf' => 'application/x-shockwave-flash',
		'svg' => 'image/svg+xml'
	));
} add_filter('upload_mimes','skivvy_add_custom_mime_types');


// Basic Setup
function skivvy_setup() {

	// WP-Theme Support - http://codex.wordpress.org/Function_Reference/add_theme_support
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'html5', array('comment-list','search-form','comment-form','gallery') );
		#	add_theme_support( 'post-formats', array('aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video') );
		#	add_theme_support( 'automatic-feed-links' );

	// Customizable options that run at Theme activation. in inc/skivvy_simple.php
		#	skivvy_autooptions();

	// Add Widget/sidebar functionality
		#	add_filter('widget_text', 'do_shortcode'); // Widget Support - Shortcodes 
		#	add_filter('widget_text', array( $wp_embed, 'run_shortcode' ), 8 );
		#	add_filter('widget_text', array( $wp_embed, 'autoembed'), 8 ); // Widget Support - oEmbed & oEmbed 2

	// Framework for global langauge set up
		/*
			$lang_location = get_template_directory_uri() . '/inc';
			$locale_file = $lang_location . '/' . get_locale() . '.php';
			load_theme_textdomain( 'skivvy', $lang_location );
			if ( is_readable( $locale_file )){ require_once( $locale_file ); }
		//*/
} add_action( 'after_setup_theme', 'skivvy_setup' ); ?>