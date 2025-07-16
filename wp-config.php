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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', "gv" );

/** Database username */
define( 'DB_USER', "root" );

/** Database password */
define( 'DB_PASSWORD', "" );

/** Database hostname */
define( 'DB_HOST', "localhost" );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'e.>$lKcKf( 8d^!`%km6w9A$rdZ_9!yh86(T*C[z}lk/_[=<QxAaxp4WZkZ-F)J/' );
define( 'SECURE_AUTH_KEY',   '00E/2SS rUFp$0TaLA_(!Rp}Wh`8e$z<621((44_|KMBdmd3yYs<Vy(^$aQ(tf]x' );
define( 'LOGGED_IN_KEY',     '*THw-zD3%l3[l|38(mSj*fGm.J.~-3gHF[qTNdbwCC6*]eU0WFl6Bs?{.V`X`whB' );
define( 'NONCE_KEY',         '~ C3bTZ2)-]J,pMI5h>QFj:kO6_J?f5{[T<xK?0A[](jodUE5]wo!!4BVIWR3MSl' );
define( 'AUTH_SALT',         'L)(*,6SDubi]E?JKRQiT1&@SeY6_ib#(jm37C(2,):|(a,+Un#(ZgA3;*fe5[64^' );
define( 'SECURE_AUTH_SALT',  '.:1`P?u{gb C_^V&!r{QR2:Vx&o*<BdR0t)oNW3E4r?;b9MoN@`FT#cQzQ.{&ZK7' );
define( 'LOGGED_IN_SALT',    'LAB<_uc2CE+LXH.2PsMHuoz2yE$O&8S.ZiV6_Ro[c`C==_:b=}8vQ[4PE~FJ_G6R' );
define( 'NONCE_SALT',        'iJVo.beI~Xu?Fp_exIv4@/vi-G60!L`OqcPuv+rU<0-Y:xNVMJYkg#Sw+gE*kE9W' );
define( 'WP_CACHE_KEY_SALT', 'Jl]I$/CbzYM]@p;_kX?uTWWve[8igzYVn(9`:h(ydQT;juX,D?Y}*+CF<ss7~V- ' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );

define( 'FS_METHOD', 'direct' );
define( 'COOKIEHASH', 'e3c65f0eef6344ebbcedeb8d3ee47419' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

define( 'WP_HOME', 'https://af389891a3b0.ngrok-free.app/gv' );
define( 'WP_SITEURL', 'https://af389891a3b0.ngrok-free.app/gv' );

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
