<?php

namespace Mediavine\Grow;

if ( class_exists( 'Social_Pug' ) ) {
	class Frontend_Data extends Asset_Loader {

		private static $instance = null;

		/**
		 * @var $data array|null
		 */
		private $data = null;

		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
				self::$instance->init();
			}

			return self::$instance;
		}


		/**
		 *  Set up data and add hook for output
		 */
		public function init() {
			$this->data = [];
			add_action( 'wp_footer', [ $this, 'output_data' ] );
			add_filter( 'mv_grow_frontend_data', [ $this, 'general_data' ] );
			add_filter( 'mv_grow_frontend_data', [ $this, 'get_counts' ] );
			add_filter( 'mv_grow_frontend_data', [ $this, 'should_run' ] );
		}

		/**
		 *  Run hook to collect all data
		 */
		public function get_data() {
			$this->data = apply_filters( 'mv_grow_frontend_data', $this->data );
		}


		/**
		 * Get share counts for post if they exist
		 *
		 * @param $data array Data that will be output
		 *
		 * @return array Data to be output
		 */
		public function get_counts( $data ) {
			$post = dpsp_get_current_post();
			if ( $post ) {
				$data['shareCounts'] = dpsp_get_post_share_counts( $post->ID );
			}

			return $data;
		}

		/**
		 * Output data as data attribute on div
		 */
		public function output_data() {
			$this->get_data();
			$data = htmlspecialchars( json_encode( $this->data ), ENT_QUOTES, 'UTF-8' );
			echo wp_kses_post( '<div id="mv-grow-data" data-settings=\'' . $data . '\'></div>' );
		}

		public function general_data( $data ) {
			$general         = [
				'contentSelector' => apply_filters( 'mv_grow_content_wrapper_selector', false ),
			];
			$data['general'] = $general;

			return $data;
		}

		/**
		 * Determine if Grow should do anything based on if the page is singular or not
		 *
		 * @param $data array Existing data that will be output to frontend
		 *
		 * @return array
		 */
		public function should_run( $data ) {
			$data['shouldRun'] = is_singular();

			return $data;
		}
	}
}
