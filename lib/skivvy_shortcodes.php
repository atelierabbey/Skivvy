<?php #3Jun15
/*
 *		-------------------------------------------------------
 *		SHORTCODES
 *		-------------------------------------------------------
 */

// Use: [$tag id="" class="$class" style="$style" title="$title" before="$before" after="$after" prepend="$prepend"	 func="$func"  param="$param" echoes="$echoes" ]
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
				'autop'   => 'true',
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

					if ( $tag == 'one_full' ) $output .= '<div class="page-wrapper">';
					$output .=	$newtitle;
					$output .=		'<div class="skivdiv-content">';
						if ( $func == '' ) {
							if ( $autop == 'true' ) {
								$output .= wpautop(do_shortcode($content));
							} else {
								$output .= do_shortcode($content);
							}
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


// Use: [bucket title="" img="" linkto="" linktext="" class="" id="" style=""][/bucket]
	function shortcode_bucket( $atts, $content = null, $tag ) {
		$attr = shortcode_atts( array(
			'url'=>'#',
			'target' => '',
			'class'=>'',
			'id'=>'',
			'style'=>'',
			'icon' => '',
			'img'=>'',
			'autop' => 'true',
			'xtra' => 'false',
			'title'=>'',
			'more'=>''
		), $atts );


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

		// icon
			if ( $attr['icon'] != '' ) {
				global $icon_locations;
				foreach ($icon_locations as $key => $value) {

						if ( $attr['icon'] == $key ) {

							$fileLocation = get_stylesheet_directory_uri(). '/img/'. $value;
							$fileInfo = pathinfo($fileLocation);

							$outIcon = '<a class="bucket-icon"' . $linkGuts . '>';

								if ( $fileInfo['extension'] == 'svg' ) {

									$outIcon .= file_get_contents( $fileLocation );

								} elseif ( $fileInfo['extension'] == 'png' || $fileInfo['extension'] == 'jpg' || $fileInfo['extension'] == 'gif' ) {

									$outIcon .= '<img src="'. $fileLocation . '" alt="icon-'. $key . '" >';

								} else {

									$outIcon .= $key;

								}
							
							$outIcon .= '</a>';
						}

				}

			}

		// Extra Link
			$outXLink = '';
			if ( $attr['xtra'] != 'false' ) {
				$outXLink = '<a class="bucket-lynx" '. $linkGuts .'></a>';
			}

		// Title
			$outTitle = '';
			if ( $attr['title'] ) {
				$outTitle = '<h3 class="bucket-title"><a' . $linkGuts . '>' . $attr['title'] .'</a></h3>';
			}

		// Content
			$outContent = '';
			if ( $content != null ) {
				$outContent .= '<span class="bucket-content">';
					if ( $attr['autop'] == 'true' ) {
						$outContent .= wpautop(do_shortcode($content));
					} else {
						$outContent .= do_shortcode($content);
					}
				$outContent .= '</span>';
			}

		// More
			$outMore = '';
			if ( $attr['more'] ) {
				$outMore = '<a class="bucket-more"' . $linkGuts . '>' . $attr['more'] . '</a>';
			}

		// RENDER
			$output = '<div' . $id . ' class="chunk-bucket'. $class . '" style="' . $style . '">';
				$output .= '<div class="bucket-wrap">';
					$output .= $outIcon;
					$output .= $outXLink;
					$output .= $outTitle;
					$output .= $outContent;
					$output .= $outMore;
					$output .= '<div class="clear"></div>';
				$output .= '</div>';
			$output .= '</div>';
		return $output;

	} add_shortcode( 'bucket', 'shortcode_bucket' );

// Slideshow shortcode
	add_shortcode('slideshow','shortcode_slideshow');
	add_shortcode('slide','shortcode_slide');
	function shortcode_slideshow( $atts, $content = null ) {
			wp_enqueue_script('jcycle2');
			extract( shortcode_atts( array(
				'time' => '4000'
			), $atts ) );
			$output = '<div class="cycle-slideshow" style="position:relative;" data-cycle-slides=".cycle-slide" data-timeout="' . $time . '" >';
				$output .= do_shortcode($content);
			$output .= '</div>';
			return $output;

	}
	function shortcode_slide( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'img' => '',
			'style' => ''
		), $atts ) );
		// SLIDE
		if ( $img != '' ) {
			$background_image = 'background-image:url(\'' . $img . '\');';
		}

		$output = '<div class="cycle-slide slide-' . get_the_ID() . '" style="position:absolute;' . $background_image . ' ' . $style .'">';
			$output .= '<div class="cycle-content">';
				$output .= '<div class="page-wrapper">';
					$output .= apply_filters( 'the_content' , $content);
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';
		return $output;
	} 

