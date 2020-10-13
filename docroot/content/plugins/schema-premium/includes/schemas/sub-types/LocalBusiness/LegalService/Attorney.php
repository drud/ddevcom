<?php
/**
 * @package Schema Premium - Class Schema Attorney
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Attorney') ) :
	/**
	 * Schema Attorney
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Attorney extends Schema_WP_LegalService {
		
		/** @var string Currenct Type */
    	protected $type = 'Attorney';
		
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
			
			return __('Attorney', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('Professional service: Attorney.', 'schema-premium');
		}
	}
	
	//new Schema_WP_Attorney();
	
endif;
