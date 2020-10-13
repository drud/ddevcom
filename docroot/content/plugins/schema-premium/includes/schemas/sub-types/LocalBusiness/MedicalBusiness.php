<?php
/**
 * @package Schema Premium - Class Schema MedicalBusiness
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_MedicalBusiness') ) :
	/**
	 * Schema MedicalBusiness
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_MedicalBusiness extends Schema_WP_LocalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'MedicalBusiness';
		
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
			
			return __('Medical Business', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A particular physical or virtual business of an organization for medical purposes. Examples of Medical Business include differents business run by health professionals.', 'schema-premium');
		}
	}
	
	//new Schema_WP_MedicalBusinessy();
	
endif;
