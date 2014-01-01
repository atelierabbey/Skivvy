<?php get_header(); ?>

<section class="page-content">&nsbp;<?php // The Content

	if ( is_front_page() ) get_template_part( 'inc/chunk' , 'slider' );

	if ( is_single() ) {
		echo '<div class="page-meta">';
			get_template_part( 'inc/chunk' , 'postmeta' );
		echo '</div>';
	}

	get_template_part( 'inc/chunk' , 'content'  );
?></section>

<aside><?php get_sidebar(); ?></aside>


<?php get_footer(); ?>
