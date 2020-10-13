<?php
/**
 * Schema Premium Install
 *
 * @since 1.0.0
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

register_activation_hook( SCHEMAPREMIUM_PLUGIN_FILE, 'schema_wp_install' );
/**
 * Schema Premium activation install
 *
 * @since 1.0.0
 * @return void
 */
function schema_wp_install() {

	// Create caps
	//
	$roles = new Schema_WP_Capabilities;
	$roles->add_roles();
	$roles->add_caps();

	$older_plugin_version = get_option( 'schema_premium_version' );
	
	// Add Upgraded From Option
	//
	if ( $older_plugin_version ) {
		update_option( 'schema_premium_version_upgraded_from', $older_plugin_version );
	}
	
	// Get saved settings
	//
	$options = schema_wp_get_settings();

	// Check if Schema Premium is already installed, or was installed before
	//
	if ( ! get_option( 'schema_premium_is_installed' )  ) {
		
		// Get saved settings
		//
		//$options = schema_wp_get_settings();
		
		// If no saved settings
		//
		if ( empty($options) ) {
			// Set defaults
			$default_options = array(
				'acf_load' 					=> 'enabled',
				'blog_markup' 				=> 'Blog',
				'schema_output_location' 	=> 'head',
				'json_ld_output_format' 	=> 'minified',
				'schema_test_link' 			=> 'yes',
				'properties_tabs' 			=> 'yes',
				'properties_instructions' 	=> 'yes',
				'breadcrumbs_home_enable'	=> 1,
				'breadcrumbs_home_text'		=> 'Blog',
				'amp_enabled'				=> 'enabled',
				'yoast_seo_enabled'			=> 'enabled',
				'rank_math_enabled'			=> 'enabled',
				'co_authors_plus_enabled'	=> 'enabled',
				'bbpress_enabled'			=> 'enabled',
				'co_authors_plus_enabled'	=> 'enabled',
				'dwqa_enabled'				=> 'enabled',
			);
			
			// Save defaults
			//
			update_option( 'schema_wp_settings', $default_options );
		}

		// Set default schema types
		//
		schema_wp_set_default_schema_types();

	} else {

		// Schema Premium was installed before... 
		// @since 1.1.2.8
		//
		if ( ! empty($options) && version_compare( $older_plugin_version, '1.1.2.8', '<' ) ) {
			
			// Upddate settings for updating from older versions
			//
			$options['acf_load'] 					= 'enabled';
			$options['properties_tabs'] 			= 'yes';
			$options['properties_instructions'] 	= 'yes';
			$options['amp_enabled'] 				= 'enabled';
			$options['yoast_seo_enabled'] 			= 'enabled';
			$options['rank_math_enabled'] 			= 'enabled';
			$options['the_seo_framework_enabled'] 	= 'enabled';
			$options['bbpress_enabled'] 			= 'enabled';
			$options['co_authors_plus_enabled']		= 'enabled';
			$options['dwqa_enabled'] 				= 'enabled';

			update_option( 'schema_wp_settings', $options );
		}
	}

	// Update plugin version
	//
	update_option( 'schema_premium_is_installed', '1' );	
	update_option( 'schema_premium_version', SCHEMAPREMIUM_VERSION );
	
	// Bail if activating from network, or bulk
	//
	if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
		return;
	}
}

add_action( 'admin_init', 'schema_wp_check_if_installed' );
/**
 * Check if Schema Premium is installed
 *
 * @since 1.0.0
 * @return void
 */
function schema_wp_check_if_installed() {

	// This is mainly for network activated installs
	//
	if(  ! get_option( 'schema_premium_is_installed' ) ) {
		schema_wp_install();
	}
}

add_action( 'admin_init', 'schema_wp_install_roles_on_network' );
/**
 * Install user roles on sub-sites of a network
 *
 * Roles do not get created when Schema is network activation so we need to create them during admin_init
 *
 * @since 1.0.0
 * @return void
 */
function schema_wp_install_roles_on_network() {

	global $wp_roles;

	if( ! is_object( $wp_roles ) ) {
		return;
	}

	if( ! in_array( 'manage_schema_options', $wp_roles->roles ) ) {

		// Create Schema roles
		//
		$roles = new Schema_WP_Capabilities;
		$roles->add_roles();
		$roles->add_caps();
	}
}

/**
 * Parse
 *
 * @since 1.1.2.2
 * @return void
 */
function schema_wp_set_default_schema_types() {

	// Disable a time limit
	//
	set_time_limit(0);
	
	// Set XML file url
	//
	$file_url = plugins_url().'/schema-premium/includes/admin/xml/default-schema-types.xml';
	
	// Download and parse the xml
	//
	$xml = file_get_contents( $file_url );
	
	// Succesfully loaded?
	//
	if ( $xml !== FALSE ) {
		
		$schema_types 	= new Schema_WP_Parser_Regex;
		$xml 			= $schema_types->parse($file_url);
		$old_posts 		= array ( 'Article', 'BlogPosting' );
		
		// debug
		//echo'<pre>';print_r($xml);echo'</pre>';

		foreach ( $xml['posts'] as $schema_type ) {

			// Check if Post already exists
			//
			$check_old_post = schema_wp_get_post_by_title( $schema_type['post_title'], 'schema' );

			/*
			*	Insert schema type
			*/
			$schema_page = ( $check_old_post == null ) ? wp_insert_post( 
				array(
					'post_title'     => $schema_type['post_title'],
					'post_content'   => '',
					'post_status'    => 'publish',
					'post_author'    => 1,
					'post_type'      => 'schema'
				)
			) : false; // set to false if already exists
				
			/*
			*	Insert schema type post meta
			*/
			if ( $schema_page ) {
				foreach ( $schema_type['postmeta'] as $meta ) {
					update_post_meta( $schema_page, $meta['key'], $meta['value'] );
				}
			}
				
		}
	}

}
