<?php
/**
 * @package Schema Premium - Class Schema DepartmentStore
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_DepartmentStore') ) :
	/**
	 * Schema DepartmentStore
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_DepartmentStore extends Schema_WP_Store {
		
		/** @var string Currenct Type */
    	protected $type = 'DepartmentStore';
		
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
			
			return __('Department Store', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A department store.', 'schema-premium');
		}
	}
	
endif;
