<?php get_header(); ?>
<h1>404 Error</h1>
<p>Sorry, the page you are looking for cannot be found.</p>
<p>Make sure you have the correct URL or try starting over at our <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">homepage</a> or find the page below.</p>

<?php $menuargs = array(
		'theme_location'  => 'sitemap',
		'menu'            => '',
		'container'       => 'div',
		'container_class' => 'sitemap',
		'container_id'    => '',
		'menu_class'      => '',
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

<?php get_sidebar(); ?>
<?php get_footer(); ?>