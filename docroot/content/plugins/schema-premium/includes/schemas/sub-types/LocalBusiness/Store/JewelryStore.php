<?php
/**
 * @package Schema Premium - Class Schema JewelryStore
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_JewelryStore') ) :
	/**
	 * Schema JewelryStore
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_JewelryStore extends Schema_WP_Store {
		
		/** @var string Currenct Type */
    	protected $type = 'JewelryStore';
			
		/** @var string Current Parent Type */
		protected $parent_type = 'Store';

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
			
			return 'JewelryStore';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Jewelry Store', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A jewelry store.', 'schema-premium');
		}
	}
	
endif;
