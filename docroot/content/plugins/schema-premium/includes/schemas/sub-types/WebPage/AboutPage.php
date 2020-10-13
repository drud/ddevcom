<?php
/**
 * @package Schema Premium - Class Schema About Page
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_AboutPage') ) :
	/**
	 * Schema AboutPage
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_AboutPage extends Schema_WP_WebPage {
		
		/** @var string Currenct Type */
    	protected $type = 'AboutPage';
		
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
			
			return __('About Page', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('Web page type: About page.', 'schema-premium');
		}
	}
	
	//new Schema_WP_AboutPage();
	
endif;
