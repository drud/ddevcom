<?php
/**
 * Notices
 *
 * @package     Schema
 * @subpackage  Admin Functions/Notices
 * @copyright   Copyright (c) 2018, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class Schema_WP_Admin_Notices {

	public function __construct() {

		// Get settings
		//
		$settings = get_option('schema_wp_settings' ); 
		
		// Notice: ACF PRO is not installed, and loading included ACF PRO is set to disabled
		//
		if ( ! class_exists('acf_pro') && isset($settings['acf_load']) && $settings['acf_load'] == 'disabled' ) {
			
			add_action( 'admin_notices', array( $this, 'acf_required' ) );
		}
		
		// Notice: ACF free is installed, and ACF PRO is not!
		//
		if ( class_exists( 'acf' )  && ! class_exists('acf_pro') ) {
			
			add_action( 'admin_notices', array( $this, 'acf_free' ) );
		}

		// Notice: save settings
		//
		add_action( 'admin_notices', array( $this, 'show_notices' ) );
		add_action( 'schema_wp_dismiss_notices', array( $this, 'dismiss_notices' ) );
	}


	public function show_notices() {

		$class = 'updated';

		if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] && isset( $_GET['page'] ) && $_GET['page'] == 'schema' ) {
			$message = __( 'Settings updated.', 'schema-premium' );
			
			// do action after settings updated
			do_action( 'schema_wp_do_after_settings_updated' );
		}

		if ( isset( $_GET['schema_wp_notice'] ) && $_GET['schema_wp_notice'] ) {

			switch( $_GET['schema_wp_notice'] ) {

				case 'settings-imported' :

					$message = __( 'Settings successfully imported', 'schema-premium' );

					break;

			}
		}

		if ( ! empty( $message ) ) {
			echo '<div class="' . esc_attr( $class ) . '"><p><strong>' .  $message  . '</strong></p></div>';
		}

	}

	/**
	 * Dismiss admin notices when Dismiss links are clicked
	 *
	 * @since 1.0
	 * @return void
	 */
	function dismiss_notices() {
		if( ! isset( $_GET['schema_wp_dismiss_notice_nonce'] ) || ! wp_verify_nonce( $_GET['schema_wp_dismiss_notice_nonce'], 'schema_wp_dismiss_notice') ) {
			wp_die( __( 'Security check failed', 'schema-premium' ), __( 'Error', 'schema-premium' ), array( 'response' => 403 ) );
		}

		if( isset( $_GET['schema_wp_notice'] ) ) {
			update_user_meta( get_current_user_id(), '_schema_wp_' . $_GET['schema_wp_notice'] . '_dismissed', 1 );
			wp_redirect( remove_query_arg( array( 'schema_wp_action', 'schema_wp_notice' ) ) );
			exit;
		}
	}

	/**
	 * Show a warning to sites with ACF PRO disabled 
	 *
	 * @access public
	 * @since 1.1.2.8
	 * @return void
	 */
	public function acf_required() {
		
		$settings_url = admin_url( $path = 'admin.php?page=schema&tab=advanced', 'admin' );

		echo '<div class="error">
				<p>' . __( 'Please, activate Advanced Custom Fields (ACF) plugin for Schema Premium to work properly!</p>
				<p>
					<ul>
						<li>ACF PRO plugin : <span style="color:red">Deactivated</span></li>
						<li>ACF PRO included in Schema Premium: <span style="color:red">Disabled</span></li>
					</ul>
				</p>
				</p><p>Enable loading ACF PRO plugin within Schema settings. <a class="button" href="'.$settings_url.'">Go to Schema Settings</a></p>
				<p style="font-size:smaller">The Schema Premium plugin includes Advanced Custom Fields PRO (ACF PRO) plugin in its core, 
				this means when you install Schema Premium you will have the latest ACF PRO version loaded to your site.', 'schema-premium' ) 
				. ' <a target="_blank" href="https://schema.press/docs-premium/advanced-custom-fields-pro/">'.__('Learn more', 'schema-premium').'</a>
				</p>
				</div>';
	}

	/**
	 * Show a warning to sites installing ACF free plugin
	 *
	 * @access public
	 * @since 1.0.6
	 * @return void
	 */
	public function acf_free() {
		echo '<div class="error">
				<p>' . __( 'Please, deactivate the free Advanced Custom Fields (ACF) plugin for Schema Premium to work properly! 
				<br><br>The Schema Premium plugin includes Advanced Custom Fields PRO (ACF PRO) plugin in its core, 
				this means when you install Schema Premium you will have the latest ACF PRO version loaded to your site.', 'schema-premium' ) 
				. ' <a target="_blank" href="https://schema.press/docs-premium/advanced-custom-fields-pro/">'.__('Learn more', 'schema-premium').'</a>
				</p>
			</div>';
	}

}
new Schema_WP_Admin_Notices;
