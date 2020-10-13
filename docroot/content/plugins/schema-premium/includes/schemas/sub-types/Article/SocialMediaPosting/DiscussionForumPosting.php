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

			// Get parent properties 
			//
			$Article_properties = parent::properties();
			// 
			// Fix tabs
			//
			$Article_properties['Article_properties_tab']['label'] 			= '<span style="color:#c90000;">' . $this->parent_type . '</span>';
			$Article_properties['Article_properties_info']['label'] 		= $this->parent_type;
			$Article_properties['Article_properties_info']['instructions'] 	= __('Properties of' , 'schema-premium') . ' ' . $this->parent_type;
			$Article_properties['Article_properties_info']['message']  		= parent::comment();
			
			$properties = $Article_properties;

			return apply_filters( 'schema_properties_DiscussionForumPosting', $properties );	
		}
	}
	
endif;
