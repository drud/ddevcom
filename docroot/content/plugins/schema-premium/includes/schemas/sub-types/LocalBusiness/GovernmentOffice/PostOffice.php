<?php
/**
 * @package Schema Premium - Class Schema PostOffice
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_PostOffice') ) :
	/**
	 * Schema PostOffice
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_PostOffice extends Schema_WP_GovernmentOffice {
		
		/** @var string Currenct Type */
    	protected $type = 'PostOffice';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'GovernmentOffice';

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
			
			return 'PostOffice';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Post Office', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A post office.', 'schema-premium');
		}
	}
	
	
endif;
