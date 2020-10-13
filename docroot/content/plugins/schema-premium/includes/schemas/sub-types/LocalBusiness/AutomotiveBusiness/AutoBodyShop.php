<?php
/**
 * @package Schema Premium - Class Schema AutoBodyShop
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_AutoBodyShop') ) :
	/**
	 * Schema AutoBodyShop
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_AutoBodyShop extends Schema_WP_LocalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'AutoBodyShop';
		
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
			
			return __('Auto Body Shop', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('Auto body shop.', 'schema-premium');
		}
	}
	
	
endif;