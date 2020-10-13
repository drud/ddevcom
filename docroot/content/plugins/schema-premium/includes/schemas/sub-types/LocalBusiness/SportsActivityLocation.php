<?php
/**
 * @package Schema Premium - Class Schema SportsActivityLocation
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_SportsActivityLocation') ) :
	/**
	 * Define class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_SportsActivityLocation extends Schema_WP_LocalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'SportsActivityLocation';
		
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
			
			return __('Sports Activity Location', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A sports location, such as a playing field.', 'schema-premium');
		}
	}
		
endif;
