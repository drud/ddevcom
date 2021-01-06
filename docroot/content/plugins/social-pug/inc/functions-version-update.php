<?php
/**
 * This file serves the purpose of updating database items when a new version of the plugin is released
 *
 */

/**
 * Updates needed to the database when updating to version 2.0.0
 *
 * In this version the new active_tools array has been added and we need to grab
 * all current active button locations and add them as active tools
 *
 * @param string $old_db_version - the previous version of the plugin
 * @param string $new_db_version - the new version of the plugin
 *
 */
function dpsp_version_update_2_0_0( $old_db_version, $new_db_version ) {

	// Do this only if the version is greater than 2.0.0
	if ( false === version_compare( $new_db_version, '2.0.0', '>=' ) ) {
		return;
	}

	// The version update is dependent on this function
	// Check to see if it exists first so we don't go into a fatal error
	if ( ! function_exists( 'dpsp_is_location_active' ) ) {
		return;
	}

	// Check to see if we've done this check before
	$version_updated = Mediavine\Grow\Settings::get_setting( 'dpsp_version_update_2_0_0', false );

	if ( $version_updated ) {
		return;
	}

	$active_tools = Mediavine\Grow\Settings::get_setting( 'dpsp_active_tools', [] );

	// Supported network locations in version 1.6.2
	$network_locations = [ 'sidebar', 'content', 'mobile', 'pop_up', 'follow_widget' ];

	// If any of the supported network locations are active add them to the
	// active_tools array
	foreach ( $network_locations as $location_slug ) {
		if ( dpsp_is_location_active( $location_slug ) ) {

			if ( 'follow_widget' != $location_slug ) {
				$tool_slug = 'share_' . $location_slug;
			} else {
				$tool_slug = $location_slug;
			}

			array_push( $active_tools, $tool_slug );

		}
	}

	$active_tools = array_unique( $active_tools );

	update_option( 'dpsp_active_tools', $active_tools );

	// Save a true bool value in the database so we know we've done this
	// version update
	update_option( 'dpsp_version_update_2_0_0', 1 );
}

/**
 * Updates needed to the database when updating to version 2.3.4
 *
 * In this version StumbleUpon has been removed and we need to remove it from
 * all location settings
 *
 * @param string $old_db_version - the previous version of the plugin
 * @param string $new_db_version - the new version of the plugin
 *
 */
function dpsp_version_update_2_3_4( $old_db_version, $new_db_version ) {

	// Do this only if the version is greater than 2.3.4
	if ( false === version_compare( $new_db_version, '2.3.4', '>=' ) ) {
		return;
	}

	// The version update is dependent on this function
	// Check to see if it exists first so we don't go into a fatal error
	if ( ! function_exists( 'dpsp_is_location_active' ) ) {
		return;
	}

	// Check to see if we've done this check before
	$version_updated = Mediavine\Grow\Settings::get_setting( 'dpsp_version_update_2_3_4', false );

	if ( $version_updated ) {
		return;
	}

	// Get all network locations
	$locations = dpsp_get_network_locations( 'share', true );

	foreach ( $locations as $location_slug ) {

		$location_settings = dpsp_get_location_settings( $location_slug );

		// If no networks are set, just go on to the next location
		if ( empty( $location_settings['networks'] ) ) {
			continue;
		}

		$networks = array_keys( $location_settings['networks'] );

		// If StumbleUpon is not present, jump to the next location
		if ( ! in_array( 'stumbleupon', $networks ) ) {
			continue;
		}

		// Remove StumbleUpon and update the settings
		unset( $location_settings['networks']['stumbleupon'] );

		update_option( 'dpsp_location_' . $location_slug, $location_settings );

	}

	// Save a true bool value in the database so we know we've done this
	// version update
	update_option( 'dpsp_version_update_2_3_4', 1 );
}

/**
 * Updates needed to the database when updating to version 2.4.0
 *
 * In this version the Mobile Sticky sharing tool has been transformed into the
 * Sticky Bar sharing tool and the settings need to be transfered
 *
 * @param string $old_db_version - the previous version of the plugin
 * @param string $new_db_version - the new version of the plugin
 *
 */
