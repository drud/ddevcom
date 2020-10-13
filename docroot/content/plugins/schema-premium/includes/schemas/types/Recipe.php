<?php
/**
 * @package Schema Premium - Class Schema Recipe
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Recipe') ) :
	/**
	 * Class 
	 *
	 * @since 1.0.1
	 */
	class Schema_WP_Recipe {
		
		/** @var string Current Type */
    	protected $type = 'Recipe';
		
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
		
			add_filter( 'schema_wp_get_default_schemas', array( $this, 'schema_type' ), 100 );
			add_filter( 'schema_wp_types', array( $this, 'schema_type_extend' ) );
		}
		
		/**
		* Get schema type label
		*
		* @since 1.0.1
		* @return array
		*/
		public function label() {
			
			return __('Recipe', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.1
		* @return array
		*/
		public function comment() {
			
			return __('Mark up your recipe content with structured data to provide rich results and host-specific lists for your recipes.', 'schema-premium');
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
			
			return apply_filters( 'schema_wp_Recipe', $schema );
		}
		
		/**
		* Get sub types
		*
		* @since 1.0.1
		* @return array
		*/
		public function subtypes() {
		
			$subtypes = array();
				
			return apply_filters( 'schema_wp_subtypes_Recipe', $subtypes );
		}
		
		/**
		* Get properties
		*
		* @since 1.0.1
		* @return array
		*/
		public function properties() {
			
			$properties = array (
					
					'url' => array(
						'label' 		=> __('URL', 'schema-premium'),
						'rangeIncludes' => array('URL'),
						'field_type' 	=> 'url',
						'markup_value' => 'post_permalink',
						'instructions' 	=> __('URL of the content.', 'schema-premium'),
						'placeholder' 	=> 'https://'
					),
					'name' => array(
						'label' 		=> __('Name', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('The name of the dish.', 'schema-premium'),
						'required' 		=> true
					),
					'headline' => array(
						'label' 		=> __('Headline', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'post_title',
						'instructions' 	=> __('Headline of the content', 'schema-premium')
					),
					'alternativeHeadline' => array(
						'label' 		=> __('Alternative Headline', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'disabled',
						'instructions' 	=> __('Secondary title for this content.', 'schema-premium')
					),
					/*
					'image' => array(
						'label' 		=> __('Image', 'schema-premium'),
						'rangeIncludes' => array('ImageObject', 'URL'),
						'field_type' 	=> 'image',
						'markup_value' => 'featured_image',
						'instructions' 	=> __('Image of the completed dish.', 'schema-premium'),
						'required' 		=> true
					),
					*/
					'images' => array(
						'label' 		=> __('Image', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'repeater',
						'layout'		=> 'block',
						'markup_value' => 'new_custom_field',
						//'required' 		=> true,
						'button_label' 	=> __('Add Image', 'schema-premium'),
						'instructions' 	=> __('Images of the item.', 'schema-premium'),
						'sub_fields' 	=>  array(
							'image_id' => array(
								'label' 		=> __('Image', 'schema-premium'),
								'rangeIncludes' => array('ImageObject', 'URL'),
								'field_type' 	=> 'image',
								'markup_value' => 'featured_image',
								'instructions' 	=> ''
							)
						), // end sub fields
					),
					'datePublished' => array(
						'label'			=> __('Published Date', 'schema-premium'),
						'rangeIncludes' => array('Date', 'DateTime'),
						'field_type' 	=> 'date_time_picker',
						'markup_value' => 'post_date',
						'instructions' 	=> __('Date of first publication of the recipe.', 'schema-premium'),
						'required' 		=> true
					),
					'dateModified' => array(
						'label' 		=> __('Modified Date', 'schema-premium'),
						'rangeIncludes' => array('Date', 'DateTime'),
						'field_type' 	=> 'date_time_picker',
						'markup_value' => 'post_modified',
						'instructions' 	=> __('The date on which the recipe was most recently modified', 'schema-premium'),
					),
					'author' => array(
						'label' 		=> __('Author Name', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'author_name',
						'instructions' 	=> __('The author name of this content.', 'schema-premium'),
						'required' 		=> true
					),
					'description' => array(
						'label' 		=> __('Description', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'textarea',
						'markup_value' => 'post_excerpt',
						'instructions' 	=> __('A short summary describing the dish.', 'schema-premium'),
					),
					'prepTime' => array(
						'label' 		=> __('Preparation Time', 'schema-premium'),
						'rangeIncludes' => array('Duration'),
						'field_type' 	=> 'time_picker',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('The length of time it takes to prepare the dish.', 'schema-premium'),
						'display_format' => 'H:i:s',
						'return_format' => 'H:i:s',
					),
					'cookTime' => array(
						'label' 		=> __('Cook Time', 'schema-premium'),
						'rangeIncludes' => array('Duration'),
						'field_type' 	=> 'time_picker',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('The time it takes to actually cook the dish.', 'schema-premium'),
						'display_format' => 'H:i:s',
						'return_format' => 'H:i:s',
					),
					'keywords' 	=> array(
						'label' 		=> __('Keywords', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('Other terms for your recipe such as the season (“summer”), the holiday (“Halloween“), or other descriptors (“quick”, “easy”, “authentic”), comma separated.', 'schema-premium')
					),
					'recipeYield' 	=> array(
						'label' 		=> __('Yield', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('The quantity produced by the recipe. For example: number of people served, or number of servings.', 'schema-premium')
					),
					'recipeCategory' 	=> array(
						'label' 		=> __('Recipe Category', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('The type of meal or course your recipe is about. For example: "dinner", "entree", or "dessert, snack".', 'schema-premium')
					),
					'recipeCuisine' 	=> array(
						'label' 		=> __('Recipe Cuisine', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('The region associated with your recipe. For example, "French", Mediterranean", or "American".', 'schema-premium')
					),
					'nutrition_calories' => array(
						'label' 		=> __('Nutrition Calories', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('The number of calories in each serving.', 'schema-premium')
					),
					'recipeIngredient' => array(
						'label' 		=> __('Recipe Ingredients', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'repeater',
						'layout'		=> 'block',
						'markup_value' => 'new_custom_field',
						'required' 		=> true,
						'button_label' 	=> __('Add ingredient', 'schema-premium'),
						'instructions' 	=> __('An ingredient used in the recipe.', 'schema-premium'),
						'sub_fields' 	=>  array(
							'recipeIngredient_item' => array(
								'label' 		=> __('Ingredient', 'schema-premium'),
								'rangeIncludes' => array('Text'),
								'field_type' 	=> 'text',
								'markup_value' 	=> 'new_custom_field',
								'instructions' 	=> '',
							),
						), // end sub fields
					),
					'recipeInstructions' => array(
						'label' 		=> __('Recipe Instructions', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'repeater',
						'layout'		=> 'block',
						'markup_value' => 'new_custom_field',
						'required' 		=> true,
						'button_label' 	=> __('Add instruction', 'schema-premium'),
						'instructions' 	=> __('The steps to make the dish.', 'schema-premium'),
						'sub_fields' 	=>  array(
							'recipeInstructions_item' => array(
								'label' 		=> __('Instruction', 'schema-premium'),
								'rangeIncludes' => array('Text'),
								'field_type' 	=> 'textarea',
								'markup_value' => 'new_custom_field',
								'instructions' 	=> '',
							),
						), // end sub fields
					),
					// Review
					'review' => array(
						'label' 		=> __('Review', 'schema-premium'),
						'rangeIncludes' => array('Number'),
						'field_type' 	=> 'star_rating',
						'markup_value' 	=> 'new_custom_field',
						'instructions' 	=> __('The rating given for this service.', 'schema-premium'),
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
						'layout' => 'horizontal'
					),
					'review_author' => array(
						'label' 		=> __('Review Author', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'author_name',
						'instructions' 	=> __('The author name of this service review.', 'schema-premium'),
					),
					// Aggregate Rating
					'ratingValue' => array(
						'label' 		=> __('Rating Value', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('The aggregate rating for the service.', 'schema-premium'),
					),
					'reviewCount' => array(
						'label' 		=> __('Review Count', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('The count of total number of reviews.', 'schema-premium'),
					),
				);
				
			return apply_filters( 'schema_properties_Recipe', $properties );	
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
	
			$schema['url'] 					= get_permalink( $post->ID );
	
			// Truncate headline 
			$headline						= schema_wp_get_the_title( $post->ID );
			$schema['headline']				= apply_filters( 'schema_wp_filter_headline', $headline );
			
			$schema['alternativeHeadline']	= get_post_meta( $post->ID, 'schema_properties_Article_alternativeHeadline', true );
			
			$schema['description']			= schema_wp_get_description( $post->ID );
			
			$schema['datePublished']		= get_the_date( 'c', $post->ID );
			$schema['dateModified']			= get_post_modified_time( 'c', false, $post->ID, false );
			
			$schema['recipeCategory']		= schema_wp_get_post_category( $post->ID );
			$schema['keywords']				= schema_wp_get_post_tags( $post->ID );
	
			$schema['publisher']			= schema_wp_get_publisher_array();
			
			// Get properties
			//
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			// Debug
			//echo "<pre>";print_r($properties);echo "</pre>";

			//$schema['image'] 				= schema_wp_get_media( $post->ID );
			$schema['image'] 				= isset($properties['images']) ? $properties['images']['image_id'] : schema_premium_get_property_images_new_custom_field( $post->ID );
			
			// Author
			//
			if ( isset($properties['author'] ) ) { 
				$schema['author'] = array (
					'@type'	=> 'Person',
					'name'	=> $properties['author']
				);
			} else {
				$schema['author'] = schema_wp_get_author_array( $post->ID );
			}
			
			// Modify properties values
			//
			// $total_time = prepTime + cookTime
			//
			if ( isset($properties['prepTime']) && $properties['prepTime'] != '' 
				|| isset($properties['cookTime']) && $properties['cookTime'] != '' ) { 
				$total_time 				= schema_premium_get_time_sum( $properties['prepTime'], $properties['cookTime'] );
				$properties['totalTime'] 	= schema_premium_format_time_to_PT( $total_time );
			}
	
			// format time
			//
			$properties['prepTime'] 	= isset($properties['prepTime']) ? schema_premium_format_time_to_PT( $properties['prepTime'] ) : '';
			$properties['cookTime'] 	= isset($properties['cookTime']) ? schema_premium_format_time_to_PT( $properties['cookTime'] ) : '';
			
			// Nutrition Calories
			//
			if ( isset($properties['nutrition_calories'] ) ) { 
				$schema['nutrition'] 	= array
				(
					'@type' 	=> 'NutritionInformation',
					'calories' 	=> $properties['nutrition_calories']
				);
			}
			
			$properties['recipeIngredient'] 	= $this->get_ingredients();
			$properties['recipeInstructions'] 	= $this->get_instructions();
			
			// Review
			//
			if ( isset($properties['review']) && $properties['review'] != 0 && $properties['review'] != '' ) {
				$schema['review'] 	= array
				(
					'@type' 		=> 'Review',
					'reviewRating'	=> array (
						'@type' 		=> 'Rating',
						'ratingValue' 	=> isset($properties['review']) ? $properties['review'] : '',
						'bestRating' 	=> 5
					)
				);		
				// review author
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
			if ( isset($properties['reviewCount']) && $properties['reviewCount'] > 0 ) {
				$schema['aggregateRating'] 	= array
				(
					'@type' 		=> 'AggregateRating',
					'ratingValue' 	=> isset($properties['ratingValue']) ? $properties['ratingValue'] : '',
					'reviewCount' 	=> isset($properties['reviewCount']) ? $properties['reviewCount'] : '',
				);
			}
			
			// Unset auto generated properties
			unset($properties['author']);
			unset($properties['images']);
			unset($properties['nutrition_calories']);
			
			unset($properties['review']);
			unset($properties['review_author']);
			unset($properties['ratingValue']);
			unset($properties['reviewCount']);
			
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
			
			return apply_filters( 'schema_output_Recipe', $schema );
		}

		/**
		* Get ingredients
		*
		* @since 1.0.1
		* @return array
		*/
		public function get_ingredients() {
	
			$ingredients = array();
	
			$count = get_post_meta( get_the_ID(), 'schema_properties_Recipe_recipeIngredient', true );
	
			if ( isset( $count ) && $count >= 0 ) {
		
				for( $i=0; $i < $count; $i++ ) {
					$ingredients[] = get_post_meta( get_the_ID(), 'schema_properties_Recipe_recipeIngredient_' . $i . '_recipeIngredient_item', true );
				}
		
			}
	
			return $ingredients;
		}
		
		/**
		* Get instructions
		*
		* @since 1.0.1
		* @return array
		*/
		function get_instructions() {
	
			$instructions = array();
	
			$count = get_post_meta( get_the_ID(), 'schema_properties_Recipe_recipeInstructions', true );
	
			if ( isset( $count ) && $count >= 0 ) {
		
				for( $i=0; $i < $count; $i++ ) {
					$instructions[] = array( 
						'@type' => 'HowToStep',
						'text' => get_post_meta( get_the_ID(), 'schema_properties_Recipe_recipeInstructions_' . $i . '_recipeInstructions_item', true )
					);
				}
		
			}
	
			return $instructions;
		}

	}
	
	new Schema_WP_Recipe();
	
endif;
