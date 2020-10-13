<?php
/**
 * Contextual Help
 *
 * @package     Schema
 * @subpackage  Admin/Settings
 * @copyright   Copyright (c) 2016, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.5.9.3
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Settings contextual help.
 *
 * @since       1.5.9.3
 * @return      void
 */
function schema_wp_settings_contextual_help() {
	
	$screen = get_current_screen();

	$screen->set_help_sidebar(
		'<p><strong>' . sprintf( __( 'For more information:', 'schema-premium' ) . '</strong></p>' .
		'<p>' . sprintf( __( 'Visit the <a href="%s">documentation</a> on the schema.press website.', 'schema-premium' ), esc_url( 'https://schema.press/docs/' ) ) ) . '</p>' .
		'<p>' . sprintf(
					__( 'View <a href="%s">extensions</a>', 'schema-premium' ),
					esc_url( 'https://schema.press/docs/?utm_source=plugin-settings-page&utm_medium=contextual-help-sidebar&utm_term=extensions&utm_campaign=ContextualHelp' )
					) . '</p>'
	);

	$screen->add_help_tab( array(
		'id'	    => 'schema-wp-settings-general',
		'title'	    => __( 'General', 'schema-premium' ),
		'content'	=> '<p>' . __( 'This screen provides the most basic settings for configuring Schema plugin on your site. You can set Schema for About and Contact pages, and turn automatic <em>Feature image</em> on and off...etc', 'schema-premium' ) . '</p>'
	) );
	
	$screen->add_help_tab( array(
		'id'	    => 'schema-wp-settings-knowledge-graph',
		'title'	    => __( 'Knowledge Graph', 'schema-premium' ),
		'content'	=> '<p>' . __( 'This screen provides settings for configuring the Knowledge Graph. You can set Organization Info, Search Results, Social Profiles, and Corporate Contacts.', 'schema-premium' ) . '</p>'
	) );
	
	$screen->add_help_tab( array(
		'id'	    => 'schema-wp-settings-schemas',
		'title'	    => __( 'Schemas', 'schema-premium' ),
		'content'	=> '<p>' . __( 'This screen provides settings for configuring Schemas.', 'schema-premium' ) . '</p>'
	) );
	
	/*
	$screen->add_help_tab( array(
		'id'		=> 'schema-wp-settings-extensions',
		'title'		=> __( 'Extensions', 'schema-premium' ),
		'content'	=> '<p>' . __( 'This screen provides access to settings added by most Schema extensions.', 'schema-premium' ) . '</p>'
	) );
	*/
	
	$screen->add_help_tab( array(
		'id'	    => 'schema-wp-settings-advanced',
		'title'	    => __( 'Advanced', 'schema-premium' ),
		'content'	=>
			'<p>' . __( 'This screen provides advanced options such as deleting plugin data on uninstall.', 'schema-premium' ) . '</p>' .
			'<p>' . __( 'A description of all the options are provided beside their input boxes.', 'schema-premium' ) . '</p>'
	) );

	do_action( 'schema_wp_settings_contextual_help', apply_filters( 'schema_wp_contextual_help', $screen ) );
}
