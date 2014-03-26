<?php #20Jun13 // The Alternate Batman Costume

/* -------------------------------
	Custom Admin Bar
---------------------------------*/ 
function skivvy_admin_bar() { 
	global $wp_admin_bar;
	//// ---- Remove stuff ---- ////

	$wp_admin_bar->remove_menu('wp-logo');          // Remove the WordPress logo
	$wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
	$wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
	$wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
	$wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
	$wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
	//$wp_admin_bar->remove_menu('site-name');        // Remove the site name menu
	$wp_admin_bar->remove_menu('view-site');        // Remove the view site link
	$wp_admin_bar->remove_menu('updates');          // Remove the updates link
	$wp_admin_bar->remove_menu('comments');         // Remove the comments link
	$wp_admin_bar->remove_menu('w3tc');             // If you use w3 total cache remove the performance link
	$wp_admin_bar->remove_menu('my-account');       // Remove the user details tab
	$wp_admin_bar->remove_menu('new-content');		// Remove the content link
	$wp_admin_bar->remove_menu('new-media');
	$wp_admin_bar->remove_menu('new-link'); 
	$wp_admin_bar->remove_menu('new-user');
	$wp_admin_bar->remove_menu('new-theme'); 
	$wp_admin_bar->remove_menu('new-plugin');
	$wp_admin_bar->remove_menu('dashboard'); 
	$wp_admin_bar->remove_menu('themes');
	$wp_admin_bar->remove_menu('customize');
	$wp_admin_bar->remove_menu('search');
	$wp_admin_bar->remove_menu('media');
	$wp_admin_bar->remove_menu('link');
	$wp_admin_bar->remove_menu('user');
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

	//// ---- Add stuff ---- ////
	/*$wp_admin_bar->add_menu( array(
		'parent' => 'new-content', // use 'false' for a root menu, or pass the ID of the parent menu
		'id' => 'new_media', // link ID, defaults to a sanitized title value
		'title' => __('Media'), // link title
		'href' => admin_url( 'media-new.php'), // name of file
		'meta' => false // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
	));*/
	$ct = wp_get_theme();

	$wp_admin_bar->add_menu( array(
		'id' => 'logout',
		'title' => __('Log Out'),
		'parent' => 'site-name',
		'href' => wp_logout_url( )
	) );
	$wp_admin_bar->add_menu( array(
		'id' => 'post',
		'title' => __('Posts'),
		'parent' => 'site-name',
		'href' => self_admin_url('edit.php')
	) ); 
	/* /// ---- Add "delete" button on posts for admins only ---- ////
	$current_object = get_queried_object();
	if ( !empty( $current_object->post_type ) && ( $post_type_object = get_post_type_object( $current_object->post_type ) ) && current_user_can( $post_type_object->cap->edit_post, $current_object->ID ) )
		$wp_admin_bar->add_menu(array(
				'id' => 'delete',
				'title' => __('Delete'),
				'href' => get_delete_post_link($current_object->term_id)
	); // */	


//// End skivvy_admin_bar
} add_action('wp_before_admin_bar_render','skivvy_admin_bar');



/* -------------------------------
	Custom Admin Menu Order
---------------------------------*/ 
   function custom_menu_order($menu_ord) {
       if (!$menu_ord) return true;
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
/* -------------------------------
	Additional Functions
---------------------------------*/ 

//// ---- Add All Settings link for great access to DB ---- ////
function all_settings_link() {add_options_page(__('All Settings'), __('All Settings'), 'administrator', 'options.php');} add_action('admin_menu', 'all_settings_link');

//// ---- Set the post revisions unless the constant was set in wp-config.php ---- ////
if (!defined('WP_POST_REVISIONS')) define('WP_POST_REVISIONS', 5);

?>
