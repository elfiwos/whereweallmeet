<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wwamblog');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'rb2p3c8tk3wqqntc');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '{CZ;@5&P!T8^uc>e+_]/pBkPEloG TtHfeBZs>GhDb4M_eg_+Ui{&`jw}T,XGyYu');
define('SECURE_AUTH_KEY',  'Y:88*Wq|}+r!{xq2:upWP`FMr,ji-`oo#(Arw>a`um+c82mJ*TJUQ^EJ> _VI6%F');
define('LOGGED_IN_KEY',    'PrgR%}kSC:hsFEy79_xTK]#NNCa=gg^]o-8*v,e_#$sc(Al|rCyGc<U85kcs!R;}');
define('NONCE_KEY',        '`)gZ)(0m}]8c;@. 9Q2$nD}mt=-o~O%cRp5B?^KYXZ89m&SG`-J}{YBnxud-]gU7');
define('AUTH_SALT',        '|jT7&1<iIvK+oiHr-3[hm$Ps?(X?jzQ?L~Fe$vc~@^X,EIqB^]Uui(=|v!mCGLIR');
define('SECURE_AUTH_SALT', 'C3;;(FhbSYmz5I_Gvxe6$vg%D7E&=^5N(Z+(]JA#=9 B7L_4jw+,oDeTaiK6_)e+');
define('LOGGED_IN_SALT',   'rcxVdwf,/q{G4}$.pSV;h+2<w-]->kv*F`N^IK[TnyenwOvUSW~94Rf)2g698Da5');
define('NONCE_SALT',       'xlCbKz)$F,jamI-8/$QY%]O!{PO?TPGtLtWTytedla0S9nTvVlD||y+{0lDnF*yi');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
