<?php

namespace Mediavine\Grow;

if ( class_exists( '\Social_Pug' ) ) {
	class Activation extends \Social_Pug {

		private static $instance = null;

		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self;
				self::$instance->init();
			}

			return self::$instance;
		}

		public function init() {
			add_action( 'update_option_dpsp_settings', [ $this, 'manage_grow_license' ], 10, 2 );
			add_action( 'wp_loaded', [ $this, 'plugin_updated_check' ] );
			add_action( 'mv_grow_plugin_updated', [ $this, 'relicense' ], 10 );
			add_action( 'wp_loaded', [ $this, 'relicense_check' ] );

			register_activation_hook( mv_grow_get_activation_path(), [ $this, 'plugin_activation' ] );
			register_deactivation_hook( mv_grow_get_activation_path(), [ $this, 'plugin_deactivation' ] );
		}

		/**
		 * Runs hook at plugin activation.
		 *
		 * The update hook will run a bit later through its own hook.
		 *
		 * @return void
		 */
		public function plugin_activation() {
			do_action( 'mv_grow_plugin_activated' );
		}

		/**
		 * Runs hook at plugin update.
		 *
		 * This runs after all plugins are loaded so it can run after update. It also performs a
		 * check based on version number, just in case someone updates in a non-conventional way.
		 * After completing hooks, Grow version number is updated in the db.
		 *
		 * @return void
		 */
		public function plugin_updated_check() {
			// Only progress if version has changed
			if ( get_option( 'mv_grow_version' ) === self::$VERSION ) {
				return;
			}

			do_action( 'mv_grow_plugin_updated' );
			update_option( 'mv_grow_version', self::$VERSION );
		}

		/**
		 * Runs hook at plugin deactivation.
		 *
		 * @return void
		 */
		public function plugin_deactivation() {
			do_action( 'mv_grow_plugin_deactivated' );
		}

		/**
		 * Checks to make sure there's a license, and runs relicense if not found
		 *
		 * @return void
		 */
		public function relicense_check() {
			if ( ! get_option( 'mv_grow_license' ) ) {
				$this->relicense();
			}
		}

		public function relicense() {
			if ( get_transient( 'mv_grow_relicense_lockout' ) == 'LOCK' ) {
				return;
			}
			set_transient( 'mv_grow_relicense_lockout', 'LOCK', 300 );
			$settings     = get_option( 'dpsp_settings', [] );
			$grow_license = get_option( 'mv_grow_license', false );

			// Remove serial key if it exists, we don't want it exposed
			if ( empty( $settings['product_serial'] ) ) {
				return;
			}

			if ( ! empty( $settings['mv_grow_license'] ) ) {
				return;
			}

			$params = [
				'serial' => $settings['product_serial'],
				'url'    => get_site_url(),
			];

			$url_string = http_build_query( $params );
			$response   = wp_remote_get( 'https://marketplace.mediavine.com/wp-json/mv-edd/v1/convert?' . $url_string );

			if ( ! is_array( $response ) || is_wp_error( $response ) ) {
				return;
			}
			$headers = $response['headers']; // array of http header lines
			$body    = json_decode( $response['body'] ); // use the content
			error_log( print_r( $body, true ) );
			if ( ! $body ) {
				error_log( 'No Body Response from Marketplace' );

				return;
			}
			if ( isset( $body->data ) && $body->data->status === 401 ) {
				error_log( 'Access to Marketplace REST API forbidden' );

				return;
			}
			if ( ! isset( $body->license ) ) {
				error_log( 'Response received but no license in response from Marketplace' );

				return;
			}
			if ( ! isset( $body->license->license_key ) ) {
				error_log( print_r( $body->license, true ) );
				error_log( 'License in response but missing actual key.' );

				return;
			}
			$settings['mv_grow_license'] = $body->license->license_key;
			update_option( 'dpsp_settings', $settings );
			update_option( 'mv_grow_license', $body->license->license_key );
			$KernlUpdater = new \MV_GROW_PRO_PluginUpdateChecker_2_0(
				'https://kernl.us/api/v1/updates/5d9de9137dd3c26d2ebaad23/',
				mv_grow_get_activation_path(),
				'social-pug',
				1,
				'Grow Social Pro by Mediavine',
				'external_updates-mv-grow'
			);

			$KernlUpdater->license = $body->license->license_key;
			add_filter( 'puc_check_now-social-pug', '__return_true' );
			$KernlUpdater->handleManualCheck();
		}

		function validate_license( $old_values, $new_values ) {
			$grow_license = $new_values['mv_grow_license'];
			update_option( 'mv_grow_license', $new_values['mv_grow_license'] );

			$params = [
				'edd_action' => 'activate_license',
				'item_id'    => '28',
				'license'    => $grow_license,
				'url'        => get_site_url(),
			];

			$url_string = http_build_query( $params );
			$result     = wp_remote_get( 'https://marketplace.mediavine.com/?' . $url_string );

			$KernlUpdater          = new \MV_GROW_PRO_PluginUpdateChecker_2_0(
				'https://kernl.us/api/v1/updates/5d9de9137dd3c26d2ebaad23/',
				mv_grow_get_activation_path(),
				'social-pug',
				1,
				'Grow Social Pro by Mediavine',
				'external_updates-mv-grow'
			);
			$KernlUpdater->license = $grow_license;
			add_filter( 'puc_check_now-social-pug', '__return_true' );
			$KernlUpdater->handleManualCheck();
		}

		function manage_grow_license( $old_values, $new_values ) {
			$grow_license = null;
			if (
				isset( $new_values['mv_grow_license'] ) &&
				( $old_values['mv_grow_license'] !== $new_values['mv_grow_license'] )
			) {
				$this->validate_license( $old_values, $new_values );
			}
		}
	}
}
