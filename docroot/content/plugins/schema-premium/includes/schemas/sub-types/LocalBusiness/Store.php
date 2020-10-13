<?php
/**
 * @package Schema Premium - Class Schema Store
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Store') ) :
	/**
	 * Schema Store
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Store extends Schema_WP_LocalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'Store';
		
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
			
			return __('Store', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A retail good store.', 'schema-premium');
		}
	}
	
	//new Schema_WP_Store();
	
endif;
