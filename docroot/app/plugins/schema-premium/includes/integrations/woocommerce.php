<?php
/**
 * WooCommerce
 *
 *
 * Integrate with WooCommerce plugin
 *
 * plugin url: https://wordpress.org/plugins/woocommerce/
 * @since 1.0.0
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'schema_wp_breadcrumb_enabled', 'schema_premium_woo_product_breadcrumb_disable' );
/*
* Disable breadcrumbs on WooCommerce 
*
* @since 1.0.0
*/
function schema_premium_woo_product_breadcrumb_disable( $breadcrumb_enabled ){
	
	if ( class_exists( 'woocommerce' ) ) { 
		if ( is_woocommerce() ) return false;
	}
	return true;
}

add_filter( 'schema_premium_admin_post_types', 'schema_premium_admin_post_types_add_product' );
/*
* Add admin post type 
*
* @since 1.0.1
*/
function schema_premium_admin_post_types_add_product( $post_types ){
	
	if ( class_exists( 'woocommerce' ) ) { 
		array_push( $post_types, 'product' );
	}
	
	return $post_types;
}

// Mostly, we don't need this since we cached meta keys array
add_filter( 'schema_premium_admin_post_types_extras', 'schema_premium_woo_remove_post_types_extras' );
/*
* Remoove WooCommerce post types extras 
*
* @since 1.1.1
*/
function schema_premium_woo_remove_post_types_extras( $post_types ) {
	
	if ( class_exists( 'woocommerce' ) ) { 
		
		unset($post_types['shop_order']);
		unset($post_types['shop_coupon']);
	}
	
	return $post_types;
}
