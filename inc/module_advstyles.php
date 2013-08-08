<?php #8Aug13 // Extra spicy crime fighting
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

//// ---- Advanced Menu Styling ---- ////
if( class_exists( 'SimpleXMLElement' ) ) {
// Cleans up and counts number of menu items
 function skivvy_advmenus( $output ) {
  libxml_use_internal_errors( false );
  try {
   $xml = new SimpleXMLElement( preg_replace( '#>([^<]+)<#i', '><![CDATA[\\1]]><', $output ), LIBXML_NOWARNING );
  }
  catch( Exception $e ) {
   return $output;
  }
  $container = array();
  if( ! $xml->li ) {
   list( , $item ) = each( $xml->xpath( 'ul' ) );
   if( ! $item ) list( , $item ) = each( $xml->xpath( 'menu' ) );
   if( $item ) {
	$container = array( '<' . $xml->getName(), '</' . $xml->getName() . '>' );
	foreach( $xml->attributes() as $key => $value ) $container[0] .= ' ' . $key . '="' . $value . '"';
	$container[0] .= '>';
   }
  }
  else $item = $xml;
  if( count( $item ) ) return $container[0]. preg_replace( '#<\?[^>]*\?>#', '', preg_replace( '#<!\[CDATA\[([^<]+)\]\]>#', '\\1', d4_advmenus_level( $item )->asXML() ) ) . $container[1];
   else return $container[0] . $output . $container[1];
 }

// Adds .odd-menu-item , .even-menu-item , .last-menu-item , .first-menu-item  to the Nav menu
 function d4_advmenus_level( $xml ) {
  if( 0 < $count = count( $xml->li ) ) {
   $i = 1;
   foreach( $xml->li as $item ) {
    $attributes = $item->attributes();
    // Adds Even Odd classes
	if( $i % 2 ) $attributes['class'] = 'odd-menu-item ' . $attributes['class'];
     else $attributes['class'] = 'even-menu-item ' . $attributes['class'];
	// Adds parent class if has submenu
    if( $item->ul ) {
	 $attributes['class'] = 'parent-menu-item ' . $attributes['class'];
	 d4_advmenus_level( $item->ul );
	}
    elseif( $item->menu ) {
	 $attributes['class'] = 'parent-menu-item ' . $attributes['class'];
	 d4_advmenus_level( $item->menu );
	}
	// Adds First and Last class
    if( $i == $count ) $attributes['class'] = 'last-menu-item ' . $attributes['class'];
    if( $i == 1 ) $attributes['class'] = 'first-menu-item ' . $attributes['class'];
    $i ++;
   }
  }
  return $xml;
 }
 add_filter( 'wp_nav_menu', 'skivvy_advmenus' );
} // Ends if class_exists('SimpleXMLElement') */

?>