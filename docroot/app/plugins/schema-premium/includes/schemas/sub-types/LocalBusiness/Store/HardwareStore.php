<?php
/**
 * @package Schema Premium - Class Schema HardwareStore
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_HardwareStore') ) :
	/**
	 * Schema HardwareStore
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_HardwareStore extends Schema_WP_Store {
		
		/** @var string Currenct Type */
    	protected $type = 'HardwareStore';
			
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
			
			return 'HardwareStore';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Hardware Store', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A hardware store.', 'schema-premium');
		}
	}
	
endif;
