<footer id="footer"><?php
	echo '<div class="page-wrapper">';


		/*echo '<div class="footer-content">';
			if ( is_active_sidebar( 'first-footer-widget-area'  ) ) : ?><ul class="nobull footsidebar-1 one_fourth"><?php dynamic_sidebar( 'first-footer-widget-area' ); ?></ul><?php endif;
			if ( is_active_sidebar( 'second-footer-widget-area' ) ) : ?><ul class="nobull footsidebar-2 one_fourth"><?php dynamic_sidebar( 'second-footer-widget-area' ); ?></ul><?php endif;
			if ( is_active_sidebar( 'third-footer-widget-area'  ) ) : ?><ul class="nobull footsidebar-3 one_fourth"><?php dynamic_sidebar( 'third-footer-widget-area' ); ?></ul><?php endif;
			if ( is_active_sidebar( 'fourth-footer-widget-area' ) ) : ?><ul class="nobull footsidebar-4 one_fourth last"><?php dynamic_sidebar( 'fourth-footer-widget-area' ); ?></ul><?php endif;
		echo '<div class="clear"></div>'; //*/


		echo '<div role="contentinfo" id="footer-copyright" class="textcenter">';
			$start_year = "2015"; // Starting Year
			$date = date( 'Y' ); // Current year
			if ( $date > $start_year ) $date = "$start_year - $date"; // If the two years don't match, they go to 'n fro. If you don't want the hyphenated date, comment out this line.

			_e( sprintf( 'Copyright &copy; %1$s <a href="%2$s" title="%3$s" rel="home">%4$s</a>. All Rights Reserved. ' , $date, home_url('/'), esc_attr( get_bloginfo( 'name', 'display' ) ), get_bloginfo( 'name' )), 'skivvy' );

			if (function_exists('skinfo')) { _e( '<a href="'. skinfo('AuthorURI') . '" title="" rel="nofollow" target="_blank">Web Design</a> by '. skinfo('Author') , 'skivvy' ) ; }
		echo '</div>';


	echo '</div>';
	wp_footer();
?></footer>
</body>
</html>