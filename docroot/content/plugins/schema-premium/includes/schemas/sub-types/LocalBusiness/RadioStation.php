<?php
/**
 * @package Schema Premium - Class Schema RadioStation
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_RadioStation') ) :
	/**
	 * Schema RadioStation
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_RadioStation extends Schema_WP_LocalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'RadioStation';
		
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
			
			return __('Radio Station', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A radio station.', 'schema-premium');
		}
	}
	
	//new Schema_WP_RadioStation();
	
endif;
