<?php #12Jun14
/*
 *		-------------------------------------------------------
 *		FUNCTIONS
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










/*
 *		-------------------------------------------------------
 *		SHORTCODES
 *		-------------------------------------------------------
 */

//// Use: [skivdiv key="" class="$class" style="$style"]
	$tags = array(
		'one_half', 'one_half_last',
		'one_third', 'one_third_last',
		'two_third', 'two_third_last',
		'one_fourth', 'one_fourth_last',
		'three_fourth', 'three_fourth_last',
	);
	foreach( $tags as $tag ) {
		add_shortcode( $tag, 'shortcode_skivv_div' );
	}
	function shortcode_skivv_div( $atts, $content = null, $tag) {
			extract( shortcode_atts( array(
				'style' => '',
				'class' => ''
			), $atts ) );

			// $style
				if ( !empty($style) ) {
					$style = ' style="'.$style.';"';
				}
			// $class
				if ( $class != '' ) {
					$class = ' ' . $class;
				}
			// $last
				$last = '';
				if ( strpos( $tag, '_last' ) !== false ) {
					$tag = str_replace( '_last', ' last', $tag);
					$last = true;
				}

			// Output
				$output  =	'<div class="' . $tag . $class  . '" '. $style . '>';
				$output .=		'<div class="skivdiv-content">';
				$output .=			do_shortcode($content);
				$output .=		'</div>';
				$output .=	'</div>';
				if ( $last === true ) {
					$output .= '<div class="clear"></div>';
				}
			return $output;
	}

//// Use: [bloginfo key='name']
	function shortcode_bloginfo( $atts ) {
		extract(shortcode_atts(array(
			'key' => '',
		), $atts));
		return get_bloginfo( $key );
	} add_shortcode( 'bloginfo', 'shortcode_bloginfo' );

/// Use [lorem words="55"]
function shortcode_loremipsum ( $atts ) {
	extract( shortcode_atts( array(
			'words' => 55
		), $atts ) );
	$lipsum = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.';
	return wp_trim_words( $lipsum , $words , '' );
} add_shortcode( 'lorem', 'shortcode_loremipsum' );




/*
 *		-------------------------------------------------------
 *		Other Tools
 *		-------------------------------------------------------
 */
/*
**
**		Template for Maintenance page
**			23May13
**
		To do
		- Hook references and images to theme
		- if logged in, hide function
		- create '?key=unlock' function
		- Create cookie with function
		- Override coming soon template with coming-soon.php in theme?
*/
/*
function maintenanceTemplatePage() {
	echo (
		'<!DOCTYPE html>'.
		'<html><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><meta name="viewport" content="width=device-width">
			<title>'. get_bloginfo('title') . ' | Undergoing Maintenance</title></head>
			<body style="text-align:center;"><br>
			<p>Thank you for visiting, we are currently working on the site.</p>
			<p>Please bookmark us and return later!</p>
		</body></html>'
	);
} //*/


?>