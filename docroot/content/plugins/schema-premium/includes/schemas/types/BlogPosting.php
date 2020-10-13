<?php
/**
 * @package Schema Premium - Class Schema BlogPosting
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
	
if ( ! class_exists('Schema_WP_BlogPosting') ) :
	/**
	 * Schema Article
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_BlogPosting {
		
		/** @var string Currenct Type */
    	protected $type = 'BlogPosting';
		
		/** @var string Current Parent Type */
    	protected $parent_type = 'BlogPosting';
		
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
			
			return __('Blog Posting', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A blog post.', 'schema-premium');
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
    			'subtypes' 		=> $this->subtypes(),
			);
			
			return apply_filters( 'schema_wp_BlogPosting', $schema );
		}
		
		/**
		* Get sub types
		*
		* @since 1.0.0
		* @return array
		*/
		public function subtypes() {
			
			/*
			$subtypes = array
			(
				'SocialMediaPosting' => __('Social Media Posting', 'schema-premium')
        	);
				
			return apply_filters( 'schema_wp_subtypes_BlogPosting', $subtypes );
			*/
		}
		
		/**
		* Get properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {
			
			$properties = array (
					
					'url' => array(
						'label' 		=> __('URL', 'schema-premium'),
						'rangeIncludes' => array('URL'),
						'field_type' 	=> 'url',
						'markup_value' => 'post_permalink',
						'instructions' 	=> __('URL of the blog post.', 'schema-premium'),
						'placeholder' 	=> 'https://'
					),
					'headline' => array(
						'label' 		=> __('Headline', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'post_title',
						'instructions' 	=> __('Headline of the blog post.', 'schema-premium'),
						'required' 		=> true
					),
					'alternativeHeadline' => array(
						'label' 		=> __('Alternative Headline', 'schema-premium'),
						'rangeIncludes'	=> array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'disabled',
						'instructions' 	=> __('Secondary title of the blog post.', 'schema-premium')
					),
					'image' => array(
						'label' 		=> __('Image', 'schema-premium'),
						'rangeIncludes' => array('ImageObject', 'URL'),
						'field_type' 	=> 'image',
						'markup_value' => 'featured_image',
						'instructions' 	=> __('An image of the blog post.', 'schema-premium'),
						'required' 		=> true
					),
					'datePublished' => array(
						'label' 		=> __('Published Date', 'schema-premium'),
						'rangeIncludes' => array('Date', 'DateTime'),
						'field_type' 	=> 'date_time_picker',
						'markup_value' => 'post_date',
						'instructions' 	=> __('Date of first publication of the blog post.', 'schema-premium'),
						'required' 		=> true
					),
					'dateModified' => array(
						'label' 		=> __('Modified Date', 'schema-premium'),
						'rangeIncludes' => array('Date', 'DateTime'),
						'field_type' 	=> 'date_time_picker',
						'markup_value' => 'post_modified',
						'instructions' 	=> __('The date on which the blog post was most recently modified', 'schema-premium'),
					),
					'author' => array(
						'label' 		=> __('Author Name', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'author_name',
						'instructions' 	=> __('The author of this content or rating. Please note that author is special in that HTML 5 provides a special mechanism for indicating authorship via the rel tag. That is equivalent to this and may be used interchangeably.', 'schema-premium'),
						'required' 		=> true
					),
					'description' => array(
						'label' 		=> __('Description', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'textarea',
						'markup_value' => 'post_excerpt',
						'instructions' 	=> __('A description of the blog post.', 'schema-premium'),
					),
					'isAccessibleForFree' => array(
						'label' 		=> __('Is Accessible For Free', 'schema-premium'),
						'rangeIncludes' => array('Boolean'),
						'field_type' 	=> 'true_false',
						'default_value' => 0,
						'markup_value' => 'disabled',
						'instructions' 	=> __('A flag to signal that the item, event, or place is accessible for free.', 'schema-premium'),
						'ui' => 1,
						'ui_on_text' => __('Yes', 'schema-premium'),
						'ui_off_text' => __('No', 'schema-premium'),
					),
					'cssSelector' => array(
						'label' 		=> __('CSS Selector', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'repeater',
						'layout'		=> 'block',
						'markup_value' => 'disabled',
						'button_label' 	=> __('Add css Selector', 'schema-premium'),
						'instructions' 	=> __('The cssSelector references the class name. (Add a class name around each paywalled section of your page)', 'schema-premium'),
						'sub_fields' 	=>  array(
							'cssSelector_name' => array(
								'label' 		=> '',
								'rangeIncludes' => array('Text'),
								'field_type' 	=> 'text',
								'markup_value' => 'new_custom_field',
								'instructions' 	=> '',
								'placeholder' => __('.class selector for the cssSelector property', 'schema-premium'),
							),
						), // end sub fields
						'conditional_logic' => array(
							array(
								array(
									'field' => 'properties_isAccessibleForFree',
									'operator' => '==',
									'value' => 'fixed_text_field',
								),
							),
							array(
								array(
									'field' => 'properties_isAccessibleForFree',
									'operator' => '==',
									'value' => 'new_custom_field',
								),
							),
							array(
								array(
									'field' => 'properties_isAccessibleForFree',
									'operator' => '==',
									'value' => 'existing_custom_field',
								),
							),
						),
					)
				);
				
			return apply_filters( 'schema_properties_BlogPosting', $properties );	
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
			
			$schema			= array();
			
			// Get properties
			//
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			// Putting all together
			//
			$schema['@context'] 			=  'http://schema.org';
			$schema['@type'] 				=  $this->type;
		
			$schema['mainEntityOfPage'] 	= array
			(
				'@type' => 'WebPage',
				'@id' => get_permalink( $post->ID )
			);
			
			$schema['url'] 				= isset($properties['url'] ) ? $properties['url'] : get_permalink( $post->ID );
			$schema['headline'] 		= isset($properties['headline'] ) ? $properties['headline'] : '';
			$schema['description'] 		= isset($properties['description'] ) ? $properties['description'] : schema_wp_get_description( $post->ID );
			$schema['image'] 			= isset($properties['image']) ? $properties['image'] : schema_wp_get_media( $post->ID );
			
			$schema['datePublished']	= isset($properties['datePublished'] ) ? $properties['datePublished'] : get_the_date( 'c', $post->ID );
			$schema['dateModified']		= isset($properties['dateModified'] ) ? $properties['dateModified'] : get_post_modified_time( 'c', false, $post->ID, false );
			
			// Author
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
		* @since 1.1.2.8
		* @return array
		*/
		public function schema_output_filter( $schema ) {
			
			return apply_filters( 'schema_output_BlogPosting', $schema );
		}
	}
	
	new Schema_WP_BlogPosting();
	
endif;
