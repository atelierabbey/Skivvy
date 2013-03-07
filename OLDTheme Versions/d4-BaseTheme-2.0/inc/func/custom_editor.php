<?php // Custom editor Access
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
							//__('Tools'),
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
}
add_action('admin_menu', 'custom_admin_menu');
?>