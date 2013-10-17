<?php // 16Oct13
function skivvy_setup() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
	# add_theme_support( 'post-formats', array('aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video') );
	# add_filter('widget_text', 'do_shortcode'); // Widget Support - Shortcodes 
	# add_filter('widget_text', array( $wp_embed, 'run_shortcode' ), 8 ); add_filter('widget_text', array( $wp_embed, 'autoembed'), 8 ); // Widget Support - oEmbed & oEmbed 2
	# if (function_exists('skivvy_autooptions')){skivvy_autooptions();} // Auto setup options on theme setup - In lib/wpsimple.php
	/* 	load_theme_textdomain( 'skivvy', TEMPLATEPATH.'/lng' );
		$locale = get_locale();
		$locale_file = TEMPLATEPATH."/lng/$locale.php";
		if ( is_readable( $locale_file ) )require_once( $locale_file ); //*/
} add_action( 'after_setup_theme', 'skivvy_setup' );


// Unique Registers
# include_once 'inc/register_sidebar.php';
# include_once 'inc/register_menu.php';
# include_once 'inc/register_posttype.php';
# include_once 'inc/register_scripts.php';

// Progressive Registers
# include_once 'inc/register_widget.php';
# include_once 'inc/register_shortcode.php';


// Modules
# include_once 'lib/branding.php';
# include_once 'lib/wpsimple.php';
# include_once 'lib/cms_client.php';
# include_once 'lib/cms_admin.php';
# include_once 'lib/cms_weboptions.php'; 
# include_once 'lib/mod_browserdetect.php';
# include_once 'lib/mod_randimg.php'; 
# include_once 'lib/mod_advstyles.php'; 
# include_once 'lib/mod_posttypetools.php';
# include_once 'lib/mod_rewrites.php';
# include_once 'inc/mod_functions.php';
?>