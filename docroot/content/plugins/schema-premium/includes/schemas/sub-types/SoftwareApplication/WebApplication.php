<?php
/**
 * @package Schema Premium - Class Schema WebApplication
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_WebApplication') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_WebApplication extends Schema_WP_SoftwareApplication {
		
		/** @var string Currenct Type */
    	protected $type = 'WebApplication';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'SoftwareApplication';

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
			
			return 'WebApplication';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Web Application', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('Web applications.', 'schema-premium');
		}

		/**
		* Get properties
		*
		* @since 1.0.2
		* @return array
		*/
		public function properties() {
			
			// Add specific properties 
			//
			$properties['browserRequirements'] =  array(
				'label' 		=> __('Browser Requirements', 'schema-premium'),
				'rangeIncludes' => array('Text'),
				'field_type' 	=> 'text',
				'markup_value' => 'disabled',
				'instructions' 	=> __('Specifies browser requirements in human-readable text. For example, requires HTML5 support.', 'schema-premium'),
			);
			
			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 40 );
			
			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

			return apply_filters( 'schema_properties_WebApplication', $properties );
		}
	}
	
endif;
