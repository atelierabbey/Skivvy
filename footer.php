<footer id="footer">
	<div class="page-wrapper">
		<div class="footer-content">
		<?php /*
			if ( is_active_sidebar( 'first-footer-widget-area'  ) ) : ?><ul class="nobull footsidebar-1 one_fourth"><?php dynamic_sidebar( 'first-footer-widget-area' ); ?></ul><?php endif;
			if ( is_active_sidebar( 'second-footer-widget-area' ) ) : ?><ul class="nobull footsidebar-2 one_fourth"><?php dynamic_sidebar( 'second-footer-widget-area' ); ?></ul><?php endif;
			if ( is_active_sidebar( 'third-footer-widget-area'  ) ) : ?><ul class="nobull footsidebar-3 one_fourth"><?php dynamic_sidebar( 'third-footer-widget-area' ); ?></ul><?php endif;
			if ( is_active_sidebar( 'fourth-footer-widget-area' ) ) : ?><ul class="nobull footsidebar-4 one_fourth last"><?php dynamic_sidebar( 'fourth-footer-widget-area' ); ?></ul><?php endif;
		//*/ ?>
			<div class="clear"></div>
		</div>
		<div class="footer-copyright"><?php

			// Auto generate year. if
			$start_year = "2015";
			$date = date( 'Y' );
			if ( $date > $start_year ) {
			$date = "$start_year - $date";
			}

			_e( sprintf( 'Copyright &copy; %1$s <a href="%2$s" title="%3$s" rel="home">%4$s</a>. All Rights Reserved. ' , $date, home_url('/'), esc_attr( get_bloginfo( 'name', 'display' ) ), get_bloginfo( 'name' )), 'skivvy' );

			if (function_exists('skinfo')) {
				_e( '<a href="'. skinfo('AuthorURI') . '" title="" rel="nofollow" target="_blank">Web Design</a> by '. skinfo('Author') , 'skivvy' ) ;
			}

		?></div>
	</div>
</footer>
<?php

	// includes Analytics.php code
		require ( 'js/analytics.php' );

	// includes custom.js
		// Inside of this script, $() will work as an alias for jQuery() and other libraries also using $ will not be accessible under this shortcut
		/* echo '<script src="' . get_stylesheet_directory_uri() . '/js/custom.js"></script>'; //*/


	// Don't touch below this line
		wp_footer();
?></body>
</html>
