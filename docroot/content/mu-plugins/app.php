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
add_filter('acf/settings/save_json', function ($path) {
    return dirname(__FILE__) . '/app/field-groups';
});
add_filter('acf/settings/load_json', function ($paths) {
    unset($paths[0]);
    $paths[] = dirname(__FILE__) . '/app/field-groups';
    return $paths;
});

add_filter('tribe_events_register_event_type_args', function ($args) {
    $args['has_archive'] = false;
    return $args;
});

// remove robots.txt creation
remove_filter('robots_txt', 'The_SEO_Framework\Init\robots_txt', 10, 2);


// fix admin issue with WYSIWYG and Cloudfront
// - https://wordpress.org/support/topic/visual-editor-not-showing-7/
add_filter('user_can_richedit', function ($wp_rich_edit) {
    if (!$wp_rich_edit
         && (get_user_option('rich_editing') == 'true' || !is_user_logged_in())
         && isset($_SERVER[ 'HTTP_USER_AGENT' ])
         && stripos($_SERVER[ 'HTTP_USER_AGENT' ], 'amazon cloudfront') !== false
    ) {
        return true;
    }

    return $wp_rich_edit;
});

add_filter('gform_confirmation_anchor_4', function () {
    return true;
});
