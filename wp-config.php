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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '? XLZaj[^FR,V%@At]?=ObfXg-,H~5U{F^+<QscYL,bRu{+8#&<aHyYfH7@oE#tG');
define('SECURE_AUTH_KEY',  'sPj9awCOIL![y(h6,*.z:d0GZ(pjZm*NL!q#:x#es&z)SXgxJiYD_!XVVm?grN)e');
define('LOGGED_IN_KEY',    '@ dh[:Lxe:f%mpz9z:nF^wf5i+NJskLR;30Y&G(u_:}6I(6s(q/ 4TlX-f?w#sk~');
define('NONCE_KEY',        'eRtR:@at GJTd 3F!+4nnFbYHx;`2[#}`%`[[fa_C}18*;yDa:-,UHBd ePL[>s9');
define('AUTH_SALT',        '|4@&ajLYrY$dTB%H$ OC@}O1]j&NNO}MZ>{]V+i[P)Xgw~rO%4YiY7~%k Sf,!#h');
define('SECURE_AUTH_SALT', ')|i|=*OSn[xUOY>E{T+A cP11?B7*<qK$.aWF5 FzL,h}kSvF|o!+W={Rd#e^/ k');
define('LOGGED_IN_SALT',   '@bNO|K 8f*JM{{}075puQ5D>!~gEW0Qb+V6qT8jW.Bga7+eoXcjQsn>da2kZ-lRr');
define('NONCE_SALT',       'I&.JB]%m^oe_,#[nga=yG9[9KJh7?SCDLSqQM(dH9>#9km=[u!]dB_~`lMYIF4-y');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