function dpsp_version_update_2_4_0( $old_db_version, $new_db_version ) {

	// Do this only if the version is greater than 2.4.0
	if ( false === version_compare( $new_db_version, '2.4.0', '>=' ) ) {
		return;
	}

	// The version update is dependent on this function
	// Check to see if it exists first so we don't go into a fatal error
	if ( ! function_exists( 'dpsp_is_location_active' ) ) {
		return;
	}

	// Check to see if we've done this check before
	$version_updated = Mediavine\Grow\Settings::get_setting( 'dpsp_version_update_2_4_0', false );

	if ( $version_updated ) {
		return;
	}

	$settings_mobile = Mediavine\Grow\Settings::get_setting( 'dpsp_location_mobile', [] );

	if ( empty( $settings_mobile ) ) {
		return;
	}

	// Additional settings
	$settings_mobile['display']['shape']          = 'rounded';
	$settings_mobile['display']['icon_animation'] = 'yes';
	$settings_mobile['display']['show_on_device'] = 'mobile';

	update_option( 'dpsp_location_sticky_bar', $settings_mobile );

	// Need to update the active tools db option
	$active_tools = Mediavine\Grow\Settings::get_setting( 'dpsp_active_tools', [] );

	if ( is_array( $active_tools ) && in_array( 'share_mobile', $active_tools ) ) {

		$active_tools[] = 'share_sticky_bar';

		update_option( 'dpsp_active_tools', $active_tools );

	}

	// Save a true bool value in the database so we know we've done this
	// version update
	update_option( 'dpsp_version_update_2_4_0', 1 );
}

/**
 * Updates needed to the database when updating to version 2.5.0
 *
 * In this version the Sticky Sticky sharing tool supports positioning, top or bottom
 * Need to set the "bottom" value to both the desktop and mobile positions, as per default
 *
 * @param string $old_db_version - the previous version of the plugin
 * @param string $new_db_version - the new version of the plugin
 *
 */
function dpsp_version_update_2_5_0( $old_db_version, $new_db_version ) {

	// Do this only if the version is greater than 2.4.0
	if ( false === version_compare( $new_db_version, '2.5.0', '>=' ) ) {
		return;
	}

	// The version update is dependent on this function
	// Check to see if it exists first so we don't go into a fatal error
	if ( ! function_exists( 'dpsp_is_location_active' ) ) {
		return;
	}

	// Check to see if we've done this check before
	$version_updated = Mediavine\Grow\Settings::get_setting( 'dpsp_version_update_2_5_0', false );

	if ( $version_updated ) {
		return;
	}

	// Update the sticky bar settings
	$settings_sticky_bar = Mediavine\Grow\Settings::get_setting( 'dpsp_location_sticky_bar', [] );

	if ( ! empty( $settings_sticky_bar ) ) {

		// Additional settings
		$settings_sticky_bar['display']['position_desktop'] = 'bottom';
		$settings_sticky_bar['display']['position_mobile']  = 'bottom';

		update_option( 'dpsp_location_sticky_bar', $settings_sticky_bar );

	}

	// Update the main plugin settings
	$settings = Mediavine\Grow\Settings::get_setting( 'dpsp_settings', [] );

	if ( empty( $settings['twitter_share_counts_provider'] ) ) {
		$settings['twitter_share_counts_provider'] = 'twitcount';
	}

	if ( empty( $settings['share_image_pin_description_source'] ) ) {
		$settings['share_image_pin_description_source'] = 'image_alt_tag';
	}

	update_option( 'dpsp_settings', $settings );

	// Save a true bool value in the database so we know we've done this
	// version update
	update_option( 'dpsp_version_update_2_5_0', 1 );
}

/**
 * Updates needed to the database when updating to version 2.5.2
 *
 * In this version OpenShareCount support has been removed, must default to TwitCount
 *
 * @param string $old_db_version - the previous version of the plugin
 * @param string $new_db_version - the new version of the plugin
 *
 */
