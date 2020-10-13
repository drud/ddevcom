<?php
/**
 * Generate post meta fields for ACF - loader
 *
 * @package     Schema
 * @subpackage  Schema Post Meta ACF
 * @copyright   Copyright (c) 2018, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Load fields
require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/acf/acf-fields/acf-default.php';
require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/acf/acf-fields/acf-gallery.php';
require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/acf/acf-fields/acf-address.php';
require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/acf/acf-fields/acf-payment-accepted.php';
require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/acf/acf-fields/acf-star-rating.php';

/**
 * Render ACF special fields
 *
 * This is the main function that prepares and returns schema output for all supported custom fields
 *
 * @since 1.0.0
 *
 * return array
 */
function schema_wp_types_acf_field_render( $post_id = null, $meta_key = null, $type = '', $filter_name = '' ) {
	
	$output = array();
	
	switch ( $type ) {
		
		case 'address':
			$streetAddress_1 	= get_post_meta( $post_id, $meta_key . '_streetAddress', true );
			$streetAddress_2 	= get_post_meta( $post_id, $meta_key . '_streetAddress_2', true );
			$streetAddress_3 	= get_post_meta( $post_id, $meta_key . '_streetAddress_3', true );
			$streetAddress 		= $streetAddress_1 . ' ' . $streetAddress_2 . ' ' . $streetAddress_3; // join the 3 address lines
			
			$addressLocality 	= get_post_meta( $post_id, $meta_key . '_addressLocality', true );
			$postalCode 		= get_post_meta( $post_id, $meta_key . '_postalCode', true );
			$addressRegion 		= get_post_meta( $post_id, $meta_key . '_addressRegion', true );
			$addressCountry 	= get_post_meta( $post_id, $meta_key . '_addressCountry', true );
											
			$output = array(
      			"@type"				=> "PostalAddress",
				"addressCountry" 	=> $addressCountry, // example: US
				"addressLocality"	=> $addressLocality,
				"addressRegion"		=> $addressRegion,
				"postalCode"		=> $postalCode,
				"streetAddress"		=> $streetAddress
			);	
			break;
			
		default:
			// get post meta like normally
			$output = get_post_meta( $post_id, $meta_key, true );
	}
	
	return $output;						
}
