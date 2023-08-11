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
define( 'DB_NAME', 'brian_sharing' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         ']UVkMFyn}{t9?z0ww>98A @15y}QG8H4ZO(^UY^WKh9#EW[AH8C0bAx%w/0CzBTU' );
define( 'SECURE_AUTH_KEY',  'b-!nU/::t$J[y5}^,|N/lv)*H#LN@IQll5xzgD?_=W,mWBJG2,O()}DB;L:rF%>W' );
define( 'LOGGED_IN_KEY',    '[ut0<:sfaFs{K&@W`LEh]Z$&c>CzI-FE]8;eV<D]#3Gvq(<A@?Xf*RV-R]YN~ZF6' );
define( 'NONCE_KEY',        '@7;Dxm%=F=LyG,{uB][,I_4](yO#y6nc0qlvBP@!YrO&L$K1| !>/X+:w}:u-7l>' );
define( 'AUTH_SALT',        '`Ul=&c8iH$py.te-LdM+tF#9W@j:FK1xEx1*OdM]EXZ#Dh~>ED,s*TQ]E@AA&U7P' );
define( 'SECURE_AUTH_SALT', '{DE6EZDus|SoXl##zsW>IX=M.(*!&%Al+zfZPr9:SV`0y9W1, JJY..L<?ZX2:V|' );
define( 'LOGGED_IN_SALT',   'tc.*f#q8frK>`>!kZ}IX5W^SP+a;,yq?}CJZZ48TMQ$t9|E?$WM$&54lFVx^tG+@' );
define( 'NONCE_SALT',       'S=1:SCbz>SwCMl~0*!as=OjBj%NQJd.Eud/(Av*2}?&Kp,2&[BfBCFYj6%xmB+,U' );

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
