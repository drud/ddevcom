<?php
/**
 * @package Schema Premium - Class Schema WebApplication
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_WebApplication') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_WebApplication extends Schema_WP_SoftwareApplication {
		
		/** @var string Currenct Type */
    	protected $type = 'WebApplication';
		
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
			
			return __('Web Application', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('Web applications.', 'schema-premium');
		}
	}
	
endif;
