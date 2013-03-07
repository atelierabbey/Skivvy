<?php // Hook this ...stuff... into header

function d4_head() {
	echo '<meta charset="' . bloginfo( "charset" ) . '" />' ;
	echo '<link rel="profile" href="http://gmpg.org/xfn/11" />';
	echo '<link rel="pingback" href="' . bloginfo( "pingback_url" ) . '" />';
	// Favicon
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('stylesheet_directory').'/img/favicon.ico" />';
	// Jquery - Google, then wordpress's
	if (!is_admin()) {
		wp_deregister_script('jquery');
		wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js', false, '1.8.3', true);
		wp_enqueue_script('jquery');
	}
	// Theme CSS
	echo '<link rel="stylesheet" type="text/css" media="all" href="'.bloginfo( 'stylesheet_url' ).'" />';
}
add_action('wp_head', 'd4_head');


/* Custom login logo */
function my_custom_login_logo() { echo '<style type="text/css"> h1 a { background-image:url('.get_bloginfo('template_directory').'/img/login-logo.png) !important; } </style>'; } add_action('login_head', 'my_custom_login_logo');
?>