<?php #7Aug13
//// ---- Use: [bloginfo key='name']
function shortcode_bloginfo( $atts ) {
   extract(shortcode_atts(array(
       'key' => '',
   ), $atts));
   return get_bloginfo($key);
} add_shortcode('bloginfo', 'shortcode_bloginfo');

//<img src='[randimg src="/wp-content/themes/Skivvy/img/social"]'> 
function shortcode_randomimage($atts) {
	extract( shortcode_atts( array(
		'src' => get_template_directory_uri().'/img/random'
	), $atts ) );
	return "/wp-content/themes/Skivvy/inc/module_randimg.php?src=$src";
} add_shortcode( 'randimg', 'shortcode_randomimage' );
?>