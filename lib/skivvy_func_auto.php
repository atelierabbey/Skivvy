<?php #10Nov15
/*
 *		-------------------------------------------------------
 *		Auto Functions
 *		-------------------------------------------------------
 */

// Skivvy Body Classes
	function skivvy_body_classes($classes) {
		global $wpdb, $post;

		// .subpage for all non-front_page
			if ( ! is_front_page() ) {
				$classes[] = 'subpage';
			}

		// page classes
		if (is_page()) {

			// .section-{$parentpage} - Parent Page Post class -- Add the top level parent page to the body class
				if ($post->post_parent) {
					$parent  = end(get_post_ancestors($current_page_id));
				} else {
					$parent = $post->ID;
				}
				$post_data = get_post($parent, ARRAY_A);
				$classes[] = 'section-' . $post_data['post_name'];

		}

		return $classes;

	}
	add_filter('body_class','skivvy_body_classes');



function html_classes( $class = array() ) {

	$classes = array();

	// Adds Skivvy version
	if (function_exists('skinfo')){
		$classes[] = skinfo('Version');
	}

	// Adds .autohide-adminbar when logged in
	/*
	if ( is_user_logged_in() ) {
		$classes[] = 'autohide-adminbar';
	} //*/

	if ( ! empty( $class ) ) {
			if ( !is_array( $class ) )
				$class = preg_split( '#\s+#', $class );
			$classes = array_merge( $classes, $class );
	}

	$classes = array_map( 'esc_attr', $classes );
	$all_classes = apply_filters( 'html_classes', $classes, $class );

	// Separates classes with a single space, collates classes
	echo join( ' ', $all_classes );
}



//// ---- Add featured images to RSS feed ---- ////
	function rss_post_thumbnail($content) {
		global $post;
		if(has_post_thumbnail($post->ID)) {
			$content = '<p>' . get_the_post_thumbnail($post->ID) .'</p>' . get_the_content();
		}
		return $content;
	}
	add_filter('the_excerpt_rss', 'rss_post_thumbnail');
	add_filter('the_content_feed', 'rss_post_thumbnail');



//// ---- Advanced Menu Styling Classes ---- ////
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




