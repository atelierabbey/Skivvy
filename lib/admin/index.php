<?php


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
**		Add All Settings link for great access to DB
**
*/
function all_settings_link() {
	add_options_page(__('All Settings'), __('All Settings'), 'administrator', 'options.php');
}
add_action('admin_menu', 'all_settings_link');




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





// skinfo('$what');  -- Get Version from theme's style.css
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

// Custom admin
	function skivvy_admin_color_schemes() {
		wp_admin_css_color(
			'skivvy-colors',
			__( 'Skivs' ),
			get_template_directory_uri() . '/lib/admin/admin-colors.css',
			array(
				'#25282b',
				'#363b3f',
				'#69a8bb',
				'#e14b3b'
			)
		);
	} add_action('admin_init', 'skivvy_admin_color_schemes');



/*
 *		-------------------------------------------------------
 *		Admin Auto Functions
 *		-------------------------------------------------------
*/


// Filter - Adds classes to admin based on user role
	function skivvy_admin_body_class( $classes ) {

		$user = new WP_User(get_current_user_id());
		if ( !empty($user->roles) && is_array($user->roles)) {
			foreach ($user->roles as $role)
				$role = $role;
		}

		return "{$classes} user-{$role}";

	}
	add_filter('admin_body_class', 'skivvy_admin_body_class');

// Admin Styles & Scripts
	function skivvy_admin_script_style() {

		// Styles
		wp_register_style( 'skivvy_admin_style', get_template_directory_uri().'/lib/admin/admin.css', false, skinfo('Version'), 'screen' );
		wp_enqueue_style( 'skivvy_admin_style' );
		// Scripts
		wp_register_script( 'skivvy_admin_script', get_template_directory_uri().'/lib/admin/admin.js', array('jquery'), skinfo('Version'), true );
		wp_enqueue_script( 'skivvy_admin_script' );

	}
	add_action( 'admin_enqueue_scripts', 'skivvy_admin_script_style' );
	add_action( 'login_enqueue_scripts', 'skivvy_admin_script_style' );

// Admin Head hook
	function skivvy_admin_head() {
		// Shortcut Icon - Favicon
			echo '<link rel="shortcut icon" type="image/png" href="' . get_template_directory_uri() . '/img/favicon.png?v='. time() . '">';
	}
	add_action('admin_head', 'skivvy_admin_head');


// Redirect Login Log link to Homepage
	function skivvy_login_logo_url() {
		return get_bloginfo( 'url' );
	}
	add_filter( 'login_headerurl', 'skivvy_login_logo_url' );



/*
**
**		Move the Author Metabox to Publish Metabox
**
*/
add_action( 'admin_menu', 'remove_author_metabox' );
add_action( 'post_submitbox_misc_actions', 'move_author_to_publish_metabox' );
function remove_author_metabox() {
	remove_meta_box( 'authordiv', 'post', 'normal' );
}
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

}
add_action('wp_before_admin_bar_render', 'skivvy_admin_bar', 0);


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
 *		-------------------------------------------------------
 *		WP-Admin branding
 *		-------------------------------------------------------
 */

// Admin footer
	function skivvy_footer_admin() {
		echo 'CMS by <a href="http://www.wordpress.org" target="_blank">WordPress</a> | Design by <a href="'.skinfo("AuthorURI").'" target="_blank">'.skinfo('Author').'</a>';
	}
	add_filter('admin_footer_text', 'skivvy_footer_admin');

	function skivvy_footer_version(){
		echo '<small>CMS: ' .get_bloginfo( 'version', 'display' ) .' | Theme: '. skinfo('Version').'</small>';
	}
	add_filter( 'update_footer', 'skivvy_footer_version', 11 );


// Adds a warning box to the settings page Uses the same style box as the WordPress Update "update-nag"
	function skivvy_admin_notice(){
		global $current_screen;
		if ( $current_screen->parent_base == 'options-general' ){
			echo '<div id="admin-settings-warning-box"><strong>Warning</strong> - changing settings on these pages may cause problems with your website&rsquo;s design!</div>';
		}
	} add_action('admin_notices', 'skivvy_admin_notice');


// Adds custom message if Wordpress is out of date
	/*
	if (!current_user_can('edit_users')) {
		add_action('init', create_function('$a', "remove_action('init', 'wp_version_check');"), 2);
		add_filter('pre_option_update_core', create_function('$a', "return null;"));
	} //*/



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
 *		-------------------------------------------------------
 *		Custom WP-Admin Dashboard Widgets
 *		-------------------------------------------------------
 */

// Registers those widgets
	function skivvy_dashboard_widgets() {
		# wp_add_dashboard_widget('dashboard_custom_feed', skinfo('Author').' News Feed', 'skivvy_dashboard_feed');
		wp_add_dashboard_widget('dashboard_custom_help', 'Website Technical Support', 'skivvy_dashboard_help');
	} add_action('wp_dashboard_setup', 'skivvy_dashboard_widgets');


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




?>