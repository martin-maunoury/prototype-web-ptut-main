<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '1ZvczUhMB4LRC25/DhwYidERnDIMfD3UcVVrpO3aEjHrLwAsIXf1be1Lg+RithrcKExaN9iJcDXMSBcvSV4Nnw==');
define('SECURE_AUTH_KEY',  '2aWm6zzpyLyaHjR14nG9efniipm5wl5kVVqe3yzdliinJESA+zGd2xUiq/UMBiRPyQBFgUgy8PtjFItTQbrhXw==');
define('LOGGED_IN_KEY',    'bIgw2EqFll+bHEYTKCSm/DS3YumFojma8JyWI7ZlC7k9BBjEoZqEAn+/usJTZIuxy6BofDDvrEpv7iBiq27+nw==');
define('NONCE_KEY',        'CP78X1KknL7YM3+JCPRSbTmxtxJ8EEnXdJMHa3J2pmAnRtuyywh36+rY9IEqpKRaaPdMbq/FoHs9Tfu1zjQ97g==');
define('AUTH_SALT',        'UizDGapaCsavQWLTG5e8pXoeqI8hw5FjHEVPBWrzCFlo3XtlQfeIzImVhtM5xo7RJsiXx4JsvF6BaaK+K1ruNA==');
define('SECURE_AUTH_SALT', '4mLo9PIa8bhgDuyK3GPJvBlxal96iqgQm4TTdpfBLtwBluWeIHyAtAEkLZnM4yqZIkRdqFW6esdiwCRp/Gi2UQ==');
define('LOGGED_IN_SALT',   'San3b3ILEdBpDDuYgY9k/sN2x1rBkz4/gMQrBXOlc/AE6yW6GVfc9Gsy6EpBLuaC4Rm2tyZqMwWAYGP6/TJ5HQ==');
define('NONCE_SALT',       '825No7g5xgQy7h6b0+rIQuuY1NqgicoMF3X8WuXBeIEujxI3W3UpK5lQ1yDXVhpbv+jxz9Na4CQQ22qs5a9gyg==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
