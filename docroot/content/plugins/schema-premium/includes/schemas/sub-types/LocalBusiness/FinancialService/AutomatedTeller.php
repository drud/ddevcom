<?php
/**
 * @package Schema Premium - Class Schema AutomatedTeller
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_AutomatedTeller') ) :
	/**
	 * Schema AutomatedTeller
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_AutomatedTeller extends Schema_WP_FinancialService {
		
		/** @var string Currenct Type */
    	protected $type = 'AutomatedTeller';
		
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
			
			return __('AutomatedTeller', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('ATM/cash machine.', 'schema-premium');
		}
	}
	
	
endif;
