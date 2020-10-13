<?php
/**
 * @package Schema Premium - Class Schema GovernmentOffice
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_GovernmentOffice') ) :
	/**
	 * Schema GovernmentOffice
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_GovernmentOffice extends Schema_WP_LocalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'GovernmentOffice';
		
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
			
			return __('Government Office', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A government office—for example, an IRS or DMV office.', 'schema-premium');
		}
	}
	
	//new Schema_WP_GovernmentOffice();
	
endif;
