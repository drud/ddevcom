<?php
/**
 * Schema Location Rules
 *
 * @package     Schema
 * @subpackage  Schema Post Meta
 * @copyright   Copyright (c) 2018, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'schema_wp_types_acf_field_locations_group' );
/**
 * Create ACF field type Group for locations rules
 *
 * @since 1.0.0
 */
function schema_wp_types_acf_field_locations_group() {
	
	global $pagenow;

	// Make sure Location group display only in Schema post type
	// @since 1.2
	//
	if ( 'post.php' === $pagenow && isset($_GET['post']) && 'schema' === get_post_type( $_GET['post'] ) ) {
		if ( function_exists('acf_add_local_field_group') ):
			
			// ACF Group: Locations
			//
			//
			acf_add_local_field_group(array (
				'key' => 'schema_locations_group',
				'title' => __('Locations', 'schema-premium'),
				'location' => array (
					array (
						array (	 // custom locations
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'schema',
						),
					),
				),
				'menu_order' => 10,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'left',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));
		
		endif;
	}
}

add_action( 'acf/init', 'schema_wp_types_acf_field_locations_enable_rules' );
/**
 * Create ACF repeater field for
 *
 * Locations Rules field: Enable Rules
 *
 * @since 1.0.0
 */
function schema_wp_types_acf_field_locations_enable_rules() {
	
	if ( function_exists('acf_add_local_field_group') ):
		
		// Repeater
		//
		//
		acf_add_local_field( apply_filters( 'field_schema_locations', array(
			'key' => 'field_schema_locations',
			'name' => 'schema_locations',
			'label' => __('Enable Rules', 'schema-premium'),
			'instructions'	=> __('Create a set of rules to determine the target of this schema.org type', 'schema-premium'), 
			'type' => 'repeater',
			'parent' => 'schema_locations_group',
			'collapsed' => '',
			'min' => 1,
			'max' => 0,
			'layout' => 'table',
			'button_label' => __('Add Enable Rule', 'schema-premium'),
		) ) );
		
		// Sub Repeater Group
		//
		//
		acf_add_local_field(array(
			'key' 		=> 'group_schema_locations_sub',
			'label' 	=> __('Enable Schema markup on', 'schema-premium'),
			'name' 		=> 'locations_group_sub',
			'type' 		=> 'group',
			'layout' 	=> 'block',
			'parent' 	=> 'field_schema_locations',
			'required' => 1,
		));
		
		// Sub Repeater Field Select
		//
		//
		
		$locations_choices = schema_wp_get_locations_choices();
		
		acf_add_local_field(array(
			'key' 		=> 'field_schema_locations_select',
			'label' 	=> '',
			'name' 		=> 'schema_locations_select',
			'type' 		=> 'select',
			'instructions' => '',
			
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
			),
			'parent' 	=> 'group_schema_locations_sub',
			'choices' => $locations_choices,
			'default_value' => array(
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'ajax' => 0,
			'return_format' => 'value',
		));
		
		//
		//
		// Sub Repeater Fields 
		// With conditional logic based on selection
		//
		//
		
		// define array
		$feilds = schema_wp_get_locations_fields_options();
		
		// Create fields
		foreach ( $feilds as $key => $details) {
		
			acf_add_local_field(array(
				'key' 		=> $key . '_location',
				'label' 	=> '',
				'name' 		=> $key . '_location',
				'type' 		=> $details['type'],
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => array(
									array(
										array(
											'field' => 'field_schema_locations_select',
											'operator' => '==',
											'value' => $details['value'],
										),
									),
								),
				'wrapper' => array(
					'width' => '50',
				),
				'parent' 	=> 'group_schema_locations_sub',
				'return_format' => 'value',
			));
		} // end foreach
		
		// Posts
		acf_add_local_field(array(
			'key' 		=> 'field_schema_post_location',
			'label' 	=> '',
			'name' 		=> 'schema_post_location',
			'type' 		=> 'post_object',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
								array(
									array(
										'field' => 'field_schema_locations_select',
										'operator' => '==',
										'value' => 'post',
									),
								),
							),
			'wrapper' => array(
				'width' => '50',
			),
			'post_type' => array(
								0 => 'post',
							),
			'parent' 	=> 'group_schema_locations_sub',
			'return_format' => 'value',
		));
		
		// Pages
		acf_add_local_field(array(
			'key' 		=> 'field_schema_page_location',
			'label' 	=> '',
			'name' 		=> 'schema_page_location',
			'type' 		=> 'post_object',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
								array(
									array(
										'field' => 'field_schema_locations_select',
										'operator' => '==',
										'value' => 'page',
									),
								),
							),
			'wrapper' => array(
				'width' => '50',
			),
			'post_type' => array(
								0 => 'page',
							),
			'parent' 	=> 'group_schema_locations_sub',
			'return_format' => 'value',
		));
		
 	endif;
}

add_action( 'acf/init', 'schema_wp_types_acf_field_locations_exclusion_rules' );
/**
 * Create ACF repeater field for
 *
 * Locations Rules field: Exclution Rules
 *
 * @since 1.0.0
 */
