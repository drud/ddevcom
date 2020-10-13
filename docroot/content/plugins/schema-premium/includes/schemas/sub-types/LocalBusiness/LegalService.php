<?php
/**
 * @package Schema Premium - Class Schema LegalService
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_LegalService') ) :
	/**
	 * Schema LegalService
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_LegalService extends Schema_WP_LocalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'LegalService';
		
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
			
			return __('Legal Service', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A Legal Service is a business that provides legally-oriented services, advice and representation, e.g. law firms.', 'schema-premium');
		}
	}
	
	//new Schema_WP_LegalService();
	
endif;
