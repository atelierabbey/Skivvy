<?php
	// Category, tag, and taxonomy
	if ( is_category() || is_tag() || is_tax() ) :
			term_description();

	// Search
	elseif ( is_search() ) :
		// Or if search, show Result Search Count
			$allsearch = &new WP_Query("s=$s&showposts=-1");
			$key = wp_specialchars($s, 1);
			$count = $allsearch->post_count;
			printf( __( '<h2>Showing %1$s  results for: %2$s</h2>', 'skivvy' ), $count , $key );
			wp_reset_query(); 

	// Author
	elseif ( is_author() || get_the_author_meta( 'description' ) ) : 
		the_author_meta( 'description' );

	// Attachment
	elseif ( is_attachment() ) :

		if ( wp_attachment_is_image() ) {
	
			$metadata = wp_get_attachment_metadata();
	
			printf( __( 'Full size is %s pixels', 'skivvy'),
				sprintf( '<a href="%1$s" title="%2$s">%3$s &times; %4$s</a>',
					wp_get_attachment_url(),
					esc_attr( __('Link to full-size image', 'skivvy') ),
					$metadata['width'],
					$metadata['height']
				)
			);
	
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
		}

endif; ?>