<?php #10Mar14

/*
 *
 *		skinfo('$what');
 *		Get Version from theme's style.css
 *
 */
function skinfo($what='Version') {
	$ct = wp_get_theme(); 
	switch ($what){
		case 'Name': return $ct->Name; break; //Theme name as given in theme's style.css
		case 'ThemeURI': return $ct->ThemeURI; break; //The path to the theme's directory 
		case 'Description': return $ct->Description; break; // The description of the theme 
		case 'Author': return $ct->display( 'Author', FALSE ); break; //The theme's author
		case 'AuthorURI': return $ct->get( 'AuthorURI' ); break; // The website of the theme author
		case 'Version': return $ct->Version; break; //The version of the theme
		case 'Template': return $ct->Template; break; //The folder name of the current theme
		case 'Status': return $ct->Status; break; //If the theme is published 
		case 'Tags': return $ct->Tags; break; //Tags used to describe the theme 
		case 'TextDomain': return $ct->get( 'TextDomain' ); break; //The text domain used in the theme for translation purposes 
		case 'DomainPath': return $ct->get( 'DomainPath'); break; //Path to the theme translation files 
	}
}




/*
	// Add specific CSS class by filter
	add_filter('html_classes','my_class_names');
	function my_class_names($classes) {
		// add 'class-name' to the $classes array
		$classes[] = 'class-name';
		// return the $classes array
		return $classes;
	}
*/
function html_classes( $class = array() ) {

	$classes = array();

	// Adds Skivvy version
	$classes[] = skinfo('Version');


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





/*
 *
 *		WP-Admin branding
 *
 */


	function skivvy_footer_admin() {
		echo 'CMS by <a href="http://www.wordpress.org" target="_blank">WordPress</a> | Design by <a href="'.skinfo("AuthorURI").'" target="_blank">'.skinfo('Author').'</a>';
	}
		add_filter('admin_footer_text', 'skivvy_footer_admin');

	function skivvy_footer_version(){
		echo '<small>CMS: ' .get_bloginfo( 'version', 'display' ) .' | Theme: '. skinfo('Version').'</small>';
	}
		add_filter( 'update_footer', 'skivvy_footer_version', 11 );

	// Admin Styles & Scripts
	function skivvy_admin_script_style() {

		// Styles
		wp_register_style( 'skivvy_admin_style', get_template_directory_uri().'/inc/admin/admin.css', false, skinfo('Version'), 'screen' );
		wp_enqueue_style( 'skivvy_admin_style' );
		// Scripts
		wp_register_script( 'skivvy_admin_script', get_template_directory_uri().'/inc/admin/admin.js', false, skinfo('Version'), true );
		wp_enqueue_script( 'skivvy_admin_script' );

	}
	add_action( 'admin_enqueue_scripts', 'skivvy_admin_script_style' );
	add_action( 'login_enqueue_scripts', 'skivvy_admin_script_style' );


	// Redirect Login Log link to Homepage
	function skivvy_login_logo_url() {
		return get_bloginfo( 'url' );
	}
	add_filter( 'login_headerurl', 'skivvy_login_logo_url' );


	// Adds a warning box to the settings page Uses the same style box as the WordPress Update "update-nag"
	function skivvy_admin_notice(){ 
		global $current_screen;
		if ( $current_screen->parent_base == 'options-general' ){
			echo '<div id="admin-settings-warning-box"><strong>Warning</strong> - changing settings on these pages may cause problems with your website&rsquo;s design!</div>';
		}
	} add_action('admin_notices', 'skivvy_admin_notice');


	/* **
	// Adds custom message if Wordpress is out of date
	if (!current_user_can('edit_users')) {
		add_action('init', create_function('$a', "remove_action('init', 'wp_version_check');"), 2);
		add_filter('pre_option_update_core', create_function('$a', "return null;"));
	} 
	***/


/*
 *
 *		Custom WP-Admin Dashboard Widgets
 *
 */


	function skivvy_dashboard_help() {
		echo '<p>Welcome to '.get_bloginfo( "name", "display" )."'s CMS! Need help? Contact <a href='".skinfo("AuthorURI")."' target='_blank'>".skinfo('Author')."</a>.</p>";
	}


	function skivvy_dashboard_feed() {

		// Edit this value to match selected RSS
		$rss_url = skinfo("AuthorURI").'feed/';


		include_once( ABSPATH . WPINC . '/feed.php' );

		$rss = fetch_feed( $rss_url );

		if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly

			// Figure out how many total items there are, but limit it to 5. 
			$maxitems = $rss->get_item_quantity( 5 ); 

			// Build an array of all the items, starting with element 0 (first element).
			$rss_items = $rss->get_items( 0, $maxitems );

		endif;

		echo '<div class="rss-widget"><ul>';

			if ( $maxitems == 0 ) {

				echo '<li>' . __( 'No items', 'skivvy' ) . '</li>';

			} else { // Loop through each feed item and display each item as a hyperlink.

				foreach ( $rss_items as $item ) {
					echo '<li><a href="' . esc_url( $item->get_permalink() ) . '" title="' . sprintf( __( 'Posted %s', 'skivvy' ), $item->get_date('j F Y | g:i a') ) . '" target="_blank">' . esc_html( $item->get_title() ) . '</a></li>';
				}

			}

		echo "</ul></div>";
	}


	// Registers those widgets
	function skivvy_dashboard_widgets() {
		wp_add_dashboard_widget('dashboard_custom_feed', skinfo('Author').' News Feed', 'skivvy_dashboard_feed');
		wp_add_dashboard_widget('dashboard_custom_help', 'Website Technical Support', 'skivvy_dashboard_help');
	} add_action('wp_dashboard_setup', 'skivvy_dashboard_widgets');

?>