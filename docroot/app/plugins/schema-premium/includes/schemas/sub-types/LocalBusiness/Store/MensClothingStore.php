<?php
/**
 * @package Schema Premium - Class Schema MensClothingStore
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_MensClothingStore') ) :
	/**
	 * Schema MensClothingStore
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_MensClothingStore extends Schema_WP_Store {
		
		/** @var string Currenct Type */
    	protected $type = 'MensClothingStore';
			
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
			
			return 'MensClothingStore';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('MensClothing Store', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A men\'s clothing store.', 'schema-premium');
		}
	}
	
endif;
