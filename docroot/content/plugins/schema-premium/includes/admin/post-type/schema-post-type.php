<?php
/**
 * Schema Custom Post Type 
 *
 * @package     Schema
 * @subpackage  Schema Custom Post Type
 * @copyright   Copyright (c) 2018, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
 
add_action( 'init', 'schema_wp_cpt_init' );
/**
 * Register Schema post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 * @since 1.0.0
 */
function schema_wp_cpt_init() {
	$labels = array(
		'name'               => _x( 'Schema', 'post type general name', 'schema-premium' ),
		'singular_name'      => _x( 'Schema', 'post type singular name', 'schema-premium' ),
		'menu_name'          => _x( 'Schema', 'admin menu', 'schema-premium' ),
		'name_admin_bar'     => _x( 'Schema', 'add new on admin bar', 'schema-premium' ),
		'add_new'            => _x( 'Add New', 'schema', 'schema-premium' ),
		'add_new_item'       => __( 'Add New Schema', 'schema-premium' ),
		'new_item'           => __( 'New Schema', 'schema-premium' ),
		'edit_item'          => __( 'Edit Schema', 'schema-premium' ),
		'view_item'          => __( 'View Schema', 'schema-premium' ),
		'all_items'          => __( 'All Schemas', 'schema-premium' ),
		'search_items'       => __( 'Search Schemas', 'schema-premium' ),
		'parent_item_colon'  => __( 'Parent Schemas:', 'schema-premium' ),
		'not_found'          => __( 'No schema found.', 'schema-premium' ),
		'not_found_in_trash' => __( 'No schema found in Trash.', 'schema-premium' )
	);

	$args = array(
		'labels'             	=> $labels,
        'description'        	=> __( 'Description.', 'schema-premium' ),
		'public'             	=> true,
		'publicly_queryable' 	=> false,
		'show_ui'            	=> true,
		'show_in_menu'       	=> false,
		'show_in_nav_menus'  	=> false,
		'show_in_admin_bar'  	=> false,
		'query_var'         	=> true,
		//'rewrite'				=> array( 'slug' => 'schema' ),
		'rewrite'            	=> false,
		'capability_type'    	=> 'post',
		'map_meta_cap'       	=> true, // Set to false, if users are not allowed to edit/delete existing schema
		'has_archive'        	=> false,
		'can_export'		 	=> true,
		'hierarchical'       	=> false,
		'exclude_from_search'	=> true,
		'menu_position'     	=> null,
		'taxonomies'			=> array(),
		'supports' 				=> array( 'title' )
	);

	register_post_type( 'schema', $args );
}


add_filter( 'post_updated_messages', 'schema_wp_cpt_updated_messages' );
/**
 * Book update messages.
 *
 * See /wp-admin/edit-form-advanced.php
 *
 * @param array $messages Existing post update messages.
 *
 * @return array Amended post update messages with new CPT update messages.
 * @since 1.0.0
 */
function schema_wp_cpt_updated_messages( $messages ) {
	
	global $current_screen;
	
	if ( $current_screen->post_type != 'schema' ) return $messages;
	
	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );

	$messages['schema'] = array(
		0  => '', // Unused. Messages start at index 1.
		1  => __( 'Schema updated.', 'schema-premium' ),
		2  => __( 'Custom field updated.', 'schema-premium' ),
		3  => __( 'Custom field deleted.', 'schema-premium' ),
		4  => __( 'Schema saved.', 'schema-premium' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Schema restored to revision from %s', 'schema-premium' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => __( 'Schema created.', 'schema-premium' ),
		7  => __( 'Schema saved.', 'schema-premium' ),
		8  => __( 'Schema added.', 'schema-premium' ),
		9  => sprintf(
			__( 'Schema scheduled for: <strong>%1$s</strong>.', 'schema-premium' ),
			// translators: Publish box date format, see http://php.net/date
			date_i18n( __( 'M j, Y @ G:i', 'schema-premium' ), strtotime( $post->post_date ) )
		),
		10 => __( 'Schema draft updated.', 'schema-premium' )
	);

	if ( $post_type_object->publicly_queryable ) {
		$permalink = get_permalink( $post->ID );

		$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View schema', 'schema-premium' ) );
		$view_link = '';
		$messages[ $post_type ][1] .= $view_link;
		$messages[ $post_type ][6] .= $view_link;
		$messages[ $post_type ][9] .= $view_link;

		$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
		$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview schema', 'schema-premium' ) );
		$preview_link = '';
		$messages[ $post_type ][8]  .= $preview_link;
		$messages[ $post_type ][10] .= $preview_link;
	}

	return $messages;
}


add_action( 'transition_post_status', 'schema_wp_set_post_status_to_publish', 10, 3 );
/**
 * Make sure that Schema post status is always set to publish (no drafts)
 *
 * @since 1.0.0
 */
function schema_wp_set_post_status_to_publish( $new_status, $old_status, $post ) { 
    if ( $post->post_type == 'schema' && $new_status == 'draft' && $old_status  != $new_status ) {
        $post->post_status = 'publish';
        wp_update_post( $post );
    }
}
