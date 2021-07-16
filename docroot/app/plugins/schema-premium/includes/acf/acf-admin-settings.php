<?php
/**
 * ACF adming settings
 *
 * @package     Schema
 * @subpackage  Schema - ACF
 * @copyright   Copyright (c) 2020, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.1.2.8
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_init', 'schema_wp_acf_register_admin_setting', 1 );
/*
* Register ACF plugin settings 
*
* @since 1.0.0
*/
function schema_wp_acf_register_admin_setting() {
	
	add_filter( 'schema_wp_settings_advanced', 'schema_wp_acf_load_setting');

	if ( function_exists( 'acf' ) ) {
	
		// ACF is active
		//
		add_filter( 'schema_wp_settings_advanced', 'schema_wp_acf_admin_menu_setting');
	}
}

/*
* Add ACF plugin loading setting
*
* @since 1.1.2.8
*/
function schema_wp_acf_load_setting( $settings_advanced ) {
	
	$settings_advanced['main']['acf_load'] = array(
		'id' => 'acf_load',
		'name' => __( 'Load ACF PRO?', 'schema-premium' ),
		'desc' => '',
		'type' => 'select',
		'options' => array(
			'enabled'	=> __( 'Enabled', 'schema-premium'),
			'disabled'	=> __( 'Disabled', 'schema-premium')
		),
		'std' => 'enabled',
		'tooltip_title' => __('Use this feature', 'schema-premium'),
		'tooltip_desc' => __('To enable/disable loading the included version of Advanced Custom Fields PRO (ACF PRO) plugin. (disabled only if you want to loaad ACF PRO as a normal plugin, or if it is loaded by the Theme or another plugin)', 'schema-premium'),
	);

	return $settings_advanced;
}

/*
* Add ACF plugin admin menu setting
*
* @since 1.0.0
*/
function schema_wp_acf_admin_menu_setting( $settings_advanced ) {
	
	// Display ACF PRO version
	$version = '';
	
	if ( function_exists( 'acf' ) ) {
		$version = acf_get_setting('version'); // may use get_option('acf_version')
	}

	if ($version != '') $version = '(' . $version . ')';
	
	$settings_advanced['main']['acf_admin_menu_show'] = array(
		'id' => 'acf_admin_menu_show',
		'name' => __( 'Enable ACF PRO admin menu?', 'schema-premium' ) . $version,
		'desc' => '',
		'type' => 'select',
		'options' => array(
			'yes'	=> __( 'Yes', 'schema-premium'),
			'no'	=> __( 'No', 'schema-premium')
		),
		'std' => 'no',
		'tooltip_title' => __('When enabled', 'schema-premium'),
		'tooltip_desc' => __('Schema Premium plugin will show Advanced Custom Fields (ACF) admin menu item.', 'schema-premium'),
	);
	
	return $settings_advanced;
}
