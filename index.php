<?php get_header(); ?>

<section class="page-content"><?php


	// Slider
		if ( is_front_page() ) get_template_part( 'inc/chunk' , 'slider' );


	// Post Meta for Singles
		if ( is_single() ) {
			echo '<div class="page-meta">';
				get_template_part( 'inc/chunk' , 'postmeta' );
			echo '</div>';
		}


	// The Content
		get_template_part( 'inc/chunk' , 'content'  );


	// Anti-collapse Space.
		echo "&nbsp;"


?></section>

<aside class="sidebar"><?php

		// The Sidebar
		get_sidebar();


?></aside>


<?php get_footer(); ?>