<?php #9Aug13 ?>
<?php get_header(); ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.cycle.lite.js"></script>
<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('.slideshow-wrapper').cycle({
			fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
			//next: '#next_arrow',
			//prev: '#prev_arrow',
			cleartypeNoBg:  true
		});
	});
</script>
<?php /* ?>
<div id='page'>
    <div id='next_arrow'></div>
    <div id='prev_arrow'></div>
</div><?php //*/ ?>
<div class='slideshow-wrapper'>
	<?php $args = array(
			'post_type' => 'd4am_slider',
			'posts_per_page' => 5,
			'order' => 'ASC', // ASC or DESC
			'orderby' => 'none' // none , ID, author, title, name, date, modified, parent, rand, comment_count, menu_order, meta_value, meta_value_num
		); $loop = new WP_Query( $args ); while ( $loop->have_posts() ) : $loop->the_post();
	?>
        <div class="slide">
			<h1><?php the_title();?></h1>
            <?php the_post_thumbnail();?>
            <?php the_content(); ?>
        </div>
	<?php endwhile; ?>
</div>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<?php the_content(); ?>
<?php endwhile; ?>

<?php get_footer(); ?>