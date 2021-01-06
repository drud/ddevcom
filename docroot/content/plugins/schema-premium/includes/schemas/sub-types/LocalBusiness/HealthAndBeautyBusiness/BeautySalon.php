<?php
/**
 * @package Schema Premium - Class Schema BeautySalon
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_BeautySalon') ) :
	/**
	 * Schema BeautySalon
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_BeautySalon extends Schema_WP_HealthAndBeautyBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'BeautySalon';
				
		/** @var string Current Parent Type */
		protected $parent_type = 'HealthAndBeautyBusiness';

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
			
			return 'BeautySalon';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Beauty Salon', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('Beauty salon.', 'schema-premium');
		}
	}
	
	
endif;
