<?php 
// Customize the admin toolbar to something useful - 2012 November 9
function d4_admin_bar_render() {
	global $wp_admin_bar;
	
	//Used in adding new menu items
	/*$wp_admin_bar->add_menu( array(
		'parent' => 'new-content', // use 'false' for a root menu, or pass the ID of the parent menu
		'id' => 'new_media', // link ID, defaults to a sanitized title value
		'title' => __('Media'), // link title
		'href' => admin_url( 'media-new.php'), // name of file
		'meta' => false // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
	));*/
	
	// Remove a bunch of useless things
	$wp_admin_bar->remove_menu('comments');
	$wp_admin_bar->remove_menu('media');
	$wp_admin_bar->remove_menu('link');
	$wp_admin_bar->remove_menu('user');
	$wp_admin_bar->remove_menu('wp-logo');
	$wp_admin_bar->remove_menu('updates');
	$wp_admin_bar->remove_menu('my-account');
	
	/* Add "delete" button on posts for admins only
	if ( !is_super_admin() || !is_admin_bar_showing() )
		return;
		$current_object = get_queried_object();
		if ( !empty( $current_object->post_type ) && ( $post_type_object = get_post_type_object( $current_object->post_type ) ) && current_user_can( $post_type_object->cap->edit_post, $current_object->ID ) )
			$wp_admin_bar->add_menu(array(
					'id' => 'delete',
					'title' => __('Delete'),
					'href' => get_delete_post_link($current_object->term_id)
			)
	);*/
	
	// Removes useless admin bar dropdown items
	foreach ( (array) $wp_admin_bar->user->blogs as $blog ) {  
		$menu_id_d  = 'blog-' . $blog->userblog_id . '-d';       /* Dashboard var */  
		$menu_id_n  = 'blog-' . $blog->userblog_id . '-n';       /* New Post var */  
		$menu_id_c  = 'blog-' . $blog->userblog_id . '-c';       /* Manage Comments var */  
		$menu_id_v  = 'blog-' . $blog->userblog_id . '-v';       /* Visit Site var */  
		$wp_admin_bar->remove_menu($menu_id_d);              /* Remove Dashboard Link */  
		$wp_admin_bar->remove_menu($menu_id_n);              /* Remove New Post Link */  
		$wp_admin_bar->remove_menu($menu_id_c);              /* Remove Manage Comments Link */  
		$wp_admin_bar->remove_menu($menu_id_v);              /* Remove Visit Site Link */  
	}  ;
	
	// Removes the "add new" button in admin area... because it's pointess there.
	if ( is_admin() ) { $wp_admin_bar->remove_menu('new-content'); }
	
	// Removes unneeded toolbar submenus
    $wp_admin_bar->remove_menu('new-media');
    $wp_admin_bar->remove_menu('new-link'); 
    $wp_admin_bar->remove_menu('new-user');
    $wp_admin_bar->remove_menu('new-theme'); 
    $wp_admin_bar->remove_menu('new-plugin');
	$wp_admin_bar->remove_menu('dashboard'); 
	$wp_admin_bar->remove_menu('themes');
	$wp_admin_bar->remove_menu('customize');
	$wp_admin_bar->remove_menu('search');
	
	//Added 19 Nov 12 - Adds 'Log out Button' to Site menu item in admin bar. 
	$wp_admin_bar->add_menu( array(
		'id' => 'logout',
		'title' => __('Log Out'),
		'parent' => 'site-name',
		'href' => wp_logout_url( )
		)
	);
	

}
add_action( 'wp_before_admin_bar_render', 'd4_admin_bar_render' );

?>