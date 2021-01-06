<?php
/**
 * @package Schema Premium - Class Schema HobbyShop
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_HobbyShop') ) :
	/**
	 * Schema HobbyShop
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_HobbyShop extends Schema_WP_Store {
		
		/** @var string Currenct Type */
    	protected $type = 'HobbyShop';
			
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
			
			return 'HobbyShop';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Hobby Shop', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A store that sells materials useful or necessary for various hobbies.', 'schema-premium');
		}
	}
	
endif;
