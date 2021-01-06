<?php
/**
 * @package Schema Premium - Class Schema Motel
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Motel') ) :
	/**
	 * Schema Motel
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Motel extends Schema_WP_LodgingBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'Motel';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'LodgingBusiness';

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
			
			return 'Motel';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Motel', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A motel.', 'schema-premium');
		}
	}
	
	
endif;
