<?php get_header(); ?>
<?php if ( have_posts() ) the_post();?>
    <h1><?php
			if ( is_day() ) : echo 'Daily Archives: '.get_the_date();
			elseif ( is_month() ) : echo 'Monthly Archives: '.get_the_date('F Y');
			elseif ( is_year() ) : echo 'Yearly Archives: '.get_the_date('Y'); 
			else : echo 'News Archives';
			endif;
		?>
    </h1>
<?php rewind_posts(); ?>
<?php $i = 1; while ( have_posts() ) : the_post(); ?> 
    <div class="blogarticle <?php if ($i % 2 == 0) {echo 'even';} else { echo 'odd';}  if($i==1){echo " first"; }?>">
        <h1>
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
                <?php the_title(); ?>
            </a>
        </h1>
        <div class="post-date"><?php the_date();?></div>
        <?php
            if ( is_archive() || is_search() ) {
				the_excerpt();
			} else {
                the_content();
            };
			$cats_list = get_the_category_list( ', ' ); if($cats_list) {echo "Category: $cats_list";};
			echo ' | ';
            $tags_list = get_the_tag_list( '', ', ' ); if($tags_list){echo "Tags: $tags_list" ;};
        ?>
    </div>
<?php $i++; endwhile;?>
<?php posts_nav_link( ' ', 'Previous', 'Next' ); ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>