function dpsp_version_update_2_5_2( $old_db_version, $new_db_version ) {

	// Do this only if the version is greater than 2.5.2
	if ( false === version_compare( $new_db_version, '2.5.2', '>=' ) ) {
		return;
	}

	// Check to see if we've done this check before
	$version_updated = Mediavine\Grow\Settings::get_setting( 'dpsp_version_update_2_5_2', false );

	if ( $version_updated ) {
		return;
	}

	// Update the main plugin settings
	$settings = Mediavine\Grow\Settings::get_setting( 'dpsp_settings', [] );

	if ( ! empty( $settings['twitter_share_counts_provider'] ) && 'twitcount' != $settings['twitter_share_counts_provider'] ) {
		if ( ! empty( $settings['twitter_share_counts'] ) ) {
			unset( $settings['twitter_share_counts'] );
		}

		$settings['twitter_share_counts_provider'] = 'twitcount';

	}

	update_option( 'dpsp_settings', $settings );

	// Save a true bool value in the database so we know we've done this
	// version update
	update_option( 'dpsp_version_update_2_5_2', 1 );
}

/**
 * Updates needed to the database when updating to version 2.6.6
 *
 * In this version the Facebook share counts provider was added
 *
 * @param string $old_db_version - the previous version of the plugin
 * @param string $new_db_version - the new version of the plugin
 *
 */
function dpsp_version_update_2_6_6( $old_db_version, $new_db_version ) {

	// Do this only if the version is greater than 2.6.6
	if ( false === version_compare( $new_db_version, '2.6.6', '>=' ) ) {
		return;
	}

	// Check to see if we've done this check before
	$version_updated = Mediavine\Grow\Settings::get_setting( 'dpsp_version_update_2_6_6', false );

	if ( $version_updated ) {
		return;
	}

	// Update the main plugin settings
	$settings = Mediavine\Grow\Settings::get_setting( 'dpsp_settings', [] );

	if ( empty( $settings['facebook_share_counts_provider'] ) ) {

		if ( ! empty( $settings['facebook_app_id'] ) && ! empty( $settings['facebook_app_secret'] ) ) {
			$settings['facebook_share_counts_provider'] = 'own_app';
		} else {
			$settings['facebook_share_counts_provider'] = 'authorized_app';
		}
	}

	update_option( 'dpsp_settings', $settings );

	// Save a true bool value in the database so we know we've done this
	// version update
	update_option( 'dpsp_version_update_2_6_6', 1 );
}

/**
 * Updates needed to the database when updating to version 2.7.0
 *
 * In this version
 *
 * @param string $old_db_version - the previous version of the plugin
 * @param string $new_db_version - the new version of the plugin
 *
 */
function dpsp_version_update_2_7_0( $old_db_version, $new_db_version ) {

	// Do this only if the version is greater than 2.7.0
	if ( false === version_compare( $new_db_version, '2.7.0', '>=' ) ) {
		return;
	}

	// Check to see if we've done this check before
	$version_updated = Mediavine\Grow\Settings::get_setting( 'dpsp_version_update_2_7_0', false );

	if ( $version_updated ) {
		return;
	}

	// Update the main plugin settings
	$settings = Mediavine\Grow\Settings::get_setting( 'dpsp_settings', [] );

	if ( empty( $settings['share_image_pinterest_button_share_behavior'] ) ) {

		$settings['share_image_pinterest_button_share_behavior'] = 'post_image';

	}

	update_option( 'dpsp_settings', $settings );

	// Save a true bool value in the database so we know we've done this
	// version update
	update_option( 'dpsp_version_update_2_7_0', 1 );
}

/**
 * Updates needed to the database when updating to version 2.10.0
 *
 * In this version support for custom post types was added to the Pinterest Image Hover Button.
 * Previously, only posts were supported. Because of this, post type checkboxes have been added
 * to the settings page for the Pinterest Image Hover Button.
 *
 * We need to make sure the "Post" checkbox is checked when upgrading, if the Image Hover Pinterest Button
 * share tool is active.
 *
 * @param string $old_db_version - the previous version of the plugin
 * @param string $new_db_version - the new version of the plugin
 *
 */
