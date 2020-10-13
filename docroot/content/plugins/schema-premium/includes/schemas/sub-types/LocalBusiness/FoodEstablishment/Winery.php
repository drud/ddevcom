<?php
/**
 * @package Schema Premium - Class Schema Winery
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Winery') ) :
	/**
	 * Schema Winery
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Winery extends Schema_WP_FoodEstablishment {
		
		/** @var string Currenct Type */
    	protected $type = 'Winery';
		
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
			
			return __('Winery', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A winery.', 'schema-premium');
		}
	}
	
	
endif;
