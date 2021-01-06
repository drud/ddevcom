<?php
/**
 * @package Schema Premium - Class Schema Psychiatric
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Psychiatric') ) :
	/**
	 * Schema 
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Psychiatric extends Schema_WP_MedicalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'Psychiatric';
			
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
			
			return 'Psychiatric';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Psychiatric', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A specific branch of medical science that is concerned with the study, treatment, and prevention of mental illness, using both medical and psychological therapies.', 'schema-premium');
		}
	}
	
endif;
