<?php # 2017-08-31

// skinfo('$what');  -- Get Version from theme's style.css
	function skinfo($what='Version') {
		$ct = wp_get_theme();
		switch ($what){
			case 'Name': return $ct->Name; break; //Theme name as given in theme's style.css
			case 'ThemeURI': return $ct->ThemeURI; break; //The path to the theme's directory
			case 'Description': return $ct->Description; break; // The description of the theme
			case 'Author': return $ct->display( 'Author', FALSE ); break; //The theme's author
			case 'AuthorURI': return $ct->get( 'AuthorURI' ); break; // The website of the theme author
			case 'Version': return $ct->Version; break; //The version of the theme
			case 'Template': return $ct->Template; break; //The folder name of the current theme
			case 'Status': return $ct->Status; break; //If the theme is published
			case 'Tags': return $ct->Tags; break; //Tags used to describe the theme
			case 'TextDomain': return $ct->get( 'TextDomain' ); break; //The text domain used in the theme for translation purposes
			case 'DomainPath': return $ct->get( 'DomainPath'); break; //Path to the theme translation files
		}
	}

// Custom admin
	function skivvy_admin_color_schemes() {
		wp_admin_css_color(
			'skivvy-colors',
			__( 'Skivs' ),
			get_template_directory_uri() . '/css/admin-colors.css',
			array(
				'#25282b',
				'#363b3f',
				'#69a8bb',
				'#e14b3b'
			)
		);
	} add_action('admin_init', 'skivvy_admin_color_schemes');

// Filter - Adds classes to admin based on user role
	function skivvy_admin_body_class( $classes ) {

		$user = new WP_User(get_current_user_id());
		if ( !empty($user->roles) && is_array($user->roles)) {
			foreach ($user->roles as $role)
				$role = $role;
		}

		return "{$classes} user-{$role}";

	}
	add_filter('admin_body_class', 'skivvy_admin_body_class');

// Admin Styles & Scripts
	function skivvy_admin_script_style() {

		// Styles
		wp_register_style( 'skivvy_admin_style', get_template_directory_uri().'/css/admin.css', false, skinfo('Version'), 'screen' );
		wp_enqueue_style( 'skivvy_admin_style' );
		// Scripts
		wp_register_script( 'skivvy_admin_script', get_template_directory_uri().'/css/admin.js', array('jquery'), skinfo('Version'), true );
		wp_enqueue_script( 'skivvy_admin_script' );

	}
	add_action( 'admin_enqueue_scripts', 'skivvy_admin_script_style' );
	add_action( 'login_enqueue_scripts', 'skivvy_admin_script_style' );

// Admin Head hook
	function skivvy_admin_head() {

		// Shortcut Icon - Favicon
			echo '<link rel="shortcut icon" type="image/png" href="' . get_template_directory_uri() . '/img/favicon.png?v='. time() . '">';

	} add_action('admin_head', 'skivvy_admin_head');


// Redirect Login Log link to Homepage
	function skivvy_login_logo_url() {
		return get_bloginfo( 'url' );
	} add_filter( 'login_headerurl', 'skivvy_login_logo_url' );