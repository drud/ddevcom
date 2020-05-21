<?php
/**
 * This file serves the purpose of updating database items when a new version of the plugin is released
 *
 */


/**
 * Updates needed to the database when updating to version 1.5.1
 *
 * In this version OpenShareCount support has been removed, must default to TwitCount
 *
 * @param string $old_db_version  - the previous version of the plugin
 * @param string $new_db_version  - the new version of the plugin
 *
 */
function dpsp_version_update_1_5_1( $old_db_version, $new_db_version ) {

	// Do this only if the version is greater than 1.5.1
	if( false === version_compare( $new_db_version, '1.5.1', '>=' ) )
		return;

	// Check to see if we've done this check before
	$version_updated = get_option( 'dpsp_version_update_1_5_1', false );

	if( $version_updated )
		return;

	// Update the main plugin settings
	$settings = get_option( 'dpsp_settings', array() );

	if( ! empty( $settings['twitter_share_counts'] ) )
		unset( $settings['twitter_share_counts'] );

	update_option( 'dpsp_settings', $settings );

	// Save a true bool value in the database so we know we've done this 
	// version update
	update_option( 'dpsp_version_update_1_5_1', 1 );

}
add_action( 'dpsp_update_database', 'dpsp_version_update_1_5_1', 10, 2 );


/**
 * Updates needed to the database when updating to version 1.6.1
 *
 * In this version the Facebook share counts provider was added
 *
 * @param string $old_db_version  - the previous version of the plugin
 * @param string $new_db_version  - the new version of the plugin
 *
 */
function dpsp_version_update_1_6_1( $old_db_version, $new_db_version ) {

	// Do this only if the version is greater than 1.6.1
	if( false === version_compare( $new_db_version, '1.6.1', '>=' ) )
		return;

	// Check to see if we've done this check before
	$version_updated = get_option( 'dpsp_version_update_1_6_1', false );

	if( $version_updated )
		return;

	// Update the main plugin settings
	$settings = get_option( 'dpsp_settings', array() );

	if( empty( $settings['facebook_share_counts_provider'] ) ) {

		if( ! empty( $settings['facebook_app_id'] ) && ! empty( $settings['facebook_app_secret'] ) )
			$settings['facebook_share_counts_provider'] = 'own_app';
		else
			$settings['facebook_share_counts_provider'] = 'authorized_app';

	}

	update_option( 'dpsp_settings', $settings );

	// Save a true bool value in the database so we know we've done this 
	// version update
	update_option( 'dpsp_version_update_1_6_1', 1 );

}
add_action( 'dpsp_update_database', 'dpsp_version_update_1_6_1', 10, 2 );