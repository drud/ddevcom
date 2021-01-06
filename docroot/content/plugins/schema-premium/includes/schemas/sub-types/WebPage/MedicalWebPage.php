<?php
/**
 * @package Schema Premium - Class Schema Medical Web Page
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_MedicalWebPage') ) :
	/**
	 * Schema MedicalWebPage
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_MedicalWebPage extends Schema_WP_WebPage {
		
		/** @var string Currenct Type */
    	protected $type = 'MedicalWebPage';
		
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
			
			return 'MedicalWebPage';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Medical Web Page', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A web page that provides medical information.', 'schema-premium');
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

			return apply_filters( 'schema_properties_MedicalWebPage', $properties );		
		}
	}
	
	//new Schema_WP_MedicalWebPage();
	
endif;
