<?php
/**
 * Schema Loader
 *
 * @since 1.0.0
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Plugin Folder Path
// @since 1.0.2
if ( ! defined( 'SCHEMAPREMIUM_PLUGIN_DIR' ) ) {
	define( 'SCHEMAPREMIUM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}
		
// 1. customize ACF path
add_filter('acf/settings/path', 'schema_premium_acf_settings_path');
 
function schema_premium_acf_settings_path( $path ) {
 
    // update path
    $path = SCHEMAPREMIUM_PLUGIN_DIR . 'vendors/acf/';
    
    // return
    return $path;
}
 
// 2. customize ACF dir
add_filter('acf/settings/dir', 'schema_premium_acf_settings_dir');
 
function schema_premium_acf_settings_dir( $dir ) {
 
    // update path
    $dir = SCHEMAPREMIUM_PLUGIN_URL . 'vendors/acf/';
    
    // return
    return $dir;
}

// 3. Hide ACF field group menu item: This is controled by a function in the plugin settings!
//add_filter('acf/settings/show_admin', '__return_false');


// 4. Include ACF
include_once( SCHEMAPREMIUM_PLUGIN_DIR . 'vendors/acf/acf.php' );
