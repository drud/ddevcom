<?php
/**
 * Class Menu - admin menues
 *
 * @package     Schema
 * @subpackage  Admin Functions/Formatting
 * @copyright   Copyright (c) 2016, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
*/ 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class Schema_WP_Admin_Menu {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register_main_menus' 		),	10 );
		add_action( 'admin_menu', array( $this, 'register_types_menus' 		),  20 );
		add_action( 'admin_menu', array( $this, 'register_extensions_menus' ),  30 );
	}

	public function register_main_menus() {
		
		global $schema_wp_options_page;
		
		$schema_wp_options_page = add_menu_page(
			__( 'Schema', 'schema-premium' ),
			__( 'Schema', 'schema-premium' ),
			'manage_schema_options',
			'schema',
			'schema_wp_options_page'
		);
		
		add_submenu_page(
			'schema',
			__( 'Schema Settings', 'schema-premium' ),
			__( 'Settings', 'schema-premium' ),
			'manage_schema_options',
			'schema',
			'schema_wp_options_page'
		);
		
		// Contextual Help
		// @since 1.5.9.3
		if ( $schema_wp_options_page )
		add_action( 'load-' . $schema_wp_options_page, 'schema_wp_settings_contextual_help' );	
	}
	
	public function register_types_menus() {
		
		add_submenu_page(
			'schema',
			__( 'Types', 'schema-premium' ),
			__( 'Types', 'schema-premium' ),
			'manage_schema_options',
			'edit.php?post_type=schema'
		);
	}
	
	public function register_extensions_menus() {
		
		add_submenu_page(
			'schema',
			__( 'Extensions', 'schema-premium' ),
			__( 'Extensions', 'schema-premium' ),
			'manage_schema_options',
			'schema-extensions',
			'schema_wp_admin_extensions_page'
		);
	}

}

$schema_wp_menu = new Schema_WP_Admin_Menu;
