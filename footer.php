<footer>
	<div class="page-wrapper">
		<?php
			if ( is_active_sidebar( 'first-footer-widget-area'  ) ) : ?><ul class="nobull footsidebar-1"><?php dynamic_sidebar( 'first-footer-widget-area' ); ?></ul><?php endif;
			if ( is_active_sidebar( 'second-footer-widget-area' ) ) : ?><ul class="nobull footsidebar-2"><?php dynamic_sidebar( 'second-footer-widget-area' ); ?></ul><?php endif;
			if ( is_active_sidebar( 'third-footer-widget-area'  ) ) : ?><ul class="nobull footsidebar-3"><?php dynamic_sidebar( 'third-footer-widget-area' ); ?></ul><?php endif;
			if ( is_active_sidebar( 'fourth-footer-widget-area' ) ) : ?><ul class="nobull footsidebar-4"><?php dynamic_sidebar( 'fourth-footer-widget-area' ); ?></ul><?php endif;
		?>
		<div class="footer-copyright"><?php
	
			// Auto generate year. if 
			$start_year = "2014";
			$date = date( 'Y' );
			if ( $date > $start_year ) {
			$date = "$start_year - $date";
			}

			_e( sprintf( 'Copyright &copy; %1$s <a href="%2$s" title="%3$s" rel="home">%4$s</a>. All Rights Reserved. ' , $date, home_url('/'), esc_attr( get_bloginfo( 'name', 'display' ) ), get_bloginfo( 'name' )), 'skivvy' );

			_e( '<a href="http://www.d4webdesign.com/" title="Reno Web Design" target="_blank">Web Design</a> by D4', 'skivvy' ) ;

		?></div>
	</div>
</footer>
<?php 

	// includes Analytics.php code
		require ( 'js/analytics.php' );

	// includes custom.js
		// Inside of this script, $() will work as an alias for jQuery() and other libraries also using $ will not be accessible under this shortcut
		/* echo '<script src="' . get_template_directory_uri() . '/js/custom.js"></script>'; //*/


	// Don't touch below this line
		wp_footer();
?></body>
</html>