<?php // D4 Slider admin area



function jcycle_init()
{
    echo '<script type="text/javascript" src="' . bloginfo("template_url") . '/inc/jquery.cycle.all.js"></script>';
}
add_action('wp_head', 'jcycle_init');
    





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