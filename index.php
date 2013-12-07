<?php get_header(); ?>

<section class="content"><?php

	// Title
	get_template_part( 'inc/title' );

	// Content
	get_template_part( 'inc/content' );

	// Sidebar
	get_sidebar();

?></section>

<?php get_footer(); ?>