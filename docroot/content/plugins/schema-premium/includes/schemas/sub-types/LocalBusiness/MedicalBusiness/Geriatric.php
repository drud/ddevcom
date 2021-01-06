<?php
/**
 * @package Schema Premium - Class Schema Geriatric
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Geriatric') ) :
	/**
	 * Schema 
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Geriatric extends Schema_WP_MedicalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'Geriatric';
			
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
			
			return 'Geriatric';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Geriatric', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A specific branch of medical science that is concerned with the diagnosis and treatment of diseases, debilities and provision of care to the aged.', 'schema-premium');
		}
	}
	
endif;
