<?php #28Jun13 // The Bat-a-rangs
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




/* -------------------------------
	Thoughtless Functions - WP does it for you via actions and filters
---------------------------------*/
//// ---- get rid of or hide useless menu items ---- ////
function skivvy_remove_menu_pages() { remove_menu_page('link-manager.php');} add_action( 'admin_menu', 'skivvy_remove_menu_pages' );
function skivvy_hide_menus() {echo '<style>#menu-comments{ display:none; }</style>';} add_action('admin_head', 'skivvy_hide_menus');

//// ---- Removes the default gallery shortcode css ---- ////
function twentyten_remove_gallery_css( $css ) { return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );}add_filter( 'gallery_style', 'twentyten_remove_gallery_css' );

//// ---- Display details at the front and back of all template parts via get_template_part ---- ////
/*add_action('all','template_snoop');
function template_snoop(){
    $args = func_get_args();
    if( !is_admin() and $args[0] ){
        if( $args[0] == 'template_include' ) {
            echo "<!-- Base Template: {$args[1]} -->\n";
        } elseif( strpos($args[0],'get_template_part_') === 0 ) {
            global $last_template_snoop;
            if( $last_template_snoop )
                echo "\n\n<!-- End Template Part: {$last_template_snoop} -->";
            $tpl = rtrim(join('-',  array_slice($args,1)),'-').'.php';
            echo "\n<!-- Template Part: {$tpl} -->\n\n";
            $last_template_snoop = $tpl;
        }
    }
}  //*/

//// ---- Increase functions of Text/HTML Widgets ---- ////
add_filter('widget_text', array( $wp_embed, 'run_shortcode' ), 8 ); // oEmbed 2
add_filter('widget_text', array( $wp_embed, 'autoembed'), 8 ); // oEmbed
add_filter('widget_text', 'do_shortcode'); // Shortcodes

//// ---- Removes "Private:" & "Password:" from protected pages ---- ////
function skip_password_prefix($title) {
  $title = attribute_escape($title);
  $findthese = array(
      '#Protected:#',
      '#Private:#'
  );
  $replacewith = array(
      '', // What to replace "Protected:" with
      '' // What to replace "Private:" with
  );
  $title = preg_replace($findthese, $replacewith, $title);
  return $title;
} add_filter('the_title', 'skip_password_prefix');

//// ---- Add featured images to RSS feed ---- ////
function rss_post_thumbnail($content) {
	global $post;
	if(has_post_thumbnail($post->ID)) {
		$content = '<p>' . get_the_post_thumbnail($post->ID) .
		'</p>' . get_the_content();
	}
	return $content;
}
add_filter('the_excerpt_rss', 'rss_post_thumbnail');
add_filter('the_content_feed', 'rss_post_thumbnail');

//// ---- Add the top level parent page to the body class ---- ////
function parent_body_class($classes) {
    global $wpdb, $post;
    if (is_page()) {
        if ($post->post_parent) {
            $parent  = end(get_post_ancestors($current_page_id));
        } else {
            $parent = $post->ID;
        }
        $post_data = get_post($parent, ARRAY_A);
        $classes[] = 'section-' . $post_data['post_name'];
    }
    return $classes;
} add_filter('body_class','parent_body_class');

//// ---- ADD CUSTOM POST TYPES TO THE DEFAULT RSS FEED ---- ////
function skivvy_custom_feed_request( $vars ) {
 if (isset($vars['feed']) && !isset($vars['post_type']))
  $vars['post_type'] = array( 'post', 'site', 'plugin', 'theme', 'person' );
 return $vars;
} add_filter( 'request', 'skivvy_custom_feed_request' );

//// ---- MAKE CUSTOM POST TYPES SEARCHABLE ---- ////
function skivvy_customPosttype_search( $query ) {
 if ( $query->is_search ) { $query->set( 'post_type', array( 'site', 'plugin', 'theme', 'person' )); } 
 return $query;
} add_filter( 'the_search_query', 'skivvy_customPosttype_search' );

