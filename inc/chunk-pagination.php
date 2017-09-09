<?php


	echo '<ul class="post-navigation nobull clearfix">';

			$next_start = '<li class="post-next alignleft button">';
			$next_end = '</li>';

			$prev_start = '<li class="post-prev alignright button">';
			$prev_end = '</li>';

			if ( is_home() || is_day() || is_month() || is_year() || is_tax() || is_category() || is_tag() || is_author() || is_archive() || is_search() ) {

						echo $next_start;
							previous_posts_link ( __('Previous Page' , 'skivvy') );
						echo $next_end;

						# posts_nav_link(' | ','&larr; Previous Page','Next Page &rarr;');

						echo $prev_start;
							next_posts_link ( __('Next Page' , 'skivvy') );
						echo $prev_end;

			} elseif ( is_attachment() ) {

						echo $next_start;
							next_image_link( 'fullsize', __('Next Image' , 'skivvy') );
						echo $next_end;

						echo $prev_start ;
							echo previous_image_link( 'fullsize', __('Previous Image' , 'skivvy') );
						echo $prev_end;


			} elseif ( is_single() ) {

						echo $next_start;
							next_post_link( '%link', __('Next' , 'skivvy') , TRUE, ' ' );
						echo $next_end;

						echo $prev_start;
							previous_post_link( '%link', __('Previous' , 'skivvy') , TRUE, ' ' );
						echo $prev_end;

			}

	echo '</ul>';

?>
