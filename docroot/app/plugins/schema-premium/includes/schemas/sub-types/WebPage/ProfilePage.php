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
		
		/** @var string Current Parent Type */
		protected $parent_type = 'WebPage';

		/**
	 	* Constructor
	 	*
	 	* @since 1.0.0
	 	*/
		public function __construct () {
		
			// emty __construct
		}
		
		/**
		* Get schema type 
		*
		* @since 1.2
		* @return string
		*/
		public function type() {
			
			return 'ProfilePage';
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

		/**
		* Properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {
			
			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( array(), self::type(), self::label(), self::comment(), 30 );

			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

			return apply_filters( 'schema_properties_ProfilePage', $properties );		
		}
	}
	
	//new Schema_WP_ProfilePage();
	
endif;
