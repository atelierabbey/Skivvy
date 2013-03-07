<?php
/////// Shortcodes ///////////////////
// [bloginfo key='name']
function digwp_bloginfo_shortcode( $atts ) {
   extract(shortcode_atts(array(
       'key' => '',
   ), $atts));
   return get_bloginfo($key);
}
add_shortcode('bloginfo', 'digwp_bloginfo_shortcode');

// Add shortcode capability in widgets - Added 22Feb13
add_filter('widget_text', 'do_shortcode');
?>