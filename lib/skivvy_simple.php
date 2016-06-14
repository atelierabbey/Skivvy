<?php #10Nov15

// WP_HEAD() Cleanup
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

	remove_action('wp_head', 'rest_output_link_wp_head');			// <link rel="https://api.w.org/" href="http://skivvy.atelierabbey.org/wp-json/">
	remove_action('wp_head', 'wp_oembed_add_host_js');				// ???
	remove_action('wp_head', 'wp_oembed_add_discovery_links');		// <link rel="alternate" type="application/json+oembed" href="http://skivvy.atelierabbey.org/wp-json/oembed/1.0/embed?url=http%3A%2F%2Fskivvy.atelierabbey.org%2F"> & <link rel="alternate" type="text/xml+oembed" href="http://skivvy.atelierabbey.org/wp-json/oembed/1.0/embed?url=http%3A%2F%2Fskivvy.atelierabbey.org%2F&amp;format=xml">
	remove_action('wp_head', '_custom_logo_header_styles');			// ???
	


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


// Remove XML-RPC function by default to remove DDOS Ping attacks    |    Read more - http://labs.sucuri.net/?is-my-wordpress-ddosing
	// NOTE - This may also affect the current WordPress phone app (v5.4.1), since it relies on the xmlrpc method
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



?>