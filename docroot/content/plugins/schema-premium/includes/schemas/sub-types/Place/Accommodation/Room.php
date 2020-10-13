<?php
/**
 * @package Schema Premium - Class Schema Room
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Room') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Room extends Schema_WP_Accommodation {
		
		/** @var string Currenct Type */
    	protected $type = 'Room';
		
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
			
			return __('Room', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A room is a distinguishable space within a structure, usually separated from other spaces by interior walls.', 'schema-premium');
		}
	}
	
endif;
