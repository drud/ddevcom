<?php
/**
 * @package Schema Premium - Class Schema BikeStore
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_BikeStore') ) :
	/**
	 * Schema BikeStore
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_BikeStore extends Schema_WP_Store {
		
		/** @var string Currenct Type */
    	protected $type = 'BikeStore';
			
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
			
			return 'BikeStore';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Bike Store', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A bike store.', 'schema-premium');
		}
	}
	
	//new Schema_WP_BikeStore();
	
endif;
