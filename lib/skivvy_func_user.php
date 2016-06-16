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


// Skivvy Default Logo
/*
NEED:
Middle parse
Middle should be img or text
parse in bg img
use default
if function exists,& has custom logo, use custom logo
*/
	function get_skivvy_logo( $atts ) {
		$attr = wp_parse_args( $atts, array(
				'id'    => 'logo',
				'class' => '',
				'title' => esc_attr( get_bloginfo( 'name', 'display' ) ),
				'alt'   => esc_attr( get_bloginfo( 'name', 'display' ) ),
				'href'  => home_url( '/' ),
				'itemprop-url'  => 'url',
				'itemprop-logo' => 'logo',
				'rel'      => 'home',
		));


		$attributes_link = array();
		$attributes_link[] = 'id="'         . $attr['id']           .'"';
		$attributes_link[] = 'class="'      . $attr['class']        .'"';
		$attributes_link[] = 'title="'      . $attr['title']        .'"';
		$attributes_link[] = 'itemprop="'   . $attr['itemprop-url'] .'"';
		$attributes_link[] = 'rel="'        . $attr['rel']          .'"';
		$attributes_link[] = 'href="'       . $attr['href']         .'"';

		$attributes_img = array();
		$attributes_img[]  = 'alt="'        . $attr['alt']          .'"';
		$attributes_img[]  = 'src="'        . get_stylesheet_directory_uri() . '/img/logo.png"';

		$output = '<a ' . join(' ', $attributes_link) . '>';
			$output .= '<img ' . join(' ', $attributes_img) . '>';
		$output .= '</a>';

		return apply_filters('get_skivvy_logo', $output);
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