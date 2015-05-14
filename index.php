<?php

get_header();

	echo ('<section id="content">'.
			'<div class="page-wrapper">'.
				'<main role="main" id="main-content" class="clearfix">');

					if ( is_front_page() ) {
						get_template_part( 'inc/chunk' , 'slider' ); // Slider

					} else {
						get_template_part( 'inc/chunk' , 'title' ); // The Title

					}

					get_template_part( 'inc/chunk' , 'content' ); // The Content

					if ( ! is_page() ) get_template_part( 'inc/chunk' , 'pagination' ); // Pagination

			echo '</main>';
			# get_sidebar();
	echo ('</div>'.
	'</section>');

get_footer();

?>