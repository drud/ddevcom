<?php
/**
 * ACF Extensions register - loader class
 *
 * @package     Schema
 * @subpackage  Schema ACF Extensions
 * @copyright   Copyright (c) 2018, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


// check if class already exists
if( !class_exists('schema_acf_load_extension_fields') ) :

class schema_acf_load_extension_fields {
	
	// vars
	var $settings;
	
	
	/*
	*  __construct
	*
	*  This function will setup the class functionality
	*
	*  @type	function
	*  @since	1.0.0
	*
	*  @param	void
	*  @return	void
	*/
	
	function __construct() {
		
		// settings
		// - these will be passed into the field class.
		//$this->settings = array(
			//'version'	=> '1.0.0',
			//'url'		=> plugin_dir_url( __FILE__ ),
			//'path'		=> plugin_dir_path( __FILE__ )
		//);
		
		
		// include field
		add_action('acf/include_field_types', 	array($this, 'include_field')); // v5
	}
	
	
	/*
	*  include_field
	*
	*  This function will include the field type class
	*
	*  @type	function
	*  @since	1.0.0
	*
	*  @param	$version (int) major ACF version. Defaults to 4
	*  @return	void
	*/
	
	function include_field() {
		
		// include
		include_once( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/acf/acf-extensions/acf-post-type-select.php');
		include_once( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/acf/acf-extensions/acf-post-formats-select.php');
		include_once( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/acf/acf-extensions/acf-post-statuses-select.php');
		include_once( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/acf/acf-extensions/acf-post-categories-select.php');
		include_once( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/acf/acf-extensions/acf-currencies-select.php');
		include_once( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/acf/acf-extensions/acf-countries-select.php');
		include_once( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/acf/acf-extensions/acf-address.php');
	}
	
}

// initialize
new schema_acf_load_extension_fields();

// class_exists check
endif;
	