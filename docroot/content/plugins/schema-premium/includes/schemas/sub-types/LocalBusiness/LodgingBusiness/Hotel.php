<?php
/**
 * @package Schema Premium - Class Schema Hotel
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Hotel') ) :
	/**
	 * Schema Hotel
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Hotel extends Schema_WP_LodgingBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'Hotel';
		
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
			
			return __('Hotel', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A hotel is an establishment that provides lodging paid on a short-term basis (Source: Wikipedia, the free encyclopedia, see http://en.wikipedia.org/wiki/Hotel).', 'schema-premium');
		}
	}
	
	
endif;
