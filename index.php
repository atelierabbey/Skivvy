<?php get_header(); ?>

<section class="content">

	<h1 class="page-title"><?php // Title

		// Prefix If is Password Protected
		if ( !empty( $post->post_password ) ) _e( 'Protected: ' , 'skivvy' ); 
		// Prefix If is Private
		if ( get_post_status ( $ID ) == 'private' ) _e( 'Private: ' , 'skivvy' );

			if ( is_home()			) : _e( 'News', 'skivvy' );
		elseif ( is_day()			) : printf( __( 'Day: %s', 'skivvy' ), get_the_date() );
		elseif ( is_month()			) : printf( __( 'Month: %s', 'skivvy' ), get_the_date( 'F Y' ) );
		elseif ( is_year()			) : printf( __( 'Year: %s', 'skivvy' ), get_the_date( 'Y' ) );
		elseif ( is_tax()			) : $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); echo $term->name;
		elseif ( is_tag()			) : single_tag_title();
		elseif ( is_category()		) : single_cat_title();
		elseif ( is_author()		) : printf( __( 'Posts by %s', 'skivvy' ), sprintf( '<span class="vcard"><a href="%1$s" rel="me">%2$s</a></span>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), get_the_author() ) );
		elseif ( is_archive()		) : _e( 'News', 'skivvy' );
		elseif ( is_search()		) : _e( 'Search Results', 'skivvy' );
		elseif ( is_attachment()	) : the_title();
		elseif ( is_single()		) : the_title();	
		elseif ( is_front_page()	) : #the_title();
		elseif ( is_page()			) : the_title();
		elseif ( is_404()			) : _e( '404 | Page not found' , 'skivvy' );
		else						  : // Silence.... 
		endif;
	?></h1>

	<section class="page-content"><?php // The Content

		if ( is_front_page() ) get_template_part( 'inc/chunk' , 'slider' );

		if ( is_single() ) {
			echo '<div class="page-meta">';
				get_template_part( 'inc/chunk' , 'postmeta' );
			echo '</div>';
		}

		get_template_part( 'inc/chunk' , 'content'  );
	?></section>

	<aside><?php // Sidebar
		get_sidebar();
	?></aside>

</section>

<?php get_footer(); ?>