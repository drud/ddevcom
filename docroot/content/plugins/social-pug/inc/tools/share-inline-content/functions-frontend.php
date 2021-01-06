<?php

namespace Mediavine\Grow;

class Frontend_Content {

	private static $instance;

	/**
	 * Makes sure class is only instantiated once and runs init
	 *
	 * @return object Instantiated class
	 */
	static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
			self::$instance->init();
		}

		return self::$instance;
	}

	public $output_top = '';

	public $output_bottom = '';

		/**
		 * Hooks to be run on class instantiation
		 *
		 * @return void
		 */
	public function init() {
		// Only run if share content is active
		if ( ! dpsp_is_tool_active( 'share_content' ) ) {
			return;
		}

		if ( Integrations\Container::has_location( 'inline_content_frontend' ) ) {
			Integrations\Container::do_location( 'inline_content_frontend' );
		} else {
			add_filter( 'the_content', [ $this, 'dpsp_output_front_end_content' ], 25 );
		}

		add_filter( 'woocommerce_short_description', [ $this, 'dpsp_output_front_end_content' ] );
		add_filter( 'mv_grow_frontend_data', [ $this, 'localize_icon_svg_data' ] );

	}

	/*
	 * Function that displays the sharing buttons in the post content
	 *
	 */
	function dpsp_output_front_end_content( $content ) {

		global $wp_current_filter;

		// We need to filter out all instances where this callback functions is applied
		// due to the_content filter being used by other plugins
		if ( ! empty( $wp_current_filter ) && is_array( $wp_current_filter ) ) {

			foreach ( $wp_current_filter as $filter ) {

				if ( 'wp_head' == $filter || 'p3_content_end' == $filter ) {
					return $content;
				}
			}
		}

		if ( ! is_main_query() ) {
			return $content;
		}

		if ( ! dpsp_is_tool_active( 'share_content' ) ) {
			return $content;
		}

		if ( ! dpsp_is_location_displayable( 'content' ) ) {
			return $content;
		}

		$tool_container = \Mediavine\Grow\Tools\Toolkit::get_instance();
		$tool_instance = $tool_container->get( 'inline_content' );
		if ( $tool_instance->has_rendered() ) {
			return $content;
		}
		$tool_instance->render();

		// Get saved settings
		$settings = dpsp_get_location_settings( 'content' );

		// Get the post object
		$post_obj = dpsp_get_current_post();

		if ( ! $post_obj ) {
			return $content;
		}

		global $post;

		if ( $post_obj->ID != $post->ID ) {
			return $content;
		}

		/**
		 * Return the content if the output for this callback isn't permitted by filters
		 *
		 * This filter has been added for edge cases
		 */
		if ( false === apply_filters( 'dpsp_output_the_content_callback', true ) ) {
			return $content;
		}

		// Set output
		$output = '';

		// Classes for the wrapper
		$wrapper_classes   = [ 'dpsp-content-wrapper' ];
		$wrapper_classes[] = ( isset( $settings['display']['shape'] ) ? 'dpsp-shape-' . $settings['display']['shape'] : '' );
		$wrapper_classes[] = ( isset( $settings['display']['size'] ) ? 'dpsp-size-' . $settings['display']['size'] : 'dpsp-size-medium' );
		$wrapper_classes[] = ( isset( $settings['display']['spacing'] ) ? 'dpsp-has-spacing' : '' );
		$wrapper_classes[] = ( isset( $settings['display']['show_labels'] ) || isset( $settings['display']['show_count'] ) ? '' : 'dpsp-no-labels' );
		$wrapper_classes[] = ( isset( $settings['display']['show_count'] ) ? 'dpsp-has-buttons-count' : '' );
		$wrapper_classes[] = ( isset( $settings['display']['show_mobile'] ) ? 'dpsp-show-on-mobile' : 'dpsp-hide-on-mobile' );

		// Button total share counts
		$minimum_count    = ( ! empty( $settings['display']['minimum_count'] ) ? (int) $settings['display']['minimum_count'] : 0 );
		$show_total_count = ( $minimum_count <= (int) dpsp_get_post_total_share_count() && ! empty( $settings['display']['show_count_total'] ) ? true : false );

		$wrapper_classes[] = ( $show_total_count ? 'dpsp-show-total-share-count' : '' );
		$wrapper_classes[] = ( $show_total_count ? ( ! empty( $settings['display']['total_count_position'] ) ? 'dpsp-show-total-share-count-' . $settings['display']['total_count_position'] : 'dpsp-show-total-share-count-before' ) : '' );

		// Button styles
		$wrapper_classes[] = ( isset( $settings['button_style'] ) ? 'dpsp-button-style-' . $settings['button_style'] : '' );

		$wrapper_classes = implode( ' ', array_filter( $wrapper_classes ) );

		// Output total share counts
		if ( $show_total_count ) {
			$output .= dpsp_get_output_total_share_count( 'content' );
		}

		// Gets the social network buttons
		if ( isset( $settings['networks'] ) ) {
			$output .= dpsp_get_output_network_buttons( $settings, 'share', 'content' );
		}

		$output = apply_filters( 'dpsp_output_front_end_content', $output );

		// Wrap output for top and bottom cases
		$output_top    = '<div id="dpsp-content-top" class="' . $wrapper_classes . '">' . $output . '</div>';
		$output_bottom = '<div id="dpsp-content-bottom" class="' . $wrapper_classes . '">' . $output . '</div>';

		// Share text
		if ( ! empty( $settings['display']['message'] ) ) {

			$share_text = '<p class="dpsp-share-text ' . ( isset( $settings['display']['show_mobile'] ) ? '' : 'dpsp-hide-on-mobile' ) . '">' . esc_attr( apply_filters( 'gettext', $settings['display']['message'], $settings['display']['message'], 'social-pug' ) ) . '</p>';

			$output_top    = $share_text . $output_top;
			$output_bottom = $share_text . $output_bottom;

		}

		// Concatenate output and content
		if ( 'top' == $settings['display']['position'] ) {
			$content = $output_top . $content;
		} elseif ( 'bottom' == $settings['display']['position'] ) {
			$content = $content . $output_bottom;
		} else {
			$content = $output_top . $content . $output_bottom;
		}

		return $content;

	}

	public function localize_icon_svg_data( $data = [] ) {
		$settings = dpsp_get_location_settings( 'content' );
		if ( ! isset( $settings['networks'] ) || empty( $settings['networks'] ) ) {
			return $data;
		}
		$svg_arr           = isset( $data['buttonSVG'] ) ? $data['buttonSVG'] : [];
		$data['buttonSVG'] = array_merge( $svg_arr, dpsp_get_svg_data_for_networks( $settings['networks'] ) );
		return $data;
	}
}
