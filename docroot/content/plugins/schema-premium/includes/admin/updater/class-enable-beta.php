<?php
/**
 * Enable beta for Easy Digital Downloads
 *
 *
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


add_action( 'schema_wp_settings_advanced', 'schema_premium_beta_add_settings' );
/**
 * Add beta releases settings to licenses page
 *
 * @since       1.1.1
 * @param       string $settings The plugin settings array
 * @return      array of settinngs
 */
function schema_premium_beta_add_settings( $settings ) {
	
	$has_beta = schema_premium_get_beta_enabled_extensions();
	
	// Debug
	//echo'<pre>';print_r($has_beta);echo'</pre>';exit;
	
	$beta_settings = array(
		array(
			'id'      => 'enabled_betas',
			'name'    => __('Beta Releases', 'schema-premium'),
			'desc'    => '<div class="schema-wp-license-data"><p>'.__('Enable to receive updates for pre-release versions.', 'schema-premium' ).'</p></div>',
			'type'    => 'multicheck',
			'options' => $has_beta,
			'tooltip_title' => __('When enabled', 'schema-premium' ),
			'tooltip_desc'  => __('You will receive pre-release updates for the selected extensions when available.', 'schema-premium' ),
			'class' => 'enabled_betas',
			'class_field' => ''
		)
	);
	
	return array_merge( $settings, $beta_settings );
}

/**
 * Return an array of all extensions with beta support
 *
 * Extensions should be added as 'extension-slug' => 'Extension Name'
 *
 * @since       1.1.1
 * @return      array $extensions The array of extensions
 */
function schema_premium_get_beta_enabled_extensions() {
	return apply_filters( 'schema_beta_enabled_extensions', array() );
}

/**
 * Check if a given extensions has beta support enabled
 *
 * @since       1.1.1
 * @param       string $slug The slug of the extension to check
 * @return      bool True if enabled, false otherwise
 */
function schema_premium_extension_has_beta_support( $slug ) {
	$enabled_betas = schema_premium_get_enabled_betas_settings();
	$return        = false;
	
	// Debug
	//echo'<pre>';print_r($enabled_betas);echo'</pre>';exit;
	
	if( is_array($enabled_betas) && array_key_exists( $slug, $enabled_betas ) ) {
		$return = true;
	}

	return $return;
}

/**
 * Return an array of all extensions with beta support enabled nin settings
 *
 * Extensions should be added as 'extension-slug' => 'Extension Name'
 * then, we convert all values to 1 (true)s
 *
 * @since       1.1.1
 * @return      array $extensions The array of extensions
 */
function schema_premium_get_enabled_betas_settings() {
	
	$enabled_betas 	= schema_wp_get_option( 'enabled_betas', array() );
	// set all values to 1
	$settings 		= array_fill_keys(array_keys($$enabled_betas),NULL);
	
	return $settings;
}
