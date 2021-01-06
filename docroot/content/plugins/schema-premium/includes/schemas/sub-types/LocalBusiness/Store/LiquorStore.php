<?php
/**
 * @package Schema Premium - Class Schema LiquorStore
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_LiquorStore') ) :
	/**
	 * Schema LiquorStore
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_LiquorStore extends Schema_WP_Store {
		
		/** @var string Currenct Type */
    	protected $type = 'LiquorStore';
			
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
			
			return 'LiquorStore';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Liquor Store', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A shop that sells alcoholic drinks such as wine, beer, whisky and other spirits.', 'schema-premium');
		}
	}
	
endif;
