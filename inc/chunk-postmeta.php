<div class="post-meta"><?php


	// POST AUTHOR
	
		/* printf(__('By %2$s ', 'skivvy'),
			'meta-prep meta-prep-author',
			sprintf( '<a class="url fn n" href="%1$s" title="%2$s">%3$s</a>',
				get_author_posts_url( get_the_author_meta( 'ID' ) ),
				sprintf( esc_attr__( 'View all posts by %s', 'skivvy' ), get_the_author() ),
				get_the_author()
				)
		); //*/


	// POST DATE
	
		the_time('F j, Y');
		/* printf( __('Published %2$s', 'skivvy'),
				'meta-prep meta-prep-entry-date',
				sprintf( '<abbr title="%1$s">%2$s</abbr>',
							esc_attr( get_the_time() ),
							get_the_date()
						)
		); //*/

	// POST CATEGORIES
		$cats_list = get_the_category_list( ', ' );
			if ( $cats_list ) echo __( ' | Category:' , 'skivvy' ). ' ' . $cats_list;

	
	// POST TAGS
		$tags_list = get_the_tag_list( '', ', ' );
			if ( $tags_list ) echo __( ' | Tags:' , 'skivvy' ) . ' ' . $tags_list;
	
	// Category, tag, and taxonomy
	if ( is_category() || is_tag() || is_tax() ) :
			term_description();
	/*
	// Search
	elseif ( is_search() ) :
		// Or if search, show Result Search Count
			$allsearch = &new WP_Query("s=$s&showposts=-1");
			$key = wp_specialchars($s, 1);
			$count = $allsearch->post_count;
			printf( __( '<h2>Showing %1$s  results for: %2$s</h2>', 'skivvy' ), $count , $key );
			wp_reset_query(); 
	//*/
	// Author
	elseif ( is_author() || get_the_author_meta( 'description' ) ) : 
		the_author_meta( 'description' );

	// Attachment
	elseif ( is_attachment() ) :

		if ( wp_attachment_is_image() ) {

			$metadata = wp_get_attachment_metadata();

			printf( __( ' | Full size is %s pixels', 'skivvy'),
				sprintf( '<a href="%1$s" title="%2$s">%3$s &times; %4$s</a>',
					wp_get_attachment_url(),
					esc_attr( __('Link to full-size image', 'skivvy') ),
					$metadata['width'],
					$metadata['height']
				)
			);
		}


endif; ?></div>