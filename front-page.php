<?php get_header(); ?>

<?php wp_enqueue_script('jcycle2'); ?>

<?php $slidequery = new WP_Query(array(
	'post_type' => 'jCycle_slider',
	'posts_per_page' => 5,
	'order' => 'ASC',
	'orderby' => 'none'
)); ?>

<div class="cycle-slideshow" style="position:relative;" data-cycle-pager="#per-slide-template" data-cycle-slides=".cycle-slide" >
	<?php while ( $slidequery->have_posts() ) : $slidequery->the_post(); ?>
        <div class="cycle-slide" style="position:absolute;">
			<h1><?php the_title();?></h1>
            <?php the_post_thumbnail();?>
            <?php the_content(); ?>
        </div>
	<?php endwhile; wp_reset_postdata(); ?>

    <div class='cycle-next cycle-pagerelement'><img src="<?php bloginfo('template_directory'); ?>/img/slider-next.png"></div>
    <div class='cycle-resume cycle-pagerelement' data-cycle-cmd="resume"><img src="<?php bloginfo('template_directory'); ?>/img/slider-resume.png"></div>
    <div class='cycle-pause cycle-pagerelement' data-cycle-cmd="pause"><img src="<?php bloginfo('template_directory'); ?>/img/slider-pause.png"></div>
    <div class='cycle-prev cycle-pagerelement'><img src="<?php bloginfo('template_directory'); ?>/img/slider-prev.png"></div>
</div>
<div id="per-slide-template"></div>

<?php while ( have_posts() ) : the_post(); ?>
	<?php the_content(); ?>
<?php endwhile; ?>
<?php get_footer(); ?>
