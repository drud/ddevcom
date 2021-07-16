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
	class Schema_WP_Recipe extends Schema_WP_HowTo {
		
		/** @var string Current Type */
    	protected $type = 'Recipe';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'HowTo';

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
		* Get schema type 
		*
		* @since 1.2
		* @return string
		*/
		public function type() {
			
			return 'Recipe';
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
				
			return apply_filters( 'schema_wp_subtypes_Recipe', array() );
		}
		
		/**
		* Get properties
		*
		* @since 1.0.1
		* @return array
		*/
		public function properties() {
			
			$properties = array (
					
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
			);
			
			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 30 );

			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

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
			$schema['@context'] 			=  'https://schema.org';
			$schema['@type'] 				=  $this->type;
		
			$schema['mainEntityOfPage'] 	= array
			(
				'@type' => 'WebPage',
				'@id' => get_permalink( $post->ID )
			);
	
			// Get properties
			//
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			// Debug
			//echo "<pre>";print_r($properties);echo "</pre>";

			//$schema['image'] 				= schema_wp_get_media( $post->ID );
			$schema['image'] 				= isset($properties['images']) ? $properties['images']['image_id'] : schema_premium_get_property_images_new_custom_field( $post->ID );
			
			// Modify properties values
			//
			// $total_time = prepTime + cookTime
			//
			if ( isset($properties['prepTime']) && $properties['prepTime'] != '' 
				|| isset($properties['cookTime']) && $properties['cookTime'] != '' ) { 
				$total_time 				= schema_premium_get_time_sum( $properties['prepTime'], $properties['cookTime'] );
				$properties['totalTime'] 	= schema_premium_format_time_to_PT( $total_time );
			}
	
			// Format time
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
			
			// Merge parent schema 
			//
			$schema = array_merge( parent::schema_output($post->ID), $schema );

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
