<?php
/**
 * @package Schema Types - Extension : OpeningHoursSpecification
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Check if a type suppoorts opening hours
 * Allow filtering of opening hours location
 *
 * @since 1.0.0
 * @return array
 */
function schema_premium_meta_is_opennings() {
	$is_opennings 	= array('');
	$output 		= apply_filters( 'schema_premium_meta_is_opennings', $is_opennings );
	return $output;
}

add_filter('schema_output', 				'schema_wp_types_OpeningHoursSpecification_markup_output');
add_filter('schema_output_blog_post', 		'schema_wp_types_OpeningHoursSpecification_markup_output');
add_filter('schema_output_category_post', 	'schema_wp_types_OpeningHoursSpecification_markup_output');
/**
 * Output Markup
 *
 * @since 1.0.0
 */
function schema_wp_types_OpeningHoursSpecification_markup_output( $schema ) {
	
	if ( empty($schema) ) return;
	
	$is_opennings_enable = schema_premium_meta_is_opennings();
	if ( ! in_array( $schema['@type'], $is_opennings_enable ) ) {
		// If is not in array of enabled types
		return $schema;
	}
	
	// OpeningHoursSpecification
	//
	//
	$openingHours = schema_wp_types_get_OpeningHoursSpecification();
	
	if ( ! empty( $openingHours ) )
		$schema['OpeningHoursSpecification'][] = $openingHours;
	
	// SpceialDays
	//
	//
	$SpecialDays = schema_wp_types_get_SpecialDays();
	
	if ( ! empty( $SpecialDays ) )
		$schema['OpeningHoursSpecification'][] = $SpecialDays;
	
	return $schema;
}

/**
 * Get OpeningHoursSpecification 
 *
 * @since 1.0.0
 *
 * return array
 */
function schema_wp_types_get_OpeningHoursSpecification() {

	$OpeningHoursSpecification = array();
	
	if( function_exists('have_rows') ) {

		// check if the OpeningHoursSpecification repeater field has rows of data
		//
		//
		if( have_rows('field_schema_OpeningHoursSpecification_repeater', get_the_ID() ) ):
			
			// loop through the rows of data
			while ( have_rows('field_schema_OpeningHoursSpecification_repeater', get_the_ID() ) ) : the_row();
				
				$closed = get_sub_field('closed');
				$from   = $closed ? '00:00' : get_sub_field('from');
				$to		= $closed ? '00:00' : get_sub_field('to');
				$from_2 = $closed ? '00:00' : get_sub_field('from_2');
				$to_2   = $closed ? '00:00' : get_sub_field('to_2');
				
				// First shift
				if ( isset($from) && $from !='' || isset($to) && $to !='' ) {
					$OpeningHoursSpecification[] = array(
						'@type'     => 'OpeningHoursSpecification',
						'dayOfWeek' => get_sub_field('days'),
						'opens'     => $from,
						'closes'    => $to
					);
				}
				// Second shift
				if ( ! $closed ) { // avoid repeating on closed days
					if ( isset($from_2) && $from_2 !='' || isset($to_2) && $to_2 !='' ) {
						$OpeningHoursSpecification[] = array(
							'@type'     => 'OpeningHoursSpecification',
							'dayOfWeek' => get_sub_field('days'),
							'opens'     => $from_2,
								'closes'    => $to_2
						);
					}
				}

			endwhile;

		else :

			// no rows found

		endif;

	} // end if function_exists

	return $OpeningHoursSpecification;
}

/**
 * Get SpecialDays 
 *
 * @since 1.0.0
 *
 * return array
 */
function schema_wp_types_get_SpecialDays() {

	$SpecialDays = array();
	
	if( function_exists('have_rows') ) {

		// check if the SpecialDays repeater field has rows of data
		//
		//
		if( have_rows('field_schema_SpecialDays_repeater', get_the_ID() ) ):
			
			// loop through the rows of data
			while ( have_rows('field_schema_SpecialDays_repeater', get_the_ID() ) ) : the_row();
				
				$closed 	= get_sub_field('closed');
				$date_from 	= get_sub_field('date_from');
				$date_to   	= get_sub_field('date_to');
				$time_from	= $closed ? '00:00' : get_sub_field('time_from');
				$time_to	= $closed ? '00:00' : get_sub_field('time_to');
				
				$SpecialDays[] = array(
							'@type'        => 'OpeningHoursSpecification',
							'validFrom'    => $date_from,
							'validThrough' => $date_to,
							'opens'        => $time_from,
							'closes'       => $time_to
						);
			endwhile;

		else :

			// no rows found

		endif;

	} // end if function_exists
	
	return $SpecialDays;
}

