<?php
/**
 * @package Schema Premium - Class Schema AdministrativeArea
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_AdministrativeArea') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_AdministrativeArea extends Schema_WP_Place {
		
		/** @var string Currenct Type */
    	protected $type = 'AdministrativeArea';
		
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
			
			return __('Administrative Area', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A geographical region, typically under the jurisdiction of a particular government.', 'schema-premium');
		}
	}
		
endif;
