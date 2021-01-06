<?php
/**
 * @package Schema Premium - Class Schema Service
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Service') ) :
	/**
	 * Class
	 *
	 * @since 1.0.1
	 */
	class Schema_WP_Service extends Schema_WP_Thing {
		
		/** @var string Currenct Type */
    	protected $type = 'Service';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'Thing';

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
			
			return 'Service';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.1
		* @return array
		*/
		public function label() {
			
			return __('Service', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.1
		* @return array
		*/
		public function comment() {
			
			return __('A service provided by an organization, e.g. delivery service, print services, etc.', 'schema-premium');
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
			
			return apply_filters( 'schema_wp_Service', $schema );
		}
		
		/**
		* Get sub types
		*
		* @since 1.0.1
		* @return array
		*/
		public function subtypes() {
			
			// This is not used yet!
			// @TODO release these when types are completed, also complete the list of subtypes
			//
			$subtypes = array
			(	
				/*
				'BroadcastService' 			=> __('Broadcast Service', 'schema-premium'),
				'CableOrSatelliteService' 	=> __('Cable Or Satellite Service', 'schema-premium'),
				'FinancialProduct'			=> __('Financial Product', 'schema-premium'),
				'FoodService' 				=> __('Food Service', 'schema-premium'),
				'GovernmentService' 		=> __('Government Service', 'schema-premium'),
				'TaxiService' 				=> __('Taxi Service', 'schema-premium'),
				'WebAPI' 					=> __('Web API', 'schema-premium')
				*/
			);
				
			return apply_filters( 'schema_wp_subtypes_Service', $subtypes );
		}
		
		/**
		* Get properties
		*
		* @since 1.0.1
		* @return array
		*/
		public function properties() {
			
			$properties = array (
				
				'provider' => array(
					'label' 		=> __('Provider Name', 'schema-premium'),
					'rangeIncludes' => array('Organization', 'Person'),
					'field_type' 	=> 'text',
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('The service provider, service operator, or service performer; the goods producer.', 'schema-premium')
				),
				'providerMobility' => array(
					'label' 		=> __('Provider Mobility', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('Indicates the mobility of a provided service (e.g. static, dynamic)', 'schema-premium'),
				),
				'serviceType' => array(
					'label' 		=> __('Service Type', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('The type of service being offered, e.g. veterans\' benefits, emergency relief, etc.', 'schema-premium'),
					//'required' 		=> true
				),
				'areaServed' => array(
					'label' 		=> __('Area Served', 'schema-premium'),
					'rangeIncludes' => array('AdministrativeArea', 'GeoShape', 'Place', 'Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The geographic area where a service or offered item is provided.', 'schema-premium'),
				),
				'award' => array(
					'label' 		=> __('Award', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('An award won by or for this item.', 'schema-premium')
				),
				'slogan' => array(
					'label' 		=> __('Slogan', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('A slogan or motto associated with the item.', 'schema-premium')
				),
				'telephone' => array(
					'label' 		=> __('Telephone', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('A business phone number meant to be the primary contact method for customers. Be sure to include the country code and area code in the phone number.', 'schema-premium'),
					'placeholder'	=> '+1-123-456-7890'
				),
				'priceRange' => array(
					'label' 		=> __('Price Range', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'select',
					'markup_value'  => 'new_custom_field',
					'choices' 		=> array
					(
						'$' => '$',
						'$$' => '$$',
						'$$$' => '$$$',
						'$$$$' => '$$$$',
						'$$$$$' => '$$$$$' 
					),
					'instructions' 	=> __('The price range of the service, for example: $$$.', 'schema-premium'),
					'allow_null'	=> true
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
			  	// Geo
				'latitude' => array(
					'label' 		=> __('Latitude', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'number',
					'markup_value' => 'new_custom_field',
					'instructions' 	=> __('The latitude of the serviice location. The precision should be at least 5 decimal places.', 'schema-premium'),
					'width' => '50'
				 ),
				 'longitude' => array(
					 'label' 		=> __('Longitude', 'schema-premium'),
					 'rangeIncludes' => array('Text'),
					 'field_type' 	=> 'number',
					 'markup_value' => 'new_custom_field',
					 'instructions' 	=> __('The longitude of the serviice location. The precision should be at least 5 decimal places.', 'schema-premium'),
					 'width' => '50'
				 ),
				 'review' => array(
					'label' 		=> __('Review', 'schema-premium'),
					'rangeIncludes' => array('Number'),
					'field_type' 	=> 'star_rating',
					'markup_value' 	=> 'new_custom_field',
					'instructions' 	=> __('The rating given for this product.', 'schema-premium'),
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
					'instructions' 	=> __('The author name of this product review.', 'schema-premium'),
				),
				'ratingValue' => array(
					'label' 		=> __('Rating Value', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' => 'new_custom_field',
					'instructions' 	=> __('The aggregate rating for the product.', 'schema-premium'),
				),
				'reviewCount' => array(
					'label' 		=> __('Review Count', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' => 'new_custom_field',
					'conditional_logic' => array(
						array(
							array(
								'field' => 'properties_ratingValue',
								'operator' => '==',
								'value' => 'fixed_rating_field',
							),
						),
						array(
							array(
								'field' => 'properties_ratingValue',
								'operator' => '==',
								'value' => 'new_custom_field',
							),
						),
						array(
							array(
								'field' => 'properties_ratingValue',
								'operator' => '==',
								'value' => 'existing_custom_field',
							),
						),
					),
					'instructions' 	=> __('The count of total number of reviews.', 'schema-premium'),
				)
			);
			
			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 20 );
			
			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

			return apply_filters( 'schema_properties_Service', $properties );	
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
			$schema['@type']	=  $this->type;
			
			// Get properties
			//
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			// Provider
			//
			$schema['provider'] = array
			(
				'@type' 		=> 'LocalBusiness',
				'name'			=> isset($properties['name']) ? $properties['name'] : '',
				'telephone'		=> isset($properties['telephone']) ? $properties['telephone'] : '',
				'priceRange'	=> isset($properties['priceRange']) ? $properties['priceRange'] : '',
				'image'			=> isset($properties['image']) ? $properties['image'] : schema_wp_get_media( $post->ID )
			);
			
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
				
				$schema['provider']['address'] = array
				(
					'@type' => 'PostalAddress',
					'streetAddress' 	=> $streetAddress . ' ' . $streetAddress_2 . ' ' . $streetAddress_3, // join the 3 address lines
					'addressLocality' 	=> $addressLocality,
					'addressRegion' 	=> $addressRegion,
					'postalCode' 		=> $postalCode,
					'addressCountry' 	=> $addressCountry,		
				);
			}
			
			// Geo Location
			$latitude 	= isset($properties['latitude']) ? $properties['latitude'] : '';
			$longitude 	= isset($properties['longitude']) ? $properties['longitude'] : '';
			
			if ( isset($properties['areaServed']) && $properties['areaServed'] != '' ) {
				$schema['areaServed'] = array
				(
					'@type' => 'State',
					'name' 	=> $properties['areaServed']
				);
			}
			
			if ( isset($latitude) && $latitude != '' || isset($longitude) && $longitude != '' ) {
				$schema['provider']['geo'] = array
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
			
				// Merge schema and properties arrays
				// 
				$schema = array_merge($schema, $properties);
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
			unset($schema['review_author']);
			
			unset($schema['telephone']);
			unset($schema['priceRange']);
			
			unset($schema['streetAddress']);
			unset($schema['streetAddress_2']);
			unset($schema['streetAddress_3']);
			unset($schema['addressLocality']);
			unset($schema['addressRegion']);
			unset($schema['postalCode']);
			unset($schema['addressCountry']);
			
			unset($schema['latitude']);
			unset($schema['longitude']);

			unset($schema['areaServed']);
			
			return apply_filters( 'schema_output_Service', $schema );
		}
	}
	
	new Schema_WP_Service();
	
endif;
