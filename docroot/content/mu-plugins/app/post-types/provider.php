<?php

namespace App\PostTypes\Provider;

/**
 * Provider custom post type
 */
add_action('init', function () {
    register_post_type('provider', [
        'labels'              => [
            'name'               => 'Providers',
            'singular_name'      => 'Provider',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Provider',
            'edit_item'          => 'Edit Provider',
            'new_item'           => 'New Provider',
            'view_item'          => 'View Provider',
            'search_items'       => 'Search Providers',
            'not_found'          => 'No providers found',
            'not_found_in_trash' => 'No providers found in trash',
            'parent_item_colon'  => '',
            'menu_name'          => 'Providers'
        ],
        'public'              => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-star-filled',
        'query_var'           => true,
        'rewrite'             => ['slug' => 'ddev-providers'],
        'capability_type'     => 'post',
        'has_archive'         => false,
        'hierarchical'        => false,
        'menu_position'       => null,
        'supports'            => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields']
    ]);
});

/**
 * Testimonial taxonomies
 */
add_action('init', function () {
    register_taxonomy('provider_category', 'provider', [
        'label'         => 'Provider Category',
        'labels'        => [
            'name'              => 'Provider Categories',
            'singular_name'     => 'Provider Category',
            'all_items'         => 'All Categories',
            'edit_item'         => 'Edit Category',
            'view_item'         => 'View Category',
            'update_item'       => 'Update Category',
            'add_new_item'      => 'Add New Category',
            'new_item_name'     => 'New Category Name',
            'search_items'      => 'Search Categories'
        ],
        'hierarchical'  => true
    ]);
});
