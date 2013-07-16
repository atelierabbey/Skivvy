<?php #20Jun13
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