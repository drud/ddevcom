<?php
/**
 * @package Schema Premium - Class Schema NailSalon
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_NailSalon') ) :
	/**
	 * Schema NailSalon
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_NailSalon extends Schema_WP_HealthAndBeautyBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'NailSalon';
		
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
			
			return __('Nail Salon', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A nail salon.', 'schema-premium');
		}
	}
	
	
endif;
