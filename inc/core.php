<?php #22Aug13 // This is the 'belt' part of the utility belt... It holds up the superhero underwear.

//// ---- skinfo('$what'); Get Version from style.css ---- ////
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

// theme branding & dashboard widgets
function skivvy_footer_admin() { echo 'Fueled by <a href="http://www.wordpress.org" target="_blank">WordPress</a> | Design by <a href="'.skinfo("AuthorURI").'" target="_blank">'.skinfo('Author').'</a>';} add_filter('admin_footer_text', 'skivvy_footer_admin');
function skivvy_footer_version(){ echo '<small>CMS: ' .get_bloginfo( 'version', 'display' ) .' | Theme: '. skinfo('Version').'</small>';} add_filter( 'update_footer', 'skivvy_footer_version', 11 );
function skivvy_admin_css() { wp_enqueue_style('skivvy_admin_css',get_template_directory_uri().'/css/admin.css','','');} add_action('admin_print_styles','skivvy_admin_css');add_action('login_head', 'skivvy_admin_css');
function skivvy_admin_notice(){ global $current_screen; if ( $current_screen->parent_base == 'options-general' ){  echo '<div id="admin-settings-warning-box"><strong>Warning</strong> - changing settings on these pages may cause problems with your website&rsquo;s design!</div>'; }} add_action('admin_notices', 'skivvy_admin_notice'); // Add a warning box to the settings page Uses the same style box as the WordPress Update "update-nag"
function skivvy_dashboard_help() {echo '<p>Welcome to '.get_bloginfo( "name", "display" )."'s CMS! Need help? Contact <a href='".skinfo("AuthorURI")."' target='_blank'>".skinfo('Author')."</a>.</p>";}
function skivvy_dashboard_feed() {echo '<div class="rss-widget">';wp_widget_rss_output(array('url' => skinfo("AuthorURI").'feed/','title' => 'Latest News','items' => 5, 'show_summary' => 1,'show_author' => 0,'show_date' => 1));echo "</div>";}
function skivvy_dashboard_widgets() {
	wp_add_dashboard_widget('dashboard_custom_feed', skinfo('Author').' News Feed', 'skivvy_dashboard_feed');
	wp_add_dashboard_widget('dashboard_custom_help', 'Website Technical Support', 'skivvy_dashboard_help');
} add_action('wp_dashboard_setup', 'skivvy_dashboard_widgets');
/* // Adds custom message if Wordpress is out of date
if (!current_user_can('edit_users')) {
	add_action('init', create_function('$a', "remove_action('init', 'wp_version_check');"), 2);
	add_filter('pre_option_update_core', create_function('$a', "return null;"));
} // */

function skivvy_autooptions() {
	$the_theme_status = get_option( 'theme_setup_status' );
	if ( $the_theme_status !== '1' ) {
		// Setup Default WordPress settings
		$core_settings = array(
			'show_avatars' => false,
			'avatar_default' => 'mystery',
			'avatar_rating' => 'G',
			'default_role' => 'editor',
			'comments_per_page' => 20,
			'uploads_use_yearmonth_folders' => false,
		);
		foreach ( $core_settings as $k => $v ) {update_option( $k, $v );}

		// Delete dummy post, page and comment.
		wp_delete_post( 1, true );
		wp_delete_post( 2, true );
		wp_delete_comment( 1 );

		update_option( 'theme_setup_status', '1' );
		$msg = '<div class="error"><p>The '.get_option( 'current_theme' ).' theme has changed your WordPress default <a href="' . admin_url( 'options-general.php' ) . '" title="See Settings">settings</a> and deleted default posts & comments.</p></div>';
		add_action( 'admin_notices', $c = create_function( '', 'echo "' . addcslashes( $msg, '"' ) . '";' ) );
	}
	// Else if we are re-activing the theme
	elseif ( $the_theme_status === '1' and isset( $_GET['activated'] ) ) {
		$msg = '
		<div class="updated">
			<p>The ' . get_option( 'current_theme' ) . ' theme was successfully re-activated.</p>
		</div>';
		add_action( 'admin_notices', $c = create_function( '', 'echo "' . addcslashes( $msg, '"' ) . '";' ) );
	}
} 

function skivvy_languageaccept() { 
	// Make theme available for translation - Translations can be filed in the /lng/ directory
	load_theme_textdomain( 'skivvy', TEMPLATEPATH.'/lng' );
	$locale = get_locale();
	$locale_file = TEMPLATEPATH."/lng/$locale.php";
	if ( is_readable( $locale_file ) )require_once( $locale_file );
} 
?>