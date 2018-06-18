<?php

// site URL
if (getenv('DDEV_ENV_NAME') == 'production') {
    define('WP_HOME', 'https://www.drud.com');
} else {
    define('WP_HOME', ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']);
}

// WP URL
define('WP_SITEURL', WP_HOME . '/wp');

// full local path of current directory (no trailing slash)
define('WP_CONTENT_DIR', getenv('NGINX_DOCROOT') . '/content');

// full URI of current directory (no trailing slash)
define('WP_CONTENT_URL', WP_HOME . '/content');

// force SSL for admin
define('FORCE_SSL_ADMIN', true);

define('WP_DEBUG', false);
define('DISALLOW_FILE_MODS', true);

// placeholder for WP_ENV - force indexing
define('WP_ENV', getenv('DDEV_ENV_NAME') ? getenv('DDEV_ENV_NAME') : 'production');

define('ABSPATH', getenv('NGINX_DOCROOT') . '/wp/');
