<?php
/**
 * @package Schema Premium - Class Schema BarOrPub
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_BarOrPub') ) :
	/**
	 * Schema BarOrPub
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_BarOrPub extends Schema_WP_FoodEstablishment {
		
		/** @var string Currenct Type */
    	protected $type = 'BarOrPub';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'FoodEstablishment';

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
			
			return 'BarOrPub';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Bar Or Pub', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A bar or pub.', 'schema-premium');
		}
	}
	
	
endif;
