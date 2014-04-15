<?php if ( ! class_exists( 'skivvy_websitedata' ) ) { class skivvy_websitedata {




	static $version = "1Feb13";




	function __construct() {
		add_action( 'admin_init', 'skivvy_websitedata::theme_options_init' );
		add_action( 'admin_menu', 'skivvy_websitedata::theme_options_add_page' ); 
	}

	public function theme_options_add_page() {
		add_theme_page(
			'Website Data', // Page Title
			'Website Data', // Menu Title
			'install_themes', // Capability
			'website_data', // menu slug
			'skivvy_websitedata::render_website_data'
		);
	}

	public function theme_options_init(){
		;
	} 




	/*
	 *
	 *		Render Website Data page
	 *
	 */


		function render_website_data() {
			global $select_options;
			if ( ! isset( $_REQUEST['settings-updated'] ) ) {
				$_REQUEST['settings-updated'] = false;
			} 

			echo '<div class="wrap skivvy-websitedata">';
				screen_icon();
				echo '<h2>Website Data</h2>';

				if ( false !== $_REQUEST['settings-updated'] ) {
							echo '<div><p><strong>Options saved</strong></p></div>';
				}

				echo '<form method="post" action="../../lib/options.php">';
						settings_fields( 'skivvy_options' );
						$options = get_option( 'website_data_options' );
						echo '<input type="submit" value="Save" class="button button-primary button-large">';
				echo '</form>';
			echo '</div>';
		}


}}?>