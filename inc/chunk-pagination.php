<?php


	echo '<ul class="post-navigation nobull clearfix">';


			$prev_start = '<li class="post-prev alignleft button">';
			$prev_end = '</li>';
			$next_start = '<li class="post-next alignright button">';
			$next_end = '</li>';

			if ( is_home() || is_day() || is_month() || is_year() || is_tax() || is_category() || is_tag() || is_author() || is_archive() || is_search() ) {

						echo $prev_start;
							previous_posts_link ( __('Previous Page' , 'skivvy') );
						echo $prev_end;

						echo $next_start;
							next_posts_link ( __('Next Page' , 'skivvy') );
						echo $next_end;

						# posts_nav_link(' | ','&larr; Previous Page','Next Page &rarr;');

			} elseif ( is_attachment() ) {

						echo $prev_start ;
							echo previous_image_link( 'fullsize', __('Previous Image' , 'skivvy') );
						echo $prev_end;

						echo $next_start;
							next_image_link( 'fullsize', __('Next Image' , 'skivvy') );
						echo $next_end;

			} elseif ( is_single() ) {

						echo $prev_start;
							previous_post_link( '%link', __('Previous' , 'skivvy') , TRUE, ' ' );
						echo $prev_end;

						echo $next_start;
							next_post_link( '%link', __('Next' , 'skivvy') , TRUE, ' ' );
						echo $next_end;

			}

	echo '</ul>';

?>