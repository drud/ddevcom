<?php
/**
 * @package Schema Premium - Class Schema GeneralContractor 
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_GeneralContractor') ) :
	/**
	 * Schema GeneralContractor
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_GeneralContractor extends Schema_WP_HomeAndConstructionBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'GeneralContractor';
				
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
			
			return 'GeneralContractor';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('General Contractor', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A general contractor.', 'schema-premium');
		}
	}
	
endif;
