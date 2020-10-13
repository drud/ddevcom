<?php
/**
 * @package Schema Premium - Class Schema DryCleaningOrLaundry
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_DryCleaningOrLaundry') ) :
	/**
	 * Schema DryCleaningOrLaundry
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_DryCleaningOrLaundry extends Schema_WP_LocalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'DryCleaningOrLaundry';
		
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
			
			return __('Dry Cleaning or Laundry', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A dry-cleaning business.', 'schema-premium');
		}
	}
	
	//new Schema_WP_DryCleaningOrLaundry();
	
endif;
