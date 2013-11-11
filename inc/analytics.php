<?php
$options = get_option( 'website_data_options' );

function remove_http($url) {
	$disallowed = array( 'http://www.', 'https://www.', 'http://', 'https://' );
	foreach($disallowed as $d) {
		if(strpos($url, $d) === 0) {
			return str_replace($d, '', $url);
		}
	}
	return $url;
}

echo
'<script>'.
	'(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){'.
	'(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),'.
	'm=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)'.
	'})(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');'.
	
	"ga('create', '".$options['ga_uacode']."', '". remove_http( get_site_url() ). "');".
	"ga('send', 'pageview');".
'</script>'
; ?>