// Use: [blogfeed show="5" class="" length="55" morelink="Read More" alllink="See All Posts"]
	function shortcode_blogfeed( $atts ) {

		// Shortcode Attrs & Variable set up
		$atts = shortcode_atts(array(
			'show'   => 5,
			'class' => '',
			'length'   => 55,
			'morelink' => 'Read More',
			'alllink' => 'See All Posts'
		), $atts, 'blogfeed' );

		if ( $atts['alllink'] != '' ) {
			$alllink = '<a class="blogfeed-all" href="' . get_permalink( get_option( 'page_for_posts' ) ) . '">' . $atts['alllink'] . '</a>';
		} else {
			$alllink = '';
		}


		$blogfeed = new WP_Query(array(
			'posts_per_page' => $atts['show'],
			'order' => 'DESC',
			'orderby' => 'date'
		));

		// Output building
			$output = '<div class="blogfeed ' . $atts['class'] . '">';

				while ( $blogfeed->have_posts() ) {
					$blogfeed->the_post();

					$output .= '<div class="post-block">';

						// Title
							$output .= '<h4 class="post-title"><a href="' . get_permalink() . '" title="' . __( 'View - ' , 'skivvy' ) . the_title_attribute( 'echo=0' ) . '" rel="bookmark">' . get_the_title(). '</a></h4>';

						// Date
							$output .= '<div class="post-meta">' . get_the_time('F j, Y') . '</div>';

						// Content
							$output .= get_the_snippet( $atts['length'], $atts['morelink'] );

					$output .= '</div>';
				}
				wp_reset_postdata();

				$output .= $alllink;
			$output .= '</div>';

		return $output;

	} add_shortcode( 'blogfeed', 'shortcode_blogfeed' );

// Use: [clearall]
	function shortcode_clearall() {
		return '<div class="clear"></div>';
	} add_shortcode( 'clearall', 'shortcode_clearall' );

// Use: [bloginfo key='name']
	function shortcode_bloginfo( $atts ) {
		extract(shortcode_atts(array(
			'key' => '',
		), $atts));
		return get_bloginfo( $key );
	} add_shortcode( 'bloginfo', 'shortcode_bloginfo' );

// Use: [lorem words="55"]
	function shortcode_loremipsum ( $atts ) {
		extract( shortcode_atts( array(
				'words' => 55
			), $atts ) );
		$lipsum = 'Lorem dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.';
		return wp_trim_words( $lipsum , $words , '' );
	} add_shortcode( 'lorem', 'shortcode_loremipsum' );

// Use: [iframe]
	function shortcode_iframe ( $atts ) {
		$attr = shortcode_atts( array(
					'src' => '',
					'class' => '',
					'width' => '100%',
					'height' => '300'
		), $atts );
			if ( $attr['class'] ) {
				$class = 'class="'. $attr['class'] .'" ';
			}
			$output = '<iframe ' . $class . 'src="' . $attr['src'] . '" width="' . $attr['width'] . '" height="' . $attr['height'] . '" frameborder="0" allowfullscreen="allowfullscreen"></iframe>';
		return $output;
	} add_shortcode( 'iframe', 'shortcode_iframe' );

?>
