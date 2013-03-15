<!DOCTYPE html><html <?php language_attributes(); ?> class="<?php if (function_exists('css_browser_selector')) { echo css_browser_selector(); } else { echo 'off'; } ?>">
<head>
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <?php wp_head(); ?>
</head>
<body id="post-<?php the_ID(); ?>" <?php body_class(); ?>>

<div class="header">
	<div class="logo"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php bloginfo('template_url'); ?>/img/logo.png"></a></div>
	<div id="access" role="navigation">
		<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
	</div>
</div>
<div class="clear"></div>