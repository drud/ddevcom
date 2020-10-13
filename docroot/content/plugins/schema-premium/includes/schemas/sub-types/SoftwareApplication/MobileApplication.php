<?php
/**
 * @package Schema Premium - Class Schema MobileApplication
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_MobileApplication') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_MobileApplication extends Schema_WP_SoftwareApplication {
		
		/** @var string Currenct Type */
    	protected $type = 'MobileApplication';
		
		/**
	 	* Constructor
	 	*
	 	* @since 1.0.0
	 	*/
		 public function __construct () {
			
			// empty construct
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Mobile Application', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A software application designed specifically to work well on a mobile device such as a telephone.', 'schema-premium');
		}

		/**
		* Get properties
		*
		* @since 1.0.2
		* @return array
		*/
		public function properties() {
			
			// Get properties from parent class
			$properties = parent::properties();
			
			// Add specific properties 
			$properties['carrierRequirements'] =  array(
				'label' 		=> __('Carrier Requirements', 'schema-premium'),
				'rangeIncludes' => array('Text'),
				'field_type' 	=> 'text',
				'markup_value' => 'disabled',
				'instructions' 	=> __('Specifies specific carrier(s) requirements for the application (e.g. an application may only work on a specific carrier network).', 'schema-premium'),
			);
			
			return apply_filters( 'schema_properties_MobileApplication', $properties );	
		}
	
	}
	
endif;
