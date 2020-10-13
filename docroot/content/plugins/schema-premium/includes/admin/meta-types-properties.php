<?php
/**
 * Schema Type Post Meta Box
 *
 * @package     Schema
 * @subpackage  Schema Post Meta
 * @copyright   Copyright (c) 2018, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'schema_wp_types_acf_field_properties' );
/**
 * Schema.org types poost meta group
 *
 * @since 1.0.0
 */
function schema_wp_types_acf_field_properties() {
	
	$post_id 				= schema_premium_get_post_ID();
	$schema_type 			= get_post_meta( $post_id, '_schema_type', true );
	$schema_subtype 		= get_post_meta( $post_id, 'schema_subtype', true );
	$schema_comment 		= get_post_meta( $post_id, '_schema_comment', true );
	$schema_default 		= schema_wp_get_default_schemas( $schema_type );
    $schema_type_properties	= isset($schema_default['properties']) ? $schema_default['properties'] : array();
	$subtype_choices 		= array();
	$type_info				= ' (<a target="_blank" href="https://schema.org/' . $schema_type . '">' . __('Learn more') . '</a>)';
	
	if( function_exists('acf_add_local_field_group') ):
		
		// ACF Group: Schema Type Info
		//
		//
		acf_add_local_field_group(array (
			'key' => 'schema_group',
			'title' => __('Schema Type', 'schema-premium'),
			'location' => array (
				array (
					array (	 // custom locations
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'schema',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'left',
			'instruction_placement' => 'field',
			'hide_on_screen' => '',
			'active' => 1,
			'description' => '',
		));
		
		acf_add_local_field( apply_filters( 'schema_wp_info_post_meta_options', array(
			'key' => 'field_schema_info',
			'name' => 'schema_info',
			'label' => '<span style="color:#c90000;">' . $schema_type . '</span>',
			'instructions'	=> '', 
			'message'	=> isset($schema_comment) ? $schema_comment . $type_info : __('Description is not available for this type!', 'schema-premium'), 
			'type' => 'message',
			'parent' => 'schema_group',
			'wrapper' => array (
				'width' => '50',
			)
		) ) );
		
		/**
		* Create Sub Types
		*/
		if ( !empty($schema_default) && !empty($schema_default['subtypes']) ) {
	
			// Add sub types to options
			foreach ($schema_default['subtypes'] as $sub_type => $sub_type_lable ) {
				$new_choice = array (
					$sub_type => $sub_type_lable
				);
				$subtype_choices = array_merge($subtype_choices, $new_choice);
			}
		
			$default_value = get_post_meta( $post_id, 'schema_subtype', true );
		
			acf_add_local_field( apply_filters( 'schema_wp_sub_types_post_meta_options', array(
				'key' => 'field_schema_subtype',
				'name' => 'schema_subtype',
				'label' => $schema_type . ' ' . __('Type', 'schema-premium'),
				'instructions' => __('Select more specific type of', 'schema-premium') . ' ' . $schema_type, // description
				'type' => 'select',
				'parent' => 'schema_group',
				'wrapper' => array (
					'width' => '50',
				),
				'choices' => $subtype_choices,
				'default_value' => $default_value,
				'return_format' => 'value', // or array
				'allow_null' => 1,
				'ui' => 1
			) ) );
		}
		
		// Get schema sub type lable from its unknown Class
		if ( isset($schema_subtype) && '' != $schema_subtype ) {
			$classname 					= 'Schema_WP_' . $schema_subtype;
			$schema_class 				= (class_exists($classname)) ? new $classname : '';
			$schema_type_properties		= is_object($schema_class) ? $schema_class->properties() : $schema_type_properties;
		}

		if (! empty($schema_type_properties) ) {
			
			// Get setting for display tabs
			//
			$properties_tabs_enable = schema_wp_get_option( 'properties_tabs_enable' );

			// Get setting for display instructions
			//
			$properties_instructions_enable = schema_wp_get_option( 'properties_instructions_enable' );
					
			//
			//
			// ACF Group: Properties
			//
			//
			acf_add_local_field_group(array (
				'key' => 'schema_properties_group',
				'title' => __('Properties', 'schema-premium'),
				'location' => array (
					array (
						array (	 // custom location
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'schema',
						),
					),
				),
				'menu_order' => 30,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'left',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));
			
			// Debug
			//echo'<pre>';print_r( $schema_default['properties'] ); echo'</pre>';exit;
			
			foreach ( $schema_type_properties as $property => $property_details) { 

				if ( $properties_tabs_enable != 'yes' && $property_details['field_type'] == 'message' ) {
					$property_details['label'] = '<span style="color:#c90000;">' . $property_details['label'] . '</span>'; // high light
				};
				
				if ( $properties_instructions_enable != 'yes' ) {
					$property_details['instructions'] = ''; // disable instructions 
				};

				if ( $properties_instructions_enable != 'yes' && $property_details['field_type'] == 'message' ) {
					continue; // get out here... disable messages if instructions is disabled 
				};
				
				// Set field layout
				//
				$layout = 'block';
				if ( isset($property_details['sub_fields']) && ! empty($property_details['sub_fields']) ) {
					$layout = 'row';
				}
				
				//
				// Start our loop
				//
				
				// check if tabs is enabled
				//
				if ( $property_details['field_type'] != 'tab' ) {

					// ACF Group: Properties Sub
					//
					//
					acf_add_local_field(array (
						'key' => 'schema_properties_group_' . $property,
						'label' => $property_details['label'],
						'title' => $property,
						'type' => 'group',
						'parent' => 'schema_properties_group',
						'menu_order' => 0,
						'position' => 'normal',
						'style' => 'default',
						'label_placement' => 'left',
						'instruction_placement' => 'left',
						'instructions' => isset($property_details['instructions']) ? $property_details['instructions'] : '',
						'conditional_logic' => !empty($property_details['conditional_logic']) ? $property_details['conditional_logic'] : array(),
						'hide_on_screen' => '',
						'active' => 1,
						'description' => '',
						'message' => isset($property_details['message']) ? $property_details['message'] : '',
						'allow_null' => 1,
						'required' => isset($property_details['required']) ? $property_details['required'] : 0,
						'layout' => $layout,
						'multiple' => 0,
						'placement' => isset($property_details['placement']) ? $property_details['placement'] : 'top',
						'endpoint'	=> isset($property_details['endpoint']) ? $property_details['endpoint'] : 0,
					));
				} // end of check if tabs enabled

				if ( isset($property_details['sub_fields']) && ! empty($property_details['sub_fields']) ) {
					//echo '<pre>'; print_r($property_details['sub_fields']); echo '</pre>';
					foreach( $property_details['sub_fields'] as $sub_field => $sub_field_details) :
						acf_add_local_field(array (
							'key' => 'schema_properties_group_' . $sub_field,
							'label' => $sub_field_details['label'],
							'title' => $sub_field,
							'type' => 'group',
							'parent' => 'schema_properties_group_' . $property,
							'menu_order' => 0,
							'position' => 'normal',
							'style' => 'default',
							'label_placement' => 'left',
							'instruction_placement' => 'left',
							'instructions' => isset($sub_field_details['instructions']) ? $sub_field_details['instructions'] : '',
							'conditional_logic' => !empty($sub_field_details['conditional_logic']) ? $sub_field_details['conditional_logic'] : array(),
							'hide_on_screen' => '',
							'active' => 1,
							'description' => '',
							'message' => isset($sub_field_details['message']) ? $sub_field_details['message'] : '',
							'allow_null' => 1,
							'required' => isset($sub_field_details['required']) ? $sub_field_details['required'] : 0,
							'multiple' => 0,
							'placement' => isset($sub_field_details['placement']) ? $sub_field_details['placement'] : 'top',
							'endpoint'	=> isset($sub_field_details['endpoint']) ? $sub_field_details['endpoint'] : 0,
						));
						
						// do sub fields
						schema_wp_do_acf_properties_fields( $post_id, $sub_field, $sub_field_details, true );
			
					endforeach;
					
				} else {
			
				// do fields
				schema_wp_do_acf_properties_fields( $post_id, $property, $property_details, $sub_field = false );
				}
			} // end foreach
		}
		
 	endif;
}


function schema_wp_do_acf_properties_fields( $post_id, $property, $property_details, $sub_field = false ) {
	
	if ( $sub_field ) {
		$sub = '_';
	} else {
		$sub = '';
	}
	
	$selected_option 	= get_post_meta( $post_id, $sub . '_properties_' . $property, true );
	$default_value 		= (!empty($selected_option)) ? $selected_option : $property_details['markup_value']; 
	$select_choices 	= array();
	$tab				= false;
	$message			= false;
	
	// Get setting for enable tabs 
	//
	$properties_tabs_enable = schema_wp_get_option( 'properties_tabs_enable' );

	// Get setting for display instructions
	//
	$properties_instructions_enable = schema_wp_get_option( 'properties_instructions_enable' );
	
	// ACF Feild: Properties options select
	// 
	// @since 1.0.2
	switch ($property) {
		case 'image':
		case 'image_id':
		case 'screenshot':
			$select_choices = schema_wp_get_properties_image_select_options();
			break;
	    case 'review':
	        $select_choices = schema_wp_get_properties_review_select_options();
	    	break;
		case 'ratingValue':
	        $select_choices = schema_wp_get_properties_ratingValue_select_options();
	    	break;
		case 'priceRange':
	        $select_choices = schema_wp_get_properties_priceRange_select_options();
			break;
		default:
			$select_choices = schema_wp_get_properties_select_options();
    		break;
	}

	// ACF Feild: Properties fields tabs
	// 
	// @since 1.1.2.8
	switch ($property_details['field_type']) {
		case 'tab':
			$tab = true;
			break;
		default:
			$tab = false;
    		break;
	}

	// ACF Feild: Properties fields message
	// 
	// @since 1.1.2.8
	switch ($property_details['field_type']) {
		case 'message':
			$message = true;
			break;
		default:
			$message = false;
    		break;
	}

	// Debug
	//echo '<pre>'; print_r($property_details); echo '</pre>'; exit;

	// Display tab field
	//
	// @since 1.1.2.8
	//
	if  ( $tab && 'yes' == $properties_tabs_enable ) { 
		acf_add_local_field( array(
			'key' => $property,
			'name' => $property,
			'label' => $property_details['label'],
			'type' => 'tab',
			'parent' => 'schema_properties_group',
			'placement' => 'top',
			'endpoint'	=> 0,
		) );
		return; // quit here
	}

	// Display message field
	//
	// @since 1.1.2.6
	//
	if  ( $message && 'yes' == $properties_instructions_enable ) { 
		acf_add_local_field( array(
			'key' => 'properties_' . $property,
			'name' => 'properties_' . $property,
			'type' => 'message',
			'parent' => 'schema_properties_group_' . $property,
			'message' => $property_details['message'],
		) );
		return; // quit here
	}

	acf_add_local_field( array(
		'key' => 'properties_' . $property,
		'name' => 'properties_' . $property,
		'type' => 'select',
		'parent' => 'schema_properties_group_' . $property,
		'wrapper' => array (
			'width' => '50',
		),
		'choices' => $select_choices,
		'default_value' => $default_value,
		'return_format' => isset($property_details['return_format']) ? $property_details['return_format'] : 'value', //'value', // or array
		'allow_null' => 1,
		'required' => 0,
		'multiple' => 0
	) );
	
	// ACF Feild: Properties options select
	// 
	// 
	$saved_value 	= get_post_meta( $post_id, $sub . '_existing_custom_field_' . $property, true );
	$value			= !empty($saved_value) ? $saved_value : '';
	$fields_choices = schema_premium_get_all_custom_fields();
	
	// ACF Feild: Existing custom field
	// 
	//
	acf_add_local_field(array(
		'key' => 'existing_custom_field_' . $property,
		'name' => 'existing_custom_field_' . $property,
		'type' => 'select',
		'choices' => $fields_choices,
		'parent' => 'schema_properties_group_' . $property,
		'conditional_logic' => array(
							array(
								array(
									'field' => 'properties_' . $property,
									'operator' => '==',
									'value' => 'existing_custom_field',
								),
							),
						),
		'wrapper' => array (
				'width' => '50',
			),
		'default_value' => $value,
		'placeholder' => __('Select custom field key', 'schema-premium'),
		'ui' => true,
		//'ajax' => true,
		'allow_null' => 1,
		'required' => 0,
		'multiple' => 0
	) );

	// ACF Feild: Fixed text field
	// 
	//	
	$saved_value 	= get_post_meta( $post_id, $sub . '_fixed_text_field_' . $property, true );
	$value			= !empty($saved_value) ? $saved_value : '';
	
	acf_add_local_field(array(
		'key' => 'fixed_text_field_' . $property,
		'name' => 'fixed_text_field_' . $property,
		'type' => 'text',
		'parent' => 'schema_properties_group_' . $property,
		'conditional_logic' => array(
							array(
								array(
									'field' => 'properties_' . $property,
									'operator' => '==',
									'value' => 'fixed_text_field',
								),
							),
						),
		'wrapper' => array (
				'width' => '50',
			),
		'default_value' => $value,
		'placeholder' => __('Add fixed text here', 'schema-premium'),
		'required' => 0,
		'multiple' => 0
	) );
	
	// ACF Feild: Fixed image field
	// 
	//
	$saved_value 	= get_post_meta( $post_id, $sub . '_fixed_image_field_' . $property, true );
	$value			= !empty($saved_value) ? $saved_value : '';
	
	acf_add_local_field(array(
		'key' => 'fixed_image_field_' . $property,
		'name' => 'fixed_image_field_' . $property,
		'type' => 'image',
		'parent' => 'schema_properties_group_' . $property,
		'conditional_logic' => array(
							array(
								array(
									'field' => 'properties_' . $property,
									'operator' => '==',
									'value' => 'fixed_image_field',
								),
							),
						),
		'wrapper' => array (
				'width' => '50',
			),
		'default_value' => $value,
		'required' => 0,
		'multiple' => 0
	) );
	
	// ACF Feild: Image URL field
	// 
	//
	$saved_value 	= get_post_meta( $post_id, $sub . '_image_url_field_' . $property, true );
	$value			= !empty($saved_value) ? $saved_value : '';
	
	acf_add_local_field(array(
		'key' => 'image_url_field_' . $property,
		'name' => 'image_url_field_' . $property,
		'type' => 'url',
		'parent' => 'schema_properties_group_' . $property,
		'conditional_logic' => array(
							array(
								array(
									'field' => 'properties_' . $property,
									'operator' => '==',
									'value' => 'image_url_field',
								),
							),
						),
		'wrapper' => array (
				'width' => '50',
			),
		'default_value' => $value,
		'placeholder' => 'https://',
		'required' => 0,
		'multiple' => 0,
	) );
	
	// ACF Feild: Fixed review field
	// 
	//
	$saved_value 	= get_post_meta( $post_id, $sub . '_fixed_review_field_' . $property, true );
	$value			= !empty($saved_value) ? $saved_value : '';
	
	acf_add_local_field(array(
		'key' => 'fixed_review_field_' . $property,
		'name' => 'fixed_review_field_' . $property,
		'type' => 'star_rating',
		'parent' => 'schema_properties_group_' . $property,
		'conditional_logic' => array(
							array(
								array(
									'field' => 'properties_' . $property,
									'operator' => '==',
									'value' => 'fixed_review_field',
								),
							),
						),
		'wrapper' => array (
				'width' => '50',
			),
		'max_stars' => 5,
		'return_type' => 0,
		'choices' => array(
				5 => '5',
				'4.5' => '4.5',
				4 => '4',
				'3.5' => '3.5',
				3 => '3',
				'2.5' => '2.5',
				2 => '2',
				'1.5' => '1.5',
				1 => '1',
				'0.5' => '0.5'
			),
		'default_value' => $value,
		'required' => 0,
		'multiple' => 0,
		'other_choice' => 0,
		'save_other_choice' => 0,
		'layout' => 'horizontal'
	) );
	
	// ACF Feild: Fixed rating field
	// 
	//
	$saved_value 	= get_post_meta( $post_id, $sub . '_fixed_ratingValue_field_' . $property, true );
	$value			= !empty($saved_value) ? $saved_value : '';
	
	acf_add_local_field(array(
		'key' => 'fixed_ratingValue_field_' . $property,
		'name' => 'fixed_ratingValue_field_' . $property,
		'type' => 'star_rating',
		'parent' => 'schema_properties_group_' . $property,
		'conditional_logic' => array(
							array(
								array(
									'field' => 'properties_' . $property,
									'operator' => '==',
									'value' => 'fixed_ratingValue_field',
								),
							),
						),
		'wrapper' => array (
				'width' => '50',
			),
		'max_stars' => 5,
		'return_type' => 0,
		'choices' => array(
				5 => '5',
				'4.5' => '4.5',
				4 => '4',
				'3.5' => '3.5',
				3 => '3',
				'2.5' => '2.5',
				2 => '2',
				'1.5' => '1.5',
				1 => '1',
				'0.5' => '0.5'
			),
		'default_value' => $value,
		'required' => 0,
		'multiple' => 0,
		'other_choice' => 0,
		'save_other_choice' => 0,
		'layout' => 'horizontal'
	) );
	
	// ACF Feild: Fixed priceRange field
	// 
	//
	$saved_value 	= get_post_meta( $post_id, $sub . '_fixed_priceRange_field_' . $property, true );
	$value			= !empty($saved_value) ? $saved_value : '';
	
	acf_add_local_field(array(
		'key' => 'fixed_priceRange_field_' . $property,
		'name' => 'fixed_priceRange_field_' . $property,
		'type' => 'select',
		'parent' => 'schema_properties_group_' . $property,
		'conditional_logic' => array(
							array(
								array(
									'field' => 'properties_' . $property,
									'operator' => '==',
									'value' => 'fixed_priceRange_field',
								),
							),
						),
		'wrapper' => array (
				'width' => '50',
			),
		'max_stars' => 5,
		'return_type' => 0,
		'choices' => array
					(
						'$' => '$',
						'$$' => '$$',
						'$$$' => '$$$',
						'$$$$' => '$$$$',
						'$$$$$' => '$$$$$' 
					),
		'default_value' => $value,
		'required' => 0,
		'multiple' => 0,
		'other_choice' => 0,
		'save_other_choice' => 0,
		'layout' => 'horizontal'
	) );
	
}


function schema_wp_get_properties_select_options() {
	
	$options = array ( 
		''	=> __('— Select —', 'schema-premium'), 
		'Site Meta' => array ( 
			'site_title'		=> __('Site Name', 'schema-premium'), 
			'site_description'	=> __('Site Description', 'schema-premium'), 
			'site_url'			=> __('Site URL', 'schema-premium'), 
		),
		'Post Meta' => array ( 
			'post_title' 		=> __('Post Title', 'schema-premium'), 
			'post_content' 		=> __('Post Content', 'schema-premium'),
			'post_excerpt' 		=> __('Post Excerpt', 'schema-premium'),
			'post_permalink' 	=> __('Post Permalink', 'schema-premium'),
			'author_name' 		=> __('Author Name', 'schema-premium'),
			'post_date' 		=> __('Publish Date', 'schema-premium'), 
			'post_modified' 	=> __('Last Modified Date', 'schema-premium'), 
		),
		'Custom Fields' => array ( 
			'fixed_text_field' 		=> __('Fixed Text', 'schema-premium'), 
			'new_custom_field' 		=> __('New Custom Field', 'schema-premium'),
			'existing_custom_field' => __('Use Existing Field', 'schema-premium'), 
		),
		'General' => array ( 
			'disabled'	=> __('Disabled', 'schema-premium'),
		),						
	);
					
	return apply_filters( 'schema_wp_get_properties_select_options', $options );
}


function schema_wp_get_properties_image_select_options() {
	
	$options = array ( 
		''	=> __('— Select —', 'schema-premium'), 
		'Site Meta' => array ( 
			'logo'				=> __('Logo', 'schema-premium'),  
		),
		'Post Meta' => array ( 
			'featured_image' 	=> __('Featured Image', 'schema-premium'), 
			'author_image' 		=> __('Author Image', 'schema-premium'),
		),
		'Custom Fields' => array ( 
			'fixed_image_field' 	=> __('Fixed Image', 'schema-premium'),
			'image_url_field'	 	=> __('Image URL', 'schema-premium'),
			'new_custom_field' 		=> __('New Custom Field', 'schema-premium'),
			'existing_custom_field' => __('Use Existing Field', 'schema-premium'), 
		),
		'General' => array ( 
			'disabled'	=> __('Disabled', 'schema-premium'),
		)						
	);
					
	return apply_filters( 'schema_wp_get_properties_image_select_options', $options );
}

function schema_wp_get_properties_review_select_options() {
	
	$options = array ( 
		''	=> __('— Select —', 'schema-premium'),
		'Custom Fields' => array ( 
			'fixed_ratingValue_field' 	=> __('Fixed Rating', 'schema-premium'),
			'new_custom_field' 			=> __('New Custom Field', 'schema-premium'),
			'existing_custom_field' 	=> __('Use Existing Field', 'schema-premium'), 
		),
		'General' => array ( 
			'disabled'	=> __('Disabled', 'schema-premium'),
		)					
	);
					
	return apply_filters( 'schema_wp_get_properties_review_select_options', $options );
}


function schema_wp_get_properties_ratingValue_select_options() {
	
	$options = array ( 
		''	=> __('— Select —', 'schema-premium'),
		'Custom Fields' => array ( 
			'fixed_ratingValue_field' 	=> __('Fixed Rating', 'schema-premium'),
			'new_custom_field' 			=> __('New Custom Field', 'schema-premium'),
			'existing_custom_field' 	=> __('Use Existing Field', 'schema-premium'), 
		),
		'General' => array ( 
			'disabled'	=> __('Disabled', 'schema-premium'),
		)					
	);
					
	return apply_filters( 'schema_wp_get_properties_ratingValue_select_options', $options );
}

function schema_wp_get_properties_priceRange_select_options() {
	
	$options = array ( 
		''	=> __('— Select —', 'schema-premium'),
		'Custom Fields' => array ( 
			'fixed_priceRange_field'	=> __('Fixed Price Range', 'schema-premium'),
			'new_custom_field' 			=> __('New Custom Field', 'schema-premium'),
			'existing_custom_field' 	=> __('Use Existing Field', 'schema-premium'), 
		)						
	);
					
	return apply_filters( 'schema_wp_get_properties_priceRange_select_options', $options );
}
