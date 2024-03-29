<?php
/**
 * @package Schema Premium - Class Schema LandmarksOrHistoricalBuildings
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_LandmarksOrHistoricalBuildings') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_LandmarksOrHistoricalBuildings extends Schema_WP_Place {
		
		/** @var string Currenct Type */
    	protected $type = 'LandmarksOrHistoricalBuildings';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'Place';

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
			
			return 'LandmarksOrHistoricalBuildings';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Landmarks Or Historical Buildings', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('An historical landmark or building.', 'schema-premium');
		}
	}
		
endif;
