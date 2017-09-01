<?php // Template Name: Chunks
	remove_filter('the_content', 'wpautop');
	get_template_part( 'index' );
