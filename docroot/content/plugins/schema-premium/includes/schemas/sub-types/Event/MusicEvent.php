<?php
/**
 * @package Schema Premium - Class Schema MusicEvent
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_MusicEvent') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_MusicEvent extends Schema_WP_Event {
		
		/** @var string Currenct Type */
    	protected $type = 'MusicEvent';
		
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
			
			return __('Music Event', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('Music event.', 'schema-premium');
		}
	}
	
	//new Schema_WP_MusicEvent();
	
endif;
