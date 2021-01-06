<?php

	// Check that the sticky bar has been added only once
	global $dpsp_output_front_end_sticky_bar;

	/*
	 * Function that displays the sticky bar sharing buttons
	 *
	 */
	function dpsp_output_front_end_sticky_bar() {
		// Only run if share sticky bar is active
		if ( ! dpsp_is_tool_active( 'share_sticky_bar' ) ) {
			return;
		}

		if ( ! dpsp_is_location_displayable( 'sticky_bar' ) ) {
			return;
		}

		$tool_container = \Mediavine\Grow\Tools\Toolkit::get_instance();
		$tool_instance = $tool_container->get( 'sticky_bar' );
		if ( $tool_instance->has_rendered() ) {
			return;
		}
		$tool_instance->render();

		// Get saved settings
		$settings = Mediavine\Grow\Settings::get_setting( 'dpsp_location_sticky_bar', [] );

		// Classes for the wrapper
		$wrapper_classes   = [ 'dpsp-share-buttons-wrapper' ];
		$wrapper_classes[] = ( isset( $settings['display']['shape'] ) ? 'dpsp-shape-' . $settings['display']['shape'] : '' );
		$wrapper_classes[] = 'dpsp-size-small';
		$wrapper_classes[] = ( isset( $settings['display']['show_count'] ) ? 'dpsp-has-buttons-count' : '' );
		$wrapper_classes[] = ( empty( $settings['display']['show_after_scrolling'] ) ? 'opened' : '' );

		// Button total share counts
		$minimum_count    = ( ! empty( $settings['display']['minimum_count'] ) ? (int) $settings['display']['minimum_count'] : 0 );
		$show_total_count = ( $minimum_count <= (int) dpsp_get_post_total_share_count() && ! empty( $settings['display']['show_count_total'] ) ? true : false );

		$wrapper_classes[] = ( $show_total_count ? 'dpsp-show-total-share-count' : '' );
		$wrapper_classes[] = ( $show_total_count ? ( ! empty( $settings['display']['total_count_position'] ) ? 'dpsp-show-total-share-count-' . $settings['display']['total_count_position'] : 'dpsp-show-total-share-count-before' ) : '' );

		// Button styles
		$wrapper_classes[] = 'dpsp-button-style-1';

		$wrapper_classes = implode( ' ', $wrapper_classes );

		// Set trigger extra data
		$trigger_data   = [];
		$trigger_data[] = 'data-trigger-scroll="' . ( isset( $settings['display']['show_after_scrolling'] ) ? ( ! empty( $settings['display']['scroll_distance'] ) ? (int) str_replace( '%', '', trim( $settings['display']['scroll_distance'] ) ) : 0 ) : 'false' ) . '"';
		$trigger_data   = implode( ' ', array_filter( $trigger_data ) );

		$output = '<div id="dpsp-sticky-bar-wrapper" class="' . ( ! empty( $settings['display']['intro_animation'] ) && $settings['display']['intro_animation'] != '-1' ? 'dpsp-animation-' . esc_attr( $settings['display']['intro_animation'] ) : 'dpsp-no-animation' ) . ' ' . ( ! empty( $settings['display']['show_on_device'] ) ? 'dpsp-device-' . esc_attr( $settings['display']['show_on_device'] ) : 'dpsp-device-mobile' ) . ' ' . ( ! empty( $settings['display']['position_desktop'] ) ? 'dpsp-position-desktop-' . esc_attr( $settings['display']['position_desktop'] ) : 'dpsp-position-desktop-bottom' ) . ' ' . ( ! empty( $settings['display']['position_mobile'] ) ? 'dpsp-position-mobile-' . esc_attr( $settings['display']['position_mobile'] ) : 'dpsp-position-mobile-bottom' ) . '" ' . $trigger_data . '>';

			$output .= '<div id="dpsp-sticky-bar" class="' . $wrapper_classes . '">';

			// Output total share counts
			if ( $show_total_count ) {
				$output .= dpsp_get_output_total_share_count( 'sticky_bar' );
			}

			// Gets the social networks buttons
			if ( isset( $settings['networks'] ) ) {
				$output .= dpsp_get_output_network_buttons( $settings, 'share', 'sticky_bar' );
			}

			$output .= '</div>';

		$output .= '</div>';

		// Echo the final output
		echo apply_filters( 'dpsp_output_front_end_sticky_bar', $output );

	}

	/**
	 * Adds extra mark-up just after the content so we know the position and width of the content wrapper
	 *
	 */
	function dpsp_output_front_end_sticky_bar_content_markup( $content ) {
		// Only run if share sticky bar is active
		if ( ! dpsp_is_tool_active( 'share_sticky_bar' ) ) {
			return $content;
		}

		if ( ! is_singular() ) {
			return $content;
		}

		if ( ! is_main_query() ) {
			return $content;
		}

		/**
		 * Return the content if the output for this callback isn't permitted by filters
		 *
		 * This filter has been added for edge cases
		 *
		 */
		if ( false === apply_filters( 'dpsp_output_the_content_callback', true ) ) {
			return $content;
		}

		if ( \Mediavine\Grow\Integrations\Container::has_location( 'output_sticky_bar_content_markup' ) ) {
			\Mediavine\Grow\Integrations\Container::do_location( 'output_sticky_bar_content_markup' );
			return $content;
		}

		$settings = Mediavine\Grow\Settings::get_setting( 'dpsp_location_sticky_bar', [] );

		$content = '<span id="dpsp-post-sticky-bar-markup" data-mobile-size="' . ( ! empty( $settings['display']['screen_size'] ) ? absint( $settings['display']['screen_size'] ) : 720 ) . '"></span>' . $content;

		return $content;

	}

	function dpsp_sticky_bar_content_data( $data = [] ) {
		// Only run if share sticky bar is active
		if ( ! dpsp_is_tool_active( 'share_sticky_bar' ) ) {
			return $data;
		}

		$settings          = Mediavine\Grow\Settings::get_setting( 'dpsp_location_sticky_bar', [] );
		$data['stickyBar'] = [
			'mobileSize' => ( ! empty( $settings['display']['screen_size'] ) ? absint( $settings['display']['screen_size'] ) : 720 ),
			'hasSticky'  => is_singular() && is_main_query() && dpsp_is_tool_active( 'share_sticky_bar' ) ? '1' : '0',
		];
		return $data;
	}
