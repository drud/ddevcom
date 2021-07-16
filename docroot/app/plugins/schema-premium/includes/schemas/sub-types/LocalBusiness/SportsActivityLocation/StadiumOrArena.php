<?php
/**
 * @package Schema Premium - Class Schema StadiumOrArena
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_StadiumOrArena') ) :
	/**
	 * Schema StadiumOrArena
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_StadiumOrArena extends Schema_WP_SportsActivityLocation {
		
		/** @var string Currenct Type */
    	protected $type = 'StadiumOrArena';
			
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
			
			return 'StadiumOrArena';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Stadium Or Arena', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A stadium.', 'schema-premium');
		}
	}
	
	
endif;
