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

define("FS_METHOD", "direct");

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'tinseau' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '06112001..Arthur' );

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
define( 'AUTH_KEY',          'cV4ayq,0ART{1^;iL}_taw10,Xx)x}HHZKw1^d)%pVY{u.KJI`m0ZkN;3s[!D?y]' );
define( 'SECURE_AUTH_KEY',   'qTt|J, pa-Tvt5Z.HdM:C!~5P<:TcCD|LDuY4UG}-sw~ |rf5+.?;+Mh*Dq4n[~T' );
define( 'LOGGED_IN_KEY',     'p`I7)5J|z!LluBt`cwn+qhZ_}f+ChQ0//N%T]+i/!c[J]2:)JwSf/^0hj,IpV&Mv' );
define( 'NONCE_KEY',         '~anu%s_&678BgD;Nf1,&V<Xp@Zd3Rh &By+%?h)^=wc-a4*N|rL5aPJk2*C.4K`)' );
define( 'AUTH_SALT',         'Hzo;:dQo+,79z_?Fg%U%Sn&r*9W*33}pcv,s*1f[>Og1Za_f4kgSMSH~-gAD?O-@' );
define( 'SECURE_AUTH_SALT',  'jw0<M2cI&#9Jix.E2N_w{@Z4lW4X@q_]G1C@|^9PS{w=K>%B[VoH7y}wGu8ju%a$' );
define( 'LOGGED_IN_SALT',    'gX(Da>}~sK|lQW^`X|7(0Cc-jTxC59a@1--%zBUVy!`SEu1k~B(U`DL(#LBl?2)&' );
define( 'NONCE_SALT',        'e=O9zmM2e5|z}46joUP%{ztmZow)_lJ?=A2_ZAt06,$ObnVbb{t]sBF}^TMRzPQU' );
define( 'WP_CACHE_KEY_SALT', '7R_j~q`s_TFNQy%.GUBR3z<mcc~<zD&X3=qIY#A];[;p{_5y 27Bc,7EslF%I1%f' );

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
