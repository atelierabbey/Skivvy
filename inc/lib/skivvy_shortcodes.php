<?php #16Jun14
/*
 *		-------------------------------------------------------
 *		SHORTCODES
 *		-------------------------------------------------------
 */
 
/*
** 		SHORTCODE - SKIVDIV
**		Use: [$tag 
**				class="$class"		// Any CSS class(es)
**				style="$style"		// any inline CSS 
**				title="$title"		// Renders either H2 (one full) or H3 (on all else) just before the "div.skivdiv-content" & addes a sanitized CSS class to the overall wrapper
**		]
*/
	$tags = array(
		'one_full',
		'one_half', 'one_half_last',
		'one_third', 'one_third_last',
		'two_third', 'two_third_last',
		'one_fourth', 'one_fourth_last',
		'three_fourth', 'three_fourth_last',
	);
	foreach( $tags as $tag ) {
		add_shortcode( $tag, 'shortcode_skiv_div' );
	}
	function shortcode_skiv_div( $atts, $content = null, $tag) {
			extract( shortcode_atts( array(
				'style' => '',
				'class' => '',
				'title' => ''
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
			// $title
				$newtitle = '';
				$titleclass = '';
				if ( $title != '' ) {
					$titleclass = ' ' . sanitize_title( $title );
					if ( $tag == 'one_full' ) {
						$newtitle = '<h2>' . $title . '</h2>';
					} else {
						$newtitle = '<h3>' . $title . '</h3>';
					}
				}


			// Output
				$output  =	'<div class="' . $tag . $class . $titleclass . '" '. $style . '>';
				$output .=	$newtitle;
				$output .=		'<div class="skivdiv-content">';
				$output .=			do_shortcode($content);
				$output .=			'<div class="clear"></div>';
				$output .=		'</div>';
				$output .=	'</div>';
				if ( $last === true ) {
					$output .= '<div class="clear"></div>';
				}
			return $output;
	}

// Use: [clearall]
	function shortcode_clearall() {
		return '<div class="clear"></div>';
	} add_shortcode( 'clearall', 'shortcode_clearall' );

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

?>