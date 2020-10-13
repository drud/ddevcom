<?php
/**
 * @package Schema Premium - Class Schema HealthAndBeautyBusiness
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_HealthAndBeautyBusiness') ) :
	/**
	 * Schema HealthAndBeautyBusiness
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_HealthAndBeautyBusiness extends Schema_WP_LocalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'HealthAndBeautyBusiness';
		
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
			
			return __('Health and Beauty Business', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('Health and beauty.', 'schema-premium');
		}
	}
	
	//new Schema_WP_HealthAndBeautyBusiness();
	
endif;
