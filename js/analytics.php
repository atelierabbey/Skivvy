<?php // This code is optional, however it is optimized. if you want to replace it with the default code, then past over all this, then remove the <script> tags.
	$uacode = 'UA-XXXXX-X';
echo(
	'<script>'.
		"var _gaq = [['_setAccount', '".$uacode."'], ['_trackPageview']];".
		"(function(d, t) {var g = d.createElement(t),s = d.getElementsByTagName(t)[0];g.async = true;g.src = '//www.google-analytics.com/ga.js';s.parentNode.insertBefore(g, s);})(document, 'script');".
	'</script>'
); ?>