/*
**
**		14Apr14
**
*/
# - http://www.useragentstring.com/pages/useragentstring.php
	function css_browser_selector( $classes ) {

			// $ua = null
			$ua = ($ua) ? strtolower($ua) : strtolower($_SERVER['HTTP_USER_AGENT']);

			$g = 'gecko';
			$w = 'webkit';
			$s = 'safari';
			if (is_array($classes)) {
				$b = $classes;
			} else {
				$b = array();
			}
				//$b[] = $ua;
			// browser

			// ie11 - 26Feb14 mozilla/5.0 (windows nt 6.3; wow64; trident/7.0; matbjs; rv:11.0) like gecko gecko win
			//ie10 - 26Feb14 mozilla/5.0 (compatible; msie 10.0; windows nt 6.2; trident/6.0) ie ie1 win
			//ie9  - 26Feb14 mozilla/5.0 (compatible; msie 9.0; windows nt 6.1; trident/5.0) ie ie9 win
			//ie8  - 26Feb14 mozilla/4.0 (compatible; msie 8.0; windows nt 6.1; trident/4.0) ie ie8 win
			if(!preg_match('/opera|webtv/i', $ua) && preg_match('/msie\s(\d)/', $ua, $array)) {
					$b[] = 'ie';
					$b[] = 'ie'.$array[1];
			}	else if(strstr($ua, 'firefox/27')) {
					$b[] = 'ff27';
			}	else if(strstr($ua, 'firefox/2 ')) {
					$b[] = $g . 'ff2';
			}	else if(strstr($ua, 'firefox/3.5')) {
					$b[] = $g . 'ff3 ff3_5';
			}	else if(strstr($ua, 'firefox/3 ')) {
					$b[] = $g . 'ff3';
			} else if(strstr($ua, 'gecko/')) {
					$b[] = $g;
			} else if(preg_match('/opera(\s|\/)(\d+)/', $ua, $array)) {
					$b[] = 'opera opera' . $array[2];
			} else if(strstr($ua, 'konqueror')) {
					$b[] = 'konqueror';
			} else if(strstr($ua, 'chrome')) {
					$b[] = $w . ' ' . $s . ' chrome';
			} else if(strstr($ua, 'iron')) {
					$b[] = $w . ' ' . $s . ' iron';
			} else if(strstr($ua, 'applewebkit/')) {
					$b[] = (preg_match('/version\/(\d+)/i', $ua, $array)) ? $w . ' ' . $s . ' ' . $s . $array[1] : $w . ' ' . $s;
			} else if(strstr($ua, 'mozilla/')) {
					$b[] = $g;
			}

			// platform
			if(strstr($ua, 'j2me')) {
					$b[] = 'mobile';
			} else if(strstr($ua, 'iphone')) {
					$b[] = 'iphone';
			} else if(strstr($ua, 'ipod')) {
					$b[] = 'ipod';
			} else if(strstr($ua, 'mac')) {
					$b[] = 'mac';
			} else if(strstr($ua, 'darwin')) {
					$b[] = 'mac';
			} else if(strstr($ua, 'webtv')) {
					$b[] = 'webtv';
			} else if(strstr($ua, 'win')) {
					$b[] = 'win';
			} else if(strstr($ua, 'freebsd')) {
					$b[] = 'freebsd';
			} else if(strstr($ua, 'x11') || strstr($ua, 'linux')) {
					$b[] = 'linux';
			}

			return $b;



			/*
			function get_browser($returnValue = 'class')
		{
			if(empty($_SERVER['HTTP_USER_AGENT'])) return false;

			$u_agent = $_SERVER['HTTP_USER_AGENT'];
			$bname = 'Unknown';
			$platform = 'Unknown';
			$version= "";

			//First get the platform?
			if (preg_match('!linux!i', $u_agent)) {
				$platform = 'linux';
			}
			elseif (preg_match('!macintosh|mac os x!i', $u_agent)) {
				$platform = 'mac';
			}
			elseif (preg_match('!windows|win32!i', $u_agent)) {
				$platform = 'windows';
			}

			// Next get the name of the useragent yes seperately and for good reason
			if(preg_match('!MSIE!i',$u_agent) && !preg_match('!Opera!i',$u_agent))
			{
				$bname = 'Internet Explorer';
				$ub = "MSIE";
			}
			elseif(preg_match('!Firefox!i',$u_agent))
			{
				$bname = 'Mozilla Firefox';
				$ub = "Firefox";
			}
			elseif(preg_match('!Chrome!i',$u_agent))
			{
				$bname = 'Google Chrome';
				$ub = "Chrome";
			}
			elseif(preg_match('!Safari!i',$u_agent))
			{
				$bname = 'Apple Safari';
				$ub = "Safari";
			}
			elseif(preg_match('!Opera!i',$u_agent))
			{
				$bname = 'Opera';
				$ub = "Opera";
			}
			elseif(preg_match('!Netscape!i',$u_agent))
			{
				$bname = 'Netscape';
				$ub = "Netscape";
			}

			// finally get the correct version number
			$known = array('Version', $ub, 'other');
			$pattern = '#(?<browser>' . join('|', $known) .
			')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
			if (!@preg_match_all($pattern, $u_agent, $matches)) {
				// we have no matching number just continue
			}

			// see how many we have
			$i = count($matches['browser']);
			if ($i != 1) {
				//we will have two since we are not using 'other' argument yet
				//see if version is before or after the name
				if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
					$version= $matches['version'][0];
				}
				else {
					$version= $matches['version'][1];
				}
			}
			else {
				$version= $matches['version'][0];
			}

			// check if we have a number
			if ($version==null || $version=="") {$version="?";}

			$mainVersion = $version;
			if (strpos($version, '.') !== false)
			{
				$mainVersion = explode('.',$version);
				$mainVersion = $mainVersion[0];
			}
			if($returnValue == 'class')
			{
				return $ub." ".$ub.$mainVersion;
			}
			else
			{
			return array(
				'userAgent' => $u_agent,
				'name'	  => $bname,
				'version'   => $version,
				'platform'  => $platform,
				'pattern'   => $pattern
			);
		}
	}
		*/
} add_filter('html_classes','css_browser_selector', 10 );

?>