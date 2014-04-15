<?php #11Apr14






/*
**
**		ADMIN SIDE MENU - Cleanup
**
*/
	function skivvy_remove_menu_pages() {
		#	remove_menu_page( $menu_slug ); // Dashboard
		#	remove_menu_page( 'edit.php' ); // Posts
		#	remove_menu_page( 'upload.php' ); // Media
			remove_menu_page( 'link-manager.php' ); // Links
			remove_menu_page( 'edit-comments.php' ); // Comments
		#	remove_menu_page( 'themes.php' ); // Appearance
		#	remove_submenu_page( 'themes.php', 'widgets.php' ); // Appearance > Widgets
		#	remove_menu_page( 'plugins.php' ); // Plugins
		#	remove_menu_page( 'users.php' ); // Users
		#	remove_menu_page( 'tools.php' ); // Tools
		#	remove_menu_page( 'options-general.php' ); // Settings 
	} add_action( 'admin_menu', 'skivvy_remove_menu_pages' );









/*
**
**		Custom Editor
**		http://codex.wordpress.org/Roles_and_Capabilities#Capabilities
*/
	function custom_admin_menu() {
		$user = new WP_User(get_current_user_id());
		if ( !empty($user->roles) && is_array($user->roles)) {
			foreach ($user->roles as $role)
				$role = $role;
		}
		if($role == "editor") { 
			global $menu;
			$restricted = array(
						#	__('Dashboard'),
						#	__('Posts'),
						#	__('Media'),
							__('Links'),
						#	__('Pages'),
						#	__('Appearance'),
							__('Tools'),
						#	__('Users'),
							__('Settings'),
							__('Comments'),
							__('Plugins'),
			);
			end ($menu);
			while (prev($menu)){
				$value = explode(' ',$menu[key($menu)][0]);
				if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
			}
			
				remove_submenu_page( 'themes.php', 'themes.php' );
			#	remove_submenu_page( 'themes.php', 'nav-menus.php' ); 
		}
		$editor = get_role('editor');
		$editor->add_cap('list_users');
		$editor->add_cap('create_users');
		$editor->add_cap('edit_users');
		$editor->add_cap('edit_theme_options');
		# $editor->add_cap('manage_options');  
	} add_action('admin_menu', 'custom_admin_menu');












/*
**
**		WP_TITLE() - Simplify
**
*/
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





/*
**
**		WIDGETS - Cleanup
**
*/
	function skivvy_remove_widget() {
		#	unregister_widget('WP_Widget_Pages'); //Pages Widget
		#	unregister_widget('WP_Widget_Calendar'); //Calendar Widget
		#	unregister_widget('WP_Widget_Archives'); //Archives Widget
		#	unregister_widget('WP_Widget_Links'); //Links Widget
		#	unregister_widget('WP_Widget_Meta'); //Meta Widget
		#	unregister_widget('WP_Widget_Search'); //Search Widget
		#	unregister_widget('WP_Widget_Text'); //Text Widget
		#	unregister_widget('WP_Widget_Categories'); //Categories Widget
		#	unregister_widget('WP_Widget_Recent_Posts'); //Recent Posts Widget
		#	unregister_widget('WP_Widget_Recent_Comments'); //Recent Comments Widget
		#	unregister_widget('WP_Widget_RSS'); //RSS Widget
		#	unregister_widget('WP_Widget_Tag_Cloud'); //Tag Cloud Widget
		#	unregister_widget('WP_Nav_Menu_Widget'); //Menus Widget
	} add_action( 'widgets_init', 'skivvy_remove_widget' );





/*
**
**		WP_HEAD() - Cleanup
**
*/ 
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wp_generator');
		remove_action('wp_head', 'feed_links', 2);
		remove_action('wp_head', 'index_rel_link');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'feed_links_extra', 3);
		#	remove_action('wp_head', 'start_post_rel_link', 10, 0);
		#	remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
		#	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
		#	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
		#	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );




