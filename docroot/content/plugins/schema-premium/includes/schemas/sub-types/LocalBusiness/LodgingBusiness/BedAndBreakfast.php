<?php
/**
 * @package Schema Premium - Class Schema BedAndBreakfast
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_BedAndBreakfast') ) :
	/**
	 * Schema BedAndBreakfast
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_BedAndBreakfast extends Schema_WP_LodgingBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'BedAndBreakfast';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'LodgingBusiness';

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
			
			return 'BedAndBreakfast';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Bed And Breakfast', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('Bed and breakfast.', 'schema-premium');
		}
	}
	
	
endif;
