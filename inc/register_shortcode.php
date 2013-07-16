<?php #21Jun13
//// ---- Use: [bloginfo key='name']
function shortcode_bloginfo( $atts ) {
   extract(shortcode_atts(array(
       'key' => '',
   ), $atts));
   return get_bloginfo($key);
} add_shortcode('bloginfo', 'shortcode_bloginfo');




/* -------------------------------
	Query Shortcode to use inside of Post/Pages/Widgets
	v. 21Jun13
		[query post_type=page posts_per_page=5]
			<h5><a href="{PERMALINK}">{TITLE}</a></h5>
			<div>{CONTENT}</div>
		[/query]
---------------------------------*/
function shortcode_query($atts, $content){
	extract(shortcode_atts(array( // a few default values
		'type' => null,	
		'show'  => 20,
		'cat' => null,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'caller_get_posts' => 1,
		'post__not_in' => get_option('sticky_posts'),
	), $atts));
	$args = array (
		'post_type' => $type,
		'posts_per_page'  => $show,
		'portfolio_category' => $cat,
		'orderby'         => $orderby,
		'order'           => $order,
		'post_status'     => 'publish'
	);
	global $post;
	
	$posts = new WP_Query($args);
	$output = '';
	if ($posts->have_posts()) while ($posts->have_posts()): $posts->the_post();
	// these arguments will be available from inside $content
	$parameters = array(
		'PERMALINK' => get_permalink(),
		'TITLE' => get_the_title(),
		'CONTENT' => get_the_content(),
		'EXCERPT' => get_the_excerpt(),
		'COMMENT_COUNT' => $post->comment_count,
		'CATEGORIES' => get_the_category_list(', '),
		'THUMB' => get_post_thumbnail(),
		// add here more...
	);
	
	$finds = $replaces = array();
	foreach($parameters as $find => $replace):
	$finds[] = '{'.$find.'}';
		$replaces[] = $replace;
	endforeach;
	$output .= str_replace($finds, $replaces, $content);
	
	endwhile;
	else
		return; // no posts found
	
	wp_reset_query();
	return html_entity_decode($output);
} add_shortcode('query', 'shortcode_query'); // */

//[posttype type="portfolio" cat="pond-water-features" show="20" orderby="date" orderin="asc"]
function shortcode_posttype($atts){
	extract( shortcode_atts( array(
		'type' => null,	
		'show'  => 20,
		'cat' => null,
		'orderby' => 'post_date',
		'order' => 'DESC'
	), $atts ) );
	$args = array (
		'post_type' => $type,
		'posts_per_page'  => $show,
		'portfolio_category' => $cat,
		'orderby'         => $orderby,
		'order'           => $order,
		'post_status'     => 'publish'
	);
	$the_query = new WP_Query( $args );
	if ($the_query->have_posts()){
		//$categori = print_r(get_category_by_slug( $cat, true ));
		$content = "";
		while ( $the_query->have_posts() ) : $the_query->the_post();
			$content .= '<div class="pstthmb"><a href="'.wp_get_attachment_url(get_post_thumbnail_id($post->ID)) /* .'" rel="shadowbox[portfolio-'.$cat.']"*/ . '" class="thickbox" rel="gallery-plants"' . '>'.get_the_post_thumbnail($post->ID,"thumbnail").'</a></div>';
		endwhile;
    } else { 
        $content = null;
    }
    wp_reset_postdata();
    return $content;
} add_shortcode( 'posttype', 'shortcode_posttype' );
?>