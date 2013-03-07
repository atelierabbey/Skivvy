<?php
// Include functions for a modular experience...
include_once 'inc/func/twtyten.php'; // Left over Twenty-Ten Theme Functions
include_once 'inc/func/sidebar_register.php'; // Twenty Ten Sidebar Registry
include_once 'inc/func/custom_adminbar.php'; // Custom Admin bar
include_once 'inc/func/custom_editor.php'; // Custom Editor Access
include_once 'inc/func/browser_detector.php'; // Browser Detector 
include_once 'inc/func/sliderfunc.php'; // D4 Slider Admin panel 
include_once 'inc/func/themeoptions.php'; // D4 Theme Options 
include_once 'inc/func/adminhtml.php'; // Unstupify Wordpress html editor


// Addition Small Snippets
/* Favicon */ function admin_favicon() {echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('stylesheet_directory').'/img/favicon.ico" />';} add_action('admin_head', 'admin_favicon'); add_action('wp_head', 'admin_favicon'); // Added 2012 November 8 - add a favicon to admin & front end.
/* Custom login logo */ function my_custom_login_logo() { echo '<style type="text/css"> h1 a { background-image:url('.get_bloginfo('template_directory').'/img/login-logo.png) !important; } </style>'; } add_action('login_head', 'my_custom_login_logo');

?>