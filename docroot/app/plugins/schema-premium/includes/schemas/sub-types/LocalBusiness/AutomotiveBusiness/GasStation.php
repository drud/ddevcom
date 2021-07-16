<?php
/**
 * @package Schema Premium - Class Schema GasStation
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_GasStation') ) :
	/**
	 * Schema GasStation
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_GasStation extends Schema_WP_LocalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'GasStation';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'LocalBusiness';
		
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
			
			return 'GasStation';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Gas Station', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A gas station.', 'schema-premium');
		}
	}
	
endif;
