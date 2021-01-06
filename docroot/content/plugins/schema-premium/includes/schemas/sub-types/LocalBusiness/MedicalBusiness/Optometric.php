<?php
/**
 * @package Schema Premium - Class Schema Optometric
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Optometric') ) :
	/**
	 * Schema 
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Optometric extends Schema_WP_MedicalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'Optometric';
			
		/** @var string Current Parent Type */
		protected $parent_type = 'MedicalBusiness';

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
			
			return 'Optometric';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Optometric', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('The science or practice of testing visual acuity and prescribing corrective lenses.', 'schema-premium');
		}
	}
	
endif;
