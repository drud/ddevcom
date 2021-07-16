<?php
/**
 * @package Schema Premium - Class Schema MovingCompany 
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_MovingCompany') ) :
	/**
	 * Schema MovingCompany
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_MovingCompany extends Schema_WP_HomeAndConstructionBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'MovingCompany';
				
		/** @var string Current Parent Type */
		protected $parent_type = 'HomeAndConstructionBusiness';

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
			
			return 'MovingCompany';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Moving Company', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A moving company.', 'schema-premium');
		}
	}
	
endif;
