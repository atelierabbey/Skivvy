<?php // Hook this ...stuff... into header
// http://codex.wordpress.org/Plugin_API/Action_Reference/wp_enqueue_scripts
// http://wp.tutsplus.com/articles/how-to-include-javascript-and-css-in-your-wordpress-themes-and-plugins/
function d4_head() {
	echo '<meta charset="'.get_bloginfo('charset').'" />' ;
	echo '<link rel="profile" href="http://gmpg.org/xfn/11" />';
	echo '<link rel="pingback" href="'.get_bloginfo('pingback_url').'" />';
	// Favicon
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('stylesheet_directory').'/img/favicon.ico" />';
	// Theme CSS
	echo '<link rel="stylesheet" type="text/css" media="all" href="'.get_bloginfo('template_directory').'/inc/functions.css" />';
	echo '<link rel="stylesheet" type="text/css" media="all" href="'.get_bloginfo('stylesheet_url').'" />';
}
add_action('wp_head', 'd4_head');


function d4script_init() {
	// Register local Jquery & stylesheets
	if (!is_admin()) {
		$handle = 'jquery';
		$src = get_template_directory_uri() . '/js/jquery.min.js';
		$deps = false;
		$ver = '1.9.1';
		$in_footer = false;
		wp_deregister_script($handle);
		wp_register_script($handle, $src, $deps, $ver, $in_footer );
	}
}
add_action('wp_enqueue_scripts', 'd4script_init');

/* Google Analytics includes - Added 17 Jan 13 - Replaces old theme option, reverted back to include file. */
function fileAnalytics() { include_once get_template_directory(). "/inc/analytics.php"; }
add_action('wp_footer', 'fileAnalytics'); 
/* Custom login logo */
function my_custom_login_logo() { echo '<style type="text/css"> h1 a { background-image:url('.get_bloginfo('template_directory').'/img/login-logo.png) !important; } </style>'; } add_action('login_head', 'my_custom_login_logo');
?>