/*
**
**		Remove XML-RPC function by default to remove DDOS Ping attacks
**		Read more - http://labs.sucuri.net/?is-my-wordpress-ddosing
**
*/
add_filter( 'xmlrpc_methods', 'remove_xmlrpc_pingback_ping' );
function remove_xmlrpc_pingback_ping( $methods ) {
	unset( $methods['pingback.ping'] );
	return $methods;
} ;






/*
**
**		Removes "Private" & "Protected" from titles
**
*/
	add_filter( 'private_title_format',   'remove_the_title_stuff' );
	add_filter( 'protected_title_format', 'remove_the_title_stuff' );
	function remove_the_title_stuff( $title ) { return '%s'; }







/*
**
**		Removes the default gallery shortcode css 
**		@ Stolen from twentyten
**
*/
	add_filter( 'gallery_style', 'skivvy_remove_gallery_css' );
	function skivvy_remove_gallery_css( $css ) { return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css ); }





/*
**
**		Remove Plugin Update Notice ONLY for INACTIVE plugins
**
*/
function skivvy_update_active_plugins($value = '') {
	// The $value array passed in contains the list of plugins with time marks when the last time the groups was checked for version matchThe $value->reponse node contains an array of the items that are out of date. This response node is use by the 'Plugins' menu for example to indicate there are updates. Also on the actual plugins listing to provide the yellow box below a given plugin to indicate action is needed by the user.     */
	if ((isset($value->response)) && (count($value->response))) {

		// Get the list cut current active plugins
		$active_plugins = get_option('active_plugins');
		if ($active_plugins) {

			//  Here we start to compare the $value->response
			//  items checking each against the active plugins list.
			foreach($value->response as $plugin_idx => $plugin_item) {

				// If the response item is not an active plugin then remove it.
				// This will prevent WordPress from indicating the plugin needs update actions.
				if (!in_array($plugin_idx, $active_plugins))
					unset($value->response[$plugin_idx]);
			}
		}
		else {
			 // If no active plugins then ignore the inactive out of date ones.
			foreach($value->response as $plugin_idx => $plugin_item) {
				unset($value->response);
			}
		}
	}
	return $value;
}
add_filter('transient_update_plugins', 'update_active_plugins');






/*
**
**		Add All Settings link for great access to DB
**
*/
function all_settings_link() {add_options_page(__('All Settings'), __('All Settings'), 'administrator', 'options.php');} add_action('admin_menu', 'all_settings_link');







/*
**
**		Set the post revisions unless the constant was set in wp-config.php
**
*/
if (!defined('WP_POST_REVISIONS')) define('WP_POST_REVISIONS', 50);







/*
**
**		Add & Remove useless profile Fields
**
*/
add_filter('user_contactmethods','hide_profile_fields',10,1);
function hide_profile_fields( $contactmethods ) {
	// Remove
			unset($contactmethods['aim']);
			unset($contactmethods['jabber']);
			unset($contactmethods['yim']);
		
	// Add - the_author_meta('facebook', $current_author->ID)
		#	$contactmethods['contact_phone_office']     = 'Office Phone';
		#	$contactmethods['contact_phone_mobile']     = 'Mobile Phone';
		#	$contactmethods['contact_office_fax']       = 'Office Fax';
		#	$contactmethods['address_line_1']       = 'Address Line 1';
		#	$contactmethods['address_line_2']       = 'Address Line 2 (optional)';
		#	$contactmethods['address_city']         = 'City';
		#	$contactmethods['address_state']        = 'State';
		#	$contactmethods['address_zipcode']      = 'Zipcode';

	return $contactmethods;
}






/*
**
**		Move the Author Metabox to Publish Metabox
**
*/
	add_action( 'admin_menu', 'remove_author_metabox' );
	add_action( 'post_submitbox_misc_actions', 'move_author_to_publish_metabox' );
	function remove_author_metabox() { remove_meta_box( 'authordiv', 'post', 'normal' ); }
	function move_author_to_publish_metabox() {
		global $post_ID;
		$post = get_post( $post_ID );
		echo '<div id="author" class="misc-pub-section" style="border-top-style:solid; border-top-width:1px; border-top-color:#EEEEEE; border-bottom-width:0px;">Author: ';
		post_author_meta_box( $post );
		echo '</div>';
	}







