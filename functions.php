<?php #15Apr14

// Basic Setup
function skivvy_setup() {
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array('comment-list','search-form','comment-form','gallery') );
	#	add_theme_support( 'post-formats', array('aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video') );
	#	include 'inc/skivvy_autooptions.php';
	#	add_filter('widget_text', 'do_shortcode'); // Widget Support - Shortcodes 
	#	add_filter('widget_text', array( $wp_embed, 'run_shortcode' ), 8 );
	#	add_filter('widget_text', array( $wp_embed, 'autoembed'), 8 ); // Widget Support - oEmbed & oEmbed 2
	#	$lang_location = get_template_directory_uri() . '/inc'; load_theme_textdomain( 'skivvy', $lang_location ); $locale_file = $lang_location . '/' . get_locale() . '.php'; if ( is_readable( $locale_file )){ require_once( $locale_file );}
}
add_action( 'after_setup_theme', 'skivvy_setup' );
include 'inc/skivvy_simple.php';
include 'inc/skivvy_branding.php';
include 'inc/skivvy_register.php';

// Theme tools
#	include 'inc/lib/skivvy_toolbox.php';
#	include 'inc/lib/skivvy_toolbox-styles.php';
#	include 'inc/lib/mod_browserdetect.php';

?>