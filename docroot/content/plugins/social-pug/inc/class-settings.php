<?php
namespace Mediavine\Grow;

class Settings extends \Social_Pug {

	private static $instance = null;

	private $no_setting_flag = 'NO_SETTING';

	/**
	 * Get instance of Class
	 * @return Settings
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
			self::$instance->init();
		}

		return self::$instance;
	}

	/**
	 *  Set up hooks
	 */
	public function init() {
	}

	/**
	 * Internal get settings implementation,Allows the output to be filtered, and set via Query Parameters for QA
	 *
	 * @param string $slug
	 * @param mixed $default
	 *
	 * @return mixed
	 */
	private function get_setting_internal( $slug, $default = [] ) {
		$setting = get_option( $slug, $default );

		$setting = apply_filters( 'mv_grow_setting_' . $slug, $setting );
		if ( apply_filters( 'mv_grow_flag_allow_settings_query', false ) ) {
			// For QA purposes, allow settings to be programmatically set via query params, this code should only be reachable in development
			$parsed_setting = $this->parse_setting_from_query( $slug );
			if ( $parsed_setting !== $this->no_setting_flag ) {
				if ( ! is_array( $setting ) ) {
					$setting = $parsed_setting;
				} else {
					$setting = array_merge( $setting, $parsed_setting );
				}
			}
		}

		return $setting;
	}

	/**
	 * Public facing static get setting method, uses the same function signature as the native WordPress get option for easy replacement
	 * @param string $slug
	 * @param array $default
	 *
	 * @return mixed
	 */
	public static function get_setting( $slug, $default = [] ) {
		$settings_instance = self::get_instance();

		return $settings_instance->get_setting_internal( $slug, $default );
	}

	/**
	 * Get settings values from the Get Query Parameter
	 * Warning, this path should not be able to be reached in production
	 * @param string $slug Setting slug to look for
	 *
	 * @return array|mixed
	 */
	public function parse_setting_from_query( $slug ) {
		return $_GET && isset( $_GET[ $slug ] ) ? $_GET[ $slug ] : $this->no_setting_flag;
	}
}
