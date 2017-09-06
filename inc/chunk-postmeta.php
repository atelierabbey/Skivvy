<?php

$output = '<div class="post-meta">';

 	if ( is_singular() ) {

		// POST AUTHOR
			$output .= 'By ';
				$output .= '<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" title="View all posts by ' . get_the_author() . '">';
					$output .= get_the_author();
				$output .= '</a> ';
		//*/


		// POST DATE
			$output .= ' | Published ';
				$output .= '<abbr title="' . esc_attr( get_the_date() . ' ' . get_the_time() ) . '">';
					$output .= get_the_time(get_option('date_format'));
				$output .= '</abbr> ';

		// POST CATEGORIES
			$cats_list = get_the_category_list( ', ' );
			if ( $cats_list ) {
				$output .= ' | Category: ' . $cats_list;
			}
		
		// POST TAGS
			$tags_list = get_the_tag_list( '', ', ' );
			if ( $tags_list ) {
				$output .= ' | Tags: ' . $tags_list;
			}
	

	} elseif ( is_category() || is_tag() || is_tax() ) {
		// Category, tag, and taxonomy
	
			$output .= '<div id="term_description">' . term_description() . '</div>';
	
	} elseif ( is_search() ) {
		// Search
			// Or if search, show Result Search Count
				$allsearch = &new WP_Query("s=$s&showposts=-1");
				$key = wp_specialchars($s, 1);
				$count = $allsearch->post_count;
				$output .= '<h2>Showing ' . $count . '  results for: ' . $key . '</h2>';
				wp_reset_postdata();
			//*/
	
	
	} elseif ( is_attachment() ) {
		// Attachment

		if ( wp_attachment_is_image() ) {
			$metadata = wp_get_attachment_metadata();
			$output .= ' | Full size is <a href="'. wp_get_attachment_url() . '" title="' . esc_attr( 'Link to full-size image' ) . '">' . $metadata['width'] . ' &times; ' . $metadata['height'] . '</a> pixels';
		}

	}

$output .= '</div>';

echo $output;