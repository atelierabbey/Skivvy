<?php get_header(); ?>
<h1>Search Results</h1>
<?php if ( have_posts() ) : ?>
	<h2><?php /* Search Count */
		$allsearch = &new WP_Query("s=$s&showposts=-1");
		$key = wp_specialchars($s, 1);
		$count = $allsearch->post_count;
						
		echo 'Showing ' . $count . ' results for: '. $key;
		wp_reset_query(); 
         ?></h2>
	<?php while ( have_posts() ) : the_post(); ?>  
                <article>
                    <h3>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
                            <?php the_title(); ?>
                        </a>
                    </h3>
                    <div class="post-meta"><?php
                            the_time('F j, Y');
                            $cats_list = get_the_category_list( ', ' ); if ($cats_list) { printf( __( ' | Category:', 'skivvy' ), 'entry-utility-prep entry-utility-prep-category-links', $cats_list ); }
                            $tags_list = get_the_tag_list( '', ', ' ); if ( $tags_list ){ printf( __( ' | Topics: %2$s', 'skivvy' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list ); }
                    ?></div>
                    <?php
                       
                        the_snippet( 55, 'Read more' );
                    ?>
                </article>
        <?php endwhile;?>
        <?php posts_nav_link( ' ', 'Previous', 'Next' ); ?>
    <?php else : ?>
        <h2>No results found for : <?php the_search_query(); ?></h2>
        <p>Sorry, but nothing matched your search criteria. Please try again with some different keywords.</p>
        <?php //get_search_form(); ?>
        <script type="text/javascript">
            // focus on search field after it has loaded
            document.getElementById('s') && document.getElementById('s').focus();
        </script>
    <?php endif; ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
