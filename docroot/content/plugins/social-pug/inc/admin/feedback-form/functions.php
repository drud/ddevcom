<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Enqueue admin scripts for the feedback form
 *
 */
function dpsp_enqueue_admin_scripts_feedback() {

	// Plugin styles
	wp_register_style( 'dpsp-style-feedback', DPSP_PLUGIN_DIR_URL . 'inc/admin/feedback-form/assets/css/style-admin-feedback-form.css', array(), DPSP_VERSION );
	wp_enqueue_style( 'dpsp-style-feedback' );

	// Plugin script
	wp_register_script( 'dpsp-script-feedback', DPSP_PLUGIN_DIR_URL . 'inc/admin/feedback-form/assets/js/script-admin-feedback-form.js', array( 'jquery' ), DPSP_VERSION );
	wp_enqueue_script( 'dpsp-script-feedback' );

}
add_action( 'dpsp_enqueue_admin_scripts', 'dpsp_enqueue_admin_scripts_feedback' );


/**
 * Outputs the feedback form in the admin footer
 *
 */
function dpsp_output_feedback_form() {

	if( empty( $_GET['page'] ) || false === strpos( $_GET['page'], 'dpsp' ) )
		return;

	include 'views/view-feedback-form.php';

}
add_action( 'admin_footer', 'dpsp_output_feedback_form' );