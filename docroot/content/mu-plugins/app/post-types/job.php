<?php

namespace App\PostTypes\Job;

/**
 * Testimonial custom post type
 */
add_action('init', function () {
    register_post_type('job', [
        'labels'              => [
            'name'               => 'Jobs',
            'singular_name'      => 'Job',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Job',
            'edit_item'          => 'Edit Job',
            'new_item'           => 'New Job',
            'view_item'          => 'View Job',
            'search_items'       => 'Search Jobs',
            'not_found'          => 'No jobs found',
            'not_found_in_trash' => 'No jobs found in trash',
            'parent_item_colon'  => '',
            'menu_name'          => 'Jobs'
        ],
        'public'              => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-star-filled',
        'query_var'           => true,
        'rewrite'             => ['slug' => 'jobs'],
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
    register_taxonomy('job_category', 'testimonial', [
        'label'         => 'Job Category',
        'labels'        => [
            'name'              => 'Job Categories',
            'singular_name'     => 'Job Category',
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
