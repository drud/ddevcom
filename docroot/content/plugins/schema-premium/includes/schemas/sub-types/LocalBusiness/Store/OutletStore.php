<?php
/**
 * @package Schema Premium - Class Schema OutletStore
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_OutletStore') ) :
	/**
	 * Schema OutletStore
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_OutletStore extends Schema_WP_Store {
		
		/** @var string Currenct Type */
    	protected $type = 'OutletStore';
		
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
			
			return __('Outlet Store', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('An outlet store.', 'schema-premium');
		}
	}
	
	//new Schema_WP_OutletStore();
	
endif;
