<?php if ( have_posts() ) :

	// post counter
	$i = 1;
	
	while ( have_posts() ) : the_post(); ?>
	<?php // Post Counter
		$class_count = 'post-' . $i;
		
		if ( $i == 1 ) $class_count .= ' first';
				
		if ( $i % 2 == 0 ) : $class_count =  ' even';
		else : $class_count = ' odd';
			
		endif;
		
	?>
    <article class="post-snippet <?php echo $class_count; ?>">
        
		<h3 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
    
        <div class="post-meta"><?php
		
            // the_date();
			the_time('F j, Y');
            
            $cats_list = get_the_category_list( ', ' );
                if ( $cats_list ) echo " | Category: $cats_list";
            
            $tags_list = get_the_tag_list( '', ', ' );
                if ( $tags_list ) echo " | Tags: $tags_list" ;
            
        ?></div>
    
        <div class="post-content"><?php
        
            if ( is_archive() || is_search() ) {
                
                the_excerpt();
                
            } else {
                
                the_content();
                
            };
        ?></div>
    
    </article>
<?php
	$i++;
	endwhile;
?>
<div class="post-navigation"><?php
	if ( is_single() ) {
		
		previous_post_link( '%link', '' . _x( '&larr;', 'Previous post link', 'skivvy' ) . ' %title' );
		next_post_link( '%link', '%title ' . _x( '&rarr;', 'Next post link', 'skivvy' ) . '' );
		
	} else { 
	
		posts_nav_link( ' ', 'Previous', 'Next' );
		
	}
?></div>
<?php else : 

	
	
endif; ?>