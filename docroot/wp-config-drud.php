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
define('WP_ENV', getenv('DDEV_ENV_NAME') ? getenv('DDEV_ENV_NAME') : 'production');

// force SSL for admin
define('FORCE_SSL_ADMIN', false);

// turn off debugging
define('WP_DEBUG', true);

// dis-allow file editing from the admin
define('DISALLOW_FILE_MODS', true);

/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache
define('W3TC_CACHE_DIR', WP_CONTENT_DIR .  '/uploads/cache');
define('W3TC_CONFIG_DIR', WP_CONTENT_DIR .  '/uploads/w3tc-config');
