<?php
/**
 * @package Schema Premium - Class Schema MotorcycleDealer
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_MotorcycleDealer') ) :
	/**
	 * Schema MotorcycleDealer
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_MotorcycleDealer extends Schema_WP_LocalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'MotorcycleDealer';
		
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
			
			return 'MotorcycleDealer';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Motorcycle Dealer', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A motorcycle dealer.', 'schema-premium');
		}
	}
	
	
endif;
