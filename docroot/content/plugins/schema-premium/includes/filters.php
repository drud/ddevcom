<?php
/**
 * Misc Filters
 *
 * @package     Schema
 * @subpackage  Filters
 * @copyright   Copyright (c) 2019, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.3
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


add_filter( 'schema_output_Product', 'schema_premium_append_cpt_slug_to_permalink' );
/**
 * Append '#product' to differentiate between this @id and the @id generated for the Breadcrumblist.
 *
 * @since 1.0.3
 * @return array 
 */
function schema_premium_append_cpt_slug_to_permalink( $schema ) {
	
	global $post;
	
	$post_type = get_post_type( $post->ID );
	
	if ( 'product' === $post_type ) {
		
		$schema['@id'] = get_permalink( $post->ID ) . '#product';
		
		unset($schema['url']);
	}
	
	return $schema;
}


add_filter( 'schema_premium_admin_post_types_extras', 'schema_premium_exclude_post_types_extras' );
/*
* Exclude post types extras to spead up loading meta keys in
* Schema > Type > edit page (editor)
* These post types are created by other plugins, but it's not to be used on front-end
*
* @since 1.1.1
*/
function schema_premium_exclude_post_types_extras( $post_types ) {
	
	if ( class_exists( 'woocommerce' ) ) { 
		
		unset($post_types['scheduled-action']);
		
		unset($post_types['wp-types-group']);
		unset($post_types['wp-types-user-group']);
		unset($post_types['wp-types-term-group']);
		
	}
	
	return $post_types;
}
