<?php
/**
 * @package Schema Premium - Class Schema House
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_House') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_House extends Schema_WP_Accommodation {
		
		/** @var string Currenct Type */
    	protected $type = 'House';
		
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
			
			return __('House', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A house is a building or structure that has the ability to be occupied for habitation by humans or other creatures.', 'schema-premium');
		}		

	}
	
endif;
