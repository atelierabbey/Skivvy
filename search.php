<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <h1>
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
            <?php
                $title  = get_the_title();
                $keys= explode(" ",$s);
                $title  = preg_replace('/('.implode('|', $keys) .')/iu',
                    '<strong class="search-excerpt">�</strong>',
                    $title);
            ?>
        </a>
    </h1>
	<time><?php the_date(); ?></time>
    <?php
		the_excerpt();
        
        if ( count( get_the_category() ) ) {
            printf( __( 'Posted in %2$s', 'skivvy' ), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list( ', ' ) );
        };
        
        $tags_list = get_the_tag_list( '', ', ' );
        if ( $tags_list ){
            printf( __( 'Tagged %2$s', 'skivvy' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list );
        };
    ?>
<?php endwhile;?>
<?php else : ?>
    <h2>Nothing Found</h2>
    <p>Sorry, but nothing matched your search criteria. Please try again with some different keywords.</p>
    <?php //get_search_form(); ?>
    <script type="text/javascript">
        // focus on search field after it has loaded
        document.getElementById('s') && document.getElementById('s').focus();
    </script>
<?php endif; ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
