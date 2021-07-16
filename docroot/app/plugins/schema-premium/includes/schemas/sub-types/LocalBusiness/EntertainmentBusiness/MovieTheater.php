<?php
/**
 * @package Schema Premium - Class Schema MovieTheater
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_MovieTheater') ) :
	/**
	 * Schema MovieTheater
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_MovieTheater extends Schema_WP_EntertainmentBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'MovieTheater';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'EntertainmentBusiness';

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
			
			return 'MovieTheater';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Movie Theater', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A movie theater.', 'schema-premium');
		}
	}
	
	
endif;
