<?php #24Jan14
function skivvy_autooptions() {
	$the_theme_status = get_option( 'theme_setup_status' );
	if ( $the_theme_status !== '1' ) {
		// Setup Default WordPress settings
		$core_settings = array(
			'show_avatars' => false,
			'avatar_default' => 'mystery',
			'avatar_rating' => 'G',
			'default_role' => 'editor',
			'comments_per_page' => 20,
			'uploads_use_yearmonth_folders' => false,
		);
		foreach ( $core_settings as $k => $v ) {update_option( $k, $v );}

		// Delete dummy post, page and comment.
		wp_delete_post( 1, true );
		wp_delete_post( 2, true );
		wp_delete_comment( 1 );

		update_option( 'theme_setup_status', '1' );
		$msg = '<div class="error"><p>The '.get_option( 'current_theme' ).' theme has changed your WordPress default <a href="' . admin_url( 'options-general.php' ) . '" title="See Settings">settings</a> and deleted default posts & comments.</p></div>';
		add_action( 'admin_notices', $c = create_function( '', 'echo "' . addcslashes( $msg, '"' ) . '";' ) );
	}
	// Else if we are re-activing the theme
	elseif ( $the_theme_status === '1' and isset( $_GET['activated'] ) ) {
		$msg = '
		<div class="updated">
			<p>The ' . get_option( 'current_theme' ) . ' theme was successfully re-activated.</p>
		</div>';
		add_action( 'admin_notices', $c = create_function( '', 'echo "' . addcslashes( $msg, '"' ) . '";' ) );
	}
} ?>