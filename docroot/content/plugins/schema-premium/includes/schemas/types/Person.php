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
	class Schema_WP_Person extends Schema_WP_Thing {
		
		/** @var string Currenct Type */
		protected $type = 'Person';
		
		/** @var string Current Parent Type */
    	protected $parent_type = 'Thing';
		
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
		* Get schema type 
		*
		* @since 1.2
		* @return string
		*/
		public function type() {
			
			return 'Person';
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
				
			return apply_filters( 'schema_wp_subtypes_Person', array() );
		}
		
		/**
		* Get properties
		*
		* @since 1.0.4
		* @return array
		*/
		public function properties() {
			
			$properties = array (
				
				'additionalName' => array(
					'label' 		=> __('Additional Name', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('An additional name for a Person, can be used for a middle name.', 'schema-premium'),
				),
				'givenName' => array(
					'label' 		=> __('Given Name', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('Given name. In the U.S., the first name of a Person. This can be used along with familyName instead of the name property.', 'schema-premium'),
				),
				'familyName' => array(
					'label' 		=> __('Family Name', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('Family name. In the U.S., the last name of an Person.', 'schema-premium'),
				),
				'award' => array(
					'label' 		=> __('Award', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled', 
					'instructions' 	=> __('An award won by or for this person.', 'schema-premium')
				),
				'gender' => array(
					'label' 		=> __('Gender', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'select',
					'markup_value'  => 'new_custom_field',
					'choices' 		=> array
					(
						'female' 	=> __('Female', 'schema-premium'),
						'male' 		=> __('Male', 'schema-premium')
					),
					'instructions' 	=> __('Gender of the person.', 'schema-premium'),
					'allow_null'	=> true
				),
				'nationality' => array(
					'label' 		=> __('Nationality', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'select',
					'choices'		=> schema_wp_get_countries(),
					'markup_value'  => 'disabled',
					'multiple' 		=> 1,
					'ui' 			=> 1,
					'instructions' 	=> __('Nationality of the person.', 'schema-premium'),
				),
				'birthDate' => array(
					'label' 		 => __('Date of Birth', 'schema-premium'),
					'rangeIncludes'  => array('Date'),
					'field_type' 	 => 'date_picker',
					'markup_value'   => 'new_custom_field',
					'instructions' 	 => __('Date of death', 'schema-premium'),
					'placeholder'	 => '',
					'display_format' => get_option( 'date_format' ), // WP
					'return_format'  => 'Y-m-d',
				),
				'deathDate' => array(
					'label' 		 => __('Date of death', 'schema-premium'),
					'rangeIncludes'  => array('Date'),
					'field_type' 	 => 'date_picker',
					'markup_value'   => 'disabled',
					'instructions' 	 => __('Date of death', 'schema-premium'),
					'placeholder'	 => '',
					'display_format' => get_option( 'date_format' ), // WP
					'return_format'  => 'Y-m-d',
				),
				'jobTitle' => array(
					'label' 		=> __('Job Title', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('The job title of the person (for example, Financial Manager).', 'schema-premium'),
				),
				'image' => array(
					'label' 		=> __('Photograph', 'schema-premium'),
					'rangeIncludes' => array('ImageObject', 'URL'),
					'field_type' 	=> 'image',
					'markup_value'  => 'featured_image',
					'instructions' 	=> __('A Photograph of the person.', 'schema-premium'),
					'required' 		=> true
				),
				'email' => array(
					'label' 		=> __('Email Address', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'email',
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('The email address of the person.', 'schema-premium'),
					'placeholder'	=> '+1-123-456-7890'
				),
				'telephone' => array(
					'label' 		=> __('Telephone', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The telephone number of the person.', 'schema-premium'),
					'placeholder'	=> '+1-123-456-7890'
				),
				'faxNumber' => array(
					'label' 		=> __('Fax Number', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The fax number.', 'schema-premium'),
					'placeholder'	=> '+1-123-456-7890'
				),
				'taxID' => array(
					'label' 		=> __('Tax ID', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The Tax / Fiscal ID of the organization or person, e.g. the TIN in the US or the CIF/NIF in Spain.', 'schema-premium'),
				),
				'vatID' => array(
					'label' 		=> __('Vat ID', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The Value-added Tax ID of the organization or person.', 'schema-premium'),
				),
				// address
				'streetAddress' => array(
					'label' 		=> __('Street Address', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('The street address. For example, 1600 Amphitheatre Pkwy.', 'schema-premium'),
					'required' 		=> true
				 ),
				 'streetAddress_2' => array(
					 'label' 		 => __('Street Address 2', 'schema-premium'),
					 'rangeIncludes' => array('Text'),
					 'field_type' 	 => 'text',
					 'markup_value'  => 'disabled',
					 'instructions'  => '',
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
			
			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 30 );

			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

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
			
			$schema = array();
			
			// Get properties
			//
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			// Address
			//
			$address = schema_premium_get_address( $properties );
			if ( ! empty($address) ) {
				$schema['address'] = schema_premium_get_address( $properties );
			}

			// Merge parent schema 
			//
			$schema = array_merge( parent::schema_output($post->ID), $schema );

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
			
			// Unset auto generated properties
			//
			unset($schema['streetAddress']);
			unset($schema['streetAddress_2']);
			unset($schema['streetAddress_3']);
			unset($schema['addressLocality']);
			unset($schema['addressRegion']);
			unset($schema['postalCode']);
			unset($schema['addressCountry']);

			return apply_filters( 'schema_output_Person', $schema );
		}
	}
	
	new Schema_WP_Person();
	
endif;
