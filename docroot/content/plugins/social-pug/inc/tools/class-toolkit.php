<?php

namespace Mediavine\Grow\Tools;

/**
 * Class Toolkit
 *
 * @package Mediavine\Grow\Tools
 */
class Toolkit {

	/** @var null */
	private static $instance = null;

	/** @var Tool[] Array of tool classes. */
	private $tools = [];

	/**
	 * @var string[] $required_metadata Array of slugs for metadata that is required for all tools to validate
	 */
	private static $required_metadata = [
		'name',
		'type',
		'img',
		'admin_page',
	];

	/**
	 * Get instance of Tool Container
	 * @return Toolkit
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self;
			self::$instance->init();
		}

		return self::$instance;
	}

	/**
	 * Tasks to be run on init
	 */
	public function init() {

	}

	/**
	 * Add a set of tools to this class.
	 *
	 * @param Tool[] $tools Array of Tools
	 *
	 * @return bool
	 */
	public function add( $tools = [] ) {
		if ( empty( $tools ) ) {
			return false;
		}

		// Filter out tools that don't have the required metadata
		$valid_tools = array_filter( $tools, 'self::validate' );

		// Create an associative array by pulling slugs off of each tool;
		$keyed_tools = array_combine( wp_list_pluck( $valid_tools, 'slug' ), $valid_tools );

		// Merge tools into new tools
		$this->tools = array_merge( $this->tools, $keyed_tools );

		return true;
	}

	/**
	 * Get all the tools registered with this class.
	 *
	 * @return Tool[]
	 */
	public function get_all() {
		return self::get_instance()->tools;
	}

	/**
	 * Get a tool by slug
	 *
	 * @param string $slug Slug for tool to get
	 *
	 * @return bool|Tool Tool if it exists, false if it doesn't exist or no slug passed in
	 */
	public function get( $slug = '' ) {
		if ( empty( $slug ) ) {
			return false;
		}
		$instance = self::get_instance();
		if ( ! isset( $instance->tools[ $slug ] ) ) {
			return false;
		}

		return $instance->tools[ $slug ];
	}

	/**
	 * @param Tool $tool Tool to validate
	 *
	 * @return bool Whether or not tool is valid
	 */
	public static function validate( $tool ) {
		return self::has_required_metadata( $tool ) && ! empty( $tool->slug );
	}

	/**
	 * Make sure tool has required metadata exists and is non empty
	 *
	 * @param Tool $tool Tool instance
	 *
	 * @return bool Whether or not the passed tool contains all required keys
	 */
	public static function has_required_metadata( $tool ) {
		$metadata = $tool->get_properties();
		// Filter out empty values
		$non_empty_metadata = array_filter(
			$metadata,
			function ( $value ) {
				return ! empty( $value );
			}
		);

		// Get Remaining Keys
		$meta_keys = array_keys( $non_empty_metadata );

		// Get required keys that are missing from the non-empty keys we have
		$missing_keys = array_diff( self::$required_metadata, $meta_keys );

		// If that array is empty, we have all keys
		return count( $missing_keys ) === 0;
	}

}
