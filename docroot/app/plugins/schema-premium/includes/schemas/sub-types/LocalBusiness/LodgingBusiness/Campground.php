<?php
/**
 * @package Schema Premium - Class Schema Campground
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Campground') ) :
	/**
	 * Schema Campground
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Campground extends Schema_WP_LodgingBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'Campground';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'LodgingBusiness';

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
			
			return 'Campground';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Campground', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A camping site, campsite, or Campground is a place used for overnight stay in the outdoors, typically containing individual CampingPitch locations.', 'schema-premium');
		}
	}
	
	
endif;
