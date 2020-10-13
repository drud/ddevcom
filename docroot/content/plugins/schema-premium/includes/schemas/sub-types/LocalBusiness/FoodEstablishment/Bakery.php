<?php
/**
 * @package Schema Premium - Class Schema Bakery
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Bakery') ) :
	/**
	 * Schema Bakery
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Bakery extends Schema_WP_FoodEstablishment {
		
		/** @var string Currenct Type */
    	protected $type = 'Bakery';
		
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
			
			return __('Bakery', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A bakery.', 'schema-premium');
		}
	}
	
	
endif;
