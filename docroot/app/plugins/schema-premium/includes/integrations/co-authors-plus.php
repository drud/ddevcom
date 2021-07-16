<?php
/**
 * Co-Authors Plus plugin integration
 *
 *
 * plugin url: https://wordpress.org/plugins/co-authors-plus/
 * *
 * @since 1.1.2.8
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'schema_output', 'schema_output_co_authors_plus' );
/**
 * Extend schema output and override author markup
 *
 * @since 1.1.2.8
 * @return array
 */
function schema_output_co_authors_plus( $schema ) {
	
	global $post;

	$enabled = schema_wp_get_option( 'co_authors_plus_enabled' );
	
	if ( $enabled == 'enabled' ) {
		return $schema;
	}

	// Chedk if Co-Authors Plus plugin is enabled 
	//
	if ( ! class_exists( 'CoAuthors_Plus' ) )
		return $schema; 

	$authors 	= array();
	$coauthors 	= get_coauthors();

	if ( is_array( $coauthors ) ) {
		foreach( $coauthors as $coauthor ):
			$authors[] = schema_wp_get_author_array( $post->ID , $coauthor->data->ID );
		endforeach;
	}

	// debug
	//echo'<pre>';print_r($authors);echo'</pre>';exit;

	$schema['author'] = $authors;
	return $schema;
}

add_action( 'admin_init', 'schema_premium_co_authors_plus_register_settings', 1 );
/*
* Register settings 
*
* @since 1.1.2.8
*/
function schema_premium_co_authors_plus_register_settings() {
	
	add_filter( 'schema_wp_settings_integrations', 'schema_premium_co_authors_plus_settings', 30 );
}

/*
* Settings 
*
* @since 1.1.2.8
*/
function schema_premium_co_authors_plus_settings( $settings ) {

	$info = ' <span style="color:#8a8a8a;margin-top:3px;" class="dashicons dashicons-admin-plugins"></span>';

	if ( class_exists( 'CoAuthors_Plus' ) ) {
		$info = ' <span style="color:#48b142;margin-top:3px;" class="dashicons dashicons-admin-plugins"></span>';
	}

	$settings['main']['co_authors_plus_enabled'] = array(
		'id' => 'co_authors_plus_enabled',
		'name' => __( 'Co-Authors Plus', 'schema-premium' ),
		'desc' => $info,
		'type' => 'select',
		'options' => array(
			'enabled'	=> __( 'Enabled', 'schema-premium'),
			'disabled'	=> __( 'Disabled', 'schema-premium')
		),
		'std' => 'enabled',
		'tooltip_title' => __('When enabled', 'schema-premium'),
		'tooltip_desc' => __('Schema plugin will add co-authors in markup.', 'schema-premium'),
	);
	
	return $settings;
}