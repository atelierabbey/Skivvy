<?php #16Mar15

	include 'inc/skivvy_register.php'; // Registry for theme specific posttypes, taxonomy, menus, widget areas, scripts, styles, etc.
	include 'inc/skivvy_simple.php'; // Various areas of clean up code, admin area, and various other functions of unneeded defaults
	include 'lib/admin/index.php'; // Admin functions
	include 'lib/skivvy_shortcodes.php'; // Shortcodes
	include 'lib/skivvy_func_user.php'; // Usable Functions
	include 'lib/skivvy_func_auto.php'; // Auto Functions

	// Basic Setup
		function skivvy_setup() {

			// WP-Theme Support - http://codex.wordpress.org/Function_Reference/add_theme_support
					add_theme_support( 'post-thumbnails' );
					add_theme_support( 'html5', array('comment-list','search-form','comment-form','gallery') );
				#	add_theme_support( 'post-formats', array('aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video') );
				#	add_theme_support( 'automatic-feed-links' );
				#	add_theme_support( 'woocommerce' );

			// Customizable options that run at Theme activation. in inc/skivvy_simple.php
				#	skivvy_autooptions();

			// Add Widget/sidebar functionality
				#	add_filter('widget_text', 'do_shortcode'); // Widget Support - Shortcodes
				#	add_filter('widget_text', array( $wp_embed, 'run_shortcode' ), 8 );
				#	add_filter('widget_text', array( $wp_embed, 'autoembed'), 8 ); // Widget Support - oEmbed & oEmbed 2

		} add_action( 'after_setup_theme', 'skivvy_setup' );

?>