<!DOCTYPE html><html class="<?php if (function_exists('css_browser_selector')){echo css_browser_selector().' ';} if (function_exists('skinfo')){ echo skinfo('Version'); }?>"  dir="ltr" lang="en-US"><meta charset=utf-8><title><?php wp_title( '|', true, 'right' ); ?></title><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><link rel="shortcut icon" type="image/png" href="<?php bloginfo('stylesheet_directory');?>/img/favicon.png?v=1" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0 Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="stylesheet" href="<?php bloginfo('template_directory');?>/css/func.css?ver=1" type="text/css" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory');?>/style.css?ver=1" type="text/css" />
<!--[if lt IE 9]><script src="<?php bloginfo('template_directory'); ?>/js/html5.js"></script><![endif]-->
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_enqueue_script("jquery"); ?>
<?php wp_head(); ?>
<body id="page-<?php the_ID(); ?>" <?php body_class(); ?>>
<div id="preloader"></div>
<div class="wrapper">
   <header>
	<div class="logo">
		<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<img src="<?php bloginfo('template_url'); ?>/img/logo.png" alt="Logo">
		</a>
	</div>
	<nav class="access">
            <?php wp_nav_menu( array(
                'theme_location'  => 'main',
                'menu'            => '',
                'container'       => false,
                'container_class' => '',
                'container_id'    => '',
                'menu_class'      => '',
                'menu_id'         => '',
                'echo'            => true,
                'fallback_cb'     => 'wp_page_menu',
                'before'          => '',
                'after'           => '',
                'link_before'     => '',
                'link_after'      => '',
                'items_wrap'      => '<ul>%3$s</ul>',
                'depth'           => 3, // 0 = all. Default, -1 = displays links at any depth and arranges them in a single, flat list.
                'walker'          => ''
            )); ?>
        </nav>
    </header>
    <div class="clear"></div>
    <article class="content">
