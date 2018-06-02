<?php

	$output = '<footer id="footer">';

		$output .= '<div class="page-wrapper">';


			// Copyright date
				$start_year = "2017"; // Starting Year
				$date = date( 'Y' ); // Current year
				if ( $date > $start_year ) $date = "$start_year - $date";

				$output .= '<div role="contentinfo" id="footer-copyright" class="textcenter">';
					$output .= __( sprintf( 'Copyright &copy; %1$s <a href="%2$s" title="%3$s" rel="home">%4$s</a>.', $date, home_url('/'), esc_attr( get_bloginfo( 'name', 'display' ) ), get_bloginfo( 'name' )), 'skivvy' );
					$output .= __( ' All Rights Reserved.', 'skivvy' );
					$output .= __( ' <a href="'. skinfo('AuthorURI') . '" title="" rel="nofollow" target="_blank">Web Design</a> by '. skinfo('Author') , 'skivvy' );
				$output .= '</div>';

		$output .= '</div>';

	$output .= '</footer>';

	echo $output;

?>
<?php wp_footer(); ?>
</body>
</html>
