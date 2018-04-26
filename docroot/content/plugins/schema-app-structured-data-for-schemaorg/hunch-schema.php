<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/*
 * Plugin Name: Schema App Structured Data
 * Plugin URI: http://www.schemaapp.com
 * Description: This plugin adds http://schema.org structured data to your website
 * Version: 1.9.10
 * Author: Hunch Manifest
 * Author URI: https://www.hunchmanifest.com
 */

require_once plugin_dir_path(__FILE__) . '/lib/classmap.php';

if ( is_admin() )
{
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	$HunchSchemaPluginData = get_plugin_data( __FILE__ );
	$HunchSchemaPluginVersion = $HunchSchemaPluginData['Version'];
	$HunchSchemaPluginURL = trailingslashit( plugins_url( '', __FILE__ ) );

	// Settings -> Schema App
	$HunchSchemaSettings = new SchemaSettings($HunchSchemaPluginURL, $HunchSchemaPluginVersion);
	// Page & Post Editor
	$HunchSchemaEditor = new SchemaEditor($HunchSchemaPluginURL);

	register_activation_hook( __FILE__, array( $HunchSchemaSettings, 'PluginActivate' ) );

	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $HunchSchemaSettings, 'hook_plugin_action_links' ) );
}
else
{
	$HunchSchemaFront = new SchemaFront();
}