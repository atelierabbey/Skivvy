<?php get_header(); ?>
<section id="content">
	<div class="page-wrapper">
		<section class="page-content clearfix"><?php

			if ( is_front_page() ) get_template_part( 'inc/chunk' , 'slider' ); // Slider

			get_template_part( 'inc/chunk' , 'title' ); // The Title

			get_template_part( 'inc/chunk' , 'content' ); // The Content

			if ( ! is_page() ) get_template_part( 'inc/chunk' , 'pagination' ); // Pagination

		?></section>
		<?php // get_sidebar();?>
	</div>
</section>
<?php get_footer(); ?>
