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
<?php rewind_posts();


$i = 1; while ( have_posts() ) : the_post(); ?> 
    <div class="blogarticle <?php if ($i % 2 == 0) {echo 'even';} else { echo 'odd';}  if ( $i==1 ){ echo " first"; }?>">
        <h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
        <div class="post-meta"><?php
        	the_date();
        	
        	$cats_list = get_the_category_list( ', ' ); if( $cats_list) echo " | Category: $cats_list";
        	
        	$tags_list = get_the_tag_list( '', ', ' ); if( $tags_list ) echo " | Tags: $tags_list" ;
        ?></div>
        <div class="post-content"><?php
            if ( is_archive() || is_search() ) {
				the_excerpt();
			} else {
                the_content();
            };
        ?></div>
    </div>
<?php $i++; endwhile;?>
<div class="post-pager"><?php posts_nav_link( ' ', 'Previous', 'Next' ); ?></div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
