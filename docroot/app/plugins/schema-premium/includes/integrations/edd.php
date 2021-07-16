<?php
/**
 * Easy Digital Downloads (EDD)
 *
 *
 * Integrate with EDD plugin
 *
 * plugin url: https://wordpress.org/plugins/easy-digital-downloads/
 * @since 1.1.1
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'schema_wp_action_post_type_archive', 'schema_premium_edd_schema_microdata_disable' );
/*
* Disable EDD Product markup output, it's hook to the post type archive function
*
* @since 1.1.1
*/
function schema_premium_edd_schema_microdata_disable() {
	
	if ( function_exists( 'edd_add_schema_microdata' ) ) { 

		$enabled = schema_wp_get_option( 'amp_enabled' );
	
		if ( $enabled == 'disabled' ) {
			add_filter( 'edd_add_schema_microdata', '__return_false' );
		}
	}
}

// Mostly, we don't need this since we cached meta keys array
add_filter( 'schema_premium_admin_post_types_extras', 'schema_premium_edd_remove_post_types_extras' );
/*
* Remoove EDD post types extras 
*
* @since 1.1.1
*/
function schema_premium_edd_remove_post_types_extras( $post_types ) {
	
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	
	if ( is_plugin_active( 'easy-digital-downloads/easy-digital-downloads.php' ) ) {
		
		unset($post_types['edd_log']);
		unset($post_types['edd_payment']);
		unset($post_types['edd_discount']);
		unset($post_types['edd_license']); 
		unset($post_types['edd_license_log']); 
	}
	
	return $post_types;
}

add_action( 'admin_init', 'schema_premium_edd_register_settings', 1 );
/*
* Register settings 
*
* @since 1.1.2.8
*/
function schema_premium_edd_register_settings() {
	
	add_filter( 'schema_wp_settings_integrations', 'schema_premium_edd_settings', 30 );
}

/*
* Settings 
*
* @since 1.1.2.8
*/
function schema_premium_edd_settings( $settings ) {

	$info = ' <span style="color:#8a8a8a;margin-top:3px;" class="dashicons dashicons-admin-plugins"></span>';

	if (  class_exists( 'Easy_Digital_Downloads' ) ) {
		$info = ' <span style="color:#48b142;margin-top:3px;" class="dashicons dashicons-admin-plugins"></span>';
	}
	
	$settings['main']['edd_enabled'] = array(
		'id' => 'edd_enabled',
		'name' => __( 'Easy Digital Downloads', 'schema-premium' ),
		'desc' => $info,
		'type' => 'select',
		'options' => array(
			'enabled'	=> __( 'Enabled', 'schema-premium'),
			'disabled'	=> __( 'Disabled', 'schema-premium')
		),
		'std' => 'enabled',
		'tooltip_title' => __('When disabled', 'schema-premium'),
		'tooltip_desc' => __('Schema Premium will Easy Digital Downloads markup output.', 'schema-premium'),
	);
	
	return $settings;
}
