<?php echo '<!DOCTYPE html>'; // HTML5 Doctype
// HTML Tag
$htmltag = '<html dir="ltr" lang="en-US" class="'; 
	if (function_exists('css_browser_selector')){ $htmltag .= css_browser_selector() . ' '; }
	if (function_exists('skinfo')){ $htmltag .= skinfo('Version'); }
$htmltag .= '">'; echo $htmltag;

echo '<head>';
	// Meta data
	echo '<meta charset=utf-8>';
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
	echo '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';
	# echo '<meta name="description" content="' . '' .'">';

	// Site Title
	echo '<title>' . wp_title( '|', FALSE, 'right' ) . '</title>';

	// Shortcut Icon - Favicon    
	$iconversion = 1;
	echo '<link rel="shortcut icon" type="image/png" href="' . get_template_directory_uri() . '/img/favicon.png?v=' . $iconversion . '" />';

	// RSS Link
	echo '<link rel="alternate" type="application/rss+xml" title="RSS 2.0 Feed" href="' . get_bloginfo('rss2_url') . '" />';

	// Standard Stylesheets
	echo '<link rel="stylesheet" href="' . get_template_directory_uri() . '/css/func.css?ver=1" type="text/css" />';
	echo '<link rel="stylesheet" href="' . get_template_directory_uri() . '/style.css?ver=1" type="text/css" />';

	// HTML5 Shiv for less than IE9
	echo '<!--[if lt IE 9]><script src="' . get_template_directory_uri() . '/js/html5.js"></script><![endif]-->';

	// Load Jquery
	wp_enqueue_script("jquery");

	// wp_head - Obviously... don't touch....
	wp_head();
echo '</head>';?><body id="page-<?php echo get_the_ID(); ?>" <?php body_class(); ?>>
<div id="preloader"></div>
<div class="wrapper">
<header>
<div class="logo"><?php echo // Logo Chunk
	'<a href="' . home_url( '/' ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">' .
		'<img src="' . get_bloginfo('template_url') . '/img/logo.png" alt="Logo">' .
	'</a>';
?></div>
<nav class="access"><?php // Main Nav Chunk
	wp_nav_menu( array(
		'theme_location'  => 'main',
		'menu'            => '',
		'container'       => FALSE,
		'container_class' => '',
		'container_id'    => '',
		'menu_class'      => '',
		'menu_id'         => '',
		'echo'            => TRUE,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul>%3$s</ul>',
		'depth'           => 3, // 0 = all. Default, -1 = displays links at any depth and arranges them in a single, flat list.
		'walker'          => ''
	));
?></nav>
</header>
<div class="clear"></div>

<section class="content">

<h1 class="page-title"><?php // Title

	// Prefix If is Password Protected
	if ( !empty( $post->post_password ) ) _e( 'Protected: ' , 'skivvy' ); 
	// Prefix If is Private
	if ( get_post_status ( $ID ) == 'private' ) _e( 'Private: ' , 'skivvy' );

	    if ( is_home()       ) : echo get_the_title( get_option( 'page_for_posts' ) );
	elseif ( is_day()        ) : printf( __( 'Day: %s', 'skivvy' ), get_the_date() );
	elseif ( is_month()      ) : printf( __( 'Month: %s', 'skivvy' ), get_the_date( 'F Y' ) );
	elseif ( is_year()       ) : printf( __( 'Year: %s', 'skivvy' ), get_the_date( 'Y' ) );
	elseif ( is_tax()        ) : $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); echo $term->name;
	elseif ( is_tag()        ) : single_tag_title();
	elseif ( is_category()   ) : single_cat_title();
	elseif ( is_author()     ) : printf( __( 'Posts by %s', 'skivvy' ), sprintf( '<span class="vcard"><a href="%1$s" rel="me">%2$s</a></span>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), get_the_author() ) );
	elseif ( is_archive()    ) : echo get_the_title( get_option( 'page_for_posts' ) );
	elseif ( is_search()     ) : _e( 'Search Results', 'skivvy' );
	elseif ( is_attachment() ) : the_title();
	elseif ( is_single()     ) : the_title();
	elseif ( is_front_page() ) : #the_title();
	elseif ( is_page()       ) : the_title();
	elseif ( is_404()        ) : _e( '404 | Page not found' , 'skivvy' );
	else                       : // Ninja Silence....
	endif;

?></h1>