<?php
/**
 * @package Schema Premium - Class Schema Resort
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Resort') ) :
	/**
	 * Schema Resort
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Resort extends Schema_WP_LodgingBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'Resort';
		
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
			
			return 'Resort';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Resort', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A resort is a place used for relaxation or recreation, attracting visitors for holidays or vacations. Resorts are places, towns or sometimes commercial establishment operated by a single company (Source: Wikipedia, the free encyclopedia, see http://en.wikipedia.org/wiki/Resort).', 'schema-premium');
		}
	}
	
	
endif;
