<footer id="footer"><?php



if ( $date > $start_year ) $date = "$start_year - $date"; // If the two years don't match, they go to 'n fro. If you don't want the hyphenated date, comment out this line.

	$output .= '<div class="page-wrapper">';


		// Copyright date
			$start_year = "2016"; // Starting Year
			$date = date( 'Y' ); // Current year
			$output .= '<div role="contentinfo" id="footer-copyright" class="textcenter">';
				$output .= __( sprintf( 'Copyright &copy; %1$s <a href="%2$s" title="%3$s" rel="home">%4$s</a>. All Rights Reserved. ' , $date, home_url('/'), esc_attr( get_bloginfo( 'name', 'display' ) ), get_bloginfo( 'name' )), 'skivvy' );
				$output .= __( '<a href="'. skinfo('AuthorURI') . '" title="" rel="nofollow" target="_blank">Web Design</a> by '. skinfo('Author') , 'skivvy' );
			$output .= '</div>';

	$output .= '</div>';
		

	echo $output;
	wp_footer();
?></footer>
</body>
</html>