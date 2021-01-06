<?php
/**
 * @package Schema Premium - Class Schema DiscussionForumPosting
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_DiscussionForumPosting') ) :
	/**
	 * Schema DiscussionForumPosting
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_DiscussionForumPosting extends Schema_WP_Article {
		
		/** @var string Currenct Type */
    	protected $type = 'DiscussionForumPosting';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'Article';

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
			
			return 'DiscussionForumPosting';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Discussion Forum Posting', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A posting to a discussion forum.', 'schema-premium');
		}
		
		/**
		* Apply filters to markup output
		*
		* @since 1.0.0
		* @return array
		*/
		public function schema_output_filter( $schema ) {
			
			return apply_filters( 'schema_output_DiscussionForumPosting', $schema );
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

			return apply_filters( 'schema_properties_DiscussionForumPosting', $properties );	
		}
	}
	
endif;
