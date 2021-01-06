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
	class Schema_WP_Movie extends Schema_WP_CreativeWork {
		
		/** @var string Currenct Type */
		protected $type = 'Movie';
		
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
			
			return 'Movie';
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
				
			return apply_filters( 'schema_wp_subtypes_Movie', array() );
		}
		
		/**
		* Get properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {
			
			$properties = array (
					
				'actor' => array(
					'label' 		=> __('Actors', 'schema-premium'),
					'rangeIncludes' => array('Person'),
					'field_type' 	=> 'repeater',
					'layout'		=> 'block',
					'markup_value'  => 'new_custom_field',
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
				),
				'director' => array(
					'label' 		=> __('Director', 'schema-premium'),
					'rangeIncludes' => array('Person'),
					'field_type' 	=> 'text',
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('A director of e.g. tv, radio, movie, video gaming etc. content, or of an event.', 'schema-premium'),
				)
			);
			
			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 30 );

			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

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
			
			// Get properties
			//
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			// Get director
			//
			if( isset($properties['director'] ) ) { 
				$schema['director'] = array (
					'@type'	=> 'Person',
					'name'	=> $properties['director']
				);
			}
			
			// Unset auto generated properties
			//
			unset($properties['director']);	
			
			// Merge parent schema 
			//
			$schema = array_merge( parent::schema_output($post->ID), $schema );

			// Get actors
			//
			$schema['actor'] = $this->get_actors($post->ID, $this->type);
			
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
		public function get_actors( $post_id, $type ) {
			
			$output = array();
	
			$count = get_post_meta( $post_id, 'schema_properties_'.$type.'_actor', true );
	
			if ( isset( $count ) && $count >= 0 ) {
		 
				for( $i=0; $i < $count; $i++ ) {
					
					$step_no = $i + 1;
					
					$name 		= get_post_meta( $post_id, 'schema_properties_'.$type.'_actor_' . $i . '_actor_name', true );
					
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
