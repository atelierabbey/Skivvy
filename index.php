<?php

get_header();

	echo ('<section id="content">'.
			'<div class="page-wrapper">'.
				'<main role="main" id="main-content" class="clearfix">');

					if ( ! is_front_page() ) {
						get_template_part( 'inc/chunk' , 'title' );
					} 

					get_template_part( 'inc/chunk' , 'content' );

					if ( ! is_page() ) get_template_part( 'inc/chunk' , 'pagination' );

			echo '</main>';
			# get_sidebar();
	echo ('</div>'.
	'</section>');

get_footer();

?>