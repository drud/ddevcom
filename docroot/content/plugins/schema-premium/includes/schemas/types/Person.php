<?php
/**
 * @package Schema Premium - Class Schema Person
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Person') ) :
	/**
	 * Class
	 *
	 * @since 1.0.4
	 */
	class Schema_WP_Person {
		
		/** @var string Currenct Type */
    	protected $type = 'Person';
		
		/**
	 	* Constructor
	 	*
	 	* @since 1.0.4
	 	*/
		public function __construct () {
		
			$this->init();
		}
	
		/**
		* Init
		*
		* @since 1.0.4
	 	*/
		public function init() {
		
			add_filter( 'schema_wp_get_default_schemas', array( $this, 'schema_type' ) );
			add_filter( 'schema_wp_types', array( $this, 'schema_type_extend' ) );
		}
		
		/**
		* Get schema type label
		*
		* @since 1.0.4
		* @return array
		*/
		public function label() {
			
			return __('Person', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.4
		* @return array
		*/
		public function comment() {
			
			return __('A person (alive, dead, undead, or fictional).', 'schema-premium');
		}
		
		/**
		* Extend schema types
		*
		* @since 1.0.4
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
		* @since 1.0.4
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
			
			return apply_filters( 'schema_wp_Person', $schema );
		}
		
		/**
		* Get sub types
		*
		* @since 1.0.4
		* @return array
		*/
		public function subtypes() {
			
			$subtypes = array();
				
			return apply_filters( 'schema_wp_subtypes_Person', $subtypes );
		}
		
		/**
		* Get properties
		*
		* @since 1.0.4
		* @return array
		*/
		public function properties() {
			
			$properties = array (
					
				'name' => array(
					'label' 		=> __('Name', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' => 'post_title',
					'instructions' 	=> __('The name of the person.', 'schema-premium'),
					'required' 		=> true
				),
				'url' => array(
					'label' 		=> __('URL', 'schema-premium'),
					'rangeIncludes' => array('URL'),
					'field_type' 	=> 'url',
					'markup_value' => 'post_permalink',
					'instructions' 	=> __('URL of the peron page.', 'schema-premium'),
					'placeholder' 	=> 'https://'
				),
				'gender' => array(
					'label' 		=> __('Gender', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'select',
					'markup_value' => 'new_custom_field',
					'choices' 		=> array
					(
						'female' 	=> 'Female',
						'male' 		=> 'Male'
					),
					'instructions' 	=> __('Gender of the person.', 'schema-premium'),
					'allow_null'	=> true
				),
				'birthDate' => array(
					'label' 		=> __('Date of Birth', 'schema-premium'),
					'rangeIncludes' => array('Date'),
					'field_type' 	=> 'date_picker',
					'markup_value' => 'new_custom_field',
					'instructions' 	=> __('Date of death', 'schema-premium'),
					'placeholder'	=> '',
					'display_format' => get_option( 'date_format' ), // WP
					'return_format' => 'Y-m-d',
				),
				'jobTitle' => array(
					'label' 		=> __('Job Title', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' => 'new_custom_field',
					'instructions' 	=> __('The job title of the person (for example, Financial Manager).', 'schema-premium'),
				),
				'image' => array(
					'label' 		=> __('Photograph', 'schema-premium'),
					'rangeIncludes' => array('ImageObject', 'URL'),
					'field_type' 	=> 'image',
					'markup_value' => 'featured_image',
					'instructions' 	=> __('A Photograph of the person.', 'schema-premium'),
					'required' 		=> true
				),
				'email' => array(
					'label' 		=> __('Email Address', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'email',
					'markup_value' => 'new_custom_field',
					'instructions' 	=> __('The email address of the person.', 'schema-premium'),
					'placeholder'	=> '+1-123-456-7890'
				),
				'telephone' => array(
					'label' 		=> __('Telephone', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' => 'new_custom_field',
					'instructions' 	=> __('The telephone number of the person.', 'schema-premium'),
					'placeholder'	=> '+1-123-456-7890'
				),
				'description' => array(
					'label' 		=> __('Description', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'textarea',
					'markup_value' => 'post_excerpt',
					'instructions' 	=> __('A description of the person.', 'schema-premium'),
				),
				// address
				'streetAddress' => array(
					'label' 		=> __('Street Address', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' => 'new_custom_field',
					'instructions' 	=> __('The street address. For example, 1600 Amphitheatre Pkwy.', 'schema-premium'),
					'required' 		=> true
				 ),
				 'streetAddress_2' => array(
					 'label' 		=> __('Street Address 2', 'schema-premium'),
					 'rangeIncludes' => array('Text'),
					 'field_type' 	=> 'text',
					 'markup_value' => 'disabled',
					 'instructions' 	=> '',
				 ),
				 'streetAddress_3' => array(
					 'label' 		=> __('Street Address 3', 'schema-premium'),
					 'rangeIncludes' => array('Text'),
					 'field_type' 	=> 'text',
					 'markup_value' => 'disabled',
					 'instructions' 	=> '',
				 ),
				 'addressLocality' => array(
					 'label' 		=> __('Locality / City', 'schema-premium'),
					 'rangeIncludes' => array('Text'),
					 'field_type' 	=> 'text',
					 'markup_value' => 'new_custom_field',
					 'instructions' 	=> __('The locality. For example, Mountain View.', 'schema-premium'),
					 'required' 		=> true
				  ),
				 'addressRegion' => array(
					 'label' 		=> __('Region / State or Province', 'schema-premium'),
					 'rangeIncludes' => array('Text'),
					 'field_type' 	=> 'text',
					 'markup_value' => 'new_custom_field',
					 'instructions' 	=> __('The region. For example, CA.', 'schema-premium'),
					 'required' 		=> true
				 ),
				 'postalCode' => array(
					 'label' 		=> __('Zip / Postal Code', 'schema-premium'),
					 'rangeIncludes' => array('Text'),
					 'field_type' 	=> 'text',
					 'markup_value' => 'new_custom_field',
					 'instructions' 	=> __('The postal code. For example, 94043.', 'schema-premium'),
					 'required' 		=> true
				 ),
				 'addressCountry' => array(
					 'label' 		=> __('Country', 'schema-premium'),
					 'rangeIncludes' => array('Country', 'Text'),
					 'field_type' 	=> 'countries_select',
					 'markup_value' => 'new_custom_field',
					 'instructions' 	=> __('The country. For example, USA. You can also provide the two-letter ISO 3166-1 alpha-2 country code.', 'schema-premium'),
					 'required' 		=> true
				 ),
			);
			
			return apply_filters( 'schema_properties_Person', $properties );	
		}
		
		/**
		* Schema output
		*
		* @since 1.0.4
		* @return array
		*/
		public function schema_output( $post_id = null ) {
			
			if ( isset($post_id) ) {
				$post = get_post( $post_id );
			} else {
				global $post;
			}
			
			$schema			= array();
			
			// Putting all together
			//
			$schema['@context'] 		=  'http://schema.org';
			$schema['@type'] 			=  $this->type;
			
			// Get properties
			//
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			// Debug
			//echo'<pre>';print_r($schema);echo'</pre>';
			//echo'<pre>';print_r($properties);echo'</pre>';
			
			$schema['name']			= isset($properties['name']) ? $properties['name'] : '';
			$schema['url']			= isset($properties['url']) ? $properties['url'] : '';
			$schema['description']	= isset($properties['description']) ? $properties['description'] : schema_wp_get_description( $post->ID );
			$schema['image'] 		= isset($properties['image']) ? $properties['image'] : schema_wp_get_media( $post->ID );
			$schema['telephone'] 	= isset($properties['telephone']) ? $properties['telephone'] : '';
			
	
			// Address
			$streetAddress		= isset($properties['streetAddress']) ? $properties['streetAddress'] : '';
			$streetAddress_2 	= isset($properties['streetAddress_2']) ? $properties['streetAddress_2'] : '';
			$streetAddress_3 	= isset($properties['streetAddress_3']) ? $properties['streetAddress_3'] : '';
			$addressLocality	= isset($properties['addressLocality']) ? $properties['addressLocality'] : '';
			$addressRegion 		= isset($properties['addressRegion']) ? $properties['addressRegion'] : '';
			$postalCode 		= isset($properties['postalCode']) ? $properties['postalCode'] : '';
			$addressCountry 	= isset($properties['addressCountry']) ? $properties['addressCountry'] : '';
			
			if ( isset($streetAddress) && $streetAddress != '' 
				|| isset($streetAddress_2) && $streetAddress_2 != '' 
				|| isset($streetAddress_3) && $streetAddress_3 != '' 
				|| isset($postalCode) && $postalCode != '' ) {
				
				$schema['address'] = array
				(
					'@type' => 'PostalAddress',
					'streetAddress' 	=> $streetAddress . ' ' . $streetAddress_2 . ' ' . $streetAddress_3, // join the 3 address lines
					'addressLocality' 	=> $addressLocality,
					'addressRegion' 	=> $addressRegion,
					'postalCode' 		=> $postalCode,
					'addressCountry' 	=> $addressCountry,		
				);
			}
		
			// Unset auto generated properties
			unset($properties['streetAddress']);
			unset($properties['streetAddress_2']);
			unset($properties['streetAddress_3']);
			unset($properties['addressLocality']);
			unset($properties['addressRegion']);
			unset($properties['postalCode']);
			unset($properties['addressCountry']);
			
			// Merge schema and properties arrays
			// Make sure $properties is an array before merging
			// 
			if ( is_array($properties) ) {
				$schema = array_merge($schema, $properties);
			}
			
			// Debug
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
			
			return apply_filters( 'schema_output_Person', $schema );
		}
	}
	
	new Schema_WP_Person();
	
endif;
