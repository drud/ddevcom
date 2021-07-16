<?php
/**
 * @package Schema Premium - Class Schema Checkout Page
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_CheckoutPage') ) :
	/**
	 * Schema CheckoutPage
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_CheckoutPage extends Schema_WP_WebPage {
		
		/** @var string Currenct Type */
    	protected $type = 'CheckoutPage';
		
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
			
			return 'CheckoutPage';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Checkout Page', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('Web page type: Checkout page.', 'schema-premium');
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

			return apply_filters( 'schema_properties_CheckoutPage', $properties );		
		}
	}
	
	//new Schema_WP_CheckoutPage();
	
endif;
