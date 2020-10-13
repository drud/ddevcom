<?php
/**
 * @package Schema Premium - Class Schema ShoppingCenter
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_ShoppingCenter') ) :
	/**
	 * Schema ShoppingCenter
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_ShoppingCenter extends Schema_WP_LocalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'ShoppingCenter';
		
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
			
			return __('Shopping Center', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A shopping center or mall.', 'schema-premium');
		}
	}
	
	//new Schema_WP_ShoppingCenter();
	
endif;
