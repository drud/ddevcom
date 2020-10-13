<?php
/**
 * Generate post meta fields for ACF - Payment Accepted field
 *
 * @package     Schema
 * @subpackage  Schema Post Meta ACF
 * @copyright   Copyright (c) 2017, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function schema_wp_types_acf_payment_accepted_field( $id = '', $type = 'payment_accepted', $label = '', $instructions = '' ) {
	
	$fields = array (
			'key' => $id,
			'label' => $label,
			'name' => $id,
			'type' => 'select',
			'instructions' => ($instructions) ? $instructions : __('Cash, credit card, etc.', 'schema-wp-types'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array (
				'Alipay' => 'Alipay',
				'Apple Pay' => 'Apple Pay',
				'Bank Transfers' => 'Bank Transfers',
				'Cash' => 'Cash',
				'Charge Cards' => 'Charge Cards',
				'Checks' => 'Checks',
				'Credit Cards' => 'Credit Cards',
				'Debit cards' => 'Debit cards',
				'Google Wallet' => 'Google Wallet',
				'Gift Cards' => 'Gift Cards',
				'iDEAL' => 'iDEAL',
				'Mobile Payments' => 'Mobile Payments',
				'Money Orders' => 'Money Orders',
				'PayU' => 'PayU',
				'PayPal' => 'PayPal',
				'Postepay' => 'Postepay',
				'Prepaid Cards' => 'Prepaid Cards',
				'Sofort Überweisung' => 'Sofort Überweisung',
			),
			'default_value' => array (
			),
			'allow_null' => 1,
			'multiple' => 1,
			'ui' => 1,
			'ajax' => 1,
			'return_format' => 'array',
			'placeholder' => '',
		);
	
	return $fields;
}
