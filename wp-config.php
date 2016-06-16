<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

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
define('DB_NAME', 'loimp_hdrguide'); // hdrguide_com

/** MySQL database username */
define('DB_USER', 'loimp_max'); // hdrguide_max

/** MySQL database password */
define('DB_PASSWORD', 'z2A4dTzwMUeA'); // hdr-2ev0+2ev

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
define('AUTH_KEY',         'Aw=i{!E-Uu#PC3+ug&4-;4V{,SJJTa-hCUIY0DUYHH+8B/rao mroKw]~QNO0z&:');
define('SECURE_AUTH_KEY',  ',yGuTQV2u&,RO^cM$Iu0P)hM{Zf]#khwg[[XHfWHGSkWCCv7+CY*7ft}Tf`Fm|(C');
define('LOGGED_IN_KEY',    '0`qD^$4RI4y~(/0&7hI jE+`d(+v(d7e,m@UYV8P+G4_nJrO*Etf~{cnYGm-zB})');
define('NONCE_KEY',        'doY[**?wu5n9CXX,-;0DkZb _1D%Y/Zoj{]/!_`Gy<mYrpDr|sAq` ncFs%t/@sm');
define('AUTH_SALT',        'xsT*q^[{X&cY)M(WskrE/+o$YO-/Q=H]#W]pP&QO/IX3|63k_qiH,+FJ2KX9Rk=-');
define('SECURE_AUTH_SALT', '`Z:J(0;-?C|;wJT|51oB+C@%ok 5jm-q|FNKT+HRK@o4`al!9HEPi,.+7ya?]kco');
define('LOGGED_IN_SALT',   'Gc3V;~]rS{%<JhKNSQrz&{]N=8kA,~dF0}@GKAW=zMsc%b%5+<oe%YoT +/8$~HW');
define('NONCE_SALT',       '!DdHZ3dIr5){)RjVLi#:_p-nvr:jTMTR77TfNWmYHE%]f.Hx|N!gV!<)a&IpeRQ$');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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
