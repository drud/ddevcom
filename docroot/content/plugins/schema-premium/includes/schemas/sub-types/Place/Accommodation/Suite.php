<?php
/**
 * @package Schema Premium - Class Schema Suite
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Suite') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Suite extends Schema_WP_Accommodation {
		
		/** @var string Currenct Type */
    	protected $type = 'Suite';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'Accommodation';

		/**
	 	* Constructor
	 	*
	 	* @since 1.0.0
	 	*/
		public function __construct () {
		
			// emty __construct
		}
		
		/**
		* Get schema type 
		*
		* @since 1.2
		* @return string
		*/
		public function type() {
			
			return 'Suite';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Suite', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A suite in a hotel or other public accommodation, denotes a class of luxury accommodations, the key feature of which is multiple rooms.', 'schema-premium');
		}

		/**
		* Get properties
		*
		* @since 1.0.2
		* @return array
		*/
		public function properties() {
			
			// Add specific properties 
			//
			$properties['bed'] =  array(
				'label' 		=> __('Bed', 'schema-premium'),
				'rangeIncludes' => array('Text'),
				'field_type' 	=> 'text',
				'markup_value' 	=> 'new_custom_field',
				'instructions' 	=> __('The type of bed or beds included in the accommodation. For the single case of just one bed of a certain type, you use bed directly with a text.', 'schema-premium'),
			);


			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 40 );
			
			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

			return apply_filters( 'schema_properties_Suite', $properties );	
		}

	}
	
endif;
