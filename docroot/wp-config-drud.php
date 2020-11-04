<?php
// site URL
$current_environment = getenv('CURRENT_ENVIRONMENT') ? getenv('CURRENT_ENVIRONMENT') : 'development';
$home_url = ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];

if('alpha' === $current_environment) {
    $home_url = 'https://www.ddev.com';
    var_dump($home_url);
    die;
}
define('WP_HOME', );

/** WP in Sub-directory */
// WP URL
define('WP_SITEURL', WP_HOME . '/wp');
// set WP ABSPATH
define('ABSPATH', getenv('DDEV_DOCROOT') . '/wp/');

/** Custom wp-content Directory */
// full local path of current directory (no trailing slash)
define('WP_CONTENT_DIR', getenv('DDEV_DOCROOT') . '/content');
// full URI of current directory (no trailing slash)
define('WP_CONTENT_URL', WP_HOME . '/content');

// placeholder for WP_ENV - force indexing
define('WP_ENV', 'production');

// force SSL for admin
define('FORCE_SSL_ADMIN', false);

// turn off debugging
define('WP_DEBUG', false);

// dis-allow file editing from the admin
define('DISALLOW_FILE_MODS', true);

/** Enable Cache by WP Rocket */
define('WP_CACHE', true);
define('WP_ROCKET_CACHE_ROOT_PATH', WP_CONTENT_DIR . '/uploads/cache/');
define('WP_ROCKET_CACHE_ROOT_URL', WP_CONTENT_URL . '/uploads/cache/');
