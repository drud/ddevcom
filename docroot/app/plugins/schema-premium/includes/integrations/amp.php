<?php
/**
 * AMP plugin integration
 *
 *
 * plugin url: https://wordpress.org/plugins/amp/
 * @since 1.3
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'amp_post_template_metadata', 'schema_premium_amp_remove_markup', 10, 2 );
/**
 * Remove AMP schema.org markup
 *
 * @since 1.1.2.3
 */
function schema_premium_amp_remove_markup( $metadata, $post ) {

	$enabled = schema_wp_get_option( 'amp_enabled' );
	
	if ( $enabled == 'disabled' ) {
		return;
	}

	return $metadata;
}

add_action( 'amp_post_template_head', 'schema_premium_amp_markup_output', 20 );
/**
 * Output the generated schema.org markup type on enabled AMP posts
 *
 * @since 1.1.2.3
 */
function schema_premium_amp_markup_output() {

	global $post;

	$enabled = schema_wp_get_option( 'amp_enabled' );
	
	if ( $enabled == 'disabled' ) {
		return;
	}

	if ( ! isset($post->ID) || ! is_singular() )
		return;

	$json = array();

	// Get AMP plugin settings
	$options = get_option('amp-options');
	
	// Check if this is the About, Contact page, or Checkout page
	// If so, get the correct schema,org markup
	//
	if ( is_array($options['supported_post_types']) ) {
		
		if ( in_array("page", $options['supported_post_types']) ) {
		
			$about_page_id 	 	= schema_wp_get_option( 'about_page' );
			$contact_page_id 	= schema_wp_get_option( 'contact_page' );
			$checkout_page_id	= schema_wp_get_option( 'checkout_page' );
	
			if ( isset($about_page_id) && $post->ID == $about_page_id ) {
				if ( class_exists('Schema_WP_SpecialPage_AboutPage') ) {
					$schema_about_page = new Schema_WP_SpecialPage_AboutPage;  
					//$json = $schema_about_page->get_markup();
					$schema_about_page->output_markup();
					return;
				}
			}  
			if ( isset($contact_page_id) && $post->ID == $contact_page_id) {
				if ( class_exists('Schema_WP_ContactPage') ) {
					$schema_contact_page = new Schema_WP_ContactPage;  
					//$json = $schema_contact_page->get_markup();
					$schema_contact_page->output_markup();
					return;
				}
			}	
			if ( isset($checkout_page_id) && $post->ID == $checkout_page_id) {
				if ( class_exists('Schema_WP_SpecialPage_CheckoutPage') ) {
					$schema_checkout_page = new Schema_WP_SpecialPage_CheckoutPage;  
					//$json = $schema_checkout_page->get_markup();
					$schema_checkout_page->output_markup();
					return;
				}
			}
			
		} // end if
	} // end if
	
	// Output the enabled schema.org markup type for this content
	$schema = new Schema_WP_Output();
	$schema->do_schema();
}

add_action( 'admin_init', 'schema_premium_amp_register_settings', 1 );
/*
* Register settings 
*
* @since 1.1.2.8
*/
function schema_premium_amp_register_settings() {
	
	add_filter( 'schema_wp_settings_integrations', 'schema_premium_amp_settings', 10 );
}

/*
* Settings 
*
* @since 1.1.2.8
*/
function schema_premium_amp_settings( $settings ) {

	$info = ' <span style="color:#8a8a8a;margin-top:3px;" class="dashicons dashicons-admin-plugins"></span>';

	if ( defined( 'AMP__VERSION' ) ) {
		$info = ' <span style="color:#48b142;margin-top:3px;" class="dashicons dashicons-admin-plugins"></span>';
	}
	
	$settings['main']['amp_enabled'] = array(
		'id' => 'amp_enabled',
		'name' => __( 'AMP', 'schema-premium' ),
		'desc' => $info,
		'type' => 'select',
		'options' => array(
			'enabled'	=> __( 'Enabled', 'schema-premium'),
			'disabled'	=> __( 'Disabled', 'schema-premium')
		),
		'std' => 'enabled',
		'tooltip_title' => __('When enabled', 'schema-premium'),
		'tooltip_desc' => __('Schema Premium will override AMP schema.org output with more advannced markup.', 'schema-premium'),
	);
	
	return $settings;
}
