<?php
/**
 * @package Schema Premium - Extension : Custom Markup
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'schema_singular_output', 'schema_premium_custom_json_markup_output' );
/**
 * Output Markup
 *
 * @since 1.0.0
 */
function schema_premium_custom_json_markup_output( $schema ) {
	
	global $post;

	if ( empty($schema) ) return;
	
	$custom_json = schema_premium_get_custom_markup( $post->ID );

	if ( ! empty( $custom_json ) && is_array( $custom_json ) ) {

		$json_override = get_post_meta( $post->ID, 'schema_custom_json_override', true);

		if ( isset($json_override) ) {
		
			if ( $json_override == 1 ) {
				
				// True
				return $custom_json;

			} elseif ( $json_override == 0 ) {

				// False
				$schema = array_merge( $schema, $custom_json );

			}
		}
	}
	
	return $schema;
}

/**
 * Get Custom Markup 
 *
 * @since 1.0.0
 *
 * return array
 */
function schema_premium_get_custom_markup( $post_id ) {
	
	if ( ! isset($post_id) )
		return;

	$custom_markup = array();
	
	if( function_exists('have_rows') ) {

		// check if the repeater field has rows of data
		if( have_rows('field_schema_custom_json_repeater', $post_id ) ):
			
			// loop through the rows of data
			while ( have_rows('field_schema_custom_json_repeater', $post_id ) ) : the_row();

				// display a sub field value
				$custom_json 		= get_sub_field('schema_custom_json');
				$custom_markup[] 	= json_decode( $custom_json, true );

			endwhile;

		else :
			// no rows found

		endif;

	} // end if function_exists

	return $custom_markup;
}


add_action( 'acf/init', 'schema_premium_custom_json_acf_field', 999 );
/**
 * Post meta
 *
 * @since 1.0
 */
function schema_premium_custom_json_acf_field() {

	if( function_exists('acf_add_local_field') ):
		
		// Add tab
		//
		acf_add_local_field( array(
			'key' 		=> 'field_schema_custom_json_tab',
			'name' 		=> 'schema_custom_json_tab',
			'label' 	=> __('Custom Markup', 'schema-premium'),
			'type' 		=> 'tab',
			'parent' 	=> 'group_schema_properties',
			'placement' => 'left',
			'endpoint'	=> 0,
		) );
		
		// Get setting for display instructions
		//
		$instructions_enable = schema_wp_get_option( 'properties_instructions_enable' );
		$instructions 		 = ( 'yes' == $instructions_enable ) ? __('Add valid custom schema.org markup in json-ld format here to be used for this entry.', 'schema-premium') : '';
		
		// Repeater
		// 
		// sameAs repeater
		acf_add_local_field( array(
			'key'          => 'field_schema_custom_json_repeater',
			'label'        => __('JSON-LD', 'schema-premium'),
			'name'         => 'schema_custom_json_repeater',
			'type'         => 'repeater',
			'parent'       => 'group_schema_properties',
			'instructions' => $instructions,
			'layout' 	   => 'table',
			'button_label' => __('Add code', 'schema-premium'),
		) );

		// Sub Field
		// 
		// Custom JSON-LD code 
		acf_add_local_field(array(
			'key' 			=> 'feild_schema_custom_json',
			'label' 		=> __('Markup code in json-ld format', 'schema-premium'),
			'name' 			=> 'schema_custom_json',
			'type' 			=> 'textarea',
			'parent' 		=> 'field_schema_custom_json_repeater',
			'markup_value' 	=> 'disabled',
			'instructions' 	=> '',
			'placeholder' 	=> __('Place valid custom json-ld code here!', 'schema_premium'),
		));

		$instructions 		 = ( 'yes' == $instructions_enable ) ? __('By default, custom markup is added to the entry markup ouput. You can set this option to override markup on this entry.', 'schema-premium') : '';

		// Sub Field
		// 
		// Custom JSON-LD code 
		acf_add_local_field(array(
			'key' 			=> 'feild_schema_custom_json_override',
			'label' 		=> __('Override Markup?', 'schema-premium'),
			'name' 			=> 'schema_custom_json_override',
			'type' 			=> 'true_false',
			'parent' 		=> 'group_schema_properties',
			'markup_value'	=> 'disabled',
			'default_value' => 0,
			'instructions' 	=> $instructions,
			'ui' 			=> 1,
			'ui_on_text' 	=> __('Yes', 'schema-premium'),
			'ui_off_text' 	=> __('No', 'schema-premium'),
		));
		
	endif;
}
