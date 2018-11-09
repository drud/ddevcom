<?php
defined('ABSPATH') || die('Cheatin&#8217; uh?');

define('WP_ROCKET_ADVANCED_CACHE', true);
$rocket_cache_path  = '/var/www/html/docroot/content/uploads/cache/wp-rocket/';
$rocket_config_path = '/var/www/html/docroot/content/uploads/wp-rocket-config/';

if (file_exists('/var/www/html/docroot/content/plugins/wp-rocket/inc/front/process.php') && version_compare(phpversion(), '5.4') >= 0) {
    spl_autoload_register(function ($class) {
        $rocket_path    = '/var/www/html/docroot/content/plugins/wp-rocket/';
        $rocket_classes = [
            'WP_Rocket\\Logger\\Logger'         => $rocket_path . 'inc/classes/logger/class-logger.php',
            'WP_Rocket\\Logger\\HTML_Formatter' => $rocket_path . 'inc/classes/logger/class-html-formatter.php',
            'WP_Rocket\\Logger\\Stream_Handler' => $rocket_path . 'inc/classes/logger/class-stream-handler.php',
        ];

        if (isset($rocket_classes[ $class ])) {
            $file = $rocket_classes[ $class ];
        } elseif (strpos($class, 'Monolog\\') === 0) {
            $file = $rocket_path . 'vendor/monolog/monolog/src/' . str_replace('\\', '/', $class) . '.php';
        } elseif (strpos($class, 'Psr\\Log\\') === 0) {
            $file = $rocket_path . 'vendor/psr/log/' . str_replace('\\', '/', $class) . '.php';
        } else {
            return;
        }

        if (file_exists($file)) {
            require $file;
        }
    });

    include '/var/www/html/docroot/content/plugins/wp-rocket/inc/front/process.php';
} else {
    define('WP_ROCKET_ADVANCED_CACHE_PROBLEM', true);
}
