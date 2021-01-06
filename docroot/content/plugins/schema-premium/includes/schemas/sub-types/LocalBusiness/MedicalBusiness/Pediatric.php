<?php
/**
 * @package Schema Premium - Class Schema Pediatric
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Pediatric') ) :
	/**
	 * Schema 
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Pediatric extends Schema_WP_MedicalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'Pediatric';
			
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
			
			return 'Pediatric';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Pediatric', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A specific branch of medical science that specializes in the care of infants, children and adolescents.', 'schema-premium');
		}
	}
	
endif;
