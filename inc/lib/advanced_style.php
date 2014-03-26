<?php #24Jan14




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
			if( count( $item ) ) return $container[0]. preg_replace( '#<\?[^>]*\?>#', '', preg_replace( '#<!\[CDATA\[([^<]+)\]\]>#', '\\1', skivvy_advmenus_level( $item )->asXML() ) ) . $container[1];
			else return $container[0] . $output . $container[1];
		} add_filter( 'wp_nav_menu', 'skivvy_advmenus' );
		
	// Adds .odd-menu-item , .even-menu-item , .last-menu-item , .first-menu-item  to the Nav menu
		function skivvy_advmenus_level( $xml ) {

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
							skivvy_advmenus_level( $item->ul );
						}
						elseif( $item->menu ) {
							$attributes['class'] = 'parent-menu-item ' . $attributes['class'];
							skivvy_advmenus_level( $item->menu );
						}

					// Adds First and Last class
						if( $i == $count ) $attributes['class'] = 'last-menu-item ' . $attributes['class'];
						if( $i == 1 ) $attributes['class'] = 'first-menu-item ' . $attributes['class'];
						$i ++;
				}
			}
			return $xml;

		}

} // Ends if class_exists('SimpleXMLElement') */

?>