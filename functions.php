<?php // 7Aug13 - Functions.php is like Batman's Tool belt. It has a ton of freakishly-specific gadgets and plenty of bat-a-rangs.
// Core
include_once 'inc/core.php';

// Setup
function skivvy_setup() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
	add_filter('widget_text', 'do_shortcode'); // Widget Support - Shortcodes 
	# add_theme_support( 'post-formats', array('aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video') );
	# skivvy_autooptions(); // Auto setup options on theme setup
	# skivvy_languageaccept(); // Language support
	# add_filter('widget_text', array( $wp_embed, 'run_shortcode' ), 8 ); add_filter('widget_text', array( $wp_embed, 'autoembed'), 8 ); // Widget Support - oEmbed & oEmbed 2

} add_action( 'after_setup_theme', 'skivvy_setup' );


// Registers
 include_once 'inc/register_sidebar.php';
# include_once 'inc/register_menu.php';
# include_once 'inc/register_scripts.php';
# include_once 'inc/register_posttype.php';
 include_once 'inc/register_widget.php';
# include_once 'inc/register_shortcode.php';
# include_once 'inc/register_functions.php';

// Modules
# include_once 'inc/cms_client.php';
# include_once 'inc/cms_admin.php';
# include_once 'inc/cms_weboptions.php'; 

// Tools
# include_once 'inc/browser_detector.php';
# include_once 'inc/advmenus.php';
?>