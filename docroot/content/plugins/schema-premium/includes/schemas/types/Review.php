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
	class Schema_WP_Review extends Schema_WP_CreativeWork {
		
		/** @var string Current Type */
		protected $type = 'Review';
		
		/** @var string Current Parent Type */
    	protected $parent_type = 'CreativeWork';
		
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
			add_filter( 'schema_add_to_properties', array( $this, 'itemReviewed_properties' ) );
		}
		
		/**
		* Get schema type 
		*
		* @since 1.2
		* @return string
		*/
		public function type() {
			
			return 'Review';
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
		
			return apply_filters( 'schema_wp_subtypes_Review', array() );
		}
		
		/**
		* Get properties
		*
		* @since 1.0.1
		* @return array
		*/
		public function properties() {
			
			$properties = array (

				'itemReviewed' => array(
					'label' 		=> __('Reviewed Item Type', 'schema-premium'),
					'rangeIncludes'	=> array('Thing'),
					'field_type' 	=> 'select',
					'choices'		=> array
						(
							//''		=> '- ' . __('Select', 'schema-premium') . ' -',
							'Book'					=> 'Book',
							'Course' 				=> 'Course',
							'Event' 				=> 'Event',
							//'HowTo' 				=> 'How To',
							//'LocalBusiness' 		=> 'Local Business',
							'Movie' 				=> 'Movie',
							'Product' 				=> 'Product',
							//'Recipe' 				=> 'Recipe',
							'SoftwareApplication' 	=> 'Software App',
							// - - - - other supported types
							//'CreativeWorkSeries'	=> 'Creative Work Series',
							//'CreativeWorkSeason'	=> 'Creative Work Season',
							//'Episode'				=> 'Episode',
							//'Game'					=> 'Game',
							//'MediaObject'			=> 'Media Object',
							//'MusicPlayList'			=> 'Music Play List',
							//'MusicRecording'		=> 'Music Recording',
							//'Organization'			=> 'Organization',
						),
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('Reviewed item or content type.', 'schema-premium'),
					'required' 		=> true
				),
				/*'item_type' => array(
					'label' 		=> __('Reviewed Item Type', 'schema-premium'),
					'rangeIncludes'	=> array('Text'),
					'field_type' 	=> 'select',
					'choices'		=> array
						(
							''						=> '- ' . __('Select', 'schema-premium') . ' -',
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
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('Reviewed item or content type.', 'schema-premium'),
					'required' 		=> true
				),*/
				'itemReviewed_name' => array(
					'label' 		=> __('Reviewed Item Name', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('The name of the reviewed item.', 'schema-premium'),
					'required' 		=> true
				),
				'reviewAspect' => array(
					'label' 		=> __('Review Aspect', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' 	=> 'disabled',
					'instructions' 	=> __('This Review or Rating is relevant to this part or facet of the itemReviewed.', 'schema-premium'),
				),
				'reviewBody' => array(
					'label' 		=> __('Review Body', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'textarea',
					'markup_value'  => 'post_content',
					'instructions' 	=> __('The actual body of the review.', 'schema-premium'),
				),
				/*
				'rating' => array(
					'label' 		=> __('Rating Value', 'schema-premium'),
					'rangeIncludes' => array('Number'),
					'field_type' 	=> 'star_rating',
					'markup_value' 	=> 'new_custom_field',
					'instructions' 	=> __('The rating given in this review.', 'schema-premium'),
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
					'layout' => 'horizontal',
					'required'	=> true
				)*/
			);
			
			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 30 );

			// Merge parent properties 
			// 
			$properties = array_merge( parent::properties(), $properties );

			// Length of description must be in range [0, 200] 
			//
			$properties['description']['maxlength'] = 200;

			// Debug
			//echo '<pre>'; print_r($properties); echo '</pre>';exit;

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
			$schema['@context'] =  'https://schema.org';
			$schema['@type'] 	=  $this->type;
		
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
			

			//echo '<pre>'; print_r($properties); echo '</pre>';

			/*
			if( isset($properties['author'] ) ) { 
				$schema['author'] = array (
					'@type'	=> 'Person',
					'name'	=> $properties['author']
				);
			} else {
				$schema['author'] = schema_wp_get_author_array( $post->ID );
			}
			*/
			$schema['reviewRating'] = array
			(
				'@type' 		=> 'Rating',
				'ratingValue'	=> isset($properties['review']) ? $properties['review'] : '',
				'worstRating'	=> 0	
			);	
			

			// Merge schema and properties arrays
			// Make sure $properties is an array before merging
			// 
			if ( is_array($properties) ) {
				
				$schema = array_merge($schema, $properties);
			}
			
			// Get itemReviewed markup output
			//
			$target_match = schema_premium_get_location_target_match( $post->ID );

			foreach ( $target_match as $Schema_ID => $val ) {
				
				// Find our matching type
				//
				if ( isset($val['match']) && $val['match'] == 1 ) {
					$itemReviewed_type = get_post_meta( $Schema_ID, '_properties_itemReviewed', true );
				}

				// If this is our matching type...
				// Call the unknow class and get markup
				//
				if ( isset($itemReviewed_type) && $itemReviewed_type != '' ) {
					$classname 					= 'Schema_WP_' . $itemReviewed_type;
					$schema_class 				= (class_exists($classname)) ? new $classname : '';
					$itemReviewed_properties	= is_object($schema_class) ? $schema_class->properties() : array();
					
					// Get markup output
					//
					$itemReviewed 					= $schema_class->schema_output( $post->ID );
					$schema['itemReviewed']			= $itemReviewed;
					
					// Get itemReviewed name
					//
					$itemReviewed = get_post_meta( $post->ID, 'schema_properties_Review_itemReviewed_name', true );
					$schema['itemReviewed']['name']	= isset($properties['itemReviewed_name']) ? $properties['itemReviewed_name'] : $itemReviewed;
					
					// Get itemReviewed image
					//
					if ( isset($properties['image']) ) {
						$schema['itemReviewed']['image'] = $properties['image'];
					} else {
						$schema['itemReviewed']['image'] = schema_wp_get_media( $post_id );
					}
					
					// Fix Movie actor property, since it's a repeater field
					//
					if ( $itemReviewed_type == 'Movie' ) {
						$schema['itemReviewed']['actor'] = $schema_class->get_actors('Review');
					}

					// Fix itemReviewed Product url property
					//
					if ( $itemReviewed_type == 'Product' ) {
						$schema['itemReviewed']['url'] = isset($schema['itemReviewed']['offers']['url']) ? $schema['itemReviewed']['offers']['url'] : '';
					}

					// Fix itemReviewed aggregateRating property
					// @since 1.2.1
					//
					if ( isset($properties['aggregateRating']) && ! empty($properties['aggregateRating']) ) {
						$schema['itemReviewed']['aggregateRating'] = $properties['aggregateRating'];
						
					}
				
				}
				continue;
			}
			
			// Merge parent schema 
			//
			$schema = array_merge( parent::schema_output($post->ID), $schema );	
			
			// Add itemReviewed:review
			// @since 1.2.1
			// TODO check this function, since adding it will results in rating stars snippets not showing.
			/*
			if ( isset($properties['review']) && ! empty($properties['review']) ) {
				$schema['itemReviewed']['review'] = array
				(
					'@type' 		=> 'Review',
					'reviewRating'	=> array (
						'@type' 		=> 'Rating',
						'ratingValue' 	=> isset($properties['review']) ? $properties['review'] : '',
						'bestRating' 	=> 5
					),
					'author' => !empty($schema['author']) ? $schema['author'] : schema_wp_get_author_array()
				);
			}
			*/

			// Debug
			//echo '<pre>'; print_r($schema); echo '</pre>';
			
			return $this->schema_output_filter($schema);
		}

		/**
		* Apply filters to markup output
		*
		* @since 1.1.2.8
		* @return array
		*/
		public function schema_output_filter( $schema ) {
			
			// Length of description must be in range [0, 200] 
			//
			$schema['description'] = schema_wp_get_substrwords( $schema['description'], 200, '' );

			// Add sameAs property
			//
			$schema['itemReviewed']['sameAs'] = schema_wp_types_get_sameAs();

			// Unset auto generated properties
			//
			unset($schema['itemReviewed']['review']);
			unset($schema['review']);
			unset($schema['rating']);
			unset($schema['itemReviewed_name']);
			// Seems to be needed
			// @since 1.2.1
			unset($schema['review_author']);
			unset($schema['ratingValue']);
			unset($schema['reviewCount']);
			// We've moved this under the itemReviewed property.
			// @since 1.2.1
			unset($schema['aggregateRating']);

			return apply_filters( 'schema_output_Review', $schema );
		}

		/**
		* itemReviewed ACF field group
		*
		* @since 1.2
		* @return void
		*/
		public function itemReviewed_properties( $properties ) {

			$post_id = schema_premium_get_post_ID();

			// Get enabled schema type
			//
			$schema_type = get_post_meta( $post_id, '_schema_type', true );
			
			// Bail if type is not Review
			//
			if ( $schema_type != 'Review' )
				return $properties;
			
			// Get supported types
			//
			$supported_types = $properties['itemReviewed']['choices'];

			// Loop through supported types to get its properties
			//
			foreach ( $supported_types as $itemReviewed => $itemReviewed_label ) {
				
				if ( isset($itemReviewed) && $itemReviewed != '' ) {
					$classname 					= 'Schema_WP_' . $itemReviewed;
					$schema_class 				= (class_exists($classname)) ? new $classname : '';
					$itemReviewed_properties	= is_object($schema_class) ? $schema_class->properties() : array();
				}
	
				// Add conditional logic
				//
				$itemReviewed_properties[$itemReviewed.'_properties_tab']['conditional_logic'] = array(
					array(
						array(
							'field' => 'properties_itemReviewed',
							'operator' => '==',
							'value' => $itemReviewed,
						),
					),
				);

				// Add dashicon 
				//
				$itemReviewed_properties[$itemReviewed.'_properties_tab']['dashicon'] = 'dashicons-star-filled';

				// Merge itemReviewed properties 
				//
				$properties = array_merge( $properties, $itemReviewed_properties );
			}

			// Debug
			//echo'<pre>';print_r( $itemReviewed_properties ); echo'</pre>'; exit;

			return $properties;
		}
	}
	
	new Schema_WP_Review();
	
endif;
