<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'basethem_d4738');

/** MySQL database username */
define('DB_USER', 'basethem_d4738');

/** MySQL database password */
define('DB_PASSWORD', 'ok43rPbgS9');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'ytpyfa2heunsxaitoyxswnq7tkkywxf27tjxl7blmkaqqbkh8puorwrynh2zcbm1');
define('SECURE_AUTH_KEY',  'jj25nphdbul8uq8f9rm56rhpjtt3vq7ghjnecv0vxhwb3fevjpie8zczlyc2ipzg');
define('LOGGED_IN_KEY',    'ek9qjzu6f10oosxulwekexi8o2j91sxwwzf96jolrvj1wm0h7ix7wovjxxiebla5');
define('NONCE_KEY',        'h4o2dwnz7ll8jxdscshioypsp1owynkiesg6f32lsyitslp4g7zyyxqoir5wyb6w');
define('AUTH_SALT',        'ckt2xbnzlrhbjewo9ie5d86dyiaydwd1s5934ytzudoceauonmmyudxntzj3cjvw');
define('SECURE_AUTH_SALT', 'vgbi7w2l05dmkoodehfnuy7qv5ul0cgqimn50inxbksq79vdujn9sajmznkgiojh');
define('LOGGED_IN_SALT',   'ty40ve8fyjbuwsfbsea8wbepkj26zebcsns3w9do438m9z1btwteqwmwer1xqayy');
define('NONCE_SALT',       '0ivgy5fz666lbp5xqvvyv8qp4zsg1woy3x5mmdvq0pkssiu2yvzeu62kgs2zo2si');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpd4bt_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define ('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
