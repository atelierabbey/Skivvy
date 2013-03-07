	<!DOCTYPE html><html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>

<!-- Style Sheets-->
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<!-- Javascript / jQuery -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php bloginfo('template_url'); ?>/inc/jquery-1.8.1.min.js"><\/script>')</script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/inc/jquery.cycle.all.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/inc/shadowbox.js"></script>






<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div id="header" class="<?php echo css_browser_selector() ?>">
	<div id="logo"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php bloginfo('template_url'); ?>/img/logo.png"></a></div>
	<p><?php bloginfo( 'description' ); ?></p>
	<div id="access" role="navigation">
		<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
		<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
	</div><!-- #access -->
</div><!-- #header -->
<div class="clear"></div>
