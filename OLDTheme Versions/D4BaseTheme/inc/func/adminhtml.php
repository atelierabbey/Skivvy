<?php
// http://wordpress.org/extend/plugins/preserved-html-editor-markup/
remove_filter ('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');
remove_filter("the_content", "convert_chars");

// allow html in category descriptions //
$filters = array('term_description' , 'category_description' , 'pre_term_description');
foreach ( $filters as $filter ) {
remove_filter($filter, 'wptexturize');
remove_filter($filter, 'convert_chars');
remove_filter($filter, 'wpautop');
remove_filter($filter, 'wp_filter_kses');
remove_filter($filter, 'strip_tags');
}




?>