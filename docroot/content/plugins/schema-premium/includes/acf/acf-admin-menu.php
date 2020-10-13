<?php
/**
 * ACF admin menua item show/hide
 *
 * @package     Schema
 * @subpackage  Schema - ACF
 * @copyright   Copyright (c) 2018, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', 'schema_wp_acf_admin_menu', 100 );
/**
 * ACF admin mneu item show/hide
 *
 * @since 1.0.0
 *
 * return void
 */
function schema_wp_acf_admin_menu() {
	
	$acf_admin_menu_show = schema_wp_get_option( 'acf_admin_menu_show' );
	
	if ( function_exists( 'acf' ) && $acf_admin_menu_show != 'yes' ) {
	// ACF is active, and setting return true!
		
		add_filter('acf/settings/show_admin', '__return_false');
	}
}
