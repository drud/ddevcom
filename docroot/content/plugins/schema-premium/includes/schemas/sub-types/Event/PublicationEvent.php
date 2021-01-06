<?php
/**
 * @package Schema Premium - Class Schema PublicationEvent
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_PublicationEvent') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_PublicationEvent extends Schema_WP_Event {
		
		/** @var string Currenct Type */
    	protected $type = 'PublicationEvent';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'Event';

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
			
			return 'PublicationEvent';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Publication Event', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A PublicationEvent corresponds indifferently to the event of publication for a CreativeWork of any type e.g. a broadcast event, an on-demand event, a book/journal publication via a variety of delivery media.', 'schema-premium');
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
			$properties = schema_properties_wrap_in_tabs( array(), self::type(), self::label(), self::comment(), 40 );
			
			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

			return apply_filters( 'schema_properties_PublicationEvent', $properties );	
		}
	}
	
	//new Schema_WP_PublicationEvent();
	
endif;
