<?php

namespace App\PostTypes\Testimonial;

/**
 * Testimonial custom post type
 */
add_action('init', function () {
    register_post_type('testimonial', [
        'labels'              => [
            'name'               => 'Testimonials',
            'singular_name'      => 'Testimonial',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Testimonial',
            'edit_item'          => 'Edit Testimonial',
            'new_item'           => 'New Testimonial',
            'view_item'          => 'View Testimonial',
            'search_items'       => 'Search Testimonials',
            'not_found'          => 'No testimonials found',
            'not_found_in_trash' => 'No testimonials found in trash',
            'parent_item_colon'  => '',
            'menu_name'          => 'Testimonials'
        ],
        'public'              => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-star-filled',
        'query_var'           => true,
        'rewrite'             => ['slug' => 'testimonials'],
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => null,
        'supports'            => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields']
    ]);
});

/**
 * Testimonial taxonomies
 */
add_action('init', function () {
    register_taxonomy('testimonial_category', 'testimonial', [
        'label'         => 'Testimonial Category',
        'labels'        => [
            'name'              => 'Testimonial Categories',
            'singular_name'     => 'Testimonial Category',
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
