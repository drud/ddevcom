<?php
/**
 * Rank Math WordPress SEO
 *
 *
 * Integrate with Rank Math WordPress SEO plugin
 *
 * plugin url: https://wordpress.org/plugins/seo-by-rank-math/
 * @since 1.1.2.2
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Code to remove json+ld data
 * 
 * @since 1.1.2.2
 */
add_action( 'rank_math/head', function() {
	
	global $wp_filter;
	
	$enabled = schema_wp_get_option( 'rank_math_enabled' );
	
	if ( $enabled == 'enabled' ) {
		if ( isset( $wp_filter["rank_math/json_ld"] ) ) {
			unset( $wp_filter["rank_math/json_ld"] );
		}
	}
});

add_action( 'admin_init', 'schema_premium_rank_math_register_settings', 1 );
/*
* Register settings 
*
* @since 1.6.4
*/
function schema_premium_rank_math_register_settings() {
	
	add_filter( 'schema_wp_settings_integrations', 'schema_premium_rank_math_settings', 10 );
}

/*
* Settings 
*
* @since 1.6.4
*/
function schema_premium_rank_math_settings( $settings ) {

	$info = ' <span style="color:#8a8a8a;margin-top:3px;" class="dashicons dashicons-admin-plugins"></span>';

	if ( class_exists( 'RankMath' ) ) {
		$info = ' <span style="color:#48b142;margin-top:3px;" class="dashicons dashicons-admin-plugins"></span>';
	}
	
	$settings['main']['rank_math_enabled'] = array(
		'id' => 'rank_math_enabled',
		'name' => __( 'Rank Math', 'schema-premium' ),
		'desc' => $info,
		'type' => 'select',
		'options' => array(
			'enabled'	=> __( 'Enabled', 'schema-premium'),
			'disabled'	=> __( 'Disabled', 'schema-premium')
		),
		'std' => 'enabld',
		'tooltip_title' => __('When enabled', 'schema-premium'),
		'tooltip_desc' => __('Rank Math schema.org markup output will be disabled.', 'schema-premium'),
	);
	
	return $settings;
}