add_action( 'acf/init', 'schema_wp_types_acf_field_OpeningHoursSpecification' );
/**
 * Meta Box
 *
 * @since 1.0.0
 */
function schema_wp_types_acf_field_OpeningHoursSpecification() {
	
	//$enabled_properties = schema_wp_get_enabled_properties();
	//if ( empty( $enabled_properties ) ) return;
	//if ( ! in_array( 'OpeningHoursSpecification', $enabled_properties ) ) return;
	
	// Do not show nn post type schema
	// @since 1.0.6
	// Not needed since we added the exxclusion within ACF location target
	//if ( $post_type = schema_wp_get_current_post_type() ) {
		//if ( $post_type == 'schema' )
		//	return;
	//}
	
	if( function_exists('acf_add_local_field_group') ):
				
		$title = __('Opening Hours Specification', 'schema-wp-types');
		
		$message = '<span class="dashicons dashicons-clock"></span> ';
		$message .= __('Open all day: 12:00 am - 11:59 pm ', 'schema-wp-types') . '<br />'; // line break
		$message .= '<p class="description">';
		$message .= __('You can add two sets of <code>open</code> and <code>close</code> hours for same day with different times to indicate that the business hours include a break. ', 'schema-wp-types') ;
		$message .= ' <a href="#">useful details @todo</a>';
		$message .= '</p>';
		
		$SpecialDays_message = '<p class="description">';
		$SpecialDays_message .=  __('Use both the <code>validFrom</code> and <code>validThrough</code> properties to define seasonal hours. (example: shows a business closed for winter holidays)', 'schema-wp-types');
		$SpecialDays_message .= '</p>';
	
		// ACF Group: openingHours
		//
		//
		acf_add_local_field_group(array (
			'key' => 'group_schema_OpeningHoursSpecification',
			'title' => $title,
			'location' => array (
				array (
					array (	 // custom location
						'param' => 'is_opennings',
						'operator' => '==',
						'value' => 'true',
					),
					array (	 // custom location
						'param' => 'is_schema',
						'operator' => '==',
						'value' => 'true',
					),
					// @since 1.0.6
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
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => 1,
			'description' => '',
			'fields' => array (
				array (
					'key' => 'field_schema_OpeningHoursSpecification_message',
					'label' =>  __('Opening Hours', 'schema-wp-types'), 
					'type' => 'message',
					'message' => $message,
				),
				array (
					'key' => 'field_schema_OpeningHoursSpecification_repeater',
					'label' => '', 
					'name' => 'schema_OpeningHoursSpecification_repeater',
					'type' => 'repeater',
					'value' => NULL,
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'collapsed' => '',
					'min' => 0,
					'max' => 0,
					'layout' => 'table',
					'button_label' => __('Add Day', 'schema-wp-types'),
					'sub_fields' => schema_wp_types_acf_OpeningHoursSpecification_sub_fields()
				),
				array (
					'key' => 'field_schema_SpecialDays_message',
					'label' =>  __('Special Days', 'schema-wp-types'), 
					'type' => 'message',
					'message' => $SpecialDays_message,
				),
				array (
					'key' => 'field_schema_SpecialDays_repeater',
					'label' =>  '', 
					'name' => 'schema_SpecialDays_repeater',
					'type' => 'repeater',
					'value' => NULL,
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'collapsed' => '',
					'min' => 0,
					'max' => 0,
					'layout' => 'table',
					'button_label' => __('Add Date', 'schema-wp-types'),
					'sub_fields' => schema_wp_types_acf_SpecialDays_sub_fields()
				),
			),
		));
		
	endif;
}


function schema_wp_types_acf_OpeningHoursSpecification_sub_fields() {
				
	$fields = array (
				array (
					'key' => 'field_OpeningHoursSpecification_days',
					'label' => __('Days', 'schema-wp-types'),
					'name' => 'days',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '30',
						'class' => '',
						'id' => '',
					),
					'choices' => array (
						'Monday' 	=> __('Mo', 'schema-wp-types'),
						'Tuesday' 	=> __('Tu', 'schema-wp-types'),
						'Wednesday' => __('We', 'schema-wp-types'),
						'Thursday' 	=> __('Th', 'schema-wp-types'),
						'Friday' 	=> __('Fr', 'schema-wp-types'),
						'Saturday' 	=> __('Sa', 'schema-wp-types'),
						'Sunday' 	=> __('Su', 'schema-wp-types'),
					),
					'default_value' => array (
					),
					'allow_null' => 0,
					'multiple' => 1,
					'ui' => 1,
					'ajax' => 0,
					'return_format' => 'value',
					'placeholder' => '',
				),
				array (
					'key' => 'field_OpeningHoursSpecification_from',
					'label' => 'from',
					'name' => 'from',
					'type' => 'time_picker',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_OpeningHoursSpecification_closed',
								'operator' => '!=',
								'value' => '1',
							),
						),
					),
					'wrapper' => array (
						'width' => '15',
						'class' => '',
						'id' => '',
					),
					'display_format' => 'g:i a',
					'return_format' => 'H:i:s',
				),
				array (
					'key' => 'field_OpeningHoursSpecification_to',
					'label' => 'to',
					'name' => 'to',
					'type' => 'time_picker',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_OpeningHoursSpecification_closed',
								'operator' => '!=',
								'value' => '1',
							),
						),
					),
					'wrapper' => array (
						'width' => '15',
						'class' => '',
						'id' => '',
					),
					'display_format' => 'g:i a',
					'return_format' => 'H:i:s',
				),
				array (
					'key' => 'field_OpeningHoursSpecification_from_2',
					'label' => 'from',
					'name' => 'from_2',
					'type' => 'time_picker',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_OpeningHoursSpecification_closed',
								'operator' => '!=',
								'value' => '1',
							),
						),
					),
					'wrapper' => array (
						'width' => '15',
						'class' => '',
						'id' => '',
					),
					'display_format' => 'g:i a',
					'return_format' => 'H:i:s',
				),
				array (
					'key' => 'field_OpeningHoursSpecification_to_2',
					'label' => 'to',
					'name' => 'to_2',
					'type' => 'time_picker',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_OpeningHoursSpecification_closed',
								'operator' => '!=',
								'value' => '1',
							),
						),
					),
					'wrapper' => array (
						'width' => '15',
						'class' => '',
						'id' => '',
					),
					'display_format' => 'g:i a',
					'return_format' => 'H:i:s',
				),
				array (
					'key' => 'field_OpeningHoursSpecification_closed',
					'label' => 'Closed',
					'name' => 'closed',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '10',
						'class' => '',
						'id' => '',
					),
					'message' => '',
					'default_value' => 0,
					'ui' => 1,
					'ui_on_text' => '',
					'ui_off_text' => '',
				),
			);
	
	return $fields;
}



