<?php #10Jul13 // The Robin Suit
/* // ADD CUSTOM USER PROFILE FIELDS - the_author_meta('facebook', $current_author->ID)
function my_custom_userfields( $contactmethods ) {
	
	// ADD CONTACT CUSTOM FIELDS
	$contactmethods['contact_phone_office']     = 'Office Phone';
	$contactmethods['contact_phone_mobile']     = 'Mobile Phone';
	$contactmethods['contact_office_fax']       = 'Office Fax';
	
	// ADD ADDRESS CUSTOM FIELDS
	$contactmethods['address_line_1']       = 'Address Line 1';
	$contactmethods['address_line_2']       = 'Address Line 2 (optional)';
	$contactmethods['address_city']         = 'City';
	$contactmethods['address_state']        = 'State';
	$contactmethods['address_zipcode']      = 'Zipcode';
	return $contactmethods;
} add_filter('user_contactmethods','my_custom_userfields',10,1); //*/


// Custom editor Access
function custom_admin_menu() {
    $user = new WP_User(get_current_user_id());     
    if (!empty( $user->roles) && is_array($user->roles)) {
		foreach ($user->roles as $role)
			$role = $role;
    }

    if($role == "editor") { 
       remove_submenu_page( 'themes.php', 'themes.php' );
       //remove_submenu_page( 'themes.php', 'nav-menus.php' ); 
	   global $menu;
			$restricted = array(
							//__('Dashboard'),
							//__('Posts'),
							//__('Media'),
							__('Links'),
							//__('Pages'),
							//__('Appearance'),
							__('Tools'),
							//__('Users'),
							//__('Settings'),
							__('Comments'),
							//__('Plugins'),
							);
			end ($menu);
			while (prev($menu)){
				$value = explode(' ',$menu[key($menu)][0]);
				if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
			}
    }  
	$editor = get_role('editor');
	$editor->add_cap('list_users');
	$editor->add_cap('create_users');
	$editor->add_cap('edit_users');
	$editor->add_cap('edit_theme_options');
	$editor->add_cap('manage_options');  
}
add_action('admin_menu', 'custom_admin_menu');

//// ---- Make user profile less confusing ---- ////
add_filter('user_contactmethods','hide_profile_fields',10,1);
function hide_profile_fields( $contactmethods ) {
	unset($contactmethods['aim']);
	unset($contactmethods['jabber']);
	unset($contactmethods['yim']);
	return $contactmethods;
}

//// ---- MOVE THE AUTHOR METABOX INTO THE PUBLISH METABOX ---- ////
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
?>