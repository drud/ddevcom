<?php

/**
 * Hides social networks that are mobile only from the share tools when these are
 * displayed on devices that are not mobile
 *
 * @param array $settings - the settings array for the current location
 * @param string $action - the current type of action ( share/follow )
 * @param string $location - the display location for the buttons
 *
 * @return array
 *
 */
function dpsp_handle_mobile_only_networks( $settings, $action, $location ) {

	if ( 'share' !== $action ) {
		return $settings;
	}

	if ( empty( $settings['networks'] ) || ! is_array( $settings['networks'] ) ) {
		return $settings;
	}

	if ( ! array_key_exists( 'whatsapp', $settings['networks'] ) ) {
		return $settings;
	}

	$plugin_settings = Mediavine\Grow\Settings::get_setting( 'dpsp_settings', [] );

	if ( empty( $plugin_settings['whatsapp_display_only_mobile'] ) ) {
		return $settings;
	}

	$mobile_detect = new \Mediavine\Grow\Mobile_Detect();

	// Remove WhatsApp from the networks array if we are not on a mobile device
	if ( ! $mobile_detect->isMobile() ) {

		unset( $settings['networks']['whatsapp'] );

	} else {

		if ( ! empty( $settings['display']['column_count'] ) && 'auto' != $settings['display']['column_count'] ) {

			$networks_count = count( $settings['networks'] );
			$column_count   = (int) $settings['display']['column_count'];

			if ( ( ( $networks_count + 1 ) / $column_count < 2 ) && ( $networks_count > $column_count ) ) {
				$settings['display']['column_count'] += 1;
			}
		}
	}

	return $settings;

}

/**
 * Register hooks for functions-mobile.php
 */
function dpsp_register_functions_mobile() {
	add_filter( 'dpsp_network_buttons_outputter_settings', 'dpsp_handle_mobile_only_networks', 10, 3 );
}
