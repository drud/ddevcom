<?php
/**
 * @package Schema Premium - Class Schema Dentist
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Dentist') ) :
	/**
	 * Schema Dentist
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Dentist extends Schema_WP_LocalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'Dentist';
		
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
			
			return __('Dentist', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A dentist.', 'schema-premium');
		}
	}
	
	//new Schema_WP_Dentist();
	
endif;
