<?php
/**
 * @package Schema Premium - Class Schema FastFoodRestaurant
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_FastFoodRestaurant') ) :
	/**
	 * Schema FastFoodRestaurant
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_FastFoodRestaurant extends Schema_WP_FoodEstablishment {
		
		/** @var string Currenct Type */
    	protected $type = 'FastFoodRestaurant';
		
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
			
			return 'FastFoodRestaurant';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Fast Food Restaurant', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A fast-food restaurant.', 'schema-premium');
		}
	}
	
	
endif;
