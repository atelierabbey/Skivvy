<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
    <h1><?php the_title(); ?></h1>
	<div class="post-date"><?php the_date();?></div>
    <?php the_content(); ?>
	<?php /* if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
        <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'skivvy_author_bio_avatar_size', 60 ) ); ?>
        <h2><?php printf( esc_attr__( 'About %s', 'skivvy' ), get_the_author() ); ?></h2>
        <?php the_author_meta( 'description' ); ?>
        <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
            <?php printf( __( 'View all posts by %s &rarr;', 'skivvy' ), get_the_author() ); ?>
        </a>
    <?php endif; //*/ ?>
    <?php wp_link_pages( array( 'before' => __( 'Pages:', 'skivvy' ), 'after' => '' ) ); ?>
    <?php previous_post_link( '%link', '' . _x( '&larr;', 'Previous post link', 'skivvy' ) . ' %title' ); ?>
    <?php next_post_link( '%link', '%title ' . _x( '&rarr;', 'Next post link', 'skivvy' ) . '' ); ?>
<?php endwhile; ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>