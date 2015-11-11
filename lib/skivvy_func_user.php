<?php #10Nov15
/*
 *		-------------------------------------------------------
 *		Usable functions
 *		-------------------------------------------------------
 */

// get_the_snippet()
function get_the_snippet( $atts = array() ) {
	global $post;
	if ( empty( $post ) ) return '';

	$attr = wp_parse_args( $atts, array(
		'more'           => 'Read More',
		'length'         => '55',
		'cut'            => 'words',		// Words or Letters
		'ignoreexcerpt'  => 'false'
	));


	if ( post_password_required() ) {
		return __( 'There is no excerpt because this is a protected post.' );
	}
	if ( has_excerpt(  get_the_ID() ) && $attr['ignoreexcerpt'] != 'false') {
		$text = get_the_excerpt();
	} else {
		$text = get_the_content();
	}
	$text = strip_shortcodes( $text );
	$text = apply_filters('the_content', $text);
	$text = str_replace('\]\]\>', ']]&gt;', $text);
    $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
    $text = strip_tags($text, '<p>');
    $words = explode(' ', $text, $attr['length'] + 1);
	if ( count($words) > $attr['length'] ) {
		array_pop($words);
		array_push($words, '...');
		$text = implode(' ', $words);
	}
	if ( $attr['more'] != '' ) {
		$text .= '<a href="'.get_permalink( get_the_ID() ).'" class="readmorebtn">'.$attr['more'].'</a>';
	}
	return $text;
}


//// ---- the_snippet() ---- ////  function to replace the_excerpt(), ex. the_snippet(72,'Read More');
function the_snippet( $length=55, $readmore = 'Read More' ) {
	$attr = array(
		'more'           => $readmore,
		'length'         => $length,
		'cut'            => 'words',		// Words or Letters
		'ignoreexcerpt'  => 'false'
	);

	echo apply_filters( 'the_snippet', get_the_snippet( $attr ) );
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