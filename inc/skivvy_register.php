<?php

// http://generatewp.com
//		Menu
//		Widgets Area
//		Post Types
//		Javascripts






/*
**
**		REGISTER - Menus
**
*/
register_nav_menus( array(
	'main' => __( 'Main Navigation' ),
	'sitemap' => __( 'Site Map' ),
) );






/*
**
**		REGISTER - Widget Areas
**
*/
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
	register_sidebar( array(
		'name' => 'Footer 1',
		'id' => 'first-footer-widget-area',
		'description' => 'The first footer widget area',
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) ); 
	register_sidebar( array(
		'name' => 'Footer 2',
		'id' => 'second-footer-widget-area',
		'description' => 'The second footer widget area',
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => 'Footer 3',
		'id' => 'third-footer-widget-area',
		'description' => 'The third footer widget area',
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => 'Footer 4',
		'id' => 'fourth-footer-widget-area',
		'description' => 'The fourth footer widget area',
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'skivvy_register_sidebars' ); //*/






/*
**
**		REGISTER - Post Types
**		http://justintadlock.com/archives/2013/09/13/register-post-type-cheat-sheet
**
*/ /*
function register_skivvy_posttype() { }
add_action( 'init', 'register_skivvy_posttype' ); //*/






/*
**
**		REGISTER - Javascripts
**		wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer ); 
**
*/ /*
function skivvy_script_enqueuer() { }
add_action('wp_enqueue_scripts', 'skivvy_script_enqueuer'); //*/
?>