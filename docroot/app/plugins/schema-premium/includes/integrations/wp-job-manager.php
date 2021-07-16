<?php
/**
 * WP Job Manager
 *
 *
 * Integrate with WP Job Manager plugin
 *
 * plugin url: https://wordpress.org/plugins/wp-job-manager/
 * @since 1.2
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'schema_output_JobPosting', 'schema_premium_wp_job_manager_markup' );
/**
 * Add missing schema.org properties
 * 
 * @since 1.2
 * @return array 
 */
function schema_premium_wp_job_manager_markup( $schema ) {

	global $post;
	
	if ( ! isset($post->ID) )
		return $schema;

	if ( ! class_exists( 'WP_Job_Manager' ) ) 
		return $schema;

	$enabled = schema_wp_get_option( 'wp_job_manager_enabled' );
	
	if ( $enabled == 'enabled' ) {

		$post_type = get_post_type( $post->ID );
		
		if ( 'job_listing' === $post_type ) {
			
			// Add job type ( Full Time, Part Time...etc.)
			//
			$terms = wp_get_post_terms( $post->ID, 'job_listing_type' );

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				$employmentType = array();
				foreach ( $terms as $term => $term_data ) {
					$employmentType[] = $term_data->name;
				}
				$schema['employmentType'] = $employmentType;
			}
		}
	}
	
	// debug
	//echo'<pre>';print_r($schema);echo'</pre>';
	
	return $schema;
}

/**
 * Code to remove json+ld data
 * 
 * @since 1.2
 */
add_action( 'init', function() {
	
	$enabled = schema_wp_get_option( 'wp_job_manager_enabled' );
	
	if ( $enabled == 'enabled' ) {
		
		add_filter( 'wpjm_get_job_listing_structured_data', '__return_false' );
	}
});

add_action( 'admin_init', 'schema_premium_wp_job_manager_register_settings', 1 );
/*
* Register settings 
*
* @since 1.2
*/
function schema_premium_wp_job_manager_register_settings() {
	
	add_filter( 'schema_wp_settings_integrations', 'schema_premium_wp_job_manager_settings', 10 );
}

/*
* Settings 
*
* @since 1.6.4
*/
function schema_premium_wp_job_manager_settings( $settings ) {

	$info = ' <span style="color:#8a8a8a;margin-top:3px;" class="dashicons dashicons-admin-plugins"></span>';

	if ( class_exists( 'WP_Job_Manager' ) ) {
		$info = ' <span style="color:#48b142;margin-top:3px;" class="dashicons dashicons-admin-plugins"></span>';
	}
	
	$settings['main']['wp_job_manager_enabled'] = array(
		'id' => 'wp_job_manager_enabled',
		'name' => __( 'WP Job Manager', 'schema-premium' ),
		'desc' => $info,
		'type' => 'select',
		'options' => array(
			'enabled'	=> __( 'Enabled', 'schema-premium'),
			'disabled'	=> __( 'Disabled', 'schema-premium')
		),
		'std' => 'enabld',
		'tooltip_title' => __('When enabled', 'schema-premium'),
		'tooltip_desc' => __('WP Job Manager schema.org markup output will be disabled.', 'schema-premium'),
	);
	
	return $settings;
}
