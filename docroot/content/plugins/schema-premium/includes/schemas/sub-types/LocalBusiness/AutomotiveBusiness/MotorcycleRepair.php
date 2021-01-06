<?php
/**
 * @package Schema Premium - Class Schema MotorcycleRepair
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_MotorcycleRepair') ) :
	/**
	 * Schema MotorcycleRepair
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_MotorcycleRepair extends Schema_WP_LocalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'MotorcycleRepair';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'LocalBusiness';
		
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
			
			return 'MotorcycleRepair';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Motorcycle Repair', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A motorcycle repair shop.', 'schema-premium');
		}
	}
	
	
endif;
