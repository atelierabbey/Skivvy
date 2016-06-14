<?php

get_header();

	echo '<section id="content">';
		echo '<div class="page-wrapper">';
				echo '<main role="main" id="main-content" class="clearfix">';

						if ( ! is_front_page() ) {
							get_template_part( 'inc/chunk' , 'title' );
						} 

						get_template_part( 'inc/chunk' , 'content' );

						if ( ! is_page() ) get_template_part( 'inc/chunk' , 'pagination' );

				echo '</main>';
				# get_sidebar();
		echo '</div>';
	echo '</section>';

get_footer();

?>