function dpsp_version_update_2_10_0( $old_db_version, $new_db_version ) {

	// Do this only if the version is greater than 2.10.0
	if ( false === version_compare( $new_db_version, '2.10.0', '>=' ) ) {
		return;
	}

	// Check to see if we've done this check before
	$version_updated = Mediavine\Grow\Settings::get_setting( 'dpsp_version_update_2_10_0', false );

	if ( $version_updated ) {
		return;
	}

	// Check for seperate pinterest settings, if missing, pull them over from the general settings
	$settings                = Mediavine\Grow\Settings::get_setting( 'dpsp_settings', [] );
	$dpsp_pinterest_settings = Mediavine\Grow\Settings::get_setting( 'dpsp_pinterest_share_images_setting', [] );

	if ( empty( $dpsp_pinterest_settings ) ) {
		$dpsp_pinterest_settings_slugs = [
			'share_image_pin_description_source',
			'share_image_pinterest_pinnable_images',
			'share_image_pinterest_button_share_behavior',
			'share_image_post_pinterest_image_hidden',
			'share_image_post_multiple_hidden_pinterest_images',
			'share_image_page_builder_compatibility',
			'share_image_lazy_load_compatibility',
			'share_image_button_position',
			'share_image_button_shape',
			'share_image_minimum_image_width',
			'share_image_minimum_image_height',
			'share_image_show_button_text_label',
			'share_image_button_text_label',
			'share_image_show_image_overlay',
			'share_image_button_share_behavior',
			'share_image_post_type_display',
		];

		foreach ( $dpsp_pinterest_settings_slugs as $slug ) {
			if ( isset( $settings[ $slug ] ) ) {
				$dpsp_pinterest_settings[ $slug ] = $settings[ $slug ];
			}
		}
		// Update for new post type settings
		if ( dpsp_is_tool_active( 'share_images' ) && empty( $settings['share_image_post_type_display'] ) ) {
			$dpsp_pinterest_settings['share_image_post_type_display'] = [ 'post' ];
		}

		update_option( 'dpsp_pinterest_share_images_setting', $dpsp_pinterest_settings );
	}

	// Save a true bool value in the database so we know we've done this
	// version update
	update_option( 'dpsp_version_update_2_10_0', 1 );
}

/**
 * Updates needed to the database when updating to version 2.12.4
 *
 * In this version
 *
 * @param string $old_db_version - the previous version of the plugin
 * @param string $new_db_version - the new version of the plugin
 *
 */
function dpsp_version_update_2_12_4( $old_db_version, $new_db_version ) {

	// Do this only if the version is greater than 2.12.4
	if ( false === version_compare( $new_db_version, '2.12.4', '>=' ) ) {
		return;
	}

	// Check to see if we've done this check before
	$version_updated = Mediavine\Grow\Settings::get_setting( 'dpsp_version_update_2_12_4', false );

	if ( $version_updated ) {
		return;
	}

	// Update the main plugin settings
	$settings = Mediavine\Grow\Settings::get_setting( 'dpsp_settings', [] );
	if ( empty( $settings['legacy_javascript'] ) && ! empty( $old_db_version ) && empty( $settings['optimize_javascript'] ) ) {
		$settings['legacy_javascript'] = '1';
	}

	update_option( 'dpsp_settings', $settings );

	// Save a true bool value in the database so we know we've done this
	// version update
	update_option( 'dpsp_version_update_2_12_4', 1 );
}

/**
 * Register hooks for functions-version-update.php
 */
function dpsp_register_functions_version_update() {
	add_action( 'dpsp_update_database', 'dpsp_version_update_2_0_0', 10, 2 );
	add_action( 'dpsp_update_database', 'dpsp_version_update_2_3_4', 10, 2 );
	add_action( 'dpsp_update_database', 'dpsp_version_update_2_4_0', 10, 2 );
	add_action( 'dpsp_update_database', 'dpsp_version_update_2_5_0', 10, 2 );
	add_action( 'dpsp_update_database', 'dpsp_version_update_2_5_2', 10, 2 );
	add_action( 'dpsp_update_database', 'dpsp_version_update_2_6_6', 10, 2 );
	add_action( 'dpsp_update_database', 'dpsp_version_update_2_7_0', 10, 2 );
	add_action( 'dpsp_update_database', 'dpsp_version_update_2_10_0', 10, 2 );
	add_action( 'dpsp_update_database', 'dpsp_version_update_2_12_4', 10, 2 );
}
