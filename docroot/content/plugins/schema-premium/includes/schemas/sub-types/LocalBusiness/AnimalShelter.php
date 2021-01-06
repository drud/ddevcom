<?php
/**
 * @package Schema Premium - Class Schema AnimalShelter
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_AnimalShelter') ) :
	/**
	 * Schema AnimalShelter
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_AnimalShelter extends Schema_WP_LocalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'AnimalShelter';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'LocalBusiness';

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
			
			return 'AnimalShelter';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Animal Shelter', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('Animal shelter.', 'schema-premium');
		}

		/**
		* Get properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {

			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( array(), self::type(), self::label(), self::comment(), 30 );
			
			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

			return apply_filters( 'schema_properties_AnimalShelter', $properties );	
		}
	}
	
	//new Schema_WP_AnimalShelter();
	
endif;
