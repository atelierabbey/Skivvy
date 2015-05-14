<?php #8Sep14
/*
 *		-------------------------------------------------------
 *		Usable functions
 *		-------------------------------------------------------
 */

// get_the_snippet()
function get_the_snippet( $atts ) {
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
	if ( has_excerpt( $post->ID ) && $attr['ignoreexcerpt'] != 'false') {
		$text = get_the_excerpt();
	} else {
		$text = get_the_content();
	}
	$text = strip_shortcodes( $text );
	$text = apply_filters('the_content', $text);
	$text = str_replace('\]\]\>', ']]&gt;', $text);
    $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
    $text = strip_tags($text, '<p>');
    $words = explode(' ', $text, $length + 1);
	if (count($words)> $length) {
		array_pop($words);
		array_push($words, '...');
		$text = implode(' ', $words);
	}
	$text = '<span class="post-snippet">'. $text . '</span>';
	if ( $readmore != '' ) {
		$text .= '<a href="'.get_permalink($post->ID).'" class="readmorebtn">'.$readmore.'</a>';
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


if ( ! function_exists( chunkifier ) ) {
	function chunkifier ( $atts ) {

		$attr = wp_parse_args( $atts, array(
			'tag' => '',
			'content' => '',
			'url'=>'#',
			'target' => '',
			'class'=>'',
			'id'=>'',
			'style'=>'',
			'img'=>'',
			'xtra' => 'false',
			'title'=>'',
			'more'=>''
		));


		// Container
			// Container ID
				$id = '';
				if ( $attr['id'] != '' ){
					$id = ' id="' . $attr['id'] .'" ';
				}

			// Container class
				$class = '';
				if ( $attr['class'] != '' ) {
					$class = ' '. $attr['class'];
				}

			// Container style
				$style = '';
				if ( $attr['img'] ){
					$style .= 'background-image:url('.$attr['img'].');';
				}
				if ( $attr['style'] ){
					$style .= '' . $attr['style'];
				}

		// LinkGuts
			$linkGuts = ' href="' . $attr['url'] .'"';

			if ( $attr['target'] )
				$linkGuts .= ' target="'. $attr['target'] .'"';

			if ( $attr['more'] != '' ) {
				$linkGuts .= ' title="'. $attr['linktext']  . ' - ' . $attr['title'] .'"';
			} else {
				$linkGuts .= ' title="'. $attr['title'] .'"';
			}

		// Extra Link
			$outXLink = '';
			if ( $attr['xtra'] != 'false' ) {
				$outXLink = '<a class="' . $attr['tag'] . '-lynx" '. $linkGuts .'></a>';
			}

		// Title
			$outTitle = '';
			if ( $attr['title'] ) {
				$outTitle = '<h3 class="' . $attr['tag'] . '-title"><a' . $linkGuts . '>' . $attr['title'] .'</a></h3>';
			}

		// Content
			$outContent = '';
			if ( $attr['content'] != '' ) {
				$outContent = '<span class="' . $attr['tag'] . '-content">'. wpautop( do_shortcode( $attr['content'] ) ).'</span>';
			}

		// More
			$outMore = '';
			if ( $attr['more'] ) {
				$outMore = '<a class="' . $attr['tag'] . '-more"' . $linkGuts . '>' . $attr['more'] . '</a>';
			}

		// RENDER
			$output = '<div' . $id . ' class="' . $attr['tag'] . '-chunk'. $class . '" style="' . $style . '">';
				$output .= '<div class="' . $attr['tag'] . '-wrap">';
					$output .= $outXLink;
					$output .= $outTitle;
					$output .= $outContent;
					$output .= $outMore;
					$output .= '<div class="clear"></div>';
				$output .= '</div>';
			$output .= '</div>';
		return $output;
	}
}


/*
 *		-------------------------------------------------------
 *		WordPress Functional Extensions
 *		-------------------------------------------------------
 */

//// ---- Mobile Menu Walker Menu ---- ///
class Walker_Nav_Mobile extends Walker_Nav_Menu {
	function start_lvl(&$output, $depth){
		$indent = str_repeat("\t", $depth); // don't output children opening tag (`<ul>`)
	}

	function end_lvl(&$output, $depth){
		$indent = str_repeat("\t", $depth); // don't output children closing tag
	}

	/**
	* Start the element output.
	*
	* @param  string $output Passed by reference. Used to append additional content.
	* @param  object $item   Menu item data object.
	* @param  int $depth     Depth of menu item. May be used for padding.
	* @param  array $args    Additional strings.
	* @return void
	*/
	function start_el(&$output, $item, $depth, $args) {
 		$url = '#' !== $item->url ? $item->url : '';
 		$output .= '<option value="' . $url . '">' . $item->title;
	}

	function end_el(&$output, $item, $depth){
		$output .= "</option>\n"; // replace closing </li> with the option tag
	}
}


?>
