<?php
/**
 * @package Schema Premium - Class Schema MedicalClinic
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_MedicalClinic') ) :
	/**
	 * Schema 
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_MedicalClinic extends Schema_WP_MedicalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'MedicalClinic';
			
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
			
			return 'MedicalClinic';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('MedicalClinic', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A facility, often associated with a hospital or medical school, that is devoted to the specific diagnosis and/or healthcare. Previously limited to outpatients but with evolution it may be open to inpatients as well.', 'schema-premium');
		}
	}
	
endif;
