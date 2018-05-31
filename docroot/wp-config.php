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

define('AUTH_KEY', getenv('WPAUTHKEY'));
define('SECURE_AUTH_KEY', getenv('WPSECUREAUTHKEY'));
define('LOGGED_IN_KEY', getenv('WPLOGGEDINKEY'));
define('NONCE_KEY', getenv('WPNONCEKEY'));
define('AUTH_SALT', getenv('WPAUTHSALT'));
define('SECURE_AUTH_SALT', getenv('WPSECUREAUTHSALT'));
define('LOGGED_IN_SALT', getenv('WPLOGGEDINSALT'));
define('NONCE_SALT', getenv('WPNONCESALT'));

$table_prefix  = 'wp_';

// site URL
define('WP_HOME', ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']);

// WP URL
define('WP_SITEURL', WP_HOME . '/wp');

// full local path of current directory (no trailing slash)
define('WP_CONTENT_DIR', getcwd() . '/content');

// full URI of current directory (no trailing slash)
define('WP_CONTENT_URL', '/content');

// unforce SSL for admin
define('FORCE_SSL_ADMIN', false);

define('WP_DEBUG', false);
define('DISALLOW_FILE_MODS', true);


if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/wp/');
}

require_once(ABSPATH . 'wp-settings.php');
