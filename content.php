<?php // The Content
if ( have_posts() ) :

	if ( is_page() || is_front_page() || is_single() ) :

			the_post(); 
			the_content(); 

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
							the_time('F j, Y');

							$cats_list = get_the_category_list( ', ' );
								if ( $cats_list ) echo __( ' | Category:' , 'skivvy' ). ' ' . $cats_list;

							$tags_list = get_the_tag_list( '', ', ' );
								if ( $tags_list ) echo __( ' | Tags:' , 'skivvy' ) . ' ' . $tags_list;

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

			} else { 

				posts_nav_link( ' ', 'Previous', 'Next' );

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

endif; ?>