<?php get_header(); ?>
<?php if ( have_posts() ) : ?>

	<?php get_template_part( 'title' ); ?>

    <section class="content"><?php // The Content  
    
		if ( is_home() ) :
            get_template_part( 'content', 'blog' );
			
        elseif ( is_archive() ) :
            get_template_part( 'content', 'blog' );
			
        elseif ( is_day() ) :
            get_template_part( 'content', 'blog' );
			
        elseif ( is_month() ) :
            get_template_part( 'content', 'blog' );
			
        elseif ( is_year() ) :
            get_template_part( 'content', 'blog' );

        elseif ( is_tag() ) :
			// Tag Description
			$term_description = term_description();
			if ( ! empty( $term_description ) ) printf( '<div class="post-description">%s</div>', $term_description );

            get_template_part( 'content', 'blog' );
			
        elseif ( is_category() ) :
			// Category Description
			$term_description = term_description();
			if ( ! empty( $term_description ) ) printf( '<div class="post-description">%s</div>', $term_description );

            get_template_part( 'content', 'blog' );
			
        elseif ( is_taxonomy() ) :
			// Taxonomy Description
			$term_description = term_description();
			if ( ! empty( $term_description ) ) printf( '<div class="post-description">%s</div>', $term_description );

            get_template_part( 'content', 'blog' );
			
        elseif ( is_author() ) :
			// Author Description
			if ( get_the_author_meta( 'description' ) ) { 
				echo '<div class="post-description">' . get_the_author_meta( 'description' ) . '</div>';
			}
			
            get_template_part( 'content', 'blog' );
			
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
			get_template_part( 'content', 'blog' );

        elseif ( is_search() ) :
			// Search Count
			$allsearch = &new WP_Query("s=$s&showposts=-1");
			$key = wp_specialchars($s, 1);
			$count = $allsearch->post_count;
			echo '<h2>Showing ' . $count . ' results for: '. $key .'</h2>';
			wp_reset_query(); 
            
			get_template_part( 'content', 'blog' );
			
        elseif ( is_single() ) :
			get_template_part( 'content', 'blog' );
            
        elseif ( is_front_page() ) :
            while ( have_posts() ) {
				the_post(); 
				the_content(); 
			}

        elseif ( is_page() ) :
			while ( have_posts() ) {
				the_post(); 
				the_content(); 
			}
			
        else : // Nothing exists!
        	
			if ( is_search() ) {
				
				echo '<h2>No results found for : ' . get_search_query() . '</h2>'.
				'<p>Sorry, but nothing matched your search criteria. Please try again with some different keywords.</p>'.
				"<script> document.getElementById('s') && document.getElementById('s').focus(); // focus on search field after it has loaded </script>";
				get_search_form();
				
			} else {
				
				echo '<p>Sorry, the page you are looking for cannot be found.</p>';
				echo '<p>Make sure you have the correct URL or try starting over at our ';
				echo  '<a href="' . home_url( '/' ) . '" title="'. esc_attr( get_bloginfo( 'name', 'display' ) ) .'" rel="home">homepage</a> or find the page below.</p>';
				wp_nav_menu(array(
					'theme_location'  => 'sitemap',
					'menu'            => '',
					'container'       => '',
					'container_class' => 'sitemap',
					'container_id'    => '',
					'menu_class'      => '',
					'menu_id'         => '',
					'echo'            => true,
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
        endif;
    ?></section>
<?php endif; ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>