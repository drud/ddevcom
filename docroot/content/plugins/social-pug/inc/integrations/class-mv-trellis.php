<?php

namespace Mediavine\Grow\Integrations;

use function add_filter;
use function apply_filters;
use function wp_kses_post;

if ( class_exists( '\Mediavine\Grow\Integrations\Integration' ) ) {
	/**
	 * Class MV_Trellis
	 *
	 * @package Mediavine\Grow\Integrations
	 */
	class MV_Trellis extends Integration {

		/** @var string[]  */
		public $locations = [ 'inline_content_frontend', 'output_pinterest_content_markup', 'output_sticky_bar_content_markup' ];

		/** @var  */
		private $output_top;

		/** @var  */
		private $output_bottom;

		/** @var null  */
		private static $instance = null;

		/**
		 * @return Container|MV_Trellis|\Social_Pug|null
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
			 	self::$instance = new self;
				self::$instance->init();
			}
			return self::$instance;
		}

		/**
		 *
		 */
		public function init() {
			add_filter( 'mv_trellis_css_bypass', [ $this, 'css_bypass' ] );
			add_filter( 'mv_trellis_disable_lazy_load_classes', [ $this, 'lazyload_bypass' ] );
		}

		/**
		 * @return bool|mixed
		 */
		public function should_run() {
			return class_exists( 'Mediavine\Trellis\Post_Meta' );
		}

		/**
		 *
		 */
		public function inline_content_frontend() {
			add_filter( 'tha_entry_before', [ $this, 'inline_content_share_top' ] );
			add_filter( 'tha_entry_after', [ $this, 'inline_content_share_bottom' ] );
		}

		/**
		 *
		 */
		public function inline_content_share_top() {
			if ( $this->share_content() ) {
				echo wp_kses_post( $this->output_top );
			}
		}

		/**
		 *
		 */
		public function inline_content_share_bottom() {
			if ( $this->share_content() ) {
				echo wp_kses_post( $this->output_bottom );
			}
		}

		/**
		 * @return bool
		 */
		function share_content() {
		    if ( $this->output_top && $this->output_bottom ) {
		  	    return true;
		    }

			if ( ! dpsp_is_tool_active( 'share_content' ) ) {
				return false;
			}

			if ( ! dpsp_is_location_displayable( 'content' ) ) {
				return false;
			}

			// Get saved settings
			$settings = dpsp_get_location_settings( 'content' );

			// Get the post object
			$post_obj = dpsp_get_current_post();

			if ( ! $post_obj ) {
				return false;
			}

			global $post;

			if ( $post_obj->ID !== $post->ID ) {
				return false;
			}

			// Return the content if the output for this callback isn't permitted by filters
			// This filter has been added for edge cases
			if ( false === apply_filters( 'dpsp_output_the_content_callback', true ) ) {
				return false;
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
			$this->output_top    = '<div id="dpsp-content-top" class="' . $wrapper_classes . '">' . $output . '</div>';
			$this->output_bottom = '<div id="dpsp-content-bottom" class="' . $wrapper_classes . '">' . $output . '</div>';

			// Share text
			if ( ! empty( $settings['display']['message'] ) ) {
				$share_text = '<p class="dpsp-share-text ' . ( isset( $settings['display']['show_mobile'] ) ? '' : 'dpsp-hide-on-mobile' ) . '">' . esc_attr( apply_filters( 'gettext', $settings['display']['message'], $settings['display']['message'], 'social-pug' ) ) . '</p>';

				$this->output_top    = $share_text . $this->output_top;
				$this->output_bottom = $share_text . $this->output_bottom;
			}

			// Filter out content that shouldn't be output
			$should_output_top    = $settings['display']['position'] == 'top' || $settings['display']['position'] == 'both';
			$should_output_bottom = $settings['display']['position'] == 'bottom' || $settings['display']['position'] == 'both';

			$this->output_top    = $should_output_top ? $this->output_top : '';
			$this->output_bottom = $should_output_bottom ? $this->output_bottom : '';

			return true;
		}

		/**
		 *
		 *
		 * @param array $bypass
		 * @return array
		 */
		public function css_bypass( $bypass = [] ) {
			$bypass[] = '((\.|#)?dpsp-(pin-it|pop-up|button-style|network|floating|animation|column|hide|has-button|position)[a-z-0-9]*)';
			return $bypass;
		}

		/**
		 *
		 *
		 * @param array $bypass
		 * @return array
		 */
		public function lazyload_bypass( $bypass = [] ) {
			$bypass[] = 'dpsp-post-pinterest-image-hidden-inner';
			return $bypass;
		}
	}
}
