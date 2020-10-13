<?php
/**
 * @package Schema Premium - Class Schema CampingPitch
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_CampingPitch') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_CampingPitch extends Schema_WP_Accommodation {
		
		/** @var string Currenct Type */
    	protected $type = 'CampingPitch';
		
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
			
			return __('Camping Pitch', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A CampingPitch is an individual place for overnight stay in the outdoors, typically being part of a larger camping site, or Campground.', 'schema-premium');
		}
	}
	
endif;
