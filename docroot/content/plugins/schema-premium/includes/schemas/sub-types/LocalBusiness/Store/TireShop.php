<?php
/**
 * @package Schema Premium - Class Schema TireShop
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_TireShop') ) :
	/**
	 * Schema TireShop
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_TireShop extends Schema_WP_Store {
		
		/** @var string Currenct Type */
    	protected $type = 'TireShop';
		
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
			
			return __('Tire Shop', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A tire shop.', 'schema-premium');
		}
	}
	
	//new Schema_WP_TireShop();
	
endif;
