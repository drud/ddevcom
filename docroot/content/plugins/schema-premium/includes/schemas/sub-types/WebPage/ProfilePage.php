<?php
/**
 * @package Schema Premium - Class Schema Profile Page
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_ProfilePage') ) :
	/**
	 * Schema ProfilePage
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_ProfilePage extends Schema_WP_WebPage {
		
		/** @var string Currenct Type */
    	protected $type = 'ProfilePage';
		
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
			
			return __('Profile Page', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('Web page type: Profile page.', 'schema-premium');
		}
	}
	
	//new Schema_WP_ProfilePage();
	
endif;
