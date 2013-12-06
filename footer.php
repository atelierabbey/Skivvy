<footer>
<?php
	if ( is_active_sidebar( 'first-footer-widget-area' ) ) : ?><ul class="xoxo footsidebar-1"><?php dynamic_sidebar( 'first-footer-widget-area' ); ?></ul><?php endif;
	if ( is_active_sidebar( 'second-footer-widget-area' ) ) : ?><ul class="xoxo footsidebar-2"><?php dynamic_sidebar( 'second-footer-widget-area' ); ?></ul><?php endif;
	if ( is_active_sidebar( 'third-footer-widget-area' ) ) : ?><ul class="xoxo footsidebar-3"><?php dynamic_sidebar( 'third-footer-widget-area' ); ?></ul><?php endif;
	if ( is_active_sidebar( 'fourth-footer-widget-area' ) ) : ?><ul class="xoxo footsidebar-4"><?php dynamic_sidebar( 'fourth-footer-widget-area' ); ?></ul><?php endif;
?>
<div class="footer-copyright"><?php 
$current_year = "2013";
$date = date("Y");
if ( $date > $current_year) {
$date = "$current_year - $date";
}
_e( sprintf( 'Copyright &copy; %1$s <a href="%2$s" title="%3$s" rel="home">%4$s</a>. All Rights Reserved.' , $date, home_url('/'), esc_attr( get_bloginfo( 'name', 'display' ) ), get_bloginfo( 'name' )), 'skivvy' );
_e( '<a href="http://www.d4webdesign.com/" title="Reno Web Design" target="_blank">Web Design</a> by D4', 'skivvy' ) ;
?></div>
</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>