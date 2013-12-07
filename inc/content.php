<section class="page-content"><?php

// The Content
if ( have_posts() ) :

	if ( is_page() || is_front_page() || is_single() ) :

			the_post();
			
			// Slider content
			if ( is_front_page() )
					get_template_part( 'inc/chunk' , 'slider' );
					
					
			// Add Page Meta for single post or attachment
			if ( is_single() ) {

					echo '<div class="page-meta">';
						get_template_part( 'inc/postmeta' );
					echo '</div>';

			}
			// Content for is_attachment
			if ( is_attachment() ) {

					$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
					foreach ( $attachments as $k => $attachment ) {
						if ( $attachment->ID == $post->ID )
						break;
					}
					$k++;

					// If there is more than 1 image attachment in a gallery
					if ( count( $attachments ) > 1 ) {
						if ( isset( $attachments[ $k ] ) )
							// get the URL of the next image attachment
							$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
						else
							// or get the URL of the first image attachment
							$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
					} else {
						// or, if there's only 1 image attachment, get the URL of the image
						$next_attachment_url = wp_get_attachment_url();
					}

					echo '<a href="' . $next_attachment_url . '" title="' . esc_attr( get_the_title() ) . '" rel="attachment">';
						 // filterable image width with, essentially, no limit for image height.
						echo wp_get_attachment_image( $post->ID, array( apply_filters( 'skivvy_attachment_size', 900 ), 9999 ) );
					echo '</a>';

			} else {

				the_content();

			}


	// EVERYTHING ELSE!!1!!!11
	else :

			// post counter
			$i = 1;


			while ( have_posts() ) :

				the_post(); 

				// Post Counter classes
				$class_count = 'post-' . $i;

				if ( $i == 1 ) $class_count .= ' first';

				if ( $i % 2 == 0 ) : $class_count =  ' even';
				else : $class_count = ' odd';

				endif;


				/// Post Loops
				echo '<article class="post-content ' . $class_count . '">';

						// Post Title
						echo '<h3 class="post-title">'.
								'<a href="' . get_permalink() . '" title="' . __( 'View - ' , 'skivvy' ) . the_title_attribute( 'echo=0' ) . '" rel="bookmark">'.
									get_the_title() .
								'</a>'.
							 '</h3>';

						// Post Meta
						echo '<div class="post-meta">';
								get_template_part( 'inc/postmeta' );
						echo '</div>';

						// Post excerpt
						echo '<div class="post-snippet">'.
								get_the_excerpt().
							 '</div>';

				echo '</article>';

				$i++;
			endwhile;

		// Post Navigation
		echo '<div class="post-navigation">';
			if ( is_single() ) {

				previous_post_link( '%link', '' . _x( '&larr;', 'Previous post link', 'skivvy' ) . ' %title' );
				next_post_link( '%link', '%title ' . _x( '&rarr;', 'Next post link', 'skivvy' ) . '' );

			} elseif ( is_attachment() ) {
				
				posts_nav_link( ' ', 'Previous', 'Next' );
				
			}else { 

				previous_image_link( false );
				next_image_link( false );
				
			}
		echo '</div>';



	endif;


else : // IF Nothing exists!

	if ( is_search() ) {

		$output  = '<h2>No results found for : ' . get_search_query() . '</h2>'.
		$output .= '<p>Sorry, but nothing matched your search criteria. Please try again with some different keywords.</p>'.
		$output .= "<script>document.getElementById('s') && document.getElementById('s').focus(); // focus on search field after it has loaded</script>";
		$output .= get_search_form( FALSE );

	} else {

		$output  = '<p>Sorry, the page you are looking for cannot be found.</p>';
		$output .= '<p>Make sure you have the correct URL or try starting over at our ';
		$output .= '<a href="' . home_url( '/' ) . '" title="'. esc_attr( get_bloginfo( 'name', 'display' ) ) .'" rel="home">homepage</a> or find the page below.</p>';
		$output .= wp_nav_menu(array(
					'theme_location'  => 'sitemap',
					'menu'            => '',
					'container'       => '',
					'container_class' => 'sitemap',
					'container_id'    => '',
					'menu_class'      => '',
					'menu_id'         => '',
					'echo'            => FALSE,
					'fallback_cb'     => 'wp_page_menu',
					'before'          => '',
					'after'           => '',
					'link_before'     => '',
					'link_after'      => '',
					'items_wrap'      => '<ul class="page-list-404">%3$s</ul>',
					'depth'           => 3, // 0 = all. Default, -1 = displays links at any depth and arranges them in a single, flat list.
					'walker'          => ''
				));
	}
	echo $output;

endif; ?></section>