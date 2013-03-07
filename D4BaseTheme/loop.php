<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
		<?php next_posts_link( __( '&larr; Older posts', 'twentyten' ) ); ?>
		<?php previous_posts_link( __( 'Newer posts &rarr;', 'twentyten' ) ); ?>
<?php endif; ?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
		<h1><?php _e( 'Not Found', 'twentyten' ); ?></h1>
		<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyten' ); ?></p>
		<?php get_search_form(); ?>
<?php endif; ?>


<?php while ( have_posts() ) : the_post(); ?>

	<?php /* GALLERY */ ?>
        <?php if ( in_category( _x('gallery', 'gallery category slug', 'twentyten') ) ) : ?>
                    <h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                    <?php twentyten_posted_on(); ?>
                <?php if ( post_password_required() ) : ?>
                    <?php the_content(); ?>
                <?php else : ?>
                    <?php
                        $images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
                        $total_images = count( $images );
                        $image = array_shift( $images );
                        $image_img_tag = wp_get_attachment_image( $image->ID, 'thumbnail' );
                    ?>
                        <a href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?></a>
                    
                        <p><?php printf( __( 'This gallery contains <a %1$s>%2$s photos</a>.', 'twentyten' ),
                            'href="' . get_permalink() . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"',
                            $total_images
                        ); ?></p>
                    
                    <?php the_excerpt(); ?>
    <?php endif; ?>
    <a href="<?php echo get_term_link( _x('gallery', 'gallery category slug', 'twentyten'), 'category' ); ?>" title="<?php esc_attr_e( 'View posts in the Gallery category', 'twentyten' ); ?>"><?php _e( 'More Galleries', 'twentyten' ); ?></a>
    |
    <?php comments_popup_link( __( 'Leave a comment', 'twentyten' ), __( '1 Comment', 'twentyten' ), __( '% Comments', 'twentyten' ) ); ?>
    <?php edit_post_link( __( 'Edit', 'twentyten' ), '|', '' ); ?>
    
    <?php /* ASIDE */ ?>
        <?php elseif ( in_category( _x('asides', 'asides category slug', 'twentyten') ) ) : ?>
            <?php if ( is_archive() || is_search() ) : // Display excerpts for archives and search. ?>
                <?php the_excerpt(); ?>
            <?php else : ?>
                <?php the_content( __( 'Continue reading &rarr;', 'twentyten' ) ); ?>
            <?php endif; ?>
                <?php twentyten_posted_on(); ?>
                |
                <?php comments_popup_link( __( 'Leave a comment', 'twentyten' ), __( '1 Comment', 'twentyten' ), __( '% Comments', 'twentyten' ) ); ?>
                <?php edit_post_link( __( 'Edit', 'twentyten' ), '| ', '' ); ?>
    
    <?php /* EVERYTHING ELSE! */ ?>
        <?php else : ?>
            <h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <?php twentyten_posted_on(); ?>
        <?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>
            <?php the_excerpt(); ?>
        <?php else : ?>
            <?php the_content( __( 'Continue reading &rarr;', 'twentyten' ) ); ?>
            <?php wp_link_pages( array( 'before' => '' . __( 'Pages:', 'twentyten' ), 'after' => '' ) ); ?>
        <?php endif; ?>
            <?php if ( count( get_the_category() ) ) : ?>
                <?php printf( __( 'Posted in %2$s', 'twentyten' ), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list( ', ' ) ); ?>
                |
            <?php endif; ?>
            <?php
                $tags_list = get_the_tag_list( '', ', ' );
                if ( $tags_list ):
            ?>
                <?php printf( __( 'Tagged %2$s', 'twentyten' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list ); ?>
                |
            <?php endif; ?>
            <?php comments_popup_link( __( 'Leave a comment', 'twentyten' ), __( '1 Comment', 'twentyten' ), __( '% Comments', 'twentyten' ) ); ?>
            <?php edit_post_link( __( 'Edit', 'twentyten' ), '| ', '' ); ?>
            <?php comments_template( '', true ); ?>
        <?php endif; // This was the if statement that broke the loop into three parts based on categories. ?>
<?php endwhile; // End the loop. Whew. ?>

<?php /* Display navigation to next/previous pages when applicable */
if (  $wp_query->max_num_pages > 1 ) : 
	next_posts_link( __( '&larr; Older posts', 'twentyten' ) ); 
	previous_posts_link( __( 'Newer posts &rarr;', 'twentyten' ) ); 
endif; ?>