function schema_wp_types_acf_SpecialDays_sub_fields() {
				
	$fields = array (
				array (
					'key' => 'field_SpecialDays_date_from',
					'label' => __('Date: from', 'schema-wp-types'),
					'name' => 'date_from',
					'type' => 'date_picker',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '25',
						'class' => '',
						'id' => '',
					),
					'display_format' => get_option( 'date_format' ), // WP
					'return_format' => 'Y-m-d',
					'first_day' => 1,
				),
				array (
					'key' => 'field_SpecialDays_date_to',
					'label' => __('Date: to', 'schema-wp-types'),
					'name' => 'date_to',
					'type' => 'date_picker',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '25',
						'class' => '',
						'id' => '',
					),
					'display_format' => get_option( 'date_format' ), // WP
					'return_format' => 'Y-m-d',
					'first_day' => 1,
				),
				array (
					'key' => 'field_SpecialDays_time_from',
					'label' => __('Time: from', 'schema-wp-types'),
					'name' => 'time_from',
					'type' => 'time_picker',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_SpecialDays_closed',
								'operator' => '!=',
								'value' => '1',
							),
						),
					),
					'wrapper' => array (
						'width' => '20',
						'class' => '',
						'id' => '',
					),
					'display_format' => 'g:i a',
					'return_format' => 'H:i:s',
				),
				array (
					'key' => 'field_SpecialDays_time_to',
					'label' => __('Time: to', 'schema-wp-types'),
					'name' => 'time_to',
					'type' => 'time_picker',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_SpecialDays_closed',
								'operator' => '!=',
								'value' => '1',
							),
						),
					),
					'wrapper' => array (
						'width' => '20',
						'class' => '',
						'id' => '',
					),
					'display_format' => 'g:i a',
					'return_format' => 'H:i:s',
				),
				array (
					'key' => 'field_SpecialDays_closed',
					'label' => __('Closed', 'schema-wp-types'),
					'name' => 'closed',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '10',
						'class' => '',
						'id' => '',
					),
					'message' => '',
					'default_value' => 0,
					'ui' => 1,
					'ui_on_text' => 'Yes',
					'ui_off_text' => 'No',
				),
			);
	
	return $fields;
}
