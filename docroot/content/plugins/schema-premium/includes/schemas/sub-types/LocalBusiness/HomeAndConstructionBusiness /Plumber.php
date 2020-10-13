<?php
/**
 * @package Schema Premium - Class Schema Plumber 
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Plumber') ) :
	/**
	 * Schema Plumber
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Plumber extends Schema_WP_HomeAndConstructionBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'Plumber';
		
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
			
			return __('Plumber', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A plumbing service.', 'schema-premium');
		}
	}
	
endif;
