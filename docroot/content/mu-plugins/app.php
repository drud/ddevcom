<?php
/**
 * Load modules
 */
// require_once(dirname(__FILE__) . '/app/post-types/testimonial.php');

/**
 * Place ACF JSON in field-groups directory
 */
add_filter('acf/settings/save_json', function($path) {
    return dirname(__FILE__) . '/app/field-groups';
});
add_filter('acf/settings/load_json', function($paths) {
    unset($paths[0]);
    $paths[] = dirname(__FILE__) . '/app/field-groups';
    return $paths;
});
