<?php #22Apr14

/*
**
**		Skivvy Auto-Options
**
*/
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






// WP_TITLE() - Simplify
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
		$filtered_title .= ( 2 <= $paged || 2 <= $page ) ? ' - ' . sprintf( __( 'Page %s' ), max( $paged, $page ) ) : '';
		return $filtered_title;

	} add_filter( 'wp_title', 'skivvy_wp_title', 10, 2 );



// WP_HEAD() - Cleanup

			remove_action('wp_head', 'rsd_link');
			remove_action('wp_head', 'wp_generator');
		#	remove_action('wp_head', 'feed_links', 2);
			remove_action('wp_head', 'index_rel_link');
			remove_action('wp_head', 'wlwmanifest_link');
			remove_action('wp_head', 'feed_links_extra', 3);
		#	remove_action('wp_head', 'start_post_rel_link', 10, 0);
		#	remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
		#	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
		#	remove_action('wp_head', 'wp_shortlink_wp_head');
		#	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');



//  WP_FOOT()
	function skivvy_footer() {
		// includes Analytics.php code
			get_template_part( '/js/analytics' );

	} add_action( 'wp_footer', 'skivvy_footer' );



// ----- Remove default WP-nonsense ----- //

// Remove XML-RPC function by default to remove DDOS Ping attacks    |    Read more - http://labs.sucuri.net/?is-my-wordpress-ddosing
	function remove_xmlrpc_pingback_ping( $methods ) {
		unset( $methods['pingback.ping'] );
		return $methods;
	}
	add_filter( 'xmlrpc_methods', 'remove_xmlrpc_pingback_ping' );

// Removes img width/height attributes in content
	function remove_width_attribute( $html ) {
		$html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
		return $html;
	}
	add_filter ( 'post_thumbnail_html',  'remove_width_attribute', 10 );
	add_filter ( 'image_send_to_editor', 'remove_width_attribute', 10 );

// Removes "Private" & "Protected" from titles
	function remove_the_title_stuff( $title ) {
		return '%s';
	}
	add_filter( 'private_title_format',   'remove_the_title_stuff' );
	add_filter( 'protected_title_format', 'remove_the_title_stuff' );

// Removes the default gallery shortcode css -  @ Stolen from twentyten
	function skivvy_remove_gallery_css( $css ) {
		return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
	}
	add_filter( 'gallery_style', 'skivvy_remove_gallery_css' );




/* NOT WORKING CURRENTLY
 * URL rewriting
 *
 * Rewrites currently do not happen for child themes (or network installs)
 * @todo https://github.com/retlehs/roots/issues/461
 *
 * Rewrite:
 *   /wp-content/themes/themename/css/ to /css/
 *   /wp-content/themes/themename/js/  to /js/
 *   /wp-content/themes/themename/img/ to /img/
 *   /wp-content/plugins/              to /plugins/
 *
 * If you aren't using Apache, alternate configuration settings can be found in the docs.
 *
 * @link https://github.com/retlehs/roots/blob/master/doc/rewrites.md
 */
/*
function roots_add_rewrites($content) {
  global $wp_rewrite;
  $roots_new_non_wp_rules = array(
    'assets/css/(.*)'      => THEME_PATH . '/assets/css/$1',
    'assets/js/(.*)'       => THEME_PATH . '/assets/js/$1',
    'assets/img/(.*)'      => THEME_PATH . '/assets/img/$1',
    'plugins/(.*)'         => RELATIVE_PLUGIN_PATH . '/$1'
  );
  $wp_rewrite->non_wp_rules = array_merge($wp_rewrite->non_wp_rules, $roots_new_non_wp_rules);
  return $content;
}

function roots_clean_urls($content) {
  if (strpos($content, RELATIVE_PLUGIN_PATH) > 0) {
    return str_replace('/' . RELATIVE_PLUGIN_PATH,  '/plugins', $content);
  } else {
    return str_replace('/' . THEME_PATH, '', $content);
  }
}

if (!is_multisite() && !is_child_theme()) {
  if (current_theme_supports('rewrites')) {
    add_action('generate_rewrite_rules', 'roots_add_rewrites');
  }

  if (!is_admin() && current_theme_supports('rewrites')) {
    $tags = array(
      'plugins_url',
      'bloginfo',
      'stylesheet_directory_uri',
      'template_directory_uri',
      'script_loader_src',
      'style_loader_src'
    );

    add_filters($tags, 'roots_clean_urls');
  }
} //*/
?>