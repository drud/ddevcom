<?php
/**
 * @package Schema Premium - Class Schema PublicSwimmingPool
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_PublicSwimmingPool') ) :
	/**
	 * Schema PublicSwimmingPool
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_PublicSwimmingPool extends Schema_WP_SportsActivityLocation {
		
		/** @var string Currenct Type */
    	protected $type = 'PublicSwimmingPool';
			
		/** @var string Current Parent Type */
		protected $parent_type = 'SportsActivityLocation';

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
			
			return 'PublicSwimmingPool';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Public Swimming Pool', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A public swimming pool.', 'schema-premium');
		}
	}
	
	
endif;
