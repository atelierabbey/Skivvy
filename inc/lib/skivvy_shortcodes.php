<?php #24Feb15
/*
 *		-------------------------------------------------------
 *		SHORTCODES
 *		-------------------------------------------------------
 */

/*
** 		SHORTCODE - SKIVDIV
**		Use: [$tag
**				id="$id"				// Adds ID to it.. serious.
**				class="$class"		// Any CSS class(es). Space seperate.
**				style="$style"		// any inline CSS. Add as normal in the " style='' " attribute.
**				title="$title"		// Renders either H2 (one full) or H3 (on all else) just before the "div.skivdiv-content" & addes a sanitized CSS class to the overall wrapper
**				before="$before"    // Adds content before open the skiv-div
**				after="$after"      // Adds content after closing the skiv-div
**				prepend="$prepend"	// Adds content after opening the skiv-div (before the title's h3/h2)
**
**			// Function attributes - Deals with turning the SkivDiv into a functional area.
**				func="$func"        // name of function to be called, works with $param. i.e. $func($param);
**				param="$param"      // Comma seperated string in order of parameters. CANNOT PASS AN ARRAY!
**				echoes="$echoes"    // If the function echoes content, $echoes should equal '1', else default = '0'. Shortcodes must return a value.
**
**		]
*/
	$tags = array(
		'fullwidth',
		'one_full',
		'one_half', 'one_half_last',
		'one_third', 'one_third_last',
		'two_third', 'two_third_last',
		'one_fourth', 'one_fourth_last',
		'three_fourth', 'three_fourth_last',
		'one_fifth', 'one_fifth_last',
		'two_fifth', 'two_fifth_last',
		'three_fifth', 'three_fifth_last',
		'four_fifth', 'four_fifth_last',
		'one_sixth','one_sixth_last',
		'five_sixth', 'five_sixth_last'
	);
	foreach( $tags as $tag ) {
		add_shortcode( $tag, 'shortcode_skiv_div' );
	}
	function shortcode_skiv_div( $atts, $content = null, $tag) {
			extract( shortcode_atts( array(
				'id'      => '',
				'style'   => '',
				'class'   => '',
				'title'   => '',
				'func'    => '',
				'param'   => '',
				'prepend' => '',
				'before'  => '',
				'after'   => '',
				'echoes'  => 0
			), $atts ) );

			// $style
				if ( !empty($style) ) {
					$style = ' style="'.$style.';"';
				}
			// $class
				if ( $class != '' ) {
					$class = ' ' . $class;
				}
			// $id
				if ( $id != '' ) {
					$id = ' id="' . $id . '"';
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
					if ( $tag == 'one_full' || $tag == 'fullwidth' ) {
						$newtitle = '<h2>' . $title . '</h2>';
					} else {
						$newtitle = '<h3>' . $title . '</h3>';
					}
				}


			// RENDERING ------
				$output  =	 $before . '<div' . $id . ' class="' . $tag . $class . $titleclass . '" '. $style . '>' . $prepend;
					$output .=	$newtitle;
					if ( $tag == 'one_full' ) $output .= '<div class="page-wrapper">';
					$output .=		'<div class="skivdiv-content">';
						if ( $func == '' ) {
								$output .= do_shortcode($content);
						} else {
							if ( $echoes === 0 ) {
								// if $func( $param ) RETURN value
									$output .= call_user_func_array( $func, explode(",", $param) );
							} else {
								// if $func( $param ) ECHO value, the below function captures the buffer and returns the value as per shortcode specs.
									ob_start();
									call_user_func_array( $func, explode(",", $param) );
									$output .= ob_get_clean();
							}
						}
					$output .=			'<div class="clear"></div>';
					$output .=		'</div>';
					if ( $tag == 'one_full' ) $output .= '</div>';
					$output .=	'</div>' . $after;
				if ( $last === true ) {
					$output .= '<div class="clear"></div>';
				}
			return $output;
	}

// Use: [newsfeed show="5" class="" length="55" morelink="Read More" alllink="See All Posts"]
function shortcode_newsfeed( $atts ) {


	// Shortcode Attrs & Variable set up
	$atts = shortcode_atts(array(
		'show'   => 2,
		'category' => '',
		'tag' => '',
		'class' => '',
		'length'   => 55,
		'morelink' => 'Read More',
		'alllink' => 'See All Posts',
		'title' => ''
	), $atts, 'newsfeed' );

	if  ( $atts['category'] != '' ) {
		$allpermalink = esc_url(get_category_link( get_category_by_slug( $atts['category'] )->term_id ));

	} elseif( $atts['tag'] != '' ) {
		$allpermalink = esc_url(get_category_link( get_cat_ID( 'Category Name' ) ));

	} else {
		$allpermalink = get_permalink( get_option( 'page_for_posts' ) );

	}


	if ( $atts['alllink'] != '' ) {
		$alllink = '<a class="blogfeed-all" href="' . $allpermalink . '">' . $atts['alllink'] . '</a>';
	}

	if ( $atts['title'] != '' ) {
		$title = '<h3><a href="' . $allpermalink . '">' . $atts['title'] . '</a></h3>';
	}


	$newsfeed = new WP_Query(array(
		'posts_per_page' => $atts['show'],
		'category_name' => $atts['category'],
		'tag' => $atts['tag'],
		'order' => 'DESC',
		'orderby' => 'date'
	));


	// Output building
		$output = '<div class="newsfeed ' . $atts['class'] . '">';
			$output .= $title;
			$output .= '<div class="skivdiv-content">';


				while ( $newsfeed->have_posts() ) {
					$newsfeed->the_post();

					$output .= '<div class="post-block">';

						// Title
							$output .= '<h4 class="post-title"><a href="' . get_permalink() . '" title="' . __( 'View - ' , 'skivvy' ) . the_title_attribute( 'echo=0' ) . '" rel="bookmark">' . get_the_title(). '</a></h4>';

						// Post Meta
							$output .= '<div class="post-meta">';
								$output .= get_the_time('F j, Y');
								$tags_list = get_the_tag_list( '', ', ' );
									if ( $tags_list ) $output .=  __( ' | ' , 'skivvy' ) . ' ' . $tags_list;
							$output .= '</div>';

						// Content
						if ($atts['length'] == '0' || $atts['length'] == 'false' ) {
							// nothing
						} else {
							$output .= get_the_snippet( $atts['length'], $atts['morelink'] );
						}

					$output .= '</div>';
				} wp_reset_postdata();

				$output .= $alllink;
				$output .= '<div class="clear"></div>';
			$output .= '</div>';
		$output .= '</div>';


	return $output;

} add_shortcode( 'newsfeed', 'shortcode_newsfeed' );





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
