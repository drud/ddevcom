<?php
/**
 * Generate post meta fields for ACF - Default field
 *
 * @package     Schema
 * @subpackage  Schema Post Meta ACF
 * @copyright   Copyright (c) 2017, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function schema_wp_types_acf_gallery_field( $id = '', $type = 'gallery', $label = '', $instructions = '' ) {
	
	$fields = array( 
		'key' => $id,
		'label' => $label,
		'name' => $id,
		'type' => $type,
		'prefix' => '',
		'instructions' => $instructions,
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array (
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'min' => '',
		'max' => '',
		'insert' => 'append',
		'library' => 'all',
		'min_width' => '',
		'min_height' => '',
		'min_size' => '',
		'max_width' => '',
		'max_height' => '',
		'max_size' => '',
		'mime_types' => '',
	);
	
	return $fields;
}
