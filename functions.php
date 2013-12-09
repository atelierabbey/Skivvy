<?php add_action( 'after_setup_theme', 'skivvy_setup' ); function skivvy_setup() {
  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
# add_theme_support( 'post-formats', array('aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video') );
# add_filter('widget_text', 'do_shortcode'); // Widget Support - Shortcodes 
# add_filter('widget_text', array( $wp_embed, 'run_shortcode' ), 8 );
# add_filter('widget_text', array( $wp_embed, 'autoembed'), 8 ); // Widget Support - oEmbed & oEmbed 2
# if (function_exists('skivvy_autooptions')){skivvy_autooptions();} // Auto setup options on theme setup - In lib/wpsimple.php
# $lang_location = get_template_directory_uri() . '/inc'; load_theme_textdomain( 'skivvy', $lang_location ); $locale_file = $lang_location . '/' . get_locale() . '.php'; if ( is_readable( $locale_file )){ require_once( $locale_file );}
} 

// Includes - You can change the includes per site
# include 'inc/register_sidebar.php';
# include 'inc/register_menu.php';
# include 'inc/register_posttype.php';
# include 'inc/register_scripts.php';
# include 'inc/register_widget.php';
# include 'inc/register_shortcode.php';
include 'inc/wpsimple.php';
include 'inc/website_branding.php';

// Library - It's not nice to write in things from the library.
# include 'inc/lib/cms_weboptions.php'; new skivvy_websiteoptions;
# include 'inc/lib/cms_client.php';
# include 'inc/lib/cms_admin.php';
# include 'inc/lib/mod_buckets.php';
# include 'inc/lib/mod_browserdetect.php';
# include 'inc/lib/mod_randimg.php'; 
# include 'inc/lib/mod_advstyles.php'; 
# include 'inc/lib/mod_posttypetools.php';
# include 'inc/lib/mod_rewrites.php';
?>
