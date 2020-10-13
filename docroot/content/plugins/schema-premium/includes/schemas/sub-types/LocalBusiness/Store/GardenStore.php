<?php
/**
 * @package Schema Premium - Class Schema GardenStore
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_GardenStore') ) :
	/**
	 * Schema GardenStore
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_GardenStore extends Schema_WP_Store {
		
		/** @var string Currenct Type */
    	protected $type = 'GardenStore';
		
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
			
			return __('Garden Store', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A garden store.', 'schema-premium');
		}
	}
	
	//new Schema_WP_GardenStore();
	
endif;
