<?php
/**
 * @package Schema Premium - Class Schema AutoRental
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_AutoRental') ) :
	/**
	 * Schema AutoRental
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_AutoRental extends Schema_WP_LocalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'AutoRental';
		
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
			
			return 'AutoRental';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Auto Rental', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A car rental business.', 'schema-premium');
		}
	}
	
	
endif;