function schema_wp_types_acf_field_locations_exclusion_rules() {
	
	if( function_exists('acf_add_local_field_group') ):
		
		// Repeater
		//
		//
		acf_add_local_field( apply_filters( 'field_schema_exclution', array(
			'key' => 'field_schema_exclution',
			'name' => 'schema_exclution',
			'label' => __('Exclusion Rules', 'schema-premium'),
			'instructions'	=> '', 
			'type' => 'repeater',
			'parent' => 'schema_locations_group',
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'table',
			'button_label' => __('Add Exclution Rule', 'schema-premium'),
		) ) );
		
		// Sub Repeater Group
		//
		//
		acf_add_local_field(array(
			'key' 		=> 'group_schema_exclution_sub',
			'label' 	=> __('Exclude schema markup on', 'schema-premium'),
			'name' 		=> 'exclusion_group_sub',
			'type' 		=> 'group',
			'layout' 	=> 'block',
			'parent' 	=> 'field_schema_exclution',
		));
		
		// Sub Repeater Field Select
		//
		//
		
		// define array
		$locations_choices = schema_wp_get_locations_choices();
		
		acf_add_local_field(array(
			'key' 		=> 'field_schema_exclusion_select',
			'label' 	=> '',
			'name' 		=> 'schema_exclution_select',
			'type' 		=> 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
			),
			'parent' 	=> 'group_schema_exclution_sub',
			'choices' => $locations_choices,
			'default_value' => array(
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'ajax' => 0,
			'return_format' => 'value',
		));
		
		//
		//
		// Sub Repeater Fields 
		// With conditional logic based on selection
		//
		//
		
		// define array
		$feilds = schema_wp_get_locations_fields_options();
		
		// Create fields
		foreach ( $feilds as $key => $details) {
		
			acf_add_local_field(array(
				'key' 		=> $key . '_exclution',
				'label' 	=> '',
				'name' 		=> $key . '_exclution',
				'type' 		=> $details['type'],
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => array(
									array(
										array(
											'field' => 'field_schema_exclusion_select',
											'operator' => '==',
											'value' => $details['value'],
										),
									),
								),
				'wrapper' => array(
					'width' => '50',
				),
				'parent' 	=> 'group_schema_exclution_sub',
				'return_format' => 'value',
			));
		} // end foreach
		
		// Posts
		acf_add_local_field(array(
			'key' 		=> 'field_schema_post_exclution',
			'label' 	=> '',
			'name' 		=> 'schema_post_exclution',
			'type' 		=> 'post_object',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
								array(
									array(
										'field' => 'field_schema_exclusion_select',
										'operator' => '==',
										'value' => 'post',
									),
								),
							),
			'wrapper' => array(
				'width' => '50',
			),
			'post_type' => array(
								0 => 'post',
							),
			'parent' 	=> 'group_schema_exclution_sub',
			'return_format' => 'value',
		));
		
		// Pages
		acf_add_local_field(array(
			'key' 		=> 'field_schema_page_exclution',
			'label' 	=> '',
			'name' 		=> 'schema_page_exclution',
			'type' 		=> 'post_object',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
								array(
									array(
										'field' => 'field_schema_exclusion_select',
										'operator' => '==',
										'value' => 'page',
									),
								),
							),
			'wrapper' => array(
				'width' => '50',
			),
			'post_type' => array(
								0 => 'page',
							),
			'parent' 	=> 'group_schema_exclution_sub',
			'return_format' => 'value',
		));
		
 	endif;
}

/**
 * Get locations options choices
 *
 * @since 1.0.0
 *
 * @return array
 */
function schema_wp_get_locations_choices() {
	
	$options = array ( 
		''						=> __('— Select —', 'schema-premium'), 
		'Everywhere' => array ( 
			'all_singulars'		=> __('All Singulars', 'schema-premium'), 
		),
		'Post' => array ( 
			'post_type' 		=> __('Post Type', 'schema-premium'), 
			'post_format' 		=> __('Post Format', 'schema-premium'),
			'post_status' 		=> __('Post Status', 'schema-premium'),
			'post_category' 	=> __('Post Category', 'schema-premium'),
			//'post_taxonomy' 	=> __('Post Taxonomy', 'schema-premium'),
			'post' 				=> __('Specific Post', 'schema-premium'), 
		),
		'Page' => array ( 
			//'page_template' 	=> __('Page Template', 'schema-premium'), 
			//'page_type' 		=> __('Page Type', 'schema-premium'),
			//'page_parent' 		=> __('Page Parent', 'schema-premium'), 
			'page' 				=> __('Specific Page', 'schema-premium'), 
		),
		'Specific ID' => array ( 
			'post_id' 			=> __('Post id', 'schema-premium'),
		)					
	);
	
	// Remove if not supported by active Theme
	// @since 1.1.2.8
	//
	$post_formats = get_theme_support('post-formats');

	if ( empty($post_formats) ) {
		unset( $options['Post']['post_format'] );
	}

	return apply_filters( 'schema_wp_get_locations_choices', $options );
}

/**
 * Get Sub Repeater Fields array
 *
 * To set conditional logic based on selection
 *
 * @since 1.0.0
 *
 * @return array
 */
function schema_wp_get_locations_fields_options() {
		
	$feilds = array(
		'schema_post_type' => array(
			'type' => 'post_type_select',
			'value' => 'post_type',
		),
		'schema_post_formats' => array(
			'type' => 'post_formats_select',
			'value' => 'post_format',
		),
		'schema_post_statuses_select' => array(
			'type' => 'post_statuses_select',
			'value' => 'post_status',
		),
		'schema_categories_select' => array(
			'type' => 'schema_categories_select',
			'value' => 'post_category',
		),
		'schema_post_id' => array(
			'type' => 'text',
			'value' => 'post_id',
		),
	);
	
	return apply_filters( 'schema_wp_get_locations_fields_options', $feilds );
}
