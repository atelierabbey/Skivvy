<?php // Template Name: Home
get_header(); ?>

<script type='text/javascript'>
	 /*function preloader() 
	 {	 
		var i = 0; // counter
		imageObj = new Image(); // create object
		images = new Array(); // set image list
		images[0]='<?php bloginfo('template_url'); ?>/images/left-arrow-hover.png'
		images[1]='<?php bloginfo('template_url'); ?>/images/right-arrow-hover.png'
		for(i=0; i<=1; i++) // start preloading
		{imageObj.src=images[i];}
	 } */
	$(document).ready(function() {
		$('#slideshow-wrapper').cycle({
			fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
			next: '#next_arrow',
			prev: '#prev_arrow',
			cleartypeNoBg:  true
		});
	});
</script>
<!--<div id='page'>
    <div id='next_arrow'></div>
    <div id='prev_arrow'></div>
</div>-->
<div id='slideshow-wrapper' onLoad='preloader()'>
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