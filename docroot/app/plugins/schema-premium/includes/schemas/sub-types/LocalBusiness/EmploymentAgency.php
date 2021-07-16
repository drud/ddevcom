<?php
/**
 * @package Schema Premium - Class Schema EmploymentAgency
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_EmploymentAgency') ) :
	/**
	 * Schema EmploymentAgency
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_EmploymentAgency extends Schema_WP_LocalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'EmploymentAgency';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'LocalBusiness';

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
			
			return 'EmploymentAgency';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Employment Agency', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('An employment agency.', 'schema-premium');
		}

		/**
		* Get properties
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

			return apply_filters( 'schema_properties_EmploymentAgency', $properties );	
		}
	}
	
	//new Schema_WP_EmploymentAgency();
	
endif;
