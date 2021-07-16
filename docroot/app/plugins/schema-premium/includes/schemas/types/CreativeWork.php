<?php
/**
 * @package Schema Premium - Class Schema CreativeWork
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_CreativeWork') ) :
	/**
	 * Class
	 *
	 * @since 1.2
	 */
	class Schema_WP_CreativeWork extends Schema_WP_Thing {
		
		/** @var string Current Type */
    	protected $type = 'CreativeWork';
		
		/** @var string Current Parent Type */
    	protected $parent_type = 'Thing'; 
		
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
			
			return 'CreativeWork';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Creative Work', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('The most generic kind of creative work, including books, movies, photographs, software programs, etc.', 'schema-premium');
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
			
			return apply_filters( 'schema_wp_CreativeWork', $schema );
		}
		
		/**
		* Get sub types
		*
		* @since 1.0.0
		* @return array
		*/
		public function subtypes() {
			
			// This is not used, since subtypes are introduced somewhere else!
			// @TODO release these when types are completed, also complete the list of subtypes
			//
			$subtypes = array
			(	
				/*
				'ArchiveComponent' 		=> __('Archive Component', 'schema-premium'),
				'Article' 				=> __('Article', 'schema-premium'),
				'Atlas'					=> __('Atlas', 'schema-premium'),
				'Blog' 					=> __('Blog', 'schema-premium'),
				'Book' 					=> __('Book', 'schema-premium'),
				'Chapter' 				=> __('Chapter', 'schema-premium'),
				'Claim' 				=> __('Claim', 'schema-premium'),
				'Clip' 					=> __('Clip', 'schema-premium'),
				'Collection' 			=> __('Collection', 'schema-premium')	
				*/
			);
			
			return apply_filters( 'schema_wp_subtypes_CreativeWork', $subtypes );
		}
		
		/**
		* Properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {
			
			$properties = array(

				'headline' => array(
					'label' 		=> __('Headline', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'post_title',
					'instructions' 	=> __('Headline of the article', 'schema-premium'),
					'required' 		=> true
				),
				'alternativeHeadline' => array(
					'label' 		=> __('Alternative Headline', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('A secondary title of the CreativeWork.', 'schema-premium')
				),
				'dateCreated' => array(
					'label'			 => __('Date Created', 'schema-premium'),
					'rangeIncludes'  => array('Date', 'DateTime'),
					'field_type' 	 => 'date_time_picker',
					'markup_value'   => 'post_date',
					'instructions'   => __('The date on which the CreativeWork was created or the item was added to a DataFeed.', 'schema-premium'),
					'display_format' => get_option( 'date_format' ), // WP
					'return_format'  => 'Y-m-d',
				),
				'datePublished' => array(
					'label'			 => __('Published Date', 'schema-premium'),
					'rangeIncludes'  => array('Date', 'DateTime'),
					'field_type' 	 => 'date_time_picker',
					'markup_value'   => 'post_date',
					'instructions' 	 => __('Date of first broadcast or publication.', 'schema-premium'),
					'display_format' => get_option( 'date_format' ), // WP
					'return_format'  => 'Y-m-d',
					'required' 		 => true
				),
				'dateModified' => array(
					'label' 		 => __('Modified Date', 'schema-premium'),
					'rangeIncludes'  => array('Date', 'DateTime'),
					'field_type' 	 => 'date_time_picker',
					'markup_value'   => 'post_modified',
					'instructions' 	 => __('The date on which the CreativeWork was most recently modified or when the item\'s entry was modified within a DataFeed', 'schema-premium'),
					'display_format' => get_option( 'date_format' ), // WP
					'return_format'  => 'Y-m-d',
				),
				'author' => array(
					'label' 		=> __('Author Name', 'schema-premium'),
					'rangeIncludes' => array('Organization', 'Person'),
					'field_type' 	=> 'text',
					'markup_value'  => 'author_name',
					'instructions' 	=> __('The author of this content or rating.', 'schema-premium'),
					'required' 		=> true
				),
				'award' => array(
					'label' 		=> __('Award', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled', 
					'instructions' 	=> __('An award won by or for this item.', 'schema-premium')
				),
				'contentRating' => array(
					'label' 		=> __('Content Rating', 'schema-premium'),
					'rangeIncludes' => array('Rating', 'Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',  
					'instructions' 	=> __('Official rating of a piece of content, example "MPAA PG-13".', 'schema-premium')
				),
				'abstract' => array(
					'label' 		=> __('Abstract', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',  //post_excerpt
					'instructions' 	=> __('An abstract is a short description that summarizes a CreativeWork.', 'schema-premium')
				),
				/*'accessMode' => array(
					'label' 		=> __('Access Mode', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text', // @todo make a select box
					'markup_value' => 'disabled', 
					'instructions' 	=> __('The human sensory perceptual system or cognitive faculty through which a person may process or perceive information. Expected values include: auditory, tactile, textual, visual, colorDependent, chartOnVisual, chemOnVisual, diagramOnVisual, mathOnVisual, musicOnVisual, textOnVisual.', 'schema-premium')
				),*/
				'isAccessibleForFree' => array(
					'label' 		=> __('Is Accessible For Free', 'schema-premium'),
					'rangeIncludes' => array('Boolean'),
					'field_type' 	=> 'true_false',
					'default_value' => 0,
					'markup_value'  => 'disabled',
					'instructions' 	=> __('A flag to signal that the item, event, or place is accessible for free.', 'schema-premium'),
					'ui' 			=> 1,
					'ui_on_text'  	=> __('Yes', 'schema-premium'),
					'ui_off_text' 	=> __('No', 'schema-premium'),
				),
				'cssSelector' => array(
					'label' 		=> __('CSS Selector', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'repeater',
					'layout'		=> 'block',
					'markup_value'  => 'disabled',
					'button_label' 	=> __('Add css Selector', 'schema-premium'),
					'instructions' 	=> __('The cssSelector references the class name. (Add a class name around each paywalled section of your page)', 'schema-premium'),
					'sub_fields' 	=>  array(
						'cssSelector_name' => array(
							'label' 		=> '',
							'rangeIncludes' => array('Text'),
							'field_type' 	=> 'text',
							'markup_value' 	=> 'disabled',
							'instructions' 	=> '',
							'placeholder' 	=> __('.class selector for the cssSelector property', 'schema-premium'),
						),
					), // end sub fields
					/*'conditional_logic' => array(
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
					),*/
				),
				// Review
				//
				'review' => array(
					'label' 		=> __('Review', 'schema-premium'),
					'rangeIncludes' => array('Number'),
					'field_type' 	=> 'star_rating',
					'markup_value' 	=> 'disabled',
					'instructions' 	=> __('The rating given for this item.', 'schema-premium'),
					'max_stars' 	=> 5,
					'return_type' 	=> 0,
					'choices' => array(
						5 => '5',
						'4.5' => '4.5',
						4 => '4',
						'3.5' => '3.5',
						3 => '3',
						'2.5' => '2.5',
						2 => '2',
						'1.5' => '1.5',
						1 => '1',
						'0.5' => '0.5'
					),
					'other_choice' => 0,
					'save_other_choice' => 0,
					'default_value' => '',
					'layout' => 'horizontal'
				),
				// Review author
				//
				'review_author' => array(
					'label' 		=> __('Review Author', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' 	=> 'disabled',
					'instructions' 	=> __('The author name of this item review.', 'schema-premium'),
				),
				// AggregateRating
				//
				'ratingValue' => array(
					'label' 		=> __('Rating Value', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The aggregate rating for the product.', 'schema-premium'),
				),
				'reviewCount' => array(
					'label' 		=> __('Review Count', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The count of total number of reviews.', 'schema-premium'),
				),
				'version' => array(
					'label' 		=> __('Abstract', 'schema-premium'),
					'rangeIncludes' => array('Number', 'Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',  //post_excerpt
					'instructions' 	=> __('The version of the CreativeWork embodied by a specified resource.', 'schema-premium')
				)
			);
			
			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 20 );
			
			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

			return apply_filters( 'schema_properties_CreativeWork', $properties );	
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
			
			$schema	= array();
			
			// Get properties
			//
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			// Put all together
			// 
			$schema['@context'] =  'https://schema.org';
			$schema['@type'] 	=  $this->type;
			
			// Get main entity of page
			//
			$schema['mainEntityOfPage'] = array
			(
				'@type' => 'WebPage',
				'@id' => get_permalink( $post->ID ) . '#webpage'
			);
			
			if ( isset($properties['headline']) ) 
				$schema['headline'] = $properties['headline'];
				
			$schema['dateCreated']    	= isset($properties['dateCreated'] ) ? $properties['dateCreated'] : get_the_date( 'c', $post_id );
			$schema['datePublished']    = isset($properties['datePublished'] ) ? $properties['datePublished'] : get_the_date( 'c', $post_id );
			$schema['dateModified']		= isset($properties['dateModified'] ) ? $properties['dateModified'] : get_post_modified_time( 'c', false, $post_id, false );
			
			$schema['publisher']		= schema_wp_get_publisher_array();
					
			$schema['keywords']			= schema_wp_get_post_tags( $post_id );
						
			// Author
			//
			if ( isset($properties['author'] ) ) { 
				$schema['author'] = array (
					'@type'	=> 'Person',
					'name'	=> $properties['author']
				);
			} else {
				$schema['author'] = schema_wp_get_author_array( $post_id );
			}
			
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
						$schema['hasPart'] = schema_premium_get_property_cssSelector( $parent_type );
					} else {
						$schema['hasPart'] = schema_premium_get_property_cssSelector_fixed( $properties['cssSelector'] );
					}
				}
			}

			// Review
			//
			if ( isset($properties['review']) && $properties['review'] != 0 && $properties['review'] != '' ) {
				$schema['review'] 	= array
				(
					'@type' 		=> 'Review',
					'reviewRating'	=> array (
						'@type' 		=> 'Rating',
						'bestRating' 	=> 5,
						'ratingValue' 	=> isset($properties['review']) ? $properties['review'] : '',
						'worstRating' 	=> 1
					)
				);		
				// Review author
				//
				if ( isset($properties['review_author']) ) {
					$schema['review']['author'] = array(
						'@type'	=> 'Person',
						'name' => $properties['review_author']
					);
				} else {
					$schema['review']['author'] = schema_wp_get_author_array();
				}
			}
			
			// Aggregate rating
			//
			if ( isset($properties['reviewCount']) && $properties['reviewCount'] > 0 ) {
				$schema['aggregateRating'] 	= array
				(
					'@type' 		=> 'AggregateRating',
					'bestRating' 	=> 5,
					'ratingValue' 	=> isset($properties['ratingValue']) ? $properties['ratingValue'] : '',
					'reviewCount' 	=> isset($properties['reviewCount']) ? $properties['reviewCount'] : '',
					'worstRating' 	=> 1
				);
			}

			// Merge schema and properties arrays
			// Make sure $properties is an array before merging
			// 
			if ( is_array($properties) ) {
				
				// Unset auto generated properties
				//
				unset($properties['review']);

				$schema = array_merge( $schema, $properties );
			}

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

			// Unset auto generated properties
			//
			unset($schema['author']);
			unset($schema['isAccessibleForFree']);
			unset($schema['cssSelector']);

			//unset($schema['review']);
			unset($schema['review_author']);
			unset($schema['ratingValue']);
			unset($schema['reviewCount']);

			return apply_filters( 'schema_output_CreativeWork', $schema );
		}
	}
	
	new Schema_WP_CreativeWork();
	
endif;
