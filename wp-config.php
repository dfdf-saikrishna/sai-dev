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
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'R yO#Em+0kd/}Py6>7 =k8Nu>!+o$Y%XGHW^]F}X(=+SyersL<[F>,>sx`gY^+=!');
define('SECURE_AUTH_KEY',  '7qTN3xX.@BN(wy^9^Q[P:F:O^jc5Lv!wt+$L.;Wxn.VWhB=wVBD@3L;y$d6uyLNN');
define('LOGGED_IN_KEY',    '[=Ktj+yg0$&-J7}:x%L/5,Jej0<|~=Q=_PoMKFBE<zi7!}(s0F5,[F^)^NUW=4f1');
define('NONCE_KEY',        'V1Jze=zockk6+w{R-hf2<+{y@*_%]-A&WjWqzP^{5cT!c>_:}U?zGsM^sfjlVA@O');
define('AUTH_SALT',        '|& QYv`Zzjts7Fwd2 h,CJygY9-: |R@^rk:p0;l^*m`VZy|P]`Jr@lSx%Kr}u2|');
define('SECURE_AUTH_SALT', 'obgvvY8yB/=b`Skqx7yIX)DZ%SS+wCVH0i>%Khkr[-5c}.-?d3~LX_995S:#yJ/+');
define('LOGGED_IN_SALT',   '+:WdcTa&7TNtvOaUDM~W^#Cq-`l3+&9LG+G;>f7.A)D_T+p~boAXR*~Ow}^h?)W2');
define('NONCE_SALT',       '-{458G.GQxCa+P0nu(.-p:S|*b&bcWs(J?}VyqPearXPUPoU}6axK.@!+N:qy)lJ');

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Initiating Session - By Sai Krishna */
if (!session_id())
    session_start();

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
