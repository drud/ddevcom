<?php
/**
 * @package Schema Premium - Class Schema PrimaryCare
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_PrimaryCare') ) :
	/**
	 * Schema 
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_PrimaryCare extends Schema_WP_MedicalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'PrimaryCare';
			
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
			
			return 'PrimaryCare';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('PrimaryCare', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('The medical care by a physician, or other health-care professional, who is the patient\'s first contact with the health-care system and who may recommend a specialist if necessary.', 'schema-premium');
		}
	}
	
endif;
