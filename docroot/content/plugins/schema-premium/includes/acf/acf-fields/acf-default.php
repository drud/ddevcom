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

function schema_wp_types_acf_default_field( $id = '', $name = '', $type = 'text', $label = '', $instructions = '' ) {
	
	$fields = array( 
		'key' => $id,
		'label' => $label,
		'name' => $name,
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
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
		'readonly' => 0,
		'disabled' => 0,
	);
	
	return $fields;
}
