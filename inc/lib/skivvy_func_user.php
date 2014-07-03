<?php #16Jun14
/*
 *		-------------------------------------------------------
 *		Usable functions
 *		-------------------------------------------------------
 */

//// ---- the_snippet() ---- ////  function to replace the_excerpt(), ex. the_snippet(72,'Read More');
function the_snippet($length=55,$readmore='Read More') {
	global $post;
	$text = $post->post_content;
	$text = strip_shortcodes( $text );
	$text = apply_filters('the_content', $text);
	$text = str_replace(']]>', ']]&gt;', $text);
	$more_link = '... <a href="'.get_permalink($post->ID).'" class="readmorebtn">'.$readmore.'</a>';
	echo wp_trim_words($text,$length,$more_link); 
} 

// ---- get_the_thumbnail_caption() ---- //// Returns the caption for attached featured image featured image
function get_the_thumbnail_caption() {
	global $post;

	$thumbnail_id    = get_post_thumbnail_id($post->ID);
	$thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

	if ($thumbnail_image && isset($thumbnail_image[0])) {
		$caption = $thumbnail_image[0]->post_excerpt;
	}
	return $caption;
}

?>