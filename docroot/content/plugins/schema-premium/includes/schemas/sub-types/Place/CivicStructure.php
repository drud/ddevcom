<?php
/**
 * @package Schema Premium - Class Schema CivicStructure
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_CivicStructure') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_CivicStructure extends Schema_WP_Place {
		
		/** @var string Currenct Type */
    	protected $type = 'CivicStructure';
		
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
			
			return __('Civic Structure', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A public structure, such as a town hall or concert hall.', 'schema-premium');
		}
	}
		
endif;
