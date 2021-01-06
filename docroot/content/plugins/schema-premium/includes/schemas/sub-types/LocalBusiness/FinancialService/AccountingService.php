<?php
/**
 * @package Schema Premium - Class Schema AccountingService
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_AccountingService') ) :
	/**
	 * Schema AccountingService
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_AccountingService extends Schema_WP_FinancialService {
		
		/** @var string Currenct Type */
    	protected $type = 'AccountingService';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'FinancialService';

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
			
			return 'AccountingService';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('AccountingService', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('Accountancy business.', 'schema-premium');
		}
	}
	
	
endif;
