<?php

$custom_settings = dirname(__FILE__) . '/wp-config-drud.php';
if (file_exists($custom_settings)) {
    require_once($custom_settings);
}

define('DB_NAME', getenv('DB_NAME'));

define('DB_USER', getenv('DB_USER'));

define('DB_PASSWORD', getenv('DB_PASS'));

define('DB_HOST', getenv('DB_HOST'));

define('DB_CHARSET', 'utf8');

define('DB_COLLATE', '');

// define('AUTH_KEY', getenv('WPAUTHKEY'));
// define('SECURE_AUTH_KEY', getenv('WPSECUREAUTHKEY'));
// define('LOGGED_IN_KEY', getenv('WPLOGGEDINKEY'));
// define('NONCE_KEY', getenv('WPNONCEKEY'));

define('AUTH_KEY', 'jE|Jl3pjPG+9~sUy;<n*$#zjKjniWS{PH)L34@@|[EBrt`SSk0GH^M&=?H>ba2qt');
define('SECURE_AUTH_KEY', 'b;:s]q%hS2sfTxY;yDD^]qH*@x9-<p&,r+!1Jrh[FFXHo,/:!vf8WrRo<zd52Rn3');
define('LOGGED_IN_KEY', 'I=VWWODrr( D3r/R$Z|2m/shWNd+aEIX{5 -7M<Zy62%CO2JSdT+l-M[DDFdq*}=');
define('NONCE_KEY', 'A|ex+.V> ]1/z37wj:}$UpZ<+J4~C{svp}xYTZ^VX>GOqgIG8XKRJ>{?h+}DDGVL');


define('AUTH_SALT', getenv('WPAUTHSALT'));
define('SECURE_AUTH_SALT', getenv('WPSECUREAUTHSALT'));
define('LOGGED_IN_SALT', getenv('WPLOGGEDINSALT'));
define('NONCE_SALT', getenv('WPNONCESALT'));

$table_prefix  = 'wp_';

// site URL
define('WP_HOME', 'https://www.drud.com');

// WP URL
define('WP_SITEURL', WP_HOME . '/wp');

// full local path of current directory (no trailing slash)
define('WP_CONTENT_DIR', getcwd() . '/content');

// full URI of current directory (no trailing slash)
define('WP_CONTENT_URL', WP_HOME . '/content');


define('WP_DEBUG', false);
define('DISALLOW_FILE_MODS', true);


if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/wp/');
}

require_once(ABSPATH . 'wp-settings.php');
