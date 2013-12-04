<h1 class="page-title"><?php

	if ( is_home() ) : 
			_e( 'News', 'skivvy' );
	
	elseif ( is_archive() ) :
			_e( 'News', 'skivvy' );
	
	elseif ( is_day() ) :
			printf( __( 'Day: %s', 'skivvy' ), get_the_date() );
	
	elseif ( is_month() ) :
			printf( __( 'Month: %s', 'skivvy' ), get_the_date( 'F Y' ) );
	
	elseif ( is_year() ) :
			printf( __( 'Year: %s', 'skivvy' ), get_the_date( 'Y' ) );
	
	elseif ( is_tag() ) :
			single_tag_title();
	
	elseif ( is_category() ) :
			single_cat_title();
	
	elseif ( is_taxonomy() ) :
			$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			echo $term->name;
	
	elseif ( is_author() ) :
			printf( __( 'All posts by %s', 'skivvy' ), sprintf(
					'<span class="vcard"><a href="%1$s" rel="me">%2$s</a></span>',
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					get_the_author()
			) );

	elseif ( is_attachment() ) :
			the_title();
	
	elseif ( is_search() ) :
			_e( 'Search Results', 'skivvy' );
	
	elseif ( is_single() ) :
			the_title();
	
	elseif ( is_front_page() ) :
			the_title();
	
	elseif ( is_page() ) :
			the_title();
	
	else :
			_e( '404 | Page not found' , 'skivvy' );
	
	endif; 
?></h1>