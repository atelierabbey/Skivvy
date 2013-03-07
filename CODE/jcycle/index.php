<?php 
// Register jCycle script
function jcycle_init()
{ if (!is_admin()) {
	$handle = 'jcycle';
	$src = get_template_directory_uri() . '/js/jcycle/jquery.cycle.all.js';
	$deps = array ( 'jquery' );
	$ver = '2.9999.5';
	$in_footer = false;
	
	wp_register_script($handle, $src, $deps, $ver, $in_footer );
	wp_enqueue_script($handle);
	}
}
add_action('wp_enqueue_scripts', 'jcycle_init');

// Register Slider custom post type
function create_sliders_type() {
	register_post_type( 'd4am_slider',
		array(
			'labels' => array(
				'name' => __( 'Slideshow' ),
				'singular_name' => __( 'Slideshow' )
			),
		'public' => true,
		'has_archive' => true,
		)
	);
}
add_action( 'init', 'create_sliders_type' );
?>