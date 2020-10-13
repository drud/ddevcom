<?php
/**
 * @package Schema Premium - Class Schema ElectronicsStore
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_ElectronicsStore') ) :
	/**
	 * Schema ElectronicsStore
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_ElectronicsStore extends Schema_WP_Store {
		
		/** @var string Currenct Type */
    	protected $type = 'ElectronicsStore';
		
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
			
			return __('Electronics Store', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('An electronics store.', 'schema-premium');
		}
	}
	
	//new Schema_WP_ElectronicsStore();
	
endif;
