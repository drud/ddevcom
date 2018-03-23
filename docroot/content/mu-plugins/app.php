<?php
/**
 * Load modules
 */
 require_once(dirname(__FILE__) . '/app/post-types/testimonial.php');
 require_once(dirname(__FILE__) . '/app/post-types/provider.php');
 require_once(dirname(__FILE__) . '/app/post-types/builder.php');
 require_once(dirname(__FILE__) . '/app/post-types/teacher.php');

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
