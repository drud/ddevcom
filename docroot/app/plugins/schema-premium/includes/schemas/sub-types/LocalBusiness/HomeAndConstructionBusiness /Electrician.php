<?php
/**
 * @package Schema Premium - Class Schema Electrician 
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Electrician') ) :
	/**
	 * Schema Electrician
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Electrician extends Schema_WP_HomeAndConstructionBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'Electrician';
				
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
			
			return 'Electrician';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Electrician', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('An electrician.', 'schema-premium');
		}
	}
	
endif;
