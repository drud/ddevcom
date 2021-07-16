<?php
/**
 * @package Schema Premium - Class Schema HVACBusiness 
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_HVACBusiness') ) :
	/**
	 * Schema HVACBusiness
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_HVACBusiness extends Schema_WP_HomeAndConstructionBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'HVACBusiness';
				
		/** @var string Current Parent Type */
		protected $parent_type = 'HomeAndConstructionBusiness';

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
			
			return 'HVACBusiness';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('HVAC Business', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A business that provide Heating, Ventilation and Air Conditioning services.', 'schema-premium');
		}
	}
	
endif;
