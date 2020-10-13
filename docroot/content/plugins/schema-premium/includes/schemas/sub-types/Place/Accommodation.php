<?php
/**
 * @package Schema Premium - Class Schema Accommodation
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Accommodation') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Accommodation extends Schema_WP_Place {
		
		/** @var string Currenct Type */
    	protected $type = 'Accommodation';
		
		/**
	 	* Constructor
	 	*
	 	* @since 1.0.0
	 	*/
		public function __construct () {
		
			// emty __construct
		}
		
		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Accommodation', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('An accommodation is a place that can accommodate human beings, e.g. a hotel room, a camping pitch, or a meeting room.', 'schema-premium');
		}

		/**
		* Get properties
		*
		* @since 1.0.2
		* @return array
		*/
		public function properties() {
			
			// Get properties from parent class
			//
			$properties = parent::properties();
			
			// Add specific properties 
			//
			
			$properties['floorLevel'] =  array(
				'label' 		=> __('Floor Level', 'schema-premium'),
				'rangeIncludes' => array('Text'),
				'field_type' 	=> 'text',
				'markup_value' => 'new_custom_field',
				'instructions' 	=> __('The floor level for an Accommodation in a multi-storey building.', 'schema-premium'),
			);
			
			$properties['numberOfBathroomsTotal'] =  array(
				'label' 		=> __('Number Of Bathrooms Total', 'schema-premium'),
				'rangeIncludes' => array('Integer'),
				'field_type' 	=> 'number',
				'markup_value' => 'new_custom_field',
				'instructions' 	=> __('The total integer number of bathrooms. For example for a property with two Full Bathrooms and one Half Bathroom, the Bathrooms Total Integer will be 3.', 'schema-premium'),
			);

			$properties['numberOfFullBathrooms'] =  array(
				'label' 		=> __('Number Of Full Bathrooms', 'schema-premium'),
				'rangeIncludes' => array('Number'),
				'field_type' 	=> 'number',
				'markup_value' => 'new_custom_field',
				'instructions' 	=> __('Number of full bathrooms - The total number of full and ¾ bathrooms.', 'schema-premium'),
			);

			$properties['numberOfRooms'] =  array(
				'label' 		=> __('Number Of Rooms', 'schema-premium'),
				'rangeIncludes' => array('Number', 'QuantitativeValue'),
				'field_type' 	=> 'number',
				'markup_value' => 'new_custom_field',
				'instructions' 	=> __('The number of rooms (excluding bathrooms and closets) of the accommodation or lodging business.', 'schema-premium'),
			);

			$properties['permittedUsage'] =  array(
				'label' 		=> __('Permitted Usage', 'schema-premium'),
				'rangeIncludes' => array('Text'),
				'field_type' 	=> 'text',
				'markup_value' => 'disabled',
				'instructions' 	=> __('Indications regarding the permitted usage of the accommodation.', 'schema-premium'),
			);

			$properties['petsAllowed'] =  array(
				'label' 		=> __('Pets Allowed', 'schema-premium'),
				'rangeIncludes' => array('Text'),
				'field_type' 	=> 'true_false',
				'markup_value' => 'disabled',
				'instructions' 	=> __('Indicates whether pets are allowed to enter the accommodation or lodging business.', 'schema-premium'),
				'ui' => 1,
				'ui_on_text' => __('Yes', 'schema-premium'),
				'ui_off_text' => __('No', 'schema-premium'),
			);
			
			return apply_filters( 'schema_properties_Accommodation', $properties );	
		}

	}
		
endif;
