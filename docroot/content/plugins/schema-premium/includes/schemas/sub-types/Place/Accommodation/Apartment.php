<?php
/**
 * @package Schema Premium - Class Schema Apartment
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Apartment') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Apartment extends Schema_WP_Accommodation {
		
		/** @var string Currenct Type */
    	protected $type = 'Apartment';
		
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
			
			return __('Apartment', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('An apartment (in American English) or flat (in British English) is a self-contained housing unit (a type of residential real estate) that occupies only part of a building.', 'schema-premium');
		}
	}
	
endif;
