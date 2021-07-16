<?php
/**
 * @package Schema Premium - Class Schema Place
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Place') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Place extends Schema_WP_Thing {
		
		/** @var string Currenct Type */
		protected $type = 'Place';
		
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
			add_filter( 'schema_premium_meta_is_opennings', array( $this, 'support_opennings' ) );
		}
		
		/**
		* Get schema type 
		*
		* @since 1.2
		* @return string
		*/
		public function type() {
			
			return 'Place';
		}
		
		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Place', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('Entities that have a somewhat fixed, physical extension.', 'schema-premium');
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
		* Add support for openning hours post meta, by fileting is_opennings array
		*
		* @since 1.0.0
		* @return array
		*/
		public function support_opennings( $is_opennings ) {
			
			$supported_types 	= array($this->type);
			$sub_types 			= $this->subtypes();

			if ( is_array( $sub_types ) && ! empty( $sub_types ) ) {
				foreach ( $sub_types as $sub_types_key => $sub_typs ) {
					foreach ( $sub_typs as $sub_type_key => $subtype_data ) {
						$supported_types[] = $sub_type_key;
					}
				}
			}
			
			if ( empty ( $is_opennings ) ) {
				return $supported_types;
			} else {
				return array_merge( $is_opennings,  $supported_types );
			}
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
			
			return apply_filters( 'schema_wp_Place', $schema );
		}
		
		/**
		* Get sub types
		*
		* @since 1.0.0
		* @return array
		*/
		public function subtypes() {
			
			$subtypes = array
			(	
				'Place' => array
				(
            		'Accommodation' 					=> __('Accommodation', 'schema-premium'),
					'AdministrativeArea' 				=> __('Administrative Area', 'schema-premium'),
					'CivicStructure'					=> __('Civic Structure', 'schema-premium'),
					'Landform' 							=> __('Landform', 'schema-premium'),
					'LandmarksOrHistoricalBuildings' 	=> __('Landmarks Or Historical Buildings', 'schema-premium'),
					'Residence'							=> __('Residence', 'schema-premium'),
					/*'TouristAttraction' 				=> __('Tourist Attraction', 'schema-premium'),
					'TouristDestination' 				=> __('Tourist Destination', 'schema-premium')*/
				),
				'Accommodation' => array
				(
            		'Apartment' 		=> __('Apartment', 'schema-premium'),
					'CampingPitch' 		=> __('Camping Pitch', 'schema-premium'),
					'House'				=> __('House', 'schema-premium'),
					'Room' 				=> __('Room', 'schema-premium'),
					'Suite' 			=> __('Suite', 'schema-premium')
				),
							
        	);
				
			return apply_filters( 'schema_wp_subtypes_Place', $subtypes );
		}
		
		/**
		* Get properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {
			
			$properties = array (
					
				'telephone' => array(
					'label' 		=> __('Telephone', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' => 'new_custom_field',
					'instructions' 	=> __('The telephone number.', 'schema-premium'),
					'placeholder'	=> '+1-123-456-7890'
				),
				'maximumAttendeeCapacity' => array(
					'label' 		=> __('Maximum Attendee Capacity', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'number',
					'markup_value' => 'new_custom_field',
					'instructions' 	=> __('The total number of individuals that may attend an event or venue.', 'schema-premium'),
					'placeholder'	=> '',
				),
				'publicAccess' => array(
					'label' 		=> __('Public Access', 'schema-premium'),
					'rangeIncludes' => array('Boolean'),
					'field_type' 	=> 'true_false',
					'default_value' => 0,
					'markup_value' => 'disabled',
					'instructions' 	=> __('A flag to signal that the Place is open to public visitors.', 'schema-premium'),
					'ui' => 1,
					'ui_on_text' => __('Yes', 'schema-premium'),
					'ui_off_text' => __('No', 'schema-premium'),
				),
				'smokingAllowed' => array(
					'label' 		=> __('Smoking Allowed', 'schema-premium'),
					'rangeIncludes' => array('Boolean'),
					'field_type' 	=> 'true_false',
					'default_value' => 0,
					'markup_value' => 'disabled',
					'instructions' 	=> __('Indicates whether it is allowed to smoke in the place, e.g. in the restaurant, hotel or hotel room.', 'schema-premium'),
					'ui' => 1,
					'ui_on_text' => __('Yes', 'schema-premium'),
					'ui_off_text' => __('No', 'schema-premium'),
				),
				'description' => array(
					'label' 		=> __('Description', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'textarea',
					'markup_value' => 'post_excerpt',
					'instructions' 	=> __('A description of the place.', 'schema-premium'),
				),
				'amenityFeature' =>  array(
					'label' 		=> __('Amenity Feature', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'repeater',
					'layout'		=> 'block',
					'markup_value' => 'new_custom_field',
					'button_label' 	=> __('Add Amenity', 'schema-premium'),
					'instructions' 	=> __('An amenity feature (e.g. a characteristic or service) of the Accommodation. This generic property does not make a statement about whether the feature is included in an offer for the main accommodation or available at extra costs.', 'schema-premium'),
					'sub_fields' 	=>  array(
						'amenity_name' => array(
							'label' 		=> __('Name', 'schema-premium'),
							'rangeIncludes' => array('Text'),
							'field_type' 	=> 'text',
							'markup_value' 	=> 'new_custom_field',
							'instructions' 	=> '',
							'placeholder' 	=> __('Amenity name', 'schema-premium'),
						),
					), // end sub fields
				),
				// Address
				'address' => array(
					'label' 		=> __('Adress', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'group',
					'layout'		=> 'block',
					'markup_value' => 'new_custom_field',
					'instructions' 	=> __('Address of the specific place.', 'schema-premium'),
					'sub_fields' 	=>  array(
						'streetAddress' => array(
							'label' 		=> __('Street Address', 'schema-premium'),
							'rangeIncludes' => array('Text'),
							'field_type' 	=> 'text',
							'markup_value' => 'new_custom_field',
							'instructions' 	=> '',
							'required' 		=> true,
							'width' => '50'
						),
						'streetAddress_2' => array(
							'label' 		=> __('Street Address 2', 'schema-premium'),
							'rangeIncludes' => array('Text'),
							'field_type' 	=> 'text',
							'markup_value' 	=> 'disabled',
							'instructions' 	=> '',
							'parent' 		=> 'address',
							'width' => '50'
						),
						'streetAddress_3' => array(
							'label' 		=> __('Street Address 3', 'schema-premium'),
							'rangeIncludes' => array('Text'),
							'field_type' 	=> 'text',
							'markup_value' => 'disabled',
							'instructions' 	=> '',
							'width' => '50'
						),
						'addressLocality' => array(
							'label' 		=> __('Locality / City', 'schema-premium'),
							'rangeIncludes' => array('Text'),
							'field_type' 	=> 'text',
							'markup_value' => 'new_custom_field',
							'instructions' 	=> '',
							'required' 		=> true,
							'width' => '25'
						),
						'addressRegion' => array(
							'label' 		=> __('State or Province', 'schema-premium'),
							'rangeIncludes' => array('Text'),
							'field_type' 	=> 'text',
							'markup_value' => 'new_custom_field',
							'instructions' 	=> '',
							'required' 		=> true,
							'width' => '25'
						),
						'postalCode' => array(
							'label' 		=> __('Zip / Postal Code', 'schema-premium'),
							'rangeIncludes' => array('Text'),
							'field_type' 	=> 'text',
							'markup_value' => 'new_custom_field',
							'instructions' 	=> '',
							'required' 		=> true,
							'width' => '25'
						),
						'addressCountry' => array(
							'label' 		=> __('Country', 'schema-premium'),
							'rangeIncludes' => array('Country', 'Text'),
							'field_type' 	=> 'countries_select',
							'markup_value' => 'new_custom_field',
							'instructions' 	=> '',
							'required' 		=> true,
							'allow_null' 	=> true,
							'ui' 			=> true,
							'width' => '25'
						)
					),
				),
				// Geo Location
				'geo' => array(
					'label' 		=> __('Geo Location', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'group',
					'layout'		=> 'block',
					'markup_value' => 'new_custom_field',
					'instructions' 	=> __('The Geo location of the place. The precision should be at least 5 decimal places.', 'schema-premium'),
					'sub_fields' 	=>  array(
						'latitude' => array(
							'label' 		=> __('Latitude', 'schema-premium'),
							'rangeIncludes' => array('Text'),
							'field_type' 	=> 'number',
							'markup_value' => 'new_custom_field',
							'width' => '50'
						),
						'longitude' => array(
							'label' 		=> __('Longitude', 'schema-premium'),
							'rangeIncludes' => array('Text'),
							'field_type' 	=> 'number',
							'markup_value' => 'new_custom_field',
							'width' => '50'
						)
					)
				)
			);
			
			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 30 );

			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

			return apply_filters( 'schema_properties_Place', $properties );	
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
			
			$schema['telephone'] 		= isset($properties['telephone'] ) ? $properties['telephone'] : get_post_meta( $post->ID , 'schema_properties_Place_telephone', true);
			$schema['maximumAttendeeCapacity'] 		= isset($properties['maximumAttendeeCapacity'] ) ? $properties['maximumAttendeeCapacity'] : get_post_meta( $post->ID , 'schema_properties_Place_maximumAttendeeCapacity', true);
			
			// Get amenityFeature
			//
			$schema['amenityFeature'] 	= $this->get_amenity();

			// Address
			$streetAddress		= get_post_meta( $post->ID , 'schema_properties_Place_address_streetAddress', true);
			$streetAddress_2 	= get_post_meta( $post->ID , 'schema_properties_Place_address_streetAddress_2', true);
			$streetAddress_3 	= get_post_meta( $post->ID , 'schema_properties_Place_address_streetAddress_3', true);
			$addressLocality	= get_post_meta( $post->ID , 'schema_properties_Place_address_addressLocality', true);
			$addressRegion 		= get_post_meta( $post->ID , 'schema_properties_Place_address_addressRegion', true);
			$postalCode 		= get_post_meta( $post->ID , 'schema_properties_Place_address_postalCode', true);
			$addressCountry 	= get_post_meta( $post->ID , 'schema_properties_Place_address_addressCountry', true);
			
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
			
			// Geo Location
			$latitude 	= get_post_meta( $post->ID , 'schema_properties_Place_geo_latitude', true);
			$longitude 	= get_post_meta( $post->ID , 'schema_properties_Place_geo_longitude', true);
			
			if ( isset($latitude) && $latitude != '' || isset($longitude) && $longitude != '' ) {
				$schema['geo'] = array
				(
					'@type' => 'GeoCoordinates',
					'latitude' 	=> $latitude, 
					'longitude'	=> $longitude	
				);
			}

			// Address: merg two arrays
			if ( !empty($schema['address']) && !empty($properties['address'])) {
				$properties['address'] = array_replace_recursive( $schema['address'], $properties['address'] );
			}
			
			// Geo: merg two arrays
			if ( !empty($schema['geo']) && !empty($properties['geo'])) {
				$properties['geo'] 	= array_replace_recursive( $schema['geo'], $properties['geo'] );
				$schema['geo'] 		= $properties['geo'];
				
				// Make sure this is added!
				$schema['geo']['@type'] = 'GeoCoordinates'; 
			}
			
			// Public Access
			//
			if ( isset($properties['publicAccess']) ) {
				
				if ( $properties['publicAccess'] == 1 ) {
					// True
					$schema['publicAccess'] = 'True';
						
				} elseif ( $properties['publicAccess'] == 0 ) {
					// False
					$schema['publicAccess'] = 'False';
				}
			}

			// Smoking Allowed
			//
			if ( isset($properties['smokingAllowed']) ) {
				
				if ( $properties['smokingAllowed'] == 1 ) {
					// True
					$schema['smokingAllowed'] = 'True';
						
				} elseif ( $properties['smokingAllowed'] == 0 ) {
					// False
					$schema['smokingAllowed'] = 'False';
				}
			}

			// Unset unwanted values
			unset($schema['address']['streetAddress_2']);
			unset($schema['address']['streetAddress_3']);

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
			
			return apply_filters( 'schema_output_Place', $schema );
		}

		/**
		* Get Supplies
		*
		* @since 1.0.0
		* @return array
		*/
		public function get_amenity() {
			
			global $post;
			
			$output = array();
	
			$count = get_post_meta( get_the_ID(), 'schema_properties_Place_amenityFeature', true );
	
			if ( isset( $count ) && $count >= 0 ) {
		 
				for( $i=0; $i < $count; $i++ ) {
					
					$step_no = $i + 1;
					
					$name 		= get_post_meta( get_the_ID(), 'schema_properties_Place_amenityFeature_' . $i . '_amenity_name', true );
					
					$output[] 	= array
					(
						'@type'	=> 'LocationFeatureSpecification',
						'name'	=> strip_tags($name),
						'value'	=> true
					);
				}
		
			}
	
			return $output;
		}

	}
	
	new Schema_WP_Place();
	
endif;
