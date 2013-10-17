<?php #22Aug13

// for posts
add_filter( 'manage_posts_columns', 'Skivvy_AddThumbnailColumn' );
add_action( 'manage_posts_custom_column', 'Skivvy_AddThumbValue', 10, 2 );
// for pages
add_filter( 'manage_pages_columns', 'Skivvy_AddThumbnailColumn' );
add_action( 'manage_pages_custom_column', 'Skivvy_AddThumbValue', 10, 2 );
//*/

/* function Skivvy_allthumbcolumns(){
	$types = get_post_types( '', 'objects' );
	foreach( $types as $type ){
		if( isset( $type->rewrite->slug ) ){ // need the actual slug?  this will do it...
			$typo = $type->rewrite->slug;
			add_filter( "manage_".$typo."_columns", 'Skivvy_AddThumbnailColumn' );
			add_action( "manage_".$typo."_custom_column", 'Skivvy_AddThumbValue', 10, 2 );
		}
	}
}add_action( 'init', 'Skivvy_allthumbcolumns' ); // */
//// ---- Add Thumbnails in Manage Posts/Pages List ---- ////
function Skivvy_AddThumbnailColumn($cols) {
	$cols['thumbnail'] = __('Thumbnail');
	return $cols;
}
function Skivvy_AddThumbValue($column_name, $post_id) {
	$width = (int) 35;
	$height = (int) 35;
	if ( 'thumbnail' == $column_name ) {
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

//// ---- ADD CUSTOM POST TYPES TO THE DEFAULT RSS FEED ---- ////
/*
function skivvy_custom_feed_request( $vars ) {
 if (isset($vars['feed']) && !isset($vars['post_type']))
  $vars['post_type'] = array( 'post', 'site', 'plugin', 'theme', 'person' );
 return $vars;
} add_filter( 'request', 'skivvy_custom_feed_request' );  //*/

//// ---- MAKE CUSTOM POST TYPES SEARCHABLE ---- ////
/*
function skivvy_customPosttype_search( $query ) {
 if ( $query->is_search ) { $query->set( 'post_type', array( 'site', 'plugin', 'theme', 'person' )); } 
 return $query;
} add_filter( 'the_search_query', 'skivvy_customPosttype_search' ); //*/

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
} add_action( 'right_now_content_table_end' , 'skivvy_right_now_content_table_end' );

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
    $text = _n( 'Word', 'Words', $num );
	// This block will add your word count to the stats portion of the Right Now box
    echo "<tr><td class='first b'>{$num}</td><td class='t'>{$text}</td></tr>";
    // This line will add your word count to the bottom of the Right Now box.
    // echo '<p>This blog contains a total of <strong>' . $num . '</strong> published words!</p>';
} add_action('right_now_content_table_end', 'post_word_count'); 
add_action('activity_box_end', 'post_word_count');
?>