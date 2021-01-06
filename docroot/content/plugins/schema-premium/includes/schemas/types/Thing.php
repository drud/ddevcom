<?php
/**
 * @package Schema Premium - Class Schema Thing
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Thing') ) :
	/**
	 * Class
	 *
	 * @since 1.2
	 */
	class Schema_WP_Thing {
		
		/** @var string Current Type */
    	protected $type = 'Thing';
		
		/** @var string Current Parent Type */
    	protected $parent_type = ''; // The most generic type of item.
		
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
			
			return 'Thing';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Thing', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('The most generic type of item.', 'schema-premium');
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
			
			return apply_filters( 'schema_wp_Thing', $schema );
		}
		
		/**
		* Get sub types
		*
		* @since 1.0.0
		* @return array
		*/
		public function subtypes() {
			
			// This is not used, since subtypes are introduced somewhere else!
			// @TODO release these when types are completed
			//
			$subtypes = array
			(	
				/*
				'Action' 		=> __('Action', 'schema-premium'),
				'CreativeWork' 	=> __('Creative Work', 'schema-premium'),
				'Event'			=> __('Event', 'schema-premium'),
				'Intangible' 	=> __('Intangible', 'schema-premium'),
				'MedicalEntity' => __('Medical Entity', 'schema-premium'),
				'Organization' 	=> __('Organization', 'schema-premium'),
				'Person' 		=> __('Person', 'schema-premium'),
				'Place' 		=> __('Place', 'schema-premium'),
				'Product' 		=> __('Product', 'schema-premium')	
				*/
			);
			
			return apply_filters( 'schema_wp_subtypes_Thing', $subtypes );
		}
		
		/**
		* Get properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {
			
			$properties = array(
				
				'additionalType' => array(
					'label' 		=> __('Additional Type', 'schema-premium'),
					'rangeIncludes' => array('URL'),
					'field_type' 	=> 'url',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('An additional type for the item, typically used for adding more specific types from external vocabularies in microdata syntax.', 'schema-premium'),
					'placeholder' 	=> 'https://'
				),
				'name' => array(
					'label' 		=> __('Name', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'post_title',
					'instructions' 	=> __('The name of the item.', 'schema-premium')
				),
				'alternateName' => array(
					'label' 		=> __('Alternative Name', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('An alias for the item.', 'schema-premium')
				),
				'description' => array(
					'label' 		=> __('Description', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'textarea',
					'markup_value'  => 'post_excerpt',
					'instructions' 	=> __('A description of the item.', 'schema-premium'),
				),
				/*
				'disambiguatingDescription' => array(
					'label' 		=> __('Disambiguating Description', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('A sub property of description. A short description of the item used to disambiguate from other, similar items.', 'schema-premium')
				),
				*/
				/*
				'identifier' => array(
					'label' 		=> __('Identifier', 'schema-premium'),
					'rangeIncludes' => array('PropertyValue', 'Text', 'URL'),
					'field_type' 	=> 'textarea',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The identifier property represents any kind of identifier for any kind of Thing, such as ISBNs, GTIN codes, UUIDs etc.', 'schema-premium'),
				),
				*/
				'image' => array(
					'label' 		=> __('Image', 'schema-premium'),
					'rangeIncludes' => array('ImageObject', 'URL'),
					'field_type' 	=> 'image',
					'markup_value'  => 'featured_image',
					'instructions' 	=> __('An image of the item.', 'schema-premium'),
					'required' 		=> true
				),
				/*
				'mainEntityOfPage' => array(
					'label' 		=> __('Main Entity of Page', 'schema-premium'),
					'rangeIncludes' => array('CreativeWork', 'URL'),
					'field_type' 	=> 'url',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('Indicates a page (or other CreativeWork) for which this thing is the main entity being described.', 'schema-premium'),
					'placeholder' 	=> 'https://'
				),
				*/
				//'potentialAction' => '',
				//'sameAs' => '',
				//'subjectOf' => '',
				'url' => array(
					'label' 		=> __('URL', 'schema-premium'),
					'rangeIncludes' => array('URL'),
					'field_type' 	=> 'url',
					'markup_value'  => 'post_permalink',
					'instructions' 	=> __('URL of the item.', 'schema-premium'),
					'placeholder' 	=> 'https://'
				)
			);
			
			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 10 );

			return apply_filters( 'schema_properties_Thing', $properties );	
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
			
			if ( isset($properties['additionalType']) ) 
				$schema['additionalType'] = $properties['additionalType'];
			
			/*
			if ( isset($properties['description']) ) {
				$schema['description'] = $properties['description'];
			} else {
				$schema['description'] = schema_wp_get_description( $post_id );
			}
			*/

			if ( isset($properties['image']) ) {
				$schema['image'] = $properties['image'];
			} else {
				$schema['image'] = schema_wp_get_media( $post_id );
			}

			if ( isset($properties['name']) ) 
				$schema['name'] = $properties['name'];

			if ( isset($properties['url']) ) 
				$schema['url'] = $properties['url'];

			// Merge schema and properties arrays
			// Make sure $properties is an array before merging
			// 
			if ( is_array($properties) ) {
				$schema = array_merge( $schema, $properties );
			}

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
			
			return apply_filters( 'schema_output_Thing', $schema );
		}
	}
	
	new Schema_WP_Thing();
	
endif;
