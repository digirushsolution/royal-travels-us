<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u997496973_royaltravelsus' );

/** Database username */
define( 'DB_USER', 'u997496973_digi_solution' );

/** Database password */
define( 'DB_PASSWORD', 'GN!|bTtF0?t' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         '2FKR5%h!zasE_yj0e+d?ZC}kn}!=K1QvQ*e6?wO:&g LR4;SofgjhxyF`Q%{V#bI' );
define( 'SECURE_AUTH_KEY',  'H50j}zE*PhP9m;+;,j1D,gw#~}NHxu<?-Z(.HqX}-WS+ak&W*27*NH-`nZ{~kzY ' );
define( 'LOGGED_IN_KEY',    'b8|>x.+wGqYr%CflQL@8c0@O5As yPs#@V1},]{ZoS^#FDOPF8+^oAXH/(^AoS(@' );
define( 'NONCE_KEY',        'yvZd^7Vt/<w[fg:A7%Fr@pX[N!]9_ds2bW|!E1Z%IuG{ZFn#gt876^VD~u!cc&4?' );
define( 'AUTH_SALT',        'Smy]nWGeIY%RF(cl,=(qOHOGT~&,Q&>/[*Rc2;=0br#ut}19t)ZW~i|zpG/y5dgL' );
define( 'SECURE_AUTH_SALT', 'At7Y&T5#>V2sFv62&ntZx<_#z.=ZDC|7@nzJ]^kQ[OfRO<T{,nG#zqgivW;{,&`c' );
define( 'LOGGED_IN_SALT',   ':i6tJO_iM!>|+n$!hr.M(V|`[oHv$j5SV#Uepd7qy}TqQ;8U^w#CL;8fz S4y.c ' );
define( 'NONCE_SALT',       'Xqa()b/DgcmgE qG}[dVV3X!?1Xz})07}y2.0676aTqyvM5KR%8j_k`q{!(Qhl&i' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
