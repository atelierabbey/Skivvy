<?php // Hook this ...stuff... into <head> - 13Mar13
function d4_head() {
	echo '<meta charset="'.get_bloginfo('charset').'" />' ;
	echo '<link rel="profile" href="http://gmpg.org/xfn/11" />';
	echo '<link rel="pingback" href="'.get_bloginfo('pingback_url').'" />';
	// Favicon
	$ct = wp_get_theme();
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('stylesheet_directory').'/img/favicon.ico?v='.$ct->Version.'" />';
}
add_action('wp_head', 'd4_head');


function d4_script_enqueuer() {
	// Register local Jquery & stylesheets
	if (!is_admin()) {
		$ct = wp_get_theme();
		
		$handle = 'jquery';
		$src = get_template_directory_uri() . '/js/jquery.min.js';
		$deps = false;
		$ver = '1.9.1';
		$in_footer = false;
		wp_deregister_script($handle);
		wp_register_script($handle, $src, $deps, $ver, $in_footer );
		
		//custom.js enque
		wp_register_script( 'site', get_template_directory_uri().'/js/custom.js', array( 'jquery' ), $ct->Version, true );
		wp_enqueue_script( 'site' );
		//Enqueue Function.css
		wp_register_style( 'function', get_template_directory_uri().'/inc/functions.css', '', '1.0', 'all' );
    	wp_enqueue_style( 'function' );
		
		//Enqueue style.css
		
		wp_register_style( 'style', get_template_directory_uri().'/style.css', array( 'function' ), $ct->Version, 'all' );
    	wp_enqueue_style( 'style' );

	}
}
add_action('wp_enqueue_scripts', 'd4_script_enqueuer');

function twentyten_filter_wp_title( $title, $separator ) {
	// Don't affect wp_title() calls in feeds.
	if ( is_feed() )
		return $title;
	// The $paged global variable contains the page number of a listing of posts.
	// The $page global variable contains the page number of a single post that is paged.
	// We'll display whichever one applies, if we're not looking at the first page.
	global $paged, $page;
	if ( is_search() ) {
		// If we're a search, let's start over:
		$title = sprintf( __( 'Search results for %s', 'twentyten' ), '"' . get_search_query() . '"' );
		// Add a page number if we're on page 2 or more:
		if ( $paged >= 2 )
			$title .= " $separator " . sprintf( __( 'Page %s', 'twentyten' ), $paged );
		// Add the site name to the end:
		$title .= " $separator " . get_bloginfo( 'name', 'display' );
		// We're done. Let's send the new title back to wp_title():
		return $title;
	}
	// Otherwise, let's start by adding the site name to the end:
	$title .= get_bloginfo( 'name', 'display' );
	// If we have a site description and we're on the home/front page, add the description:
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $separator " . $site_description;
	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $separator " . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );
	// Return the new title to wp_title():
	return $title;
}
add_filter( 'wp_title', 'twentyten_filter_wp_title', 10, 2 );

/* Google Analytics includes - Added 17 Jan 13 - Replaces old theme option, reverted back to include file. */
function fileAnalytics() { include_once get_template_directory(). "/inc/analytics.php"; }
add_action('wp_footer', 'fileAnalytics'); 
/* Custom login logo */
function my_custom_login_logo() { echo '<style type="text/css"> h1 a { background-image:url('.get_bloginfo('template_directory').'/img/login-logo.png) !important; } </style>'; } add_action('login_head', 'my_custom_login_logo');
?>