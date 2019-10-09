<?php
/**
 * Load modules
 */

 require_once dirname(__FILE__) . '/app/post-types/job.php';
 require_once dirname(__FILE__) . '/app/options/theme.php';
 require_once dirname(__FILE__) . '/app/options/header.php';
 require_once dirname(__FILE__) . '/app/options/footer.php';
 require_once dirname(__FILE__) . '/app/options/newsletter.php';
 require_once dirname(__FILE__) . '/app/options/company.php';
 require_once dirname(__FILE__) . '/app/options/hosting-modal.php';

/**
 * Place ACF JSON in field-groups directory
 */
add_filter(
    'acf/settings/save_json',
    function ($path) {
        return dirname(__FILE__) . '/app/field-groups';
    }
);

add_filter(
    'acf/settings/load_json',
    function ($paths) {
        unset($paths[0]);
        $paths[] = dirname(__FILE__) . '/app/field-groups';
        return $paths;
    }
);

add_filter(
    'tribe_events_register_event_type_args',
    function ($args) {
        $args['has_archive'] = false;
        return $args;
    }
);

// remove robots.txt creation
remove_filter('robots_txt', 'The_SEO_Framework\Init\robots_txt', 10, 2);


// fix admin issue with WYSIWYG and Cloudfront
// - https://wordpress.org/support/topic/visual-editor-not-showing-7/
add_filter(
    'user_can_richedit',
    function ($wp_rich_edit) {
        if (!$wp_rich_edit
            && (get_user_option('rich_editing') == 'true' || !is_user_logged_in())
            && isset($_SERVER[ 'HTTP_USER_AGENT' ])
            && stripos($_SERVER[ 'HTTP_USER_AGENT' ], 'amazon cloudfront') !== false
        ) {
            return true;
        }

        return $wp_rich_edit;
    }
);

add_filter(
    'gform_confirmation_anchor_3',
    function () {
        return true;
    }
);

add_filter(
    'gform_confirmation_anchor_4',
    function () {
        return true;
    }
);

add_filter(
    'gform_confirmation',
    function ($confirmation, $form, $entry, $ajax) {
        if ($form['id'] == '8' && isset($entry[5])) {
            $confirmation = array( 'redirect' => 'https://dash.ddev.com/?ticket=' . $entry[5] );
        }
        return $confirmation;
    },
    10, 4
);


add_action(
    'acf/init',
    function () {
        // check function exists
        if (function_exists('acf_register_block')) {

            // register a newsletter block
            acf_register_block(
                array(
                    'name'              => 'newsletter',
                    'title'             => __('newsletter'),
                    'description'       => __('A custom newsletter block.'),
                    'render_callback'   => 'DDEV_ACF_Block_render',
                    'category'          => 'formatting',
                    'icon'              => 'admin-comments',
                    'keywords'          => array( 'newsletter', 'signup' ),
                )
            );

            // register a jumbotron block
            acf_register_block(
                array(
                    'name'              => 'jumbotron',
                    'title'             => __('Jumbotron'),
                    'description'       => __('A custom jumbotron block.'),
                    'render_callback'   => 'DDEV_ACF_Block_render',
                    'category'          => 'formatting',
                    'icon'              => 'admin-comments',
                    'keywords'          => array( 'banner', 'jumbotron', 'header' ),
                )
            );

            // register a events banner block
            acf_register_block(
                array(
                    'name'              => 'events',
                    'title'             => __('Events Banner'),
                    'description'       => __('A custom events banner.'),
                    'render_callback'   => 'DDEV_ACF_Block_render',
                    'category'          => 'formatting',
                    'icon'              => 'admin-comments',
                    'keywords'          => array( 'banner', 'jumbotron', 'header' ),
                )
            );

            // register a custom Title w/ FontAwesome Icon
            acf_register_block(
                array(
                    'name'              => 'icontitle',
                    'title'             => __('DDEV Icon Title'),
                    'description'       => __('A custom Title w/ FontAwesome Icon.'),
                    'render_callback'   => 'DDEV_ACF_Block_render',
                    'category'          => 'formatting',
                    'icon'              => 'admin-comments',
                    'keywords'          => array( 'banner', 'jumbotron', 'header' ),
                )
            );

            // register One Platform block
            acf_register_block(
                array(
                    'name'              => 'oneplatform',
                    'title'             => __('DDEV One Platform'),
                    'description'       => __('A custom One Platform block.'),
                    'render_callback'   => 'DDEV_ACF_Block_render',
                    'category'          => 'formatting',
                    'icon'              => 'admin-comments',
                    'keywords'          => array( 'banner', 'jumbotron', 'header' ),
                )
            );

            // register Cloud Native block
            acf_register_block(
                array(
                    'name'              => 'cloudnative',
                    'title'             => __('DDEV Cloud Native'),
                    'description'       => __('A custom Cloud Native block.'),
                    'render_callback'   => 'DDEV_ACF_Block_render',
                    'category'          => 'formatting',
                    'icon'              => 'admin-comments',
                    'keywords'          => array( 'banner', 'jumbotron', 'header' ),
                )
            );

            // register Built & Guaranteed block
            acf_register_block(
                array(
                    'name'              => 'builtguaranteed',
                    'title'             => __('DDEV Built & Guaranteed'),
                    'description'       => __('A custom Built & Guaranteed block.'),
                    'render_callback'   => 'DDEV_ACF_Block_render',
                    'category'          => 'formatting',
                    'icon'              => 'admin-comments',
                    'keywords'          => array( 'banner', 'jumbotron', 'header' ),
                )
            );

            // register Built & Guaranteed block
            acf_register_block(
                array(
                    'name'              => 'supportedcms',
                    'title'             => __('DDEV Supported CMS'),
                    'description'       => __('A custom Supported CMS block.'),
                    'render_callback'   => 'DDEV_ACF_Block_render',
                    'category'          => 'formatting',
                    'icon'              => 'admin-comments',
                    'keywords'          => array( 'banner', 'jumbotron', 'header' ),
                )
            );
        }
    }
);


/*
 * Render the ACF Block
 */
function DDEV_ACF_Block_render($block)
{

    // convert name ("acf/testimonial") into path friendly slug ("testimonial")
    $slug = str_replace('acf/', '', $block['name']);

    // include a template part from within the "templates/block" folder
    if (file_exists(get_theme_file_path("/templates/block/content-{$slug}.php"))) {
        include get_theme_file_path("/templates/block/content-{$slug}.php");
    }
}
