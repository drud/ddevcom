<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;

/**
 * Add <body> classes
 */
function body_class($classes)
{
    // Add page slug if it doesn't exist
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    // Add class if sidebar is active
    if (Setup\display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more()
{
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('twitter-js-widgets', 'https://platform.twitter.com/widgets.js');
}, 100);

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function content_image_sizes_attr($sizes, $size, $image_src, $image_meta)
{
    $width = $size[0];

    840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

    if (is_front_page()) {
        840 <= $width && $sizes = '(max-width: 575px) 95vw, (max-width: 909px) 27vw, (max-width: 1362px) 30vw, 575px';
        840 > $width && $sizes = '(max-width: ' . $width . 'px) 30vw, ' . $width . 'px';
    } elseif ('page' === get_post_type()) {
        840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
    } else {
        840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
        600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
    }

    return $sizes;
}
add_filter('wp_calculate_image_sizes', __NAMESPACE__ . '\\content_image_sizes_attr', 10, 4);
