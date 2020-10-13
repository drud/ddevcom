<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package     Schema
 * @subpackage  Uninstall
 * @copyright   Copyright (c) 2019, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Make sure that we are uninstalling
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();

// Plugin Folder Path
if ( ! defined( 'SCHEMAPREMIUM_PLUGIN_DIR' ) ) 
	define( 'SCHEMAPREMIUM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
				
// Load file
include_once( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/admin/class-capabilities.php' );

// Leave no trail
$option_name = 'schema_wp_settings';

if ( !is_multisite() ) {
	
    $options = get_option( $option_name );
	
	// Debug
	//echo '<pre>'; print_r($options); echo '</pre>'; exit;
	
	if ( isset($options['uninstall_on_delete']) && $options['uninstall_on_delete'] == true ) {

		// Remove all plugin settings
		delete_option( $option_name );
		delete_option( 'schema_premium_version' );
		delete_option( 'schema_premium_is_installed' );
		
		// Remove all capabilities and roles
		$caps = new Schema_WP_Capabilities;
		$caps->remove_caps();
	}

} else { 

	// This is a multisite
	//
	// @since 1.4

    global $wpdb;
	
    $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
    $original_blog_id = get_current_blog_id();

    foreach ( $blog_ids as $blog_id ) {
		
        switch_to_blog( $blog_id );
		
		$options = get_option( $option_name );
		
		if ( isset($options['uninstall_on_delete']) && $options['uninstall_on_delete'] == true ) {
			
			// Remove all plugin settings
			delete_option( $option_name );
			delete_option( 'schema_premium_version' );
			delete_option( 'schema_premium_is_installed' );
			
			// Remove all capabilities and roles
			$caps = new Schema_WP_Capabilities;
			$caps->remove_caps();
		}
    }

    switch_to_blog( $original_blog_id );
}
