<?php
/**
 * @package Schema Premium - Class Schema BowlingAlley
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_BowlingAlley') ) :
	/**
	 * Schema BowlingAlley
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_BowlingAlley extends Schema_WP_SportsActivityLocation {
		
		/** @var string Currenct Type */
    	protected $type = 'BowlingAlley';
			
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
			
			return 'BowlingAlley';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Bowling Alley', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A bowling alley.', 'schema-premium');
		}
	}
	
	
endif;
