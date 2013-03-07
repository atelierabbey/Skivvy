<?php // D4 Slider admin area
add_action( 'init', 'create_post_type' );
function create_post_type() {
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
?>