//// ---- ADD CUSTOM POST TYPES TO THE 'RIGHT NOW' DASHBOARD WIDGET ---- ////
function skivvy_right_now_content_table_end() {
 $args = array(
  'public' => true ,
  '_builtin' => false
 );
 $output = 'object';
 $operator = 'and';
 $post_types = get_post_types( $args , $output , $operator );
 foreach( $post_types as $post_type ) {
  $num_posts = wp_count_posts( $post_type->name );
  $num = number_format_i18n( $num_posts->publish );
  $text = _n( $post_type->labels->singular_name, $post_type->labels->name , intval( $num_posts->publish ) );
  if ( current_user_can( 'edit_posts' ) ) {
   $num = "<a href='edit.php?post_type=$post_type->name'>$num</a>";
   $text = "<a href='edit.php?post_type=$post_type->name'>$text</a>";
  }
  echo '<tr><td class="first num b b-' . $post_type->name . '">' . $num . '</td>';
  echo '<td class="text t ' . $post_type->name . '">' . $text . '</td></tr>';
 }
 $taxonomies = get_taxonomies( $args , $output , $operator ); 
 foreach( $taxonomies as $taxonomy ) {
  $num_terms  = wp_count_terms( $taxonomy->name );
  $num = number_format_i18n( $num_terms );
  $text = _n( $taxonomy->labels->singular_name, $taxonomy->labels->name , intval( $num_terms ));
  if ( current_user_can( 'manage_categories' ) ) {
   $num = "<a href='edit-tags.php?taxonomy=$taxonomy->name'>$num</a>";
   $text = "<a href='edit-tags.php?taxonomy=$taxonomy->name'>$text</a>";
  }
  echo '<tr><td class="first b b-' . $taxonomy->name . '">' . $num . '</td>';
  echo '<td class="t ' . $taxonomy->name . '">' . $text . '</td></tr>';
 }
}
add_action( 'right_now_content_table_end' , 'wph_right_now_content_table_end' );
//// ---- Add Thumbnails in Manage Posts/Pages List ---- ////
function Skivvy_AddThumbnailColumn($cols) {
	$cols['thumbnail'] = __('Thumbnail');
	return $cols;
}
function Skivvy_AddThumbValue($column_name, $post_id) {
	$width = (int) 35;
	$height = (int) 35;
	if ( 'thumbnail' == $column_name ) {
		// thumbnail of WP 2.9
		$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
		// image from gallery
		$attachments = get_children( array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
		if ($thumbnail_id)
			$thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
		elseif ($attachments) {
			foreach ( $attachments as $attachment_id => $attachment ) {
				$thumb = wp_get_attachment_image( $attachment_id, array($width, $height), true );
			}
		}
			if ( isset($thumb) && $thumb ) {
				echo $thumb;
			} else {
				echo __('None');
			}
	}
}
// for posts
add_filter( 'manage_posts_columns', 'Skivvy_AddThumbnailColumn' );
add_action( 'manage_posts_custom_column', 'Skivvy_AddThumbValue', 10, 2 );
// for pages
add_filter( 'manage_pages_columns', 'Skivvy_AddThumbnailColumn' );
add_action( 'manage_pages_custom_column', 'Skivvy_AddThumbValue', 10, 2 );

//// ---- Remove Plugin Update Notice ONLY for INACTIVE plugins ---- ////
function skivvy_update_active_plugins($value = '') {
    // The $value array passed in contains the list of plugins with time marks when the last time the groups was checked for version matchThe $value->reponse node contains an array of the items that are out of date. This response node is use by the 'Plugins' menu for example to indicate there are updates. Also on the actual plugins listing to provide the yellow box below a given plugin to indicate action is needed by the user.     */
    if ((isset($value->response)) && (count($value->response))) {

        // Get the list cut current active plugins
        $active_plugins = get_option('active_plugins');    
        if ($active_plugins) {

            //  Here we start to compare the $value->response
            //  items checking each against the active plugins list.
            foreach($value->response as $plugin_idx => $plugin_item) {

                // If the response item is not an active plugin then remove it.
                // This will prevent WordPress from indicating the plugin needs update actions.
                if (!in_array($plugin_idx, $active_plugins))
                    unset($value->response[$plugin_idx]);
            }
        }
        else {
             // If no active plugins then ignore the inactive out of date ones.
            foreach($value->response as $plugin_idx => $plugin_item) {
                unset($value->response);
            }          
        }
    }  
    return $value;
} add_filter('transient_update_plugins', 'update_active_plugins');

//// ---- Counts word in posts,  ---- ////
function post_word_count() {
    $count = 0;
    $posts = get_posts( array(
        'numberposts' => -1,
        'post_type' => array( 'post', 'page' )
    ));
    foreach( $posts as $post ) {
        $count += str_word_count( strip_tags( get_post_field( 'post_content', $post->ID )));
    }
    $num =  number_format_i18n( $count );
    // This block will add your word count to the stats portion of the Right Now box
    $text = _n( 'Word', 'Words', $num );
    echo "<tr><td class='first b'>{$num}</td><td class='t'>{$text}</td></tr>";
    // This line will add your word count to the bottom of the Right Now box.
    echo '<p>This blog contains a total of <strong>' . $num . '</strong> published words!</p>';
}
add_action( 'right_now_content_table_end', 'post_word_count'); // add to Content Stats table
add_action('activity_box_end', 'post_word_count'); // add to bottom of Activity Box

?>