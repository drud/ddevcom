<?php
/**
 * @package Schema Premium - Class Schema PoliceStation
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_PoliceStation') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_PoliceStation extends Schema_WP_EmergencyService {
		
		/** @var string Currenct Type */
    	protected $type = 'PoliceStation';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'EmergencyService';
		
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
			
			return 'PoliceStation';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Police Station', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A police station.', 'schema-premium');
		}
	}
	
endif;
