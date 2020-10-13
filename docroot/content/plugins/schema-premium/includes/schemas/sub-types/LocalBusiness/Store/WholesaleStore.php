<?php
/**
 * @package Schema Premium - Class Schema WholesaleStore
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_WholesaleStore') ) :
	/**
	 * Schema WholesaleStore
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_WholesaleStore extends Schema_WP_Store {
		
		/** @var string Currenct Type */
    	protected $type = 'WholesaleStore';
		
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
			
			return __('Wholesale Store', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A wholesale store.', 'schema-premium');
		}
	}
	
	//new Schema_WP_WholesaleStore();
	
endif;
