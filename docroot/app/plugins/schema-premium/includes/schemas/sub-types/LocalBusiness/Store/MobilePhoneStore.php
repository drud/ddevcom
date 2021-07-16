<?php
/**
 * @package Schema Premium - Class Schema MobilePhoneStore
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_MobilePhoneStore') ) :
	/**
	 * Schema MobilePhoneStore
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_MobilePhoneStore extends Schema_WP_Store {
		
		/** @var string Currenct Type */
    	protected $type = 'MobilePhoneStore';
			
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
			
			return 'MobilePhoneStore';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('MobilePhone Store', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A store that sells mobile phones and related accessories.', 'schema-premium');
		}
	}
	
endif;
