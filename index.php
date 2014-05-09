<?php get_header(); ?>
<section class="content">
	<section class="page-content">
		<?php get_template_part( 'inc/chunk' , 'title' ); // The Content ?>
		<?php if ( is_front_page() ) get_template_part( 'inc/chunk' , 'slider' ); // Slider ?>
		<?php get_template_part( 'inc/chunk' , 'content' ); // The Content ?>
		<?php get_template_part( 'inc/chunk' , 'pagination' ); // Pagination ?>
		<?php echo "&nbsp;"; // Anti-collapse Space. ?>
	</section>
	<?php // get_sidebar();?>
</section>
<?php get_footer(); ?>