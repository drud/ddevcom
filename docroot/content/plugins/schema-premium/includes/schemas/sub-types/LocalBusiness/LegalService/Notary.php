<?php
/**
 * @package Schema Premium - Class Schema Notary
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Notary') ) :
	/**
	 * Schema Notary
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Notary extends Schema_WP_LegalService {
		
		/** @var string Currenct Type */
    	protected $type = 'Notary';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'LegalService';

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
			
			return 'Notary';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Notary', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A notary.', 'schema-premium');
		}
	}
	
	//new Schema_WP_Notary();
	
endif;
