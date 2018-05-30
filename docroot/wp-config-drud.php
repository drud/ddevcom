<?php

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
