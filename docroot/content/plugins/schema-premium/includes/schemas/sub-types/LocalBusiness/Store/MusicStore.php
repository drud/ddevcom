<?php
/**
 * @package Schema Premium - Class Schema MusicStore
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_MusicStore') ) :
	/**
	 * Schema MusicStore
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_MusicStore extends Schema_WP_Store {
		
		/** @var string Currenct Type */
    	protected $type = 'MusicStore';
		
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
			
			return __('Music Store', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A music store.', 'schema-premium');
		}
	}
	
	//new Schema_WP_MusicStore();
	
endif;
