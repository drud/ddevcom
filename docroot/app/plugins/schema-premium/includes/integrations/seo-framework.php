<?php
/**
 * The SEO Framework 
 *
 *
 * Integrate with SEO Framework plugin
 *
 * plugin url: https://wordpress.org/plugins/autodescription/
 * @since 1.5.6
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'schema_wp_filter_output_knowledge_graph', 'schema_premium_the_seo_framework_knowledge_graph_remove' );
/*
* Remove Knowledge Graph
*
* @since 1.5.6
*/
function schema_premium_the_seo_framework_knowledge_graph_remove( $knowledge_graph ) {
	
	$enabled = schema_wp_get_option( 'the_seo_framework_enabled' );

	// Run only on front page and make sure The SEO Framework is active
	//
	if ( is_front_page() && defined('THE_SEO_FRAMEWORK_VERSION') && $enabled == 'enabled' ) 
		return;
	
	return $knowledge_graph;
}

add_filter( 'schema_wp_output_sitelinks_search_box', 'schema_premium_the_seo_framework_sitelinks_search_box_remove' );
/*
* Remove SiteLinks Search Box
*
* @since 1.5.6
*/
function schema_premium_the_seo_framework_sitelinks_search_box_remove( $sitelinks_search_box ) {
	
	$enabled = schema_wp_get_option( 'the_seo_framework_enabled' );
	
	// Run only on front page and make sure The SEO Framework is active
	//
	if ( is_front_page() && defined('THE_SEO_FRAMEWORK_VERSION') && $enabled == 'enabled' )
		return;

	return $sitelinks_search_box;
}

add_action( 'admin_init', 'schema_premium_the_seo_framework_register_settings', 1 );
/*
* Register settings 
*
* @since 1.1.2.8
*/
function schema_premium_the_seo_framework_register_settings() {
	
	add_filter( 'schema_wp_settings_integrations', 'schema_premium_the_seo_framework_settings', 20 );
}

/*
* Settings 
*
* @since 1.1.2.8
*/
function schema_premium_the_seo_framework_settings( $settings ) {

	$info = ' <span style="color:#8a8a8a;margin-top:3px;" class="dashicons dashicons-admin-plugins"></span>';

	if ( defined('THE_SEO_FRAMEWORK_VERSION') ) {
		$info = ' <span style="color:#48b142;margin-top:3px;" class="dashicons dashicons-admin-plugins"></span>';
	}

	$settings['main']['the_seo_framework_enabled'] = array(
		'id' => 'the_seo_framework_enabled',
		'name' => __( 'The SEO Framework', 'schema-premium' ),
		'desc' => $info,
		'type' => 'select',
		'options' => array(
			'enabled'	=> __( 'Enabled', 'schema-premium'),
			'disabled'	=> __( 'Disabled', 'schema-premium')
		),
		'std' => 'enabled',
		'tooltip_title' => __('When enabled', 'schema-premium'),
		'tooltip_desc' => __('Schema plugin will disable the duplicate Knowledge Graph and SiteLinks Search Box markup.', 'schema-premium'),
	);
	
	return $settings;
}
