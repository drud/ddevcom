<?php
/**
 * @package Schema Premium - Class Schema EmergencyService
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_EmergencyService') ) :
	/**
	 * Schema EmergencyService
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_EmergencyService extends Schema_WP_LocalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'EmergencyService';
		
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
			
			return __('Emergency Service', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('An emergency service, such as a fire station or ER.', 'schema-premium');
		}
	}
	
	//new Schema_WP_EmergencyService();
	
endif;
