<?php

namespace App\PostTypes\Event;

add_action( 'init', function() {
  $labels = array(
    'name'                  => _x( 'Events', 'Post type general name', 'textdomain' ),
    'singular_name'         => _x( 'Event', 'Post type singular name', 'textdomain' ),
    'menu_name'             => _x( 'Events', 'Admin Menu text', 'textdomain' ),
    'name_admin_bar'        => _x( 'Event', 'Add New on Toolbar', 'textdomain' ),
    'add_new'               => __( 'Add New', 'textdomain' ),
    'add_new_item'          => __( 'Add New Event', 'textdomain' ),
    'new_item'              => __( 'New Event', 'textdomain' ),
    'edit_item'             => __( 'Edit Event', 'textdomain' ),
    'view_item'             => __( 'View Event', 'textdomain' ),
    'all_items'             => __( 'All Events', 'textdomain' ),
    'search_items'          => __( 'Search Events', 'textdomain' ),
    'parent_item_colon'     => __( 'Parent Events:', 'textdomain' ),
    'not_found'             => __( 'No events found.', 'textdomain' ),
    'not_found_in_trash'    => __( 'No events found in Trash.', 'textdomain' ),
    'featured_image'        => _x( 'Event Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
    'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
    'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
    'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
    'archives'              => _x( 'Event archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
    'insert_into_item'      => _x( 'Insert into event', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
    'uploaded_to_this_item' => _x( 'Uploaded to this event', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
    'filter_items_list'     => _x( 'Filter events list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
    'items_list_navigation' => _x( 'Events list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
    'items_list'            => _x( 'Events list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
);

$args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'event' ),
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
);

register_post_type( 'event', $args );
});

/**
 * Event taxonomies
 */
add_action('init', function () {
    register_taxonomy('event_category', 'event', [
        'label'         => 'Event Category',
        'labels'        => [
            'name'              => 'Event Categories',
            'singular_name'     => 'Event Category',
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