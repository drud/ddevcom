<?php
/**
 * @package Schema Premium - Class Schema AutoWash
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_AutoWash') ) :
	/**
	 * Schema AutoWash
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_AutoWash extends Schema_WP_LocalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'AutoWash';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'LocalBusiness';

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
			
			return 'AutoWash';
		}
		
		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Auto Wash', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A car wash business.', 'schema-premium');
		}
	}
	
	
endif;
