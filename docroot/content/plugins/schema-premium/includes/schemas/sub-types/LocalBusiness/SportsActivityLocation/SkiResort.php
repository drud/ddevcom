<?php
/**
 * @package Schema Premium - Class Schema SkiResort

 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_SkiResort') ) :
	/**
	 * Schema SkiResort
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_SkiResort extends Schema_WP_SportsActivityLocation {
		
		/** @var string Currenct Type */
    	protected $type = 'SkiResort';
		
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
			
			return __('Ski Resort', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A ski resort.', 'schema-premium');
		}
	}
	
	
endif;
