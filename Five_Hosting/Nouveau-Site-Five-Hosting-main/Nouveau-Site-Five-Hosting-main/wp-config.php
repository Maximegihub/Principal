<?php
define('WP_CACHE', true); // WP-Optimize Cache
 // WP-Optimize Cache
define('FS_METHOD', 'direct');
define('FORCE_SSL_ADMIN', true);
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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'dbs4787357' );
/** MySQL database username */
define( 'DB_USER', 'dbu2645977' );
/** MySQL database password */
define( 'DB_PASSWORD', 'dQvAzHLJTlSabtXmZuZy' );
/** MySQL hostname */
define( 'DB_HOST', 'db5005687033.hosting-data.io' );
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
define( 'AUTH_KEY',          'ItJwwujkd/jtvb:G{$+/GvW89Vk2?9r@,Sz`)7(ynu5k08xkcS4I72q3up4P,6R/' );
define( 'SECURE_AUTH_KEY',   'L5{hQXs|las[`C;o:J+]4Bx|tYyj0-RS*Vj3F[1fNf(LIcqgY8E<a?fodB{KKm,$' );
define( 'LOGGED_IN_KEY',     'AAfm^n5}IHfPn@>qxYZSgG#iT7|iAhW}*;8h/~C5m9x6Jwxm>.G$Ug:%{}GB.OhO' );
define( 'NONCE_KEY',         'N.Bg}Y0t(wrbhD`-yUIL%AcRHxCa}(1sfC~pjJE41`[)asRtc^:U2RsV3ktJ>ac!' );
define( 'AUTH_SALT',         '-~&J0c1F9(_V}3*Xy(clQ//${ras`~f_q$qsUX=je^?zC|l|MZ]A,Idv:!pEcq*E' );
define( 'SECURE_AUTH_SALT',  '2jCbjKM4 WUyrxw.}iA):S</cHF5$0-rk-{b+Af6#4+1gK1w1zDrCM$j/%zi/;ya' );
define( 'LOGGED_IN_SALT',    'bB8I8YQK?P0lQR=Q%61Qg)jIU2_taRje&cfi3Q2HB]tChbTbHM:-ngN `xG(7_!S' );
define( 'NONCE_SALT',        '6w$LV{<=k(K|WOglkyVg3>B{bNI@H$lF>sw:fEs1 6}ExmP+^q`6Syd:{nSVPcD*' );
define( 'WP_CACHE_KEY_SALT', 'tv2u8aYnm>#Km>q:Ha=+iKdEHgt%a9`M5kIj@qq<hdFFX<D_M=WAFRpUR_PKt0~c' );
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'rNMlfiWZ';
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';