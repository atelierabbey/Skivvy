<?php #27Feb14 - http://www.useragentstring.com/pages/useragentstring.php
add_filter('html_classes','css_browser_selector', 10 ); function css_browser_selector( $classes ) {

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

}?>