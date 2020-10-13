<?php
/**
 * @package Schema Premium - Class Schema NightClub
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_NightClub') ) :
	/**
	 * Schema NightClub
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_NightClub extends Schema_WP_EntertainmentBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'NightClub';
		
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
			
			return __('Night Club', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A nightclub or discotheque.', 'schema-premium');
		}
	}
	
	
endif;