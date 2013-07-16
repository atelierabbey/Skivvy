<?php get_header(); ?>
<h1><?php single_cat_title();?></h1>
<p>
	<?php
        $category_description = category_description();
        if ( ! empty( $category_description ) ) {
            echo $category_description;
        };
    ?>
</p>
<?php while ( have_posts() ) : the_post(); ?>  
    <h1>
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
            <?php the_title(); ?>
        </a>
    </h1>
    <?php
        the_date();
        if ( is_archive() || is_search() ) { // Only display excerpts for archives and search.
            the_excerpt();
        } else {
            the_content( __( 'Continue reading &rarr;', 'd4basetheme' ) );
            wp_link_pages( array( 'before' => '' . __( 'Pages:', 'd4basetheme' ), 'after' => '' ) );
        };
        
        if ( count( get_the_category() ) ) {
            printf( __( 'Posted in %2$s', 'd4basetheme' ), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list( ', ' ) );
        };
        
        $tags_list = get_the_tag_list( '', ', ' );
        if ( $tags_list ){
            printf( __( 'Tagged %2$s', 'd4basetheme' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list );
        };
    ?>
<?php endwhile;?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>