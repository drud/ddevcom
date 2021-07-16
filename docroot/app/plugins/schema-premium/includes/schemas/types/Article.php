<?php
/**
 * @package Schema Premium - Class Schema Article
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Article') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Article extends Schema_WP_CreativeWork {
		
		/** @var string Current Type */
    	protected $type = 'Article';
		
		/** @var string Current Parent Type */
    	protected $parent_type = 'CreativeWork';
	
		/**
	 	* Constructor
	 	*
	 	* @since 1.0.0
	 	*/
		public function __construct () {
			
			$this->init();
		}
	
		/**
		* Init
		*
		* @since 1.0.0
	 	*/
		public function init() {
		
			add_filter( 'schema_wp_get_default_schemas', array( $this, 'schema_type' ) );
			add_filter( 'schema_wp_types', array( $this, 'schema_type_extend' ) );
		}
		
		/**
		* Get schema type 
		*
		* @since 1.2
		* @return string
		*/
		public function type() {
			
			return 'Article';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Article', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('An article, such as a news article or piece of investigative report. Newspapers and magazines have articles of many different types and this is intended to cover them all. (See also blog post).', 'schema-premium');
		}
		
		/**
		* Extend schema types
		*
		* @since 1.0.0
		* @return array
		*/
		public function schema_type_extend( $schema_types ) {
			
			$schema_types[$this->type] = array 
				(
					'label' => $this->label(),
					'value'	=> $this->type
				);
			
			return $schema_types;
		}
		
		/**
		* Get schema type
		*
		* @since 1.0.0
		* @return array
		*/
		public function schema_type( $schema ) {
			
			$schema[$this->type] = array (
    			'id' 			=> $this->type,
    			'lable' 		=> $this->label(),
				'comment' 		=> $this->comment(),
    			'properties'	=> $this->properties(),
				'subtypes' 		=> $this->subtypes()
			);
			
			return apply_filters( 'schema_wp_Article', $schema );
		}
		
		/**
		* Get sub types
		*
		* @since 1.0.0
		* @return array
		*/
		public function subtypes() {
		
			$subtypes = array
			(	
				'Article' => array
				(
            		'AdvertiserContentArticle' 	=> __('Advertiser Content Article', 'schema-premium'),
					'NewsArticle' 				=> __('News Article', 'schema-premium'),
					'Report'					=> __('Report', 'schema-premium'),
					'SatiricalArticle' 			=> __('Satirical Article', 'schema-premium'),
					'ScholarlyArticle' 			=> __('Scholarly Article', 'schema-premium'),
					'SocialMediaPosting' 		=> __('Social Media Posting', 'schema-premium'),
					'TechArticle' 				=> __('Tech Article', 'schema-premium')	
				),
				'Social Media Posting' => array
				(
            		'BlogPosting' 				=> __('Blog Posting', 'schema-premium'),
					'DiscussionForumPosting' 	=> __('Discussion Forum Posting', 'schema-premium')
				),
			);
				
			return apply_filters( 'schema_wp_subtypes_Article', $subtypes );
		}
		
		/**
		* Properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {

			$properties = array(

				'articleBody' => array(
					'label' 		=> __('Article Body', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'textarea',
					'markup_value' 	=> 'post_content',
					'instructions' 	=> __('A description of the article.', 'schema-premium'),
				),
				'backstory' => array(
					'label' 		=> __('Backstory', 'schema-premium'),
					'rangeIncludes' => array('CreativeWork', 'Text'),
					'field_type' 	=> 'textarea',
					'markup_value' 	=> 'disabled',
					'instructions' 	=> __('For an Article, typically a NewsArticle, the backstory property provides a textual summary giving a brief explanation of why and how an article was created.', 'schema-premium'),
				)
			);

			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 30 );

			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

			return apply_filters( 'schema_properties_Article', $properties );	
		}

		/**
		* Schema output
		*
		* @since 1.0.0
		* @return array
		*/
		public function schema_output( $post_id = null ) {
			
			if ( isset($post_id) ) {
				$post = get_post( $post_id );
			} else {
				global $post;
			}
			
			$schema = array();
			
			// Get main entity of page
			//
			$schema['mainEntityOfPage'] = array
			(
				'@type' => 'WebPage',
				'@id' => get_permalink( $post->ID ) . '#webpage'
			);
			
			// Get properties
			//
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			// Merge parent schema 
			//
			$schema = array_merge( parent::schema_output($post->ID), $schema );

			// debug
			//echo '<pre>'; print_r($schema); echo '</pre>';

			return $this->schema_output_filter($schema);
		}
		
		/**
		* Apply filters to markup output
		*
		* @since 1.1.2
		* @return array
		*/
		public function schema_output_filter( $schema ) {
			
			return apply_filters( 'schema_output_Article', $schema );
		}
	}
	
	new Schema_WP_Article();
	
endif;
