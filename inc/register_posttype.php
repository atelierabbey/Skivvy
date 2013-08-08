<?php #8Aug13
add_action( 'init', 'register_skivvy_posttype' ); function register_skivvy_posttype() { 

register_post_type( 'd4am_slider', array(
	'labels' => array(
		'name' => 'Slides',
		'singular_name' => 'Slide',
		'menu_name' => 'Slideshow',
		'all_items' => 'Slides',
		#'add_new' => '',
		#'add_new_item' => '',
		#'edit_item' => '',
		#'new_item' => '',
		#'view_item' => '',
	),
	'description' => '',
	'public' => true,
	'supports' => array(
		'title',
		'editor',
		#'author',
		'thumbnail',
		#'excerpt',
		#'trackbacks',
		#'custom-fields',
		#'comments',
		'revisions',
		#'page-attributes',
		#'post-formats'
	),
	#'taxonomies' => '',
	#'has_archive' => '',
	#'rewrite' => false,
	#'can_export' => true
) ); //  End Post Type */

}?>