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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpressjeff' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'MC.GMW6%-4@Arp|bZyp+-Lp>>ba?K]oVb(2HTCVuLhXm9AC,zUyeq1sptBgAnZNK' );
define( 'SECURE_AUTH_KEY',  '@bMo$=M3ZR|dH[w!F@vIS:~c7ZPt&R~/`Hp$y?;&.J:zI^|ld.RY*|RJGnMKNJi5' );
define( 'LOGGED_IN_KEY',    '~w0=jECYeD91^v!`o ./ KjUud@hC{.O^0NaR)~Bh}wf0#}8,.dhF2+0qgpG0JU{' );
define( 'NONCE_KEY',        'JW@k#P1eKDhnPBzq.TnsSKN#-l_q`#D9|.TOd0(8?w.@+0-g&GR`j2DcZ#|B(bn6' );
define( 'AUTH_SALT',        'e~Xb#C4R4VGdZPxY(oK5vL4JR~QC-WDS[dT 7N389b&AUc[.!MpmBb VVF1l}x-P' );
define( 'SECURE_AUTH_SALT', 'vt#a/(#xZHtpi>P;d,29KBUp?{SR,=i_$Fe~2>Ua4czrlYyeqR@yN8#[.e(%aqyH' );
define( 'LOGGED_IN_SALT',   'ToJ~}kM]#cvzC`?%YHP4Wf=]ESG}(j@/x/i/4a6zr6e&5 g[o;<9>r>35jw+r=`Q' );
define( 'NONCE_SALT',       'mHH1&Q#p_n>Y0a?DR-c05KdQq>#Se^uX<gBjGpH;~~~k}+70Q?8Of=&BiM]sf Ii' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
