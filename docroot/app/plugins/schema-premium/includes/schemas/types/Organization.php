<?php
/**
 * @package Schema Premium - Class Schema Organization
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Organization') ) :
	/**
	 * Class
	 *
	 * @since 1.2
	 */
	class Schema_WP_Organization extends Schema_WP_Thing {
		
		/** @var string Current Type */
    	protected $type = 'Organization';
		
		/** @var string Current Parent Type */
    	protected $parent_type = 'Thing'; 
		
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
			
			return 'Organization';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Organization', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('An organization such as a school, NGO, corporation, club, etc.', 'schema-premium');
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
			
			return apply_filters( 'schema_wp_Organization', $schema );
		}
		
		/**
		* Get sub types
		*
		* @since 1.0.0
		* @return array
		*/
		public function subtypes() {
			
			// This is not used yes!
			// @TODO release these when types are completed, also complete the list of subtypes
			//
			$subtypes = array
			(	
				/*
				'Airline' 					=> __('Airline', 'schema-premium'),
				'Consortium' 				=> __('Consortium', 'schema-premium'),
				'Corporation'				=> __('Corporation', 'schema-premium'),
				'EducationalOrganization'	=> __('Educational Organization', 'schema-premium'),
				'FundingScheme' 			=> __('Funding Scheme', 'schema-premium'),
				'GovernmentOrganization' 	=> __('Government Organization', 'schema-premium'),
				'LibrarySystem' 			=> __('Library System', 'schema-premium'),
				'LocalBusiness' 			=> __('Local Business', 'schema-premium'),
				'MedicalOrganization' 		=> __('MedicalOrganization', 'schema-premium').
				'NGO' 						=> __('NGO', 'schema-premium')
				'NewsMediaOrganization' 	=> __('News Media Organization', 'schema-premium')
				'PerformingGroup' 			=> __('Performing Groupn', 'schema-premium')
				'MedicalOrganization' 		=> __('MedicalOrganization', 'schema-premium')
				'Project' 					=> __('Project', 'schema-premium')
				'SportsOrganization' 		=> __('Sports Organization', 'schema-premium')
				'WorkersUnion' 				=> __('Workers Union', 'schema-premium')	
				*/
			);
			
			return apply_filters( 'schema_wp_subtypes_Organization', $subtypes );
		}
		
		/**
		* Properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {
			
			$properties = array(

				'award' => array(
					'label' 		=> __('Award', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('An award won by or for this item.', 'schema-premium'),
				),
				'email' => array(
					'label' 		=> __('Email', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'email',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('Email address.', 'schema-premium'),
				),
				'telephone' => array(
					'label' 		=> __('Telephone', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The telephone number.', 'schema-premium')
				),
				'faxNumber' => array(
					'label' 		=> __('Fax Number', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The fax number.', 'schema-premium')
				),
				'foundingDate' => array(
					'label'			 => __('Founding Date', 'schema-premium'),
					'rangeIncludes'  => array('Date'),
					'field_type' 	 => 'date_picker',
					'markup_value'   => 'disabled',
					'instructions'   => __('The date that this organization was founded.', 'schema-premium'),
					'display_format' => get_option( 'date_format' ), // WP
					'return_format'  => 'Y-m-d',
				),
				'dissolutionDate' => array(
					'label'			 => __('Dissolution Date', 'schema-premium'),
					'rangeIncludes'  => array('Date'),
					'field_type' 	 => 'date_picker',
					'markup_value'   => 'disabled',
					'instructions'   => __('The date that this organization was dissolved.', 'schema-premium'),
					'display_format' => get_option( 'date_format' ), // WP
					'return_format'  => 'Y-m-d',
				),
				'legalName' => array(
					'label' 		=> __('Legal Name', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The official name of the organization, e.g. the registered company name.', 'schema-premium'),
				),
				// Logo
				'logo' => array(
					'label' 		=> __('Logo', 'schema-premium'),
					'rangeIncludes' => array('ImageObject', 'URL'),
					'field_type' 	=> 'image',
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('An associated logo.', 'schema-premium'),
				),
				// Review
				'review' => array(
					'label' 		=> __('Review', 'schema-premium'),
					'rangeIncludes' => array('Number'),
					'field_type' 	=> 'star_rating',
					'markup_value' 	=> 'disabled',
					'instructions' 	=> __('The rating given for this item.', 'schema-premium'),
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
					'layout' => 'horizontal'
				),
				'review_author' => array(
					'label' 		=> __('Review Author', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' 	=> 'disabled',
					'instructions' 	=> __('The author name of this item review.', 'schema-premium'),
				),
				'slogan' => array(
					'label' 		=> __('Slogan', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('A slogan or motto associated with the item.', 'schema-premium'),
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
				// Address
				'streetAddress' => array(
					'label' 		=> __('Street Address', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('The street address. For example, 1600 Amphitheatre Pkwy.', 'schema-premium'),
					'required' 		=> true
				),
				'streetAddress_2' => array(
					'label' 		=> __('Street Address 2', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> '',
				),
				'streetAddress_3' => array(
					'label' 		=> __('Street Address 3', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> '',
				),
				'addressLocality' => array(
					'label' 		=> __('Locality / City', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('The locality. For example, Mountain View.', 'schema-premium'),
					'required' 		=> true
				),
				'addressRegion' => array(
					'label' 		=> __('Region / State or Province', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'new_custom_field',
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
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('The country. For example, USA. You can also provide the two-letter ISO 3166-1 alpha-2 country code.', 'schema-premium'),
					'required' 		=> true,
					'allow_null' 	=> true
				),
				// geo
				'geo_latitude' => array(
					'label' 		=> __('Geo Latitude', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'number',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The latitude of the business location. The precision should be at least 5 decimal places.', 'schema-premium')
				),
				'geo_longitude' => array(
					'label' 		=> __('Geo Longitude', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'number',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The longitude of the business location. The precision should be at least 5 decimal places', 'schema-premium')
				)
			);
			
			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 20 );
			
			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

			return apply_filters( 'schema_properties_Organization', $properties );	
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
			$schema['@type']	=  $this->type;
			
			// Get main entity of page
			//
			$schema['mainEntityOfPage'] = array
			(
				'@type' => 'WebPage',
				'@id' => get_permalink( $post->ID ) . '#webpage'
			);
			
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
				// Review author
				//
				if ( isset($properties['review_author']) ) {
					$schema['review']['author'] = array(
						'@type'	=> 'Person',
						'name' => $properties['review_author']
					);
				} else {
					$schema['review']['author'] = schema_wp_get_author_array();
				}
			}
			
			// Address
			//
			$streetAddress		= isset($properties['streetAddress'] ) ? $properties['streetAddress'] : get_post_meta( $post->ID , 'schema_properties_Organization_streetAddress', true);
			$streetAddress_2 	= isset($properties['streetAddress_2'] ) ? $properties['streetAddress_2'] : get_post_meta( $post->ID , 'schema_properties_Organization_streetAddress_2', true);
			$streetAddress_3 	= isset($properties['streetAddress_3'] ) ? $properties['streetAddress_3'] :  get_post_meta( $post->ID , 'schema_properties_Organization_streetAddress_3', true);
			$addressLocality	= isset($properties['addressLocality'] ) ? $properties['addressLocality'] : get_post_meta( $post->ID , 'schema_properties_Organization_addressLocality', true);
			$addressRegion 		= isset($properties['addressRegion'] ) ? $properties['addressRegion'] : get_post_meta( $post->ID , 'schema_properties_Organization_addressRegion', true);
			$postalCode 		= isset($properties['postalCode'] ) ? $properties['postalCode'] : get_post_meta( $post->ID , 'schema_properties_Organization_postalCode', true);
			$addressCountry 	= isset($properties['addressCountry'] ) ? $properties['addressCountry'] : get_post_meta( $post->ID , 'schema_properties_Organization_addressCountry', true);
			
			if ( isset($streetAddress) && $streetAddress != '' 
				|| isset($streetAddress_2) && $streetAddress_2 != '' 
				|| isset($streetAddress_3) && $streetAddress_3 != '' 
				|| isset($postalCode) && $postalCode != '' ) {
				
				// Set location markup
				//
				$schema['address'] = array
				(
					'streetAddress' 	=> $streetAddress . ' ' . $streetAddress_2 . ' ' . $streetAddress_3, // join the 3 address lines
					'addressLocality' 	=> $addressLocality,
					'addressRegion' 	=> $addressRegion,
					'postalCode' 		=> $postalCode,
					'addressCountry' 	=> $addressCountry	
				);
			}

			// Geo Location
			//
			$latitude 	= isset($properties['geo_latitude'] ) ? $properties['geo_latitude'] : get_post_meta( $post->ID , 'schema_properties_Organization_geo_latitude', true);
			$longitude 	= isset($properties['geo_longitude'] ) ? $properties['geo_longitude'] : get_post_meta( $post->ID , 'schema_properties_Organization_geo_longitude', true);
			
			if ( isset($latitude) && $latitude != '' || isset($longitude) && $longitude != '' ) {
				$schema['geo'] = array
				(
					'@type' => 'GeoCoordinates',
					'latitude' 	=> $latitude, 
					'longitude'	=> $longitude	
				);
			}

			// Merge schema and properties arrays
			// Make sure $properties is an array before merging
			// 
			if ( is_array($properties) ) {

				// Unset auto generated properties
				//
				unset($properties['review']);
				unset($properties['review_author']);
				
				$schema = array_merge( $schema, $properties );
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
		* @since 1.1.2
		* @return array
		*/
		public function schema_output_filter( $schema ) {
			
			// Unset auto generated properties
			//

			//unset($schema['review']);
			//unset($schema['review_author']);

			unset($schema['streetAddress']);
			unset($schema['addressLocality']);
			unset($schema['addressRegion']);
			unset($schema['postalCode']);
			unset($schema['addressCountry']);
			unset($schema['geo_latitude']);
			unset($schema['geo_longitude']);

			return apply_filters( 'schema_output_Organization', $schema );
		}
	}
	
	new Schema_WP_Organization();
	
endif;
