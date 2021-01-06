<?php
/**
 * @package Schema Premium - Class Schema Restaurant
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Restaurant') ) :
	/**
	 * Schema Restaurant
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Restaurant extends Schema_WP_FoodEstablishment {
		
		/** @var string Currenct Type */
    	protected $type = 'Restaurant';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'FoodEstablishment';

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
			
			return 'Restaurant';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Restaurant', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A restaurant.', 'schema-premium');
		}
	}
	
	
endif;
