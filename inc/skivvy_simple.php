<?php #13May15

//	Skivvy Auto-Options
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
	/*
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
//*/

// WP_HEAD() - Cleanup
		remove_action('wp_head', 'wp_generator');
		remove_action('wp_head', 'rsd_link');							// <link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://url.com/xmlrpc.php?rsd">
		remove_action('wp_head', 'wlwmanifest_link');					// <link rel="wlwmanifest" type="application/wlwmanifest+xml" href="http://url.com/wp-includes/wlwmanifest.xml"> | Resource file needed to enable tagging support for Windows Live Writer.
		remove_action('wp_head', 'index_rel_link');						// ???
		remove_action('wp_head', 'start_post_rel_link', 10, 0);			// ???
		remove_action('wp_head', 'parent_post_rel_link', 10, 0);		// ???
		remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);		// ???
		remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');	// <link rel="next" title="Post Title!" href="http://url.com/post-title/">
		remove_action('wp_head', 'wp_shortlink_wp_head');				// <link rel="shortlink" href="http://url.com/?p=10">
		remove_action('wp_head', 'feed_links', 2);						// <link rel="alternate" type="application/rss+xml" title="Skivvy » Feed" href="http://url.com/feed/"> | Works with Add_theme_support('automatic-feed-links');
		remove_action('wp_head', 'feed_links_extra', 3);				// <link rel="alternate" type="application/rss+xml" title="Skivvy » Hello world! Comments Feed" href="http://url.com/hello-world/feed/">


	function skivvy_head() {
		echo (
			'<!--[if lt IE 9]><script src="' . get_template_directory_uri() . '/js/html5.js"></script><![endif]-->' // HTML5 Shiv for < IE9
		#	.'<link rel="profile" href="http://gmpg.org/xfn/11">'

		);
	} add_action( 'wp_head', 'skivvy_head' );


//  WP_FOOT()
	function skivvy_foot() {
		// includes Analytics.php code
			get_template_part( '/js/analytics' );
	} add_action( 'wp_footer', 'skivvy_foot' );






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

// Disable Emojis - By Ryan Hellyer @ https://geek.hellyer.kiwi/ - License: GPL2
	function disable_emojis() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	} add_action( 'init', 'disable_emojis' );
	function disable_emojis_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		} else {
			return array();
		}
	}

?>