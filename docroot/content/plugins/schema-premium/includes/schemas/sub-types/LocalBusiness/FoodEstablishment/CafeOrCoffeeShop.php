<?php
/**
 * @package Schema Premium - Class Schema CafeOrCoffeeShop
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_CafeOrCoffeeShop') ) :
	/**
	 * Schema CafeOrCoffeeShop
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_CafeOrCoffeeShop extends Schema_WP_FoodEstablishment {
		
		/** @var string Currenct Type */
    	protected $type = 'CafeOrCoffeeShop';
		
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
			
			return 'CafeOrCoffeeShop';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Cafe Or Coffee Shop', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A cafe or coffee shop.', 'schema-premium');
		}
	}
	
	
endif;
