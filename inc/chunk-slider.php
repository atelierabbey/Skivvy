<?php wp_enqueue_script('jcycle2'); ?>
<?php $slidequery = new WP_Query(array(
	'post_type' => 'jCycle_slider',
	'posts_per_page' => 5,
	'order' => 'ASC',
	'orderby' => 'none'
)); ?>
<div class="cycle-slideshow" style="position:relative;" data-cycle-pager="#per-slide-template" data-cycle-slides=".cycle-slide" >
	<?php while ( $slidequery->have_posts() ) : $slidequery->the_post();
				$image_id = get_post_thumbnail_id();
				$image_url = wp_get_attachment_image_src($image_id,'full', true);
		?>
        <div class="cycle-slide" style="position:absolute;<?php echo "background-image:url('{$image_url[0]}'); ')";?>">
			<h1><?php the_title();?></h1>
            <?php //the_post_thumbnail();?>
            <?php the_content(); ?>
        </div>
	<?php endwhile; wp_reset_postdata(); ?>

	<div class='cycle-next cycle-pagerelement'></div>
	<div class='cycle-resume cycle-pagerelement' data-cycle-cmd="resume"></div>
	<div class='cycle-pause cycle-pagerelement' data-cycle-cmd="pause"></div>
	<div class='cycle-prev cycle-pagerelement'></div>
</div><div id="per-slide-template"></div>