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
	class Schema_WP_Article {
		
		/** @var string Current Type */
    	protected $type = 'Article';
		
		/** @var string Current Parent Type */
    	protected $parent_type = 'Article';
		
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
		* Get properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {
			
			$Thing_properties 			= schema_premium_get_schema_properties('Thing');
			$CreativeWork_properties 	= schema_premium_get_schema_properties('CreativeWork');
			$Article_properties 		= array(
				'Article_properties_tab' => array(
					'label' 		=> '<span style="color:#c90000;">' . $this->type . '</span>',
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'tab',
					'menu_order' 	=> 30,
					'markup_value' 	=> 'none'
				),
				'Article_properties_info' => array(
					'label' => $this->type,
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'message',
					'markup_value' => 'none',
					'instructions' 	=> __('Properties of' , 'schema-premium') . ' ' . $this->type,
					'message'		=> $this->comment(),
				),
				'articleBody' => array(
					'label' 		=> __('Article Body', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'textarea',
					'markup_value' => 'post_content',
					'instructions' 	=> __('A description of the article.', 'schema-premium'),
				),
				'backstory' => array(
					'label' 		=> __('Backstory', 'schema-premium'),
					'rangeIncludes' => array('CreativeWork', 'Text'),
					'field_type' 	=> 'textarea',
					'markup_value' => 'disabled',
					'instructions' 	=> __('For an Article, typically a NewsArticle, the backstory property provides a textual summary giving a brief explanation of why and how an article was created.', 'schema-premium'),
				),
				'Article_properties_tab_endpoint' => array(
					'label' 		=> '', // empty label
					'field_type' 	=> 'tab',
					'markup_value' 	=> 'none'
				),
			);

			$properties = array_merge( $Thing_properties, $CreativeWork_properties, $Article_properties );

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
			
			// Putting all together
			//
			$schema['@context'] 		=  'http://schema.org';
			$schema['@type'] 			=  $this->type;
		
			$schema['mainEntityOfPage'] = array
			(
				'@type' => 'WebPage',
				'@id' => get_permalink( $post->ID )
			);
			
			// Get properties
			//
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			// debug
			//echo '<pre>'; print_r($properties); echo '</pre>';
	
			$schema['url'] 				= isset($properties['url'] ) ? $properties['url'] : get_permalink( $post->ID );
			$schema['headline'] 		= isset($properties['headline'] ) ? $properties['headline'] : '';
			$schema['description'] 		= isset($properties['description'] ) ? $properties['description'] : schema_wp_get_description( $post->ID );
			$schema['image'] 			= isset($properties['image']) ? $properties['image'] : schema_wp_get_media( $post->ID );
			
			$schema['datePublished']	= isset($properties['datePublished'] ) ? $properties['datePublished'] : get_the_date( 'c', $post->ID );
			$schema['dateModified']		= isset($properties['dateModified'] ) ? $properties['dateModified'] : get_post_modified_time( 'c', false, $post->ID, false );
			
			// Author
			//
			if( isset($properties['author'] ) ) { 
				$schema['author'] = array (
					'@type'	=> 'Person',
					'name'	=> $properties['author']
				);
			} else {
				$schema['author'] = schema_wp_get_author_array( $post->ID );
			}
			
			$schema['publisher']		= schema_wp_get_publisher_array();
			
			$schema['articleSection']	= schema_wp_get_post_category( $post->ID );
			$schema['keywords']			= schema_wp_get_post_tags( $post->ID );
			
			$schema['wordCount'] 		= str_word_count( strip_tags( $post->post_content ) );
			
			// Subscription and paywalled content
			//
			if ( isset($properties['isAccessibleForFree']) ) {
				
				if ( $properties['isAccessibleForFree'] == 1 ) {
					// True
					$schema['isAccessibleForFree'] = 'True';
						
				} elseif ( $properties['isAccessibleForFree'] == 0 ) {
					// False
					$schema['isAccessibleForFree'] = 'False';
					if( !isset($properties['cssSelector']) ) {
						$schema['hasPart'] = schema_premium_get_property_cssSelector( $this->parent_type );
					} else {
						$schema['hasPart'] = schema_premium_get_property_cssSelector_fixed( $properties['cssSelector'] );
					}
				}
			}
			
			// Unset auto generated properties
			unset($properties['author']);
			unset($properties['isAccessibleForFree']);
			unset($properties['cssSelector']);
			
			// Merge schema and properties arrays
			// Make sure $properties is an array before merging
			// 
			if ( is_array($properties) ) {
				$schema = array_merge($schema, $properties);
			}
			
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