/*
**
**		ADMIN BAR - Cleanup
**
*/
	function skivvy_admin_bar() {
		global $wp_admin_bar;

			// Wp-Logo
				#	$wp_admin_bar->remove_menu('wp-logo');
					$wp_admin_bar->remove_menu('about');
					$wp_admin_bar->remove_menu('wporg');
					$wp_admin_bar->remove_menu('documentation');
					$wp_admin_bar->remove_menu('support-forums');
					$wp_admin_bar->remove_menu('feedback');

			// Site Name
				#	$wp_admin_bar->remove_menu('site-name');
				#	$wp_admin_bar->remove_menu('dashboard');
					$wp_admin_bar->remove_menu('view-site');
				#	$wp_admin_bar->remove_menu('updates');
					$wp_admin_bar->remove_menu('comments');
				#	$wp_admin_bar->remove_menu('w3tc');
					$wp_admin_bar->remove_menu('themes');
					$wp_admin_bar->remove_menu('customize');
				#	$wp_admin_bar->remove_menu('media');
				#	$wp_admin_bar->remove_menu('link');	
				#	$wp_admin_bar->add_menu( array('id' => 'logout','title' => __('Log Out'),'parent' => 'site-name','href' => wp_logout_url( )) );			// Adds Log-out
					$wp_admin_bar->add_menu( array('id' => 'post','title' => __('Posts'),'parent' => 'site-name','href' => self_admin_url('edit.php')) );	// Adds Posts
					$wp_admin_bar->add_menu( array('id' => 'pages','title' => __('Pages'),'parent' => 'site-name','href' => self_admin_url('edit.php?post_type=page')) );	// Adds Posts


			// New
				#	$wp_admin_bar->remove_menu('new-content');
					$wp_admin_bar->remove_menu('new-media');
					$wp_admin_bar->remove_menu('new-link');
					$wp_admin_bar->remove_menu('new-user');
					$wp_admin_bar->remove_menu('new-theme');
				#	$wp_admin_bar->remove_menu('new-plugin');

			// Edit
				#	$wp_admin_bar->remove_menu('edit');

			// Right side
					$wp_admin_bar->remove_menu('search');
				#	$wp_admin_bar->remove_menu('my-account');
				#	$wp_admin_bar->remove_menu('edit-profile');
				#	$wp_admin_bar->remove_menu('user');

					// My Account Greeting
						$new_greeting = 'Hi,';
						$my_account = $wp_admin_bar -> get_node('my-account');
						$wp_admin_bar->add_node( array( 'id' => 'my-account','title' => str_replace( 'Howdy,', $new_greeting, $my_account->title ) ) );


		//  ---- Add Stuff template
		//	$wp_admin_bar->add_menu( array(
		//		'parent' => 'new-content', // use 'false' for a root menu, or pass the ID of the parent menu
		//		'id' => 'new_media', // link ID, defaults to a sanitized title value
		//		'title' => __('Media'), // link title
		//		'href' => admin_url( 'media-new.php'), // name of file
		//		'meta' => false // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
		//	));

	} add_action('wp_before_admin_bar_render', 'skivvy_admin_bar', 0);







/*
**
**		Custom Admin Menu Order
*/
/*
	function custom_menu_order($menu_ord) {
		if (!$menu_ord)
			return true;
		return array(
			'index.php', // this represents the dashboard link
			'edit.php?post_type=events', // this is a custom post type menu
			'edit.php?post_type=news', 
			'edit.php?post_type=articles', 
			'edit.php?post_type=faqs', 
			'edit.php?post_type=mentors',
			'edit.php?post_type=testimonials',
			'edit.php?post_type=services',
			'edit.php?post_type=page', // this is the default page menu
			'edit.php', // this is the default POST admin menu 
		);
	}
	add_filter('custom_menu_order', 'custom_menu_order');
	add_filter('menu_order', 'custom_menu_order');
	//*/
?>