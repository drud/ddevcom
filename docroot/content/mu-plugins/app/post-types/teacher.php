<?php

namespace App\PostTypes\Teacher;

/**
 * Teacher custom post type
 */
add_action('init', function () {
    register_post_type('teacher', [
        'labels'              => [
            'name'               => 'Teachers',
            'singular_name'      => 'Teacher',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Teacher',
            'edit_item'          => 'Edit Teacher',
            'new_item'           => 'New Teacher',
            'view_item'          => 'View Teacher',
            'search_items'       => 'Search Teachers',
            'not_found'          => 'No teachers found',
            'not_found_in_trash' => 'No teachers found in trash',
            'parent_item_colon'  => '',
            'menu_name'          => 'Teachers'
        ],
        'public'              => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-star-filled',
        'query_var'           => true,
        'rewrite'             => ['slug' => 'ddev-teachers'],
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
    register_taxonomy('teacher_category', 'teacher', [
        'label'         => 'Teacher Category',
        'labels'        => [
            'name'              => 'Teacher Categories',
            'singular_name'     => 'Teacher Category',
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
