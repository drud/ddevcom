<?php
/**
 * @package Schema Premium - Class Schema Course
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Course') ) :
	/**
	 * Class
	 *
	 * @since 1.0.1
	 */
	class Schema_WP_Course extends Schema_WP_CreativeWork {
		
		/** @var string Current Type */
    	protected $type = 'Course';
		
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
		}
		
		/**
		* Get schema type 
		*
		* @since 1.2
		* @return string
		*/
		public function type() {
			
			return 'Course';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Course', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.1
		* @return array
		*/
		public function comment() {
			
			return __('Mark up your course lists with structured data so prospective students find you through Google Search.', 'schema-premium');
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
			
			return apply_filters( 'schema_wp_Course', $schema );
		}
		
		/**
		* Get sub types
		*
		* @since 1.0.1
		* @return array
		*/
		public function subtypes() {
		
			return apply_filters( 'schema_wp_subtypes_Course', array() );
		}
		
		/**
		* Get properties
		*
		* @since 1.0.1
		* @return array
		*/
		public function properties() {
			
			$properties = array (
				
				'courseCode' => array(
					'label' 		=> __('Course Code', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The identifier for the Course used by the course provider (e.g. CS101 or 6.001).', 'schema-premium'),
				),
				'provider' => array(
					'label' 		=> __('Provider', 'schema-premium'),
					'rangeIncludes' => array('Organization'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The organization that publishes the source content of the course. For example, UC Berkeley.', 'schema-premium'),
				)
			);
			
			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 30 );

			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

			return apply_filters( 'schema_properties_Course', $properties );	
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
			
			// provider : Organization
			//
			if( isset($properties['provider'] ) ) { 
				$schema['provider'] = array (
					'@type'	=> 'Organization',
					'name'	=> $properties['provider']
				);
			} else {
				$schema['provider'] = schema_wp_get_publisher_array();
			}
			
			// Unset auto generated properties
			unset($properties['author']);
			
			// Merge schema and properties arrays
			// Make sure $properties is an array before merging
			// 
			if ( is_array($properties) ) {
				$schema = array_merge($schema, $properties);
			}
			
			// Merge parent schema 
			//
			$schema = array_merge( parent::schema_output($post->ID), $schema );

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
			
			return apply_filters( 'schema_output_Course', $schema );
		}
	}
	
	new Schema_WP_Course();
	
endif;
