<?php
/**
 * ACF Schema Properties Fields for Page Editor
 *
 * @package     Schema
 * @subpackage  Schema Post Meta ACF
 * @copyright   Copyright (c) 2018, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if( ! is_admin() ){
	// @since 1.0.6
    add_action('wp', 'schema_wp_premium_acf_field_properties', 99 );
} else {
    add_action('acf/init', 'schema_wp_premium_acf_field_properties', 99 );
}
/**
 * Meta Box
 *
 * @since 1.0.0
 */
function schema_wp_premium_acf_field_properties() {

	$post_id = schema_premium_get_post_ID();
	
	if ( !isset($post_id) ) return;
	
	$is_enabled 		= schema_premium_get_location_target_match( $post_id );
	$location_targets	= schema_wp_get_enabled_location_targets();
	
	// Debug
	//echo '<pre>'; print_r($location_targets); echo '</pre>'; exit;
	
	if ( empty($is_enabled) || ! is_array($is_enabled) ) return;
	
	// Get post type
	$post_type = schema_wp_get_current_post_type();
	
	// Get setting for display instructions
	$properties_instructions_enable = schema_wp_get_option( 'properties_instructions_enable' );
	
	if( function_exists('acf_add_local_field_group') ):
		
		// ACF Group: Properties
		//
		//
		acf_add_local_field_group(array (
			'key' => 'group_schema_properties',
			'title' => __('Schema Markup', 'schema-premium'),
			'location' => array (
				array (
					array (	 // custom location
						'param' => 'is_schema',
						'operator' => '==',
						'value' => 'true',
					),
					array ( // Exclude from schema post type
						'param' => 'post_type',
						'operator' => '!=',
						'value' => 'schema',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'left',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => 1,
			'description' => '',
		));

		// Add General Tab
		// @sice 1.1.2.8
		acf_add_local_field( array(
			'key' => 'field_schema_general_tab',
			'name' => 'schema_general_tab',
			'label' => __('General', 'schema-premium'),
			'type' => 'tab',
			'parent' => 'group_schema_properties',
			'placement' => 'left',
			'endpoint'	=> 0,
		) );
		
		// General Tab: Message
		// @sice 1.1.2.8
		acf_add_local_field(array(
			'key' 		=> 'field_schema_general_message',
			'label' 	=> ' ', // empty space
			'name' 		=> 'schema_general_message',
			'type' 		=> 'message',
			'parent' 	=> 'group_schema_properties',
			'message'	=> __('You can use these options to configure schema.org properties.', 'schema-premium')
		));

		$instructions = ( 'yes' == $properties_instructions_enable ) ? __('Disable schema.org markup on this entry.', 'schema-premium') : '';

		// General Tab: Enable/Ddisable markup
		// @sice 1.1.2.8
		acf_add_local_field(array(
			'key' 			=> 'feild_schema_disabled',
			'label' 		=> __('Disable Markup?', 'schema-premium'),
			'name' 			=> 'schema_disabled',
			'type' 			=> 'true_false',
			'parent' 		=> 'group_schema_properties',
			'default_value' => 0,
			'instructions' 	=> $instructions,
			'ui' 			=> 1,
			'ui_on_text' 	=> __('Yes', 'schema-premium'),
			'ui_off_text' 	=> __('No', 'schema-premium'),
		));

		// General Tab: Message Bottom (empty)
		//
		// NOTE: This is used to scape an issue in tab display
		// @sice 1.1.2.8
		acf_add_local_field(array(
			'key' 		=> 'field_schema_general_message_btm',
			'label' 	=> ' ', // empty space
			'name' 		=> 'schema_general_message_btm',
			'type' 		=> 'message',
			'parent' 	=> 'group_schema_properties',
			'message'	=> '',
		));

		// Get enabled count
		//
		$match_count = 0;
		foreach ( $is_enabled as $schema_ID => $enabled ) :
			if ($enabled['match']){
				$match_count++;
			}
		endforeach;

		foreach ( $is_enabled as $schema_ID => $enabled ) :
			
			// Run only on enabled location targets
			if ( $enabled['match'] ) {
				
				// Get final schema type
				//
				$schema_type 			= $enabled['schema_type'];
				$schema_default 		= schema_wp_get_default_schemas( $schema_type );
				$schema_type_properties	= $schema_default['properties'];
				
				// Debug
				//echo '<pre>'; print_r($schema_type_properties); echo '</pre>'; exit;
				
				if ( is_array($schema_type_properties) && !empty($schema_type_properties) ) {	
	
					// Get schema sub type lable from its unknown Class
					//
					if ( isset($enabled['schema_subtype']) && '' != $enabled['schema_subtype'] ) {
						$classname 					= 'Schema_WP_' . $enabled['schema_subtype'];
						$schema_class 				= (class_exists($classname)) ? new $classname : '';
						$enabled['schema_subtype'] 	= is_object($schema_class) ? $schema_class->label() : $enabled['schema_subtype'];
						$schema_type_properties		= is_object($schema_class) ? $schema_class->properties() : $schema_type_properties;
					}
					
					// Check if this is a Review type
					// Get itemReviewed properties and merge them
					// @since 1.2
					//
					if ( $schema_default['id'] == 'Review' ) {
						
						$itemReviewed_type	= get_post_meta( $schema_ID, '_properties_itemReviewed', true );
						
						if ( isset($itemReviewed_type) ) {
							$itemReviewed_classname 	= 'Schema_WP_' . $itemReviewed_type;
							if ( class_exists($itemReviewed_classname) ) {
								$itemReviewed = new $itemReviewed_classname;
								$itemReviewed_properties 	= $itemReviewed->properties();
								$schema_type_properties 	= array_merge( $schema_type_properties, $itemReviewed_properties );	
							} 
						}
						
						// Debug
						//echo '<pre>'; print_r($itemReviewed_properties); echo '</pre>'; exit;
					}
					
					$new_custom_field_enabled = schema_wp_recursive_array_search('new_custom_field', $schema_type_properties);
					$new_custom_field_enabled = ($new_custom_field_enabled == 'cssSelector') ? false : true;
					
					// Add tabs only if there is more than one schema type enabled
					//
					if ( $match_count >= 1 || $new_custom_field_enabled == true ) { 
						
						$type_label = isset($enabled['schema_subtype']) && '' != $enabled['schema_subtype'] ? $enabled['schema_subtype'] : $schema_default['lable'];
						
						// Append itemReviewed type to tab label
						// @since 1.2
						//
						if ( $schema_default['id'] == 'Review' ) {
							//$type_label = $type_label . ': ' . $itemReviewed_type;
							$type_label = $type_label . ': ' . $itemReviewed_properties[$itemReviewed_type.'_properties_info']['label'];
						}

						// Sub field tab: Start
						// 
						// Tab field
						//
						acf_add_local_field(array(
							'key' 		=> 'feild_schema_properties_tab_' . $schema_type,
							'label' 	=> $type_label,
							'name' 		=> 'schema_properties_tab_' . $schema_type,
							'type' 		=> 'tab',
							'placement' => 'left',
							'parent' 	=> 'group_schema_properties',
						));
					}
					
					// Display properties edit link button
					//
					$schema_type_edit_btn = '<a class="button" href="' . admin_url( 'post.php?post=' . $schema_ID ) . '&action=edit">' . __('Edit Properties', 'schema-premium') . '</a>';
					//
					//
					acf_add_local_field( array(
						'key' => 'field_schema_info_not_available_' . $schema_type,
						'name' => 'schema_info_not_available_' . $schema_type,
						'label' => ' ', // empty space!
						'message'	=> $schema_type_edit_btn . ' <span style="color:#999;">' . __('for schema.org type') . ' ' . $type_label . '</span>', 
						'type' => 'message',
						'parent' => 'group_schema_properties'
					) );
					
					// Display properties fields
					//
					if ( is_array($schema_type_properties) ):
						
						foreach ( $schema_type_properties as $properity => $details ) :
					
							$property_field = get_post_meta( $schema_ID, '_properties_' . $properity, true ); 
							$placeholder 	= '';
							
							if (   'new_custom_field' 		== $property_field // new custom field
								|| 'accept_user_rating' 	== $property_field // accept user rating
								|| 'accept_user_reviews' 	== $property_field // accept user reviews
								|| 'address' 				== $properity
								|| 'question_answer' 		== $properity
								|| 'howto_tools' 			== $properity
								|| 'howto_supplies' 		== $properity
								|| 'howto_steps' 			== $properity
								|| 'actor' 					== $properity
								|| 'geo' 					== $properity
								|| 'recipeIngredient' 		== $properity
								|| 'recipeInstructions' 	== $properity
								|| 'cssSelector' 			== $properity
								|| 'amenityFeature' 		== $properity
								|| 'spatialCoverage' 		== $properity
								|| 'images' 				== $properity
								
							) {
								
								if ( $properties_instructions_enable != 'yes' ) {
									$details['instructions'] = ''; // disable instructions 
								};
								
								// Rating fields
								// 
								// Remove rating property fields if ratingValue field is set to accept user rating,
								// or both fields are not set to a new custom field
								//
								// @since 1.0.2
								//
								if ( 'ratingValue' == $properity  || 'reviewCount' == $properity ) { 
									$property_field_ratingValue = get_post_meta( $schema_ID, '_properties_ratingValue', true );
									$property_field_reviewCount = get_post_meta( $schema_ID, '_properties_reviewCount', true );
									if ( 'accept_user_rating' == $property_field_ratingValue ) 
										continue;
									if ( 'new_custom_field' != $property_field_ratingValue  && 'new_custom_field' != $property_field_reviewCount ) 
										continue;
								}
								// User Reviews fields
								// 
								// Remove rating property fields if ratingValue field is set to accept user reviews,
								// or both fields are not set to a new custom field
								//
								// @since 1.1.2
								//
								if ( 'ratingValue' == $properity || 'reviewCount' == $properity ) { 
									$property_field_ratingValue = get_post_meta( $schema_ID, '_properties_ratingValue', true );
									$property_field_reviewCount = get_post_meta( $schema_ID, '_properties_reviewCount', true );
									if ( 'accept_user_reviews' == $property_field_ratingValue ) 
										continue;
									if ( 'new_custom_field' != $property_field_ratingValue  && 'new_custom_field' != $property_field_reviewCount ) 
										continue;
								}
								
								// cssSelector field 
								// 
								// Remove cssSelector field if disable, 
								// also, check for isAccessibleForFree if is disabled
								//
								// @since 1.1.2.5
								//
								if ( 'cssSelector' == $properity ) { 
									$cssSelector_name 	= get_post_meta( $schema_ID, '__properties_cssSelector_name', true );
									$isAccessibleForFree = get_post_meta( $schema_ID, '_properties_isAccessibleForFree', true );
									if ( 'disabled' == $cssSelector_name || 'disabled' == $isAccessibleForFree )
										continue;
								}

								if ( 'images' == $properity ) { 
									$image_id = get_post_meta( $schema_ID, '__properties_image_id', true );
									if ( 'new_custom_field' != $image_id  && 'new_custom_field' != $image_id ) 
										continue;
								}

								// Sub field
								// 
								// Property field
								acf_add_local_field(array(
									'key' 				=> 'feild_schema_properties_' . $schema_type . '_' . $properity,
									'label' 			=> isset($details['label']) ? $details['label'] : '',
									'name' 				=> 'schema_properties_' . $schema_type . '_' . $properity,
									'type' 				=> isset($details['field_type']) ? $details['field_type'] : '',
									//'sub_fields'		=> isset($details['sub_fields']) ? $details['sub_fields'] : '',
									'choices'			=> !empty($details['choices']) ? $details['choices'] : '',
									'multiple'			=> isset($details['multiple']) ? $details['multiple'] : '',
									'parent' 			=> 'group_schema_properties',
									'default_value' 	=> '',
									'display_format' 	=> isset($details['display_format']) ? $details['display_format'] : '',
									'return_format' 	=> isset($details['return_format']) ? $details['return_format'] : '',
									'required' 			=> isset($details['required']) ? $details['required'] : '',
									'instructions' 		=> isset($details['instructions']) ? $details['instructions'] : '',
									'message' 			=> isset($details['message']) ? $details['message'] : '',
									'button_label' 		=> isset($details['button_label']) ? $details['button_label'] : '',
									'placeholder' 		=> isset($details['placeholder']) ? $details['placeholder'] : '',
									'rows' 				=> isset($details['rows']) ? $details['rows'] : '',
									'ui' 				=> isset($details['ui']) ? $details['ui'] : '',
									'ui_on_text' 		=> isset($details['ui_on_text']) ? $details['ui_on_text'] : '',
									'ui_off_text' 		=> isset($details['ui_off_text']) ? $details['ui_off_text'] : '',
									'ajax' 				=> isset($details['ajax']) ? $details['ajax'] : '',
									'allow_null' 		=> isset($details['allow_null']) ? $details['allow_null'] : '',
									'layout'			=> isset($details['layout']) ? $details['layout'] : 'table',
								));
								
								// Sub Sub fields
								//
								// For Group and Repeated fields
								if ( isset($details['sub_fields']) && ! empty($details['sub_fields']) ) {
									foreach ( $details['sub_fields'] as $sub_field => $sub_field_details) :
										
										//echo '<pre>'; print_r($sub_field_details); echo '</pre>';
										$property_sub_field = get_post_meta( $schema_ID, '__properties_' . $sub_field, true );
										
										if ( 'new_custom_field' == $property_sub_field ) {
											acf_add_local_field(array(
												'key' 				=> 'feild_schema_properties_' . $schema_type . '_' . $sub_field,
												'label' 			=> isset($sub_field_details['label']) ? $sub_field_details['label'] : '',
												'name' 				=> $sub_field,
												'type' 				=> isset($sub_field_details['field_type']) ? $sub_field_details['field_type'] : '',
												'sub_fields'		=> isset($sub_field_details['sub_fields']) ? $sub_field_details['sub_fields'] : '',
												'choices'			=> !empty($sub_field_details['choices']) ? $sub_field_details['choices'] : '',
												'multiple'			=> isset($sub_field_details['multiple']) ? $sub_field_details['multiple'] : '',
												'parent' 			=> 'feild_schema_properties_' . $schema_type . '_' . $properity,
												'default_value' 		=> '',
												'display_format' 	=> isset($sub_field_details['display_format']) ? $sub_field_details['display_format'] : '',
												'return_format' 	=> isset($sub_field_details['return_format']) ? $sub_field_details['return_format'] : '',
												'required' 			=> isset($sub_field_details['required']) ? $sub_field_details['required'] : '',
												'instructions' 		=> isset($sub_field_details['instructions']) ? $sub_field_details['instructions'] : '',
												'message' 			=> isset($sub_field_details['message']) ? $sub_field_details['message'] : '',
												'button_label' 		=> isset($sub_field_details['button_label']) ? $sub_field_details['button_label'] : '',
												'placeholder' 		=> isset($sub_field_details['placeholder']) ? $sub_field_details['placeholder'] : '',
												'rows' 				=> isset($sub_field_details['rows']) ? $sub_field_details['rows'] : '',
												'ui' 				=> isset($sub_field_details['ui']) ? $sub_field_details['ui'] : '',
												'ui_on_text' 		=> isset($sub_field_details['ui_on_text']) ? $sub_field_details['ui_on_text'] : '',
												'ui_off_text' 		=> isset($sub_field_details['ui_off_text']) ? $sub_field_details['ui_off_text'] : '',
												'ajax' 				=> isset($sub_field_details['ajax']) ? $sub_field_details['ajax'] : '',
												'allow_null' 		=> isset($sub_field_details['allow_null']) ? $sub_field_details['allow_null'] : '',
												'wrapper' => array (
													'width' => isset($sub_field_details['width']) ? $sub_field_details['width'] : '',
												),
											));
										}

									endforeach;
								}
								
							} else { // else : new_custom_field
								//$get_stuff = $location_targets[$schema_ID];
								//echo'<pre>'; print_r($get_stuff); echo '</pre>';
								//echo $location_targets[$schema_ID]['enabled_on']['all_singulars'];exit;
								
								// Find out if there is a property set to display a new custom field
								// @since 1.0.7
								$is_new_custom_field_found = schema_wp_recursive_array_search( 'new_custom_field', $schema_type_properties );
								if (!$is_new_custom_field_found) {
									// Display message when properities are not set
									if ( 'new_custom_field' != $property_field 
										&& !isset($location_targets[$schema_ID]['enabled_on']['all_singulars']) 
										&& !empty($location_targets[$schema_ID]['enabled_on']['post_type']) 
									
										|| isset($location_targets[$schema_ID]['enabled_on']['all_singulars']) 
										&& $location_targets[$schema_ID]['enabled_on']['all_singulars'] == true 
									) {
										acf_add_local_field( array(
											'key' => 'field_schema_info_no_properties_are_set',
											'name' => 'schema_schema_info_no_properties_are_set',
											'label' => '<span style="color:#999;">' . __('No properties are set!', 'schema-premium') . '</span>',
											'instructions'	=> '', 
											'message' => '<span class="dashicons dashicons-info" style="color:#999;"></span> '.__('You can set property fields to "New Custom Field" in Schema > Types for fields to show here.', 'schema-premium'), 
											'type' => 'message',
											'parent' => 'group_schema_properties'
										) );
									} //End if : new_custom_field 
								} // End if : is_new_custom_field_found
							}
			
						endforeach; // End foreach
						
					endif; // End if
					
				} // End if ! empty array 
					
			} else {

				// Display message on new post creation, when post id is not available yet!
				// @since 1.0.6
				//if ( sp_is_edit_page('new') && $post_id == 0 && !$enabled['match'] && $post_type === null 
				// @since 1.0.7 (modified this line again
				if ( sp_is_edit_page('new') && $post_id == 0 && !$enabled['match']
					&& !empty($location_targets[$schema_ID]['enabled_on']['post_type']) 
					//&& $location_targets[$schema_ID]['enabled_on']['post_type'] == false 
				) {

					// Sub field tab: Start
					// 
					// Tab field
					acf_add_local_field(array(
						'key' 		=> 'feild_schema_properties_tab',
						'label' 	=> '<span class="dashicons dashicons-info" style="color:#999;"></span><span style="color:#999;">' . __('Not available!', 'schema-premium') . '</span>',
						'name' 		=> 'schema_properties_tab',
						'type' 		=> 'tab',
						'placement' => 'left',
						'parent' 	=> 'group_schema_properties',
					));

					acf_add_local_field( array(
						'key' => 'field_schema_info_not_available',
						'name' => 'schema_info_not_available',
						'label' => ' ', // empty space
						'message'	=> '<span class="dashicons dashicons-info" style="color:#999;"></span> ' . __('Properties maybe not be available before saving the post!', 'schema-premium') . '('. __('If you are using Gutenberg editor, save and refresh the post') . ')', 
						'type' => 'message',
						'parent' => 'group_schema_properties'
					) );
				}
			} // Enf if match
			
		endforeach;
	endif;
}
