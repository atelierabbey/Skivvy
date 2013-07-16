<?php get_header(); ?>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#slideshow-wrapper').cycle({
			fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
			//next: '#next_arrow',
			//prev: '#prev_arrow',
			cleartypeNoBg:  true
		});
	});
</script>
<!--<div id='page'>
    <div id='next_arrow'></div>
    <div id='prev_arrow'></div>
</div>-->
<div id='slideshow-wrapper'>
	<?php
        $args = array( 'post_type' => 'd4am_slider',
                       'posts_per_page' => 10,
                       'order' => 'ASC', // ASC or DESC
                       'orderby' => 'none' // none , ID, author, title, name, date, modified, parent, rand, comment_count, menu_order, meta_value, meta_value_num
                       );
        $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post();
            the_content();
        endwhile;
    ?>
</div>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<?php the_content(); ?>
<?php endwhile; ?>

<?php get_footer(); ?>