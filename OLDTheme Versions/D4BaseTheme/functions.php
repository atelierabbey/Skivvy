<?php // Include functions for a modular experience...
/* *** Default *** */
include_once 'inc/func/wp-clean-head.php'; // Cleans up the header.php Also includes log in logo function
include_once 'inc/func/twtyten.php'; // Left over Twenty-Ten Theme Functions
include_once 'inc/func/sidebar_register.php'; // Twenty Ten Sidebar Registry
include_once 'inc/func/custom_adminbar.php'; // Custom Admin bar
include_once 'inc/func/custom_editor.php'; // Custom Editor Access
include_once 'inc/func/themeoptions.php'; // D4 Theme Options 
include_once 'inc/func/adminhtml.php'; // Unstupify Wordpress html editor

/* *** Plugins *** */
include_once 'inc/func/sliderfunc.php'; // D4 Slider Admin panel 
// include_once 'inc/func/browser_detector.php'; // Browser Detector 
// include_once 'inc/func/shadowbox.php'; // Shadowbox
?>