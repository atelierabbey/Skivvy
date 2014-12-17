<?php

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

?>