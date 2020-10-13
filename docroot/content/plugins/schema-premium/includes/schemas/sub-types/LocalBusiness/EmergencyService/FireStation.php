<?php
/**
 * @package Schema Premium - Class Schema FireStation
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_FireStation') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_FireStation extends Schema_WP_EmergencyService {
		
		/** @var string Currenct Type */
    	protected $type = 'FireStation';
		
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
			
			return __('Fire Station', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A fire station. With firemen.', 'schema-premium');
		}
	}
	
endif;
