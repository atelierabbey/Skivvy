<?php #22Aug13
// remove wp_head fluff
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);

// wp_title
function skivvy_wp_title( $title, $separator ) {
	global $paged, $page;
	$description = get_bloginfo( 'description', 'display' );

	if (is_feed()) { return $title; }		
	if (is_category()) { $title = "Category: $title";}	
	if (is_tag()) { $title = "Tag: $title";}
	if (is_search()) { $title = "Search: $title"; }
	if (post_password_required($post) ) { $title = "Protected: $title"; }
	if (is_404() ) { $title = "404 Not Found $separator "; }
	$filtered_title = $title . get_bloginfo( 'name', 'display' );
	$filtered_title .= ( ! empty( $description ) && ( is_home() || is_front_page() || is_404() ) ) ? " $separator $description" : '';
	$filtered_title .= ( 2 <= $paged || 2 <= $page ) ? ' | ' . sprintf( __( 'Page %s' ), max( $paged, $page ) ) : '';
	return $filtered_title;
} add_filter( 'wp_title', 'skivvy_wp_title', 10, 2 );

// Remove Widgets
function skivvy_remove_widget() {
	unregister_widget('WP_Widget_Pages'); //Pages Widget
	unregister_widget('WP_Widget_Calendar'); //Calendar Widget
	unregister_widget('WP_Widget_Archives'); //Archives Widget
	unregister_widget('WP_Widget_Links'); //Links Widget
	unregister_widget('WP_Widget_Meta'); //Meta Widget
	unregister_widget('WP_Widget_Search'); //Search Widget
#	unregister_widget('WP_Widget_Text'); //Text Widget
	unregister_widget('WP_Widget_Categories'); //Categories Widget
	unregister_widget('WP_Widget_Recent_Posts'); //Recent Posts Widget
	unregister_widget('WP_Widget_Recent_Comments'); //Recent Comments Widget
#	unregister_widget('WP_Widget_RSS'); //RSS Widget
	unregister_widget('WP_Widget_Tag_Cloud'); //Tag Cloud Widget
#	unregister_widget('WP_Nav_Menu_Widget'); //Menus Widget
} add_action( 'widgets_init', 'skivvy_remove_widget' );
?>