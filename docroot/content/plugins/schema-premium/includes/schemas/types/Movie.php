<?php
/**
 * @package Schema Premium - Class Schema Movie
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Movie') ) :
	/**
	 * Schema Movie
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Movie {
		
		/** @var string Currenct Type */
    	protected $type = 'Movie';
		
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
			
			return __('Movie', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A movie.', 'schema-premium');
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
			
			return apply_filters( 'schema_wp_Movie', $schema );
		}
		
		/**
		* Get sub types
		*
		* @since 1.0.0
		* @return array
		*/
		public function subtypes() {
			
			$subtypes = array();
				
			return apply_filters( 'schema_wp_subtypes_Movie', $subtypes );
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
						'instructions' 	=> __('URL of the movie.', 'schema-premium'),
						'placeholder' 	=> 'https://'
					),
					'headline' => array(
						'label' 		=> __('Headline', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'post_title',
						'instructions' 	=> __('Headline of the movie.', 'schema-premium'),
						'required' 		=> true
					),
					'alternativeHeadline' => array(
						'label' 		=> __('Alternative Headline', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'disabled',
						'instructions' 	=> __('Secondary title for this movie.', 'schema-premium')
					),
					'name' => array(
						'label' 		=> __('Name', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'post_title',
						'instructions' 	=> __('The name of the movie.', 'schema-premium'),
						'required' 		=> true
					),
					'image' => array(
						'label' 		=> __('Image', 'schema-premium'),
						'rangeIncludes' => array('ImageObject', 'URL'),
						'field_type' 	=> 'image',
						'markup_value' => 'featured_image',
						'instructions' 	=> __('An image of the movie.', 'schema-premium'),
						'required' 		=> true
					),
					'dateCreated' => array(
						'label'			=> __('Created Date', 'schema-premium'),
						'rangeIncludes' => array('Date', 'DateTime'),
						'field_type' 	=> 'date_time_picker',
						'markup_value' => 'post_date',
						'instructions' 	=> __('The date on which the movie was created.', 'schema-premium'),
						'display_format' => get_option( 'date_format' ), // WP
						'return_format' => 'Y-m-d',
						'required' 		=> true
					),
					'datePublished' => array(
						'label'			=> __('Published Date', 'schema-premium'),
						'rangeIncludes' => array('Date', 'DateTime'),
						'field_type' 	=> 'date_time_picker',
						'markup_value' => 'post_date',
						'instructions' 	=> __('Date of first publication of this web page.', 'schema-premium'),
						'display_format' => get_option( 'date_format' ), // WP
						'return_format' => 'Y-m-d',
						'required' 		=> true
					),
					'dateModified' => array(
						'label' 		=> __('Modified Date', 'schema-premium'),
						'rangeIncludes' => array('Date', 'DateTime'),
						'field_type' 	=> 'date_time_picker',
						'markup_value' => 'post_modified',
						'instructions' 	=> __('The date on which the movie or this web page was most recently modified', 'schema-premium'),
						'display_format' => get_option( 'date_format' ), // WP
						'return_format' => 'Y-m-d',
					),
					'director' => array(
						'label' 		=> __('Director', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('A director of e.g. tv, radio, movie, video gaming etc. content, or of an event.', 'schema-premium'),
					),
					'author' => array(
						'label' 		=> __('Author Name', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'author_name',
						'instructions' 	=> __('The author name of this web page.', 'schema-premium'),
						'required' 		=> true
					),
					'description' => array(
						'label' 		=> __('Description', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'textarea',
						'markup_value' => 'post_excerpt',
						'instructions' 	=> __('A description of the movie.', 'schema-premium'),
					),
					'actor' => array(
						'label' 		=> __('Actors', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'repeater',
						'layout'		=> 'block',
						'markup_value' => 'new_custom_field',
						'button_label' 	=> __('Add an actor', 'schema-premium'),
						'instructions' 	=> __('An actor, e.g. in tv, radio, movie, video games etc., or in an event. Actors can be associated with individual items or with a series, episode, clip.', 'schema-premium'),
						'sub_fields' 	=>  array(
							'actor_name' => array(
								'label' 		=> __('Name', 'schema-premium'),
								'rangeIncludes' => array('Text'),
								'field_type' 	=> 'text',
								'markup_value' => 'new_custom_field',
								'instructions' 	=> '',
								'placeholder' => __('Actor name', 'schema-premium'),
							),
						), // end sub fields
					)
				);
			
			return apply_filters( 'schema_properties_Movie', $properties );	
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
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			$schema['url'] 				= isset($properties['url'] ) ? $properties['url'] : get_permalink( $post->ID );
			$schema['headline'] 		= isset($properties['headline'] ) ? $properties['headline'] : '';
			$schema['description'] 		= isset($properties['description'] ) ? $properties['description'] : schema_wp_get_description( $post->ID );
			$schema['name'] 			= isset($properties['name'] ) ? $properties['name'] : '';
			$schema['image'] 			= isset($properties['image']) ? $properties['image'] : schema_wp_get_media( $post->ID );
			
			$schema['dateCreated']		= isset($properties['dateCreated'] ) ? $properties['dateCreated'] : get_the_date( 'c', $post->ID );
			$schema['datePublished']	= isset($properties['datePublished'] ) ? $properties['datePublished'] : get_the_date( 'c', $post->ID );
			$schema['dateModified']		= isset($properties['dateModified'] ) ? $properties['dateModified'] : get_post_modified_time( 'c', false, $post->ID, false );
			
			// Get actors
			$schema['actor'] = $this->get_actors();
			
			// Get director
			if( isset($properties['director'] ) ) { 
				$schema['director'] = array (
					'@type'	=> 'Person',
					'name'	=> $properties['director']
				);
			}
			
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
			unset($properties['name']);
			unset($properties['director']);	
			
			// Merge schema and properties arrays
			// Make sure $properties is an array before merging
			// 
			if ( is_array($properties) ) {
				$schema = array_merge($schema, $properties);
			}
			
			// debug
			//echo'<pre>';print_r($schema);echo'</pre>';

			return $this->schema_output_filter($schema);
		}

		/**
		* Apply filters to markup output
		*
		* @since 1.1.2.8
		* @return array
		*/
		public function schema_output_filter( $schema ) {
			
			return apply_filters( 'schema_output_Movie', $schema );
		}

		/**
		* Get Actorg
		*
		* @since 1.0.0
		* @return array
		*/
		public function get_actors() {
			
			global $post;
			
			$output = array();
	
			$count = get_post_meta( get_the_ID(), 'schema_properties_Movie_actor', true );
	
			if ( isset( $count ) && $count >= 0 ) {
		 
				for( $i=0; $i < $count; $i++ ) {
					
					$step_no = $i + 1;
					
					$name 		= get_post_meta( get_the_ID(), 'schema_properties_Movie_actor_' . $i . '_actor_name', true );
					
					$output[] = array
					(
						'@type'	=> 'Person',
						'name'	=> strip_tags($name),
					);
				}
		
			}
	
			return $output;
		}
		
	}
	
	new Schema_WP_Movie();
	
endif;
