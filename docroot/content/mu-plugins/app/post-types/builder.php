<?php

namespace App\PostTypes\Builder;

/**
 * Builder custom post type
 */
add_action('init', function () {
    register_post_type('builder', [
        'labels'              => [
            'name'               => 'Builders',
            'singular_name'      => 'Builder',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Builder',
            'edit_item'          => 'Edit Builder',
            'new_item'           => 'New Builder',
            'view_item'          => 'View Builder',
            'search_items'       => 'Search Builders',
            'not_found'          => 'No builders found',
            'not_found_in_trash' => 'No builders found in trash',
            'parent_item_colon'  => '',
            'menu_name'          => 'Builders'
        ],
        'public'              => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-star-filled',
        'query_var'           => true,
        'rewrite'             => ['slug' => 'ddev-builders'],
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
    register_taxonomy('builder_category', 'builder', [
        'label'         => 'Builder Category',
        'labels'        => [
            'name'              => 'Builder Categories',
            'singular_name'     => 'Builder Category',
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
