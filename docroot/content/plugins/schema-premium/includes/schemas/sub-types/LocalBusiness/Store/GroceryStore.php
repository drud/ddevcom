<?php
/**
 * @package Schema Premium - Class Schema GroceryStore
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_GroceryStore') ) :
	/**
	 * Schema GroceryStore
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_GroceryStore extends Schema_WP_Store {
		
		/** @var string Currenct Type */
    	protected $type = 'GroceryStore';
		
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
			
			return __('Grocery Store', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A grocery store.', 'schema-premium');
		}
	}
	
	//new Schema_WP_GroceryStore();
	
endif;
