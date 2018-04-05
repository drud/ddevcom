<?php
/**
 * Load modules
 */
 require_once(dirname(__FILE__) . '/app/post-types/provider.php');
 require_once(dirname(__FILE__) . '/app/post-types/builder.php');
 require_once(dirname(__FILE__) . '/app/post-types/teacher.php');
 require_once(dirname(__FILE__) . '/app/post-types/job.php');
 require_once(dirname(__FILE__) . '/app/options/theme.php');
 require_once(dirname(__FILE__) . '/app/options/header.php');
 require_once(dirname(__FILE__) . '/app/options/footer.php');
 require_once(dirname(__FILE__) . '/app/options/newsletter.php');
 require_once(dirname(__FILE__) . '/app/options/company.php');
 require_once(dirname(__FILE__) . '/app/options/hosting-modal.php');

 require_once(dirname(__FILE__) . '/app/options/theme.php');
 require_once(dirname(__FILE__) . '/app/options/header.php');
 require_once(dirname(__FILE__) . '/app/options/footer.php');

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

add_filter('tribe_events_register_event_type_args', function($args){
  $args['has_archive'] = false;
  return $args;
});
