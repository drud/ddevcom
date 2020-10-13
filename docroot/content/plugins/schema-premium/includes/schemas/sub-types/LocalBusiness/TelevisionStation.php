<?php
/**
 * @package Schema Premium - Class Schema TelevisionStation
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_TelevisionStation') ) :
	/**
	 * Schema TelevisionStation
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_TelevisionStation extends Schema_WP_LocalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'TelevisionStation';
		
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
			
			return __('Television Station', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A television station.', 'schema-premium');
		}
	}
	
	//new Schema_WP_TelevisionStation();
	
endif;
