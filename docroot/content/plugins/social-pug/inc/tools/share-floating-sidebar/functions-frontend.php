<?php

	// Check that the sidebar has been added only once
	global $dpsp_output_front_end_floating_sidebar;

	/**
	 * Function that displays the floating sidebar sharing buttons
	 *
	 */
	function dpsp_output_front_end_floating_sidebar() {
		// Only run if share sidebar is active
		if ( ! dpsp_is_tool_active( 'share_sidebar' ) ) {
			return;
		}

		if ( ! dpsp_is_tool_active( 'share_sidebar' ) ) {
			return;
		}

		if ( ! dpsp_is_location_displayable( 'sidebar' ) ) {
			return;
		}

		// Check that the sidebar has been added only once
		$tool_container = \Mediavine\Grow\Tools\Toolkit::get_instance();
		$tool_instance = $tool_container->get( 'floating_sidebar' );
		if ( $tool_instance->has_rendered() ) {
			return;
		}
		$tool_instance->render();

		// Get saved settings
		$settings = Mediavine\Grow\Settings::get_setting( 'dpsp_location_sidebar', [] );

		// Classes for the wrapper
		$wrapper_classes   = [];
		$wrapper_classes[] = ( isset( $settings['display']['spacing'] ) ? 'dpsp-bottom-spacing' : '' );
		$wrapper_classes[] = ( isset( $settings['display']['position'] ) ? 'dpsp-position-' . $settings['display']['position'] : '' );
		$wrapper_classes[] = ( isset( $settings['display']['shape'] ) ? 'dpsp-shape-' . $settings['display']['shape'] : '' );
		$wrapper_classes[] = ( isset( $settings['display']['size'] ) ? 'dpsp-size-' . $settings['display']['size'] : 'dpsp-size-small' );
		$wrapper_classes[] = ( isset( $settings['display']['show_count'] ) ? 'dpsp-has-buttons-count' : '' );
		$wrapper_classes[] = ( isset( $settings['display']['show_mobile'] ) ? 'dpsp-show-on-mobile' : 'dpsp-hide-on-mobile' );

		// Button styles
		$wrapper_classes[] = ( isset( $settings['button_style'] ) ? 'dpsp-button-style-' . $settings['button_style'] : '' );

		// Set intro animation
		$wrapper_classes[] = ( ! empty( $settings['display']['intro_animation'] ) && $settings['display']['intro_animation'] != '-1' ? 'dpsp-animation-' . esc_attr( $settings['display']['intro_animation'] ) : 'dpsp-no-animation' );

		$wrapper_classes = implode( ' ', $wrapper_classes );

		// Set trigger extra data
		$trigger_data   = [];
		$trigger_data[] = 'data-trigger-scroll="' . ( isset( $settings['display']['show_after_scrolling'] ) ? ( ! empty( $settings['display']['scroll_distance'] ) ? (int) str_replace( '%', '', trim( $settings['display']['scroll_distance'] ) ) : 0 ) : 'false' ) . '"';
		$trigger_data   = implode( ' ', array_filter( $trigger_data ) );

		$output = '<div id="dpsp-floating-sidebar" class="' . $wrapper_classes . '" ' . $trigger_data . '>';

			// Show total share count
			$show_total_count = ( ! isset( $settings['display']['minimum_count'] ) || empty( $settings['display']['minimum_count'] ) || ( ! empty( $settings['display']['minimum_count'] ) && (int) $settings['display']['minimum_count'] < dpsp_get_post_total_share_count() ) ) ? true : false;

			// Total share count before buttons
			if ( $show_total_count && isset( $settings['display']['show_count_total'] ) && ( ! isset( $settings['display']['total_count_position'] ) || $settings['display']['total_count_position'] == 'before' ) ) {
				$output .= dpsp_get_output_total_share_count( 'sidebar' );
			}

			// Gets the social networks buttons
			if ( isset( $settings['networks'] ) ) {
				$output .= dpsp_get_output_network_buttons( $settings, 'share', 'sidebar' );
			}

			// Total share count after buttons
			if ( $show_total_count && isset( $settings['display']['show_count_total'] ) && $settings['display']['total_count_position'] == 'after' ) {
				$output .= dpsp_get_output_total_share_count( 'sidebar' );
			}

		$output .= '</div>';

		// Echo the final output
		echo apply_filters( 'dpsp_output_front_end_floating_sidebar', $output );

	}
