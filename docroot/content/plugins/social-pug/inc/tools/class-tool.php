<?php

namespace Mediavine\Grow\Tools;

abstract class Tool {

	/**
	 * @var array $metadata Associative array of metadata for this tool
	 */
	protected $metadata;

	/**
	 * @var string $slug Unique identifier for this tool e.g. floating-sidebar
	 */
	public $slug;

	/**
	 * @var string $name Displayed Name for this tool e.g. Floating Sidebar
	 */
	protected $name;

	/**
	 * @var string $type What type of tool this is
	 */
	protected $type;

	/**
	 * @var string $img Path to image for this tool
	 */
	protected $img;

	/**
	 * @var string $admin_page URL of WordPress admin page for this tool
	 */
	protected $admin_page;

	/**
	 * @var string[] $required_properties Properties all tools must have
	 */
	private $required_properties = ['slug','name', 'type', 'img', 'admin_page'];


	/**
	 * Construct action to run child init method
	 */
	public function __construct() {
		$this->init();
	}

	abstract public function init();

	public function load_properties($props) {
		foreach ($this->required_properties as $property_slug) {
			$this->{$property_slug} = $props[$property_slug];
			unset($props[$property_slug]);
		}
		$this->metadata = $props;
	}

	/**
	 * @param string $key Property key to get value for
	 *
	 * @return mixed Value of the property or false if it doesn't exist
	 */
	public function get_property( $key = '' ) {
		if ( empty( $key ) ) {
			return false;
		}
		if (property_exists($this, $key)) {
			return $this->{$key};
		}
		if ( array_key_exists( $key, $this->metadata ) ) {
			return $this->metadata[ $key ];
		}
		return false;
	}

	/**
	 * Get all properties including metadata for this tool
	 * @return array
	 */
	public function get_properties() {
		$properties = [];
		foreach($this->required_properties as $key) {
			$properties[$key] = $this->{$key};
		}
		return array_merge($this->metadata, $properties);
	}

}
