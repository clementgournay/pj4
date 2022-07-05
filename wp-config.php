<?php
define('JWT_AUTH_SECRET_KEY', 'iR67XWlt');
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache
define('WP_MEMORY_LIMIT', '500M');
define('NON_EXISTANT_ID', 28032);

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'sc4elaugier_wp167');

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );




/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'maeug0ubjlmxegah7ucwoswwh6lmtwin8zx4azkujvehrttztglbg5a9894mtwco' );
define( 'SECURE_AUTH_KEY',  'rymkh8x72txx4kcfen8bdk0bke5akzuwws74ygjaqb4wdt18u6uvdx3xvihcagi0' );
define( 'LOGGED_IN_KEY',    'e6weeudxdwwkht0aigowoguqt6nyqnkckp2wmoflrtrtbkyruub71kfl89ndvt4l' );
define( 'NONCE_KEY',        'xy1qwoyo9ffh1ecozfojjsgnz7fpebjbelgkmpe7nbcwwsj5qxh2fmc4xc9gxlme' );
define( 'AUTH_SALT',        'dneedadpt4q1yn5zbqjuvwdfln6yz5qpbyidnb50iyzxdznde8mxumkaculf0klk' );
define( 'SECURE_AUTH_SALT', 'lfff54zomk149ftkqrcbkrez9tpevauns5htf5ubaciz9t8v2qyijio8fyiwdmcm' );
define( 'LOGGED_IN_SALT',   'l80hg0lucd0k7mn70l3cpcrn02wcbic24upmkxi8wm5tkckrotrr3er5tl3wd4sm' );
define( 'NONCE_SALT',       'mzs6iiknsygcvj92pefcgrgkzvscrygja3oimwi2sbi1gnmzmz94bqtxhmjcdvcp' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpbr_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */

/*
define( 'WP_DEBUG', true);
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', true);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';




