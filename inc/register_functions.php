<?php #8Aug13 // The Bat-a-rangs
/* -------------------------------
	Usable Functions
---------------------------------*/

//// ---- get_custom_field('key', TRUE); Easy way to get custom fields
function get_custom_field($key, $echo = FALSE) {
	global $post;
	$custom_field = get_post_meta($post->ID, $key, true);
	if ($echo == FALSE) return $custom_field;
	echo $custom_field;
}

//// ---- Dynamic footer year, start to current year ---- ////
function skivvy_copyright() {
	global $wpdb;
	$copyright_dates = $wpdb->get_results("SELECT YEAR(min(post_date_gmt)) AS firstdate, YEAR(max(post_date_gmt)) AS lastdate FROM $wpdb->posts WHERE post_status = 'publish'");
	$output = '';
	if($copyright_dates) {
		$copyright = "Copyright &copy; " . $copyright_dates[0]->firstdate;
		if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
			$copyright .= '-' . $copyright_dates[0]->lastdate;
		}
		$output = $copyright;
	}
	return $output;
}

//// ---- the_snippet() function to replace the_excerpt() ---- //// the_snippet(72,'Read More');
function the_snippet($length=55,$readmore='Read More') {
  global $post;
  $text = $post->post_content;
  $text = strip_shortcodes( $text );
  $text = apply_filters('the_content', $text);
  $text = str_replace(']]>', ']]&gt;', $text);
  $more_link = '<a href="'.get_permalink($post->ID).'" class="readmorebtn">'.$readmore.'</a>';
  echo wp_trim_words($text,$length,$more_link); 
} 

//// ---- the_tree() function - Conditional to check if a page is a grandchild, great-grandchild or father down the hierarchy tree ---- ////
function is_tree($pid) {      // $pid = The ID of the page we're looking for pages underneath
    global $post;         // load details about this page

    $anc = get_post_ancestors( $post->ID );
    foreach($anc as $ancestor) {
        if(is_page() && $ancestor == $pid) {
            return true;
        }
    }
    if(is_page()&&(is_page($pid))) 
               return true;   // we're at the page or at a sub page
    else 
               return false;  // we're elsewhere
};

//// ---- Not Tested yet! - Auto Populates an area with given image folder  ---- ////
function auto_gallery($imgfolder="img/") {
	if ($handle = opendir( TEMPLATEPATH . $imgfolder) ) {
		$headers = array();
		while (false !== ($file = readdir($handle))) {
			$pos = strrpos( $file, '.' );
			if( $pos !== false && $pos > 0 ) {
				$file_name = substr( $file, 0, $pos );
				if( strpos( $file_name, "-thumbnail" ) === false ) {
					$file_ext = substr( $file, $pos+1 );
					$file_ext_low = strtolower( $file_ext );
					if( $file_ext_low == "jpg" || $file_ext_low == "jpeg" ) {
						$headers[$file_name] = array (
							'url' => "%s/$imgfolder" . $file,
							'thumbnail_url' => "%s/$imgfolder" . $file_name ."-thumbnail." . $file_ext,
							'description' => __( str_replace( "_", " ", $file_name ), 'twentyten' )
						);
					}
				}
			}
		}
		closedir($handle);
		register_default_headers( $headers );
	}
}

//// ---- Returns the portion of haystack which goes until the last occurrence of needle - Mean what I'm not sure, used in other functions---- ////
function reverse_strrchr($haystack, $needle, $trail) { return strrpos($haystack, $needle) ? substr($haystack, 0, strrpos($haystack, $needle) + $trail) : false; } 

//// ---- function leftover from twentyten, just in case. ---- ////
if ( ! function_exists( 'twentyten_posted_in' ) ) {
  function twentyten_posted_in() {
    // Retrieves tag list of current post, separated by commas.
    $tag_list = get_the_tag_list( '', ', ' );
    if ( $tag_list ) {
      $posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
    } elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
      $posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
    } else {
      $posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
    }
    // Prints the string, replacing the placeholders.
    printf(
      $posted_in,
      get_the_category_list( ', ' ),
      $tag_list,
      get_permalink(),
      the_title_attribute( 'echo=0' )
    );
  }
};


?>