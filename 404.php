<?php get_header(); ?>
<h1>404 | Page not found</h1>
<p>Sorry, the page you are looking for cannot be found.</p>
<p>Make sure you have the correct URL or try starting over at our <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">homepage</a> or find the page below.</p>
<?php wp_nav_menu(array(
	'theme_location'  => 'sitemap',
	'menu'            => '',
	'container'       => '',
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
	'items_wrap'      => '<ul>%3$s</ul>',
	'depth'           => 3, // 0 = all. Default, -1 = displays links at any depth and arranges them in a single, flat list.
	'walker'          => ''
)); ?>
<script>if(_gaq != null) {_gaq.push(['_trackEvent', '404', document.location.pathname + document.location.search, document.referrer, 0, true]);}</script>
<?php get_sidebar(); ?>
<?php get_footer(); ?>