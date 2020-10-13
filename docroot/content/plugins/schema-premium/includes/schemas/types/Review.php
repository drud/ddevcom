<?php
/**
 * @package Schema Premium - Class Schema Review
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Review') ) :
	/**
	 * Class
	 *
	 * @since 1.0.1
	 */
	class Schema_WP_Review {
		
		/** @var string Current Type */
    	protected $type = 'Review';
		
		/**
	 	* Constructor
	 	*
	 	* @since 1.0.1
	 	*/
		public function __construct () {
			
			$this->init();
		}
	
		/**
		* Init
		*
		* @since 1.0.1
	 	*/
		public function init() {
		
			add_filter( 'schema_wp_get_default_schemas', array( $this, 'schema_type' ) );
			add_filter( 'schema_wp_types', array( $this, 'schema_type_extend' ) );
		}
		
		/**
		* Get schema type label
		*
		* @since 1.0.1
		* @return array
		*/
		public function label() {
			
			return __('Review', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.1
		* @return array
		*/
		public function comment() {
			
			return __('A review of an item - for example, of a restaurant, movie, or store.', 'schema-premium');
		}
		
		/**
		* Extend schema types
		*
		* @since 1.0.1
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
		* @since 1.0.1
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
			
			return apply_filters( 'schema_wp_Review', $schema );
		}
		
		/**
		* Get sub types
		*
		* @since 1.0.1
		* @return array
		*/
		public function subtypes() {
		
			$subtypes = array();
				
			return apply_filters( 'schema_wp_subtypes_Review', $subtypes );
		}
		
		/**
		* Get properties
		*
		* @since 1.0.1
		* @return array
		*/
		public function properties() {
			
			$properties = array (
					
					'item_type' => array(
						'label' 		=> __('Reviewed Item Type', 'schema-premium'),
						'rangeIncludes'	=> array('Text'),
						'field_type' 	=> 'select',
						'choices'		=> array
							(
								''		=> '- ' . __('Select', 'schema-premium') . ' -',
								'Book'					=> 'Book',
								'Course' 				=> 'Course',
								'Event' 				=> 'Event',
								'HowTo' 				=> 'How To',
								'LocalBusiness' 		=> 'Local Business',
								'Movie' 				=> 'Movie',
								'Product' 				=> 'Product',
								'Recipe' 				=> 'Recipe',
								'SoftwareApplication' 	=> 'Software App',
								'CreativeWorkSeries'	=> 'Creative Work Series',
								'CreativeWorkSeason'	=> 'Creative Work Season',
								'Episode'				=> 'Episode',
								'Game'					=> 'Game',
								'MediaObject'			=> 'Media Object',
								'MusicPlayList'			=> 'Music Play List',
								'MusicRecording'		=> 'Music Recording',
								'Organization'			=> 'Organization',
							),
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('Reviewed item or content type.', 'schema-premium'),
						'required' 		=> true
					),
					'item_name' => array(
						'label' 		=> __('Reviewed Item Name', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('The name of the reviewed item.', 'schema-premium'),
						'required' 		=> true
					),
					'url' => array(
						'label' 		=> __('URL', 'schema-premium'),
						'rangeIncludes' => array('URL'),
						'field_type' 	=> 'url',
						'markup_value' => 'post_permalink',
						'instructions' 	=> __('URL of the review.', 'schema-premium'),
						'placeholder' 	=> 'https://'
					),
					'name' => array(
						'label' 		=> __('Review Name', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'post_title',
						'instructions' 	=> __('The title or headline of the review.', 'schema-premium'),
						'required' 		=> true
					),
					'alternativeHeadline' => array(
						'label' 		=> __('Alternative Headline', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'disabled',
						'instructions' 	=> __('Secondary title for this review.', 'schema-premium')
					),
					'image' => array(
						'label' 		=> __('Image', 'schema-premium'),
						'rangeIncludes' => array('ImageObject', 'URL'),
						'field_type' 	=> 'image',
						'markup_value' => 'featured_image',
						'instructions' 	=> __('An image of the reviewed item.', 'schema-premium'),
						'required' 		=> true
					),
					'datePublished' => array(
						'label'			=> __('Published Date', 'schema-premium'),
						'rangeIncludes' => array('Date', 'DateTime'),
						'field_type' 	=> 'date_time_picker',
						'markup_value' => 'post_date',
						'instructions' 	=> __('Date of first publication of the review.', 'schema-premium'),
						'required' 		=> true
					),
					'dateModified' => array(
						'label' 		=> __('Modified Date', 'schema-premium'),
						'rangeIncludes' => array('Date', 'DateTime'),
						'field_type' 	=> 'date_time_picker',
						'markup_value' => 'post_modified',
						'instructions' 	=> __('The date on which the review was most recently modified', 'schema-premium'),
					),
					'author' => array(
						'label' 		=> __('Author Name', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'author_name',
						'instructions' 	=> __('The author name of this review.', 'schema-premium'),
						'required' 		=> true
					),
					'reviewBody' => array(
						'label' 		=> __('Review Body', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'textarea',
						'markup_value' => 'post_content',
						'instructions' 	=> __('The actual body of the review.', 'schema-premium'),
					),
					'description' => array(
						'label' 		=> __('Description', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'textarea',
						'markup_value' => 'post_excerpt',
						'instructions' 	=> __('A description of the item.', 'schema-premium'),
					),
					'rating' => array(
						'label' 		=> __('Rating Value', 'schema-premium'),
						'rangeIncludes' => array('Number'),
						'field_type' 	=> 'star_rating',
						'markup_value' 	=> 'new_custom_field',
						'instructions' 	=> __('The rating given in this review.', 'schema-premium'),
						'max_stars' => 5,
						'return_type' => 0,
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
						'layout' => 'horizontal',
						'required'	=> true
					)
				);
				
			return apply_filters( 'schema_properties_Review', $properties );	
		}
		
		/**
		* Schema output
		*
		* @since 1.0.1
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
			$schema['@context'] 			=  'http://schema.org';
			$schema['@type'] 				=  $this->type;
		
			$schema['mainEntityOfPage'] 	= array
			(
				'@type' => 'WebPage',
				'@id' => get_permalink( $post->ID )
			);
			
			// Get properties
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			$schema['url'] 					= isset($properties['url']) ? $properties['url'] : '';
			$schema['headline']				= isset($properties['headline']) ? $properties['headline'] : '';
			$schema['alternativeHeadline']	= isset($properties['alternativeHeadline']) ? $properties['alternativeHeadline'] : '';
			$schema['description']			= isset($properties['description']) ? $properties['description'] : schema_wp_get_description( $post->ID );
			$schema['image'] 				= isset($properties['image']) ? $properties['image'] : '';
			
			$schema['datePublished']		= isset($properties['datePublished']) ? $properties['datePublished'] : '';
			$schema['dateModified']			= isset($properties['dateModified']) ? $properties['dateModified'] : '';
			
			if( isset($properties['author'] ) ) { 
				$schema['author'] = array (
					'@type'	=> 'Person',
					'name'	=> $properties['author']
				);
			} else {
				$schema['author'] = schema_wp_get_author_array( $post->ID );
			}
			
			$schema['itemReviewed'] 		= array
			(
				//'@type' => 'Thing', // This is a default type
				// This has changed 
				// @since 1.0.8
				'@type' 		=> isset($properties['item_type']) ? $properties['item_type'] : '', 
				'name' 			=> isset($properties['item_name']) ? $properties['item_name'] : '',
				'description' 	=> isset($properties['description']) ? $properties['description'] : '',
			);
			
			$schema['reviewRating'] 		= array
			(
				'@type' => 'Rating',
				'worstRating'	=> '0',
				'bestRating'	=> '5',
				'ratingValue'	=> isset($properties['rating']) ? $properties['rating'] : ''
			);
			
			// Unset auto generated properties
			unset($properties['author']);
			unset($properties['rating']);
			unset($properties['item_name']);	
			unset($properties['item_type']);			
			
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
			
			return apply_filters( 'schema_output_Review', $schema );
		}
	}
	
	new Schema_WP_Review();
	
endif;
