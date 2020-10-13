<?php
/**
 * @package Schema Premium - Class Schema FAQPage
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_FAQPage') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_FAQPage {
		
		/** @var string Current Type */
    	protected $type = 'FAQPage';
		
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
			
			return __('FAQ Page', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A FAQPage is a WebPage presenting one or more "Frequently asked questions".', 'schema-premium');
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
			
			return apply_filters( 'schema_wp_FAQPage', $schema );
		}
		
		/**
		* Get sub types
		*
		* @since 1.0.0
		* @return array
		*/
		public function subtypes() {
		
			$subtypes = array();
				
			return apply_filters( 'schema_wp_subtypes_FAQPage', $subtypes );
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
						'instructions' 	=> __('URL of the article.', 'schema-premium'),
						'placeholder' 	=> 'https://'
					),
					'headline' => array(
						'label' 		=> __('Headline', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'post_title',
						'instructions' 	=> __('Headline of the article', 'schema-premium'),
						'required' 		=> true
					),
					'alternativeHeadline' => array(
						'label' 		=> __('Alternative Headline', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'disabled',
						'instructions' 	=> __('Secondary title for this article.', 'schema-premium')
					),
					'image' => array(
						'label' 		=> __('Image', 'schema-premium'),
						'rangeIncludes' => array('ImageObject', 'URL'),
						'field_type' 	=> 'image',
						'markup_value' => 'featured_image',
						'instructions' 	=> __('An image of the article.', 'schema-premium'),
						'required' 		=> true
					),
					'datePublished' => array(
						'label'			=> __('Published Date', 'schema-premium'),
						'rangeIncludes' => array('Date', 'DateTime'),
						'field_type' 	=> 'date_time_picker',
						'markup_value' => 'post_date',
						'instructions' 	=> __('Date of first publication of the article.', 'schema-premium'),
						'display_format' => get_option( 'date_format' ), // WP
						'return_format' => 'Y-m-d',
						'required' 		=> true
					),
					'dateModified' => array(
						'label' 		=> __('Modified Date', 'schema-premium'),
						'rangeIncludes' => array('Date', 'DateTime'),
						'field_type' 	=> 'date_time_picker',
						'markup_value' => 'post_modified',
						'instructions' 	=> __('The date on which the article was most recently modified', 'schema-premium'),
						'display_format' => get_option( 'date_format' ), // WP
						'return_format' => 'Y-m-d',
					),
					'author' => array(
						'label' 		=> __('Author Name', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'author_name',
						'instructions' 	=> __('The author name of this article.', 'schema-premium'),
						'required' 		=> true
					),
					'description' => array(
						'label' 		=> __('Description', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'textarea',
						'markup_value' => 'post_excerpt',
						'instructions' 	=> __('A description of the article.', 'schema-premium'),
					),
					'question_answer' => array(
						'label' 		=> __('Question & Answer', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'repeater',
						'layout'		=> 'block',
						'markup_value' => 'new_custom_field',
						//'required' 		=> true,
						'button_label' 	=> __('Add FAQ', 'schema-premium'),
						'instructions' 	=> __('FAQ (Frequently asked questions), and answers.', 'schema-premium'),
						'sub_fields' 	=>  array(
							'question_item' => array(
								'label' 		=> __('Question', 'schema-premium'),
								'rangeIncludes' => array('Text'),
								'field_type' 	=> 'text',
								'markup_value' => 'new_custom_field',
								'instructions' 	=> '',
								'placeholder' => __('Question', 'schema-premium'),
							),
							'answer_item' => array(
								'label' 		=> __('Answer', 'schema-premium'),
								'rangeIncludes' => array('Text'),
								'field_type' 	=> 'textarea',
								'markup_value' => 'new_custom_field',
								'instructions' 	=> '',
								'placeholder' => __('Answer', 'schema-premium'),
								'rows' => 2
							),
						), // end sub fields
					),
				);
				
			return apply_filters( 'schema_properties_FAQPage', $properties );	
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
			
			// Get mainEntity
			$schema['mainEntity'] = $this->get_question_answer();
						
			// Get properties
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			$schema['url'] 				= isset($properties['url'] ) ? $properties['url'] : get_permalink( $post->ID );
			$schema['headline'] 		= isset($properties['headline'] ) ? $properties['headline'] : '';
			$schema['description'] 		= isset($properties['description'] ) ? $properties['description'] : schema_wp_get_description( $post->ID );
			$schema['image'] 			= isset($properties['image']) ? $properties['image'] : schema_wp_get_media( $post->ID );
			
			$schema['datePublished']	= isset($properties['datePublished'] ) ? $properties['datePublished'] : get_the_date( 'c', $post->ID );
			$schema['dateModified']		= isset($properties['dateModified'] ) ? $properties['dateModified'] : get_post_modified_time( 'c', false, $post->ID, false );
			
			if( isset($properties['author'] ) ) { 
				$schema['author'] = array (
					'@type'	=> 'Person',
					'name'	=> $properties['author']
				);
			} else {
				$schema['author'] = schema_wp_get_author_array( $post->ID );
			}
			
			$schema['publisher']		= schema_wp_get_publisher_array();
			
			$schema['keywords']			= schema_wp_get_post_tags( $post->ID );
			
			// Unset auto generated properties
			unset($properties['author']);
			
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
			
			return apply_filters( 'schema_output_FAQPage', $schema );
		}
		
		/**
		* Get mainEntity Questions and Answers
		*
		* @since 1.0.0
		* @return array
		*/
		public function get_question_answer() {
	
			$output = array();
	
			$count = get_post_meta( get_the_ID(), 'schema_properties_FAQPage_question_answer', true );
	
			if ( isset( $count ) && $count >= 0 ) {
		 
				for( $i=0; $i < $count; $i++ ) {
					$question 	= get_post_meta( get_the_ID(), 'schema_properties_FAQPage_question_answer_' . $i . '_question_item', true );
					$answer 	= get_post_meta( get_the_ID(), 'schema_properties_FAQPage_question_answer_' . $i . '_answer_item', true );
					
					$output[] = array
					(
						'@type'				=> 'Question',
						'name'				=> strip_tags($question),
						'acceptedAnswer' 	=> array
						(
							'@type' => 'Answer',
							'text'	=> strip_tags($answer)
						)
					);
				}
		
			}
	
			return $output;
		}
		
	}
	
	new Schema_WP_FAQPage();
	
endif;
