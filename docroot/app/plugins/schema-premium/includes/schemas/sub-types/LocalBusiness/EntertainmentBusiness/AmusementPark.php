<?php
/**
 * @package Schema Premium - Class Schema AmusementPark
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_AmusementPark') ) :
	/**
	 * Schema AmusementPark
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_AmusementPark extends Schema_WP_EntertainmentBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'AmusementPark';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'EntertainmentBusiness';
		
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
			
			return 'AmusementPark';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Amusement Park', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('An amusement park.', 'schema-premium');
		}
	}
	
	
endif;
