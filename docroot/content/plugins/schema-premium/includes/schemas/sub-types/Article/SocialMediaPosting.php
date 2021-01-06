<?php
/**
 * @package Schema Premium - Class Schema SocialMediaPosting
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_SocialMediaPosting') ) :
	/**
	 * Schema Article
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_SocialMediaPosting extends Schema_WP_Article {
		
		/** @var string Currenct Type */
    	protected $type = 'SocialMediaPosting';
		
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
			
			return 'SocialMediaPosting';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Social Media Posting', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A post to a social media platform, including blog posts, tweets, Facebook posts, etc.', 'schema-premium');
		}

		/**
		* Get sub types
		*
		* @since 1.2
		* @return array
		*/
		public function subtypes() {
			
			$subtypes = array
			(
				'BlogPosting' 				=> __('Blog Posting', 'schema-premium'),
				'DiscussionForumPosting' 	=> __('Discussion Forum Posting', 'schema-premium')
        	);
				
			return apply_filters( 'schema_wp_subtypes_SocialMediaPosting', $subtypes );
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

			return apply_filters( 'schema_properties_SocialMediaPosting', $properties );	
		}
	}
	
endif;
