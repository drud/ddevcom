<?php

// site URL
if (getenv('DDEV_ENV_NAME') == 'production') {
    define('WP_HOME', 'https://www.drud.com');
} else {
    define('WP_HOME', ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']);
}

/** WP in Sub-directory */
// WP URL
define('WP_SITEURL', WP_HOME . '/wp');
// set WP ABSPATH
define('ABSPATH', getenv('NGINX_DOCROOT') . '/wp/');

/** Custom wp-content Directory */
// full local path of current directory (no trailing slash)
define('WP_CONTENT_DIR', getenv('NGINX_DOCROOT') . '/content');
// full URI of current directory (no trailing slash)
define('WP_CONTENT_URL', WP_HOME . '/content');

// placeholder for WP_ENV - force indexing
define('WP_ENV', 'production');

// force SSL for admin
define('FORCE_SSL_ADMIN', false);

// turn off debugging
define('WP_DEBUG', true);

// dis-allow file editing from the admin
define('DISALLOW_FILE_MODS', true);

/** Enable Cache by WP Rocket */
// define('WP_CACHE', false);
// define('WP_ROCKET_CACHE_ROOT_PATH', WP_CONTENT_DIR . '/uploads/cache/');
// define('WP_ROCKET_CACHE_ROOT_URL', WP_CONTENT_URL . '/uploads/cache/');
