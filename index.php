<?php get_header(); 

echo '<section class="content">';

	// Title
	echo '<h1 class="page-title">';
		get_template_part( 'title' );
	echo '</h1>';

	// Post Meta
	if ( !is_page() && !is_single() && !is_front_page() ) {
		echo '<div class="page-data">';
			get_template_part( 'postmeta' );
		echo '</div>';
	}

	// Content
	echo '<section class="page-content">';
		get_template_part( 'content' );
	echo '</section>';

	// Sidebar
	echo '<aside>';
		get_sidebar();
	echo '</aside>';

echo '</section>';

get_footer(); ?>