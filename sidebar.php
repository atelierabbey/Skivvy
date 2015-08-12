<?php
	if ( is_active_sidebar( 'primary-widget-area' ) ) :
		echo '<aside class="sidebar dont-print">';
			echo '<ul class="nobull">';
				dynamic_sidebar('primary-widget-area');
			echo '</ul>';
		echo '</aside>';
	endif;
?>
