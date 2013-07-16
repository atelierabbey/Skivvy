<?php #2Jul13 ?>
<!DOCTYPE html>
<html class="<?php if (function_exists('css_browser_selector')){echo css_browser_selector().' ';} if (function_exists('skinfo')){ echo skinfo('Version'); }?>"  dir="ltr" lang="en-US">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <meta name="description" content="">
	<link rel="shortcut icon" type="image/png" href="<?php bloginfo('stylesheet_directory');?>/img/favicon.png?v=1" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0 Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="stylesheet" href="<?php bloginfo('template_directory');?>/inc/func.css?ver=1" type="text/css" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory');?>/style.css?ver=1" type="text/css" />
	<?php wp_enqueue_script("jquery"); ?>
	<?php wp_head(); ?>
</head>
<body id="post-<?php the_ID(); ?>" <?php body_class(); ?>>
<div id="preloader"></div>
<div class="header">
	<div class="logo">
    	<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
        	<img src="<?php bloginfo('template_url'); ?>/img/logo.png">
        </a>
    </div>
	<?php $menuargs = array(
            'theme_location'  => 'main',
            'menu'            => '',
            'container'       => 'div',
            'container_class' => 'access',
            'container_id'    => '',
            'menu_class'      => 'mainnav',
            'menu_id'         => '',
            'echo'            => true,
            'fallback_cb'     => 'wp_page_menu',
            'before'          => '',
            'after'           => '',
            'link_before'     => '',
            'link_after'      => '',
            'items_wrap'      => '<ul id="%1$s" class="%2$s" role="navigation">%3$s</ul>',
            'depth'           => 3, // 0 = all. Default, -1 = displays links at any depth and arranges them in a single, flat list.
            'walker'          => ''
        );
        wp_nav_menu( $menuargs ); ?>
</div>
<div class="clear"></div>