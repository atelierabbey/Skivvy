<?php // 22Aug13 - Functions.php is like Batman's Tool belt. It has a ton of freakishly-specific gadgets and plenty of bat-a-rangs.
// Core & Setup
include_once 'inc/core.php';
function skivvy_setup() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
	# add_theme_support( 'post-formats', array('aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video') );
	# add_filter('widget_text', 'do_shortcode'); // Widget Support - Shortcodes 
	# add_filter('widget_text', array( $wp_embed, 'run_shortcode' ), 8 ); add_filter('widget_text', array( $wp_embed, 'autoembed'), 8 ); // Widget Support - oEmbed & oEmbed 2
	# if (function_exists('skivvy_autooptions')){skivvy_autooptions();} // Auto setup options on theme setup
	# if (function_exists('skivvy_languageaccept')){skivvy_languageaccept();}; // Language support
} add_action( 'after_setup_theme', 'skivvy_setup' );
include_once 'inc/wpsimple.php';

// Unique Registers
# include_once 'inc/register_sidebar.php';
# include_once 'inc/register_menu.php';
# include_once 'inc/register_posttype.php';
# include_once 'inc/register_scripts.php';

// Progressive Registers
# include_once 'inc/register_widget.php';
# include_once 'inc/register_shortcode.php';
# include_once 'inc/register_functions.php';

// Modules
# include_once 'inc/cms_client.php';
# include_once 'inc/cms_admin.php';
# include_once 'inc/cms_weboptions.php'; 
# include_once 'inc/mod_browserdetect.php';
# include_once 'inc/mod_randimg.php'; 
# include_once 'inc/mod_advstyles.php'; 
# include_once 'inc/mod_posttypetools.php';
# include_once 'inc/mod_rewrites.php';

?>