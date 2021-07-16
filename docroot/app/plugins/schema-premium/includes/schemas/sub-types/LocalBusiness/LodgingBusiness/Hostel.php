<?php
/**
 * @package Schema Premium - Class Schema Hostel
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Hostel') ) :
	/**
	 * Schema Hostel
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Hostel extends Schema_WP_LodgingBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'Hostel';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'LodgingBusiness';

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
			
			return 'Hostel';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Hostel', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A hostel - cheap accommodation, often in shared dormitories.', 'schema-premium');
		}
	}
	
	
endif;
