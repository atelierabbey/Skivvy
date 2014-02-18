<?php #18Feb14
add_action( 'after_setup_theme', 'skivvy_setup' ); function skivvy_setup() {
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
	#	include 'inc/skivvy_autooptions.php';
	#	add_theme_support( 'post-formats', array('aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video') );
		add_filter('widget_text', 'do_shortcode'); // Widget Support - Shortcodes 
	#	add_filter('widget_text', array( $wp_embed, 'run_shortcode' ), 8 );
	#	add_filter('widget_text', array( $wp_embed, 'autoembed'), 8 ); // Widget Support - oEmbed & oEmbed 2
	#	$lang_location = get_template_directory_uri() . '/inc'; load_theme_textdomain( 'skivvy', $lang_location ); $locale_file = $lang_location . '/' . get_locale() . '.php'; if ( is_readable( $locale_file )){ require_once( $locale_file );}
} 

// Includes - You can change the includes per site
	#	include 'inc/register_sidebar.php';
	#	include 'inc/register_menu.php';
	#	include 'inc/register_posttype.php';
	#	include 'inc/register_taxonomy.php';
	#	include 'inc/register_scripts.php';
		include 'inc/skivvy_simple.php';
		include 'inc/skivvy_branding.php';

// Library - It's not nice to write in things from the library.
	#	include 'inc/lib/skivvy_websiteoptions.php'; new skivvy_websiteoptions;
	#	include 'inc/lib/skivvy_meta-home.php'; $list_o_meta = array('Bucket 1','Bucket 2','Bucket 3','Bucket 4'); new skivvy_home_meta ;
	#	include 'inc/lib/skivvy_toolbox.php';
	#	include 'inc/lib/skivvy_toolbox-styles.php'; 
	#	include 'inc/lib/skivvy_toolbox-posttypes.php';
	#	include 'inc/lib/mod_buckets.php';
	#	include 'inc/lib/mod_browserdetect.php';
?>