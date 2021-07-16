<?php
/**
 * @package Schema Premium - Class Schema Event
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Event') ) :
	/**
	 * Schema Event
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Event extends Schema_WP_Thing {
		
		/** @var string Currenct Type */
    	protected $type = 'Event';
		
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
			
			return 'Event';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Event', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('An event happening at a certain time and location, such as a concert, lecture, or festival.', 'schema-premium');
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
			
			return apply_filters( 'schema_wp_Event', $schema );
		}
		
		/**
		* Get sub types
		*
		* @since 1.0.0
		* @return array
		*/
		public function subtypes() {
			
			// Some subtypes are missing!
			// @TODO  complete the list of subtypes
			//
			$subtypes =  array
			(
           		'BusinessEvent' 	=> __('Business Event', 'schema-premium'),
				'ChildrensEvent' 	=> __('Childrens Event', 'schema-premium'),
				'ComedyEvent'		=> __('Comedy Event', 'schema-premium'),
				'CourseInstance'	=> __('Course Instance', 'schema-premium'),
				'DanceEvent' 		=> __('Dance Event', 'schema-premium'),
				'DeliveryEvent' 	=> __('Delivery Event', 'schema-premium'),
				'EducationEvent'	=> __('Education Event', 'schema-premium'),
				'EventSeries'		=> __('Event Series', 'schema-premium'),
				'ExhibitionEvent' 	=> __('Exhibition Event', 'schema-premium'),
				'Festival' 			=> __('Festival', 'schema-premium'),
				'FoodEvent' 		=> __('Food Event', 'schema-premium'),
				'Hackathon' 		=> __('Hackathon', 'schema-premium'),
				'LiteraryEvent' 	=> __('Literary Event', 'schema-premium'),
				'MusicEvent' 		=> __('Music Event', 'schema-premium'),
				'PublicationEvent'	=> __('Publication Event', 'schema-premium'),
				'SaleEvent' 		=> __('Sale Event', 'schema-premium'),
				'ScreeningEvent' 	=> __('Screening Event', 'schema-premium'),
				'SocialEvent' 		=> __('Social Event', 'schema-premium'),
				'SportsEvent' 		=> __('Sports Event', 'schema-premium'),
				'TheaterEvent' 		=> __('Theater Event', 'schema-premium'),
				'VisualArtsEvent' 	=> __('Visual Arts Event', 'schema-premium')
			);
				
			return apply_filters( 'schema_wp_subtypes_Event', $subtypes );
		}
		
		/**
		* Get properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {
			
			$properties = array (
					
				'startDate' => array(
					'label' 		 => __('Start Date', 'schema-premium'),
					'rangeIncludes'  => array('Date', 'DateTime'),
					'field_type' 	 => 'date_time_picker',
					'markup_value'   => 'new_custom_field',
					'instructions' 	 => __('The start date and time of the event.', 'schema-premium'),
					'display_format' => get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), // WP
					'return_format'  => 'Y-m-d g:i a',
					'required' 		 => true
				),
				'endDate' => array(
					'label' 		 => __('End Date', 'schema-premium'),
					'rangeIncludes'  => array('Date', 'DateTime'),
					'field_type' 	 => 'date_time_picker',
					'markup_value'   => 'new_custom_field',
					'instructions' 	 => __('The end date and time of the event.', 'schema-premium'),
					'display_format' => get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), // WP
					'return_format'  => 'Y-m-d g:i a',
				),
				'eventAttendanceMode' => array(
					'label' 		=> __('Event Attendance Mode', 'schema-premium'),
					'rangeIncludes' => array('EventAttendanceModeEnumeration'),
					'field_type' 	=> 'select',
					'choices' 		=> array
					(
						'' => '- ' . __('Select', 'schema-premium') . ' -',
						'MixedEventAttendanceMode' 		=> __('Mixed Event Attendance Mode', 'schema-premium'),
						'OfflineEventAttendanceMode' 	=> __('Offline Event Attendance Mode', 'schema-premium'),
						'OnlineEventAttendanceMode' 	=> __('Online Event Attendance Mode', 'schema-premium')
					),
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('The Event Attendance Mode of an event indicates whether it occurs online, offline, or a mix.', 'schema-premium'),
				),
				'eventStatus' => array(
					'label' 		=> __('Event Status', 'schema-premium'),
					'rangeIncludes' => array('EventStatusType'),
					'field_type' 	=> 'select',
					'choices' 		=> array
					(
						'' => '- ' . __('Select', 'schema-premium') . ' -',
						'EventCancelled' 	=> __('Event Cancelled', 'schema-premium'),
						'EventMovedOnline' 	=> __('Event Moved Online', 'schema-premium'),
						'EventPostponed' 	=> __('Event Postponed', 'schema-premium'),
						'EventRescheduled' 	=> __('Event Rescheduled', 'schema-premium'),
						'EventScheduled' 	=> __('Event Scheduled', 'schema-premium')
					),
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('A Status of an event represents its status; particularly useful when an event is cancelled or rescheduled.', 'schema-premium'),
				),
				'performer_name' => array(
					'label' 		=> __('Performer Name', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('Performer name.', 'schema-premium'),
				),
				'organizer_name' => array(
					'label' 		=> __('Organizer Name', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('The person or organization that is hosting the event.', 'schema-premium'),
				),
				'organizer_url' => array(
					'label' 		=> __('Organizer URL', 'schema-premium'),
					'rangeIncludes' => array('URL'),
					'field_type' 	=> 'url',
					'markup_value'  => 'post_permalink',
					'instructions' 	=> __('The event host\'s domain URL.', 'schema-premium'),
					'placeholder'   => 'https://'
				),
				'offer_price' => array(
					'label' 		=> __('Offer Price', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'number',
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('The lowest available price, including service charges and fees, of this type of ticket.', 'schema-premium'),
				),
				'offer_priceCurrency' => array(
					'label' 		=> __('Price Currency', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'currency_select',
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('The 3-letter currency code.', 'schema-premium'),
				),
				'offer_availability' => array(
					'label' 		=> __('Offer Availability', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'select',
					'choices' 		=> array
					(
						'' => '- ' . __('Select', 'schema-premium') . ' -',
						'InStock' 	=> __('In Stock', 'schema-premium'),
						'SoldOut' 	=> __('Sold Out', 'schema-premium'),
						'PreOrder' 	=> __('Pre Order', 'schema-premium')
					),
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('The availability of the offer.', 'schema-premium'),
				),
				'offer_validFrom' => array(
					'label' 		 => __('Offer Valid From', 'schema-premium'),
					'rangeIncludes'  => array('Date', 'DateTime'),
					'field_type' 	 => 'date_time_picker',
					'markup_value'   => 'new_custom_field',
					'instructions' 	 => __('The date and time when tickets go on sale (only required on date-restricted offers).', 'schema-premium'),
					'display_format' => get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), // WP
					'return_format'  => 'Y-m-d g:i a',
				),
				'offer_url' => array(
					'label' 		=> __('Offer URL', 'schema-premium'),
					'rangeIncludes' => array('URL'),
					'field_type' 	=> 'url',
					'markup_value'  => 'post_permalink',
					'instructions' 	=> __('The URL of a page providing the ability to buy tickets.', 'schema-premium'),
					'placeholder'   => 'https://'
				),
				'isAccessibleForFree' => array(
					'label' 		=> __('Is Accessible For Free', 'schema-premium'),
					'rangeIncludes' => array('Boolean'),
					'field_type' 	=> 'true_false',
					'default_value' => 0,
					'markup_value'  => 'disabled',
					'instructions' 	=> __('A flag to signal that the item, event, or place is accessible for free.', 'schema-premium'),
					'ui' 			=> 1,
					'ui_on_text'    => __('Yes', 'schema-premium'),
					'ui_off_text'   => __('No', 'schema-premium'),
				),
				'venue_name' => array(
					'label' 		=> __('Venue Name', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('The venue\'s detailed name.', 'schema-premium'),
					'required' 		=> true
				),
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

			return apply_filters( 'schema_properties_Event', $properties );	
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
			
			// Debug
			//echo'<pre>';print_r($properties);echo'</pre>';

			// Putting all together
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
			
			// Performer
			//
			$performer_name = isset($properties['performer_name'] ) ? $properties['performer_name'] : get_post_meta( $post->ID , 'schema_properties_Event_performer_name', true);
			
			if ( $performer_name != '') { 
				$schema['performer'] = array(
					'@type' => 'Person',
					'name' 	=> $performer_name
				);
			}

			// Organizer
			//
			$organizer_name = isset($properties['organizer_name'] ) ? $properties['performer_name'] : get_post_meta( $post->ID , 'schema_properties_Event_organizer_name', true);
			$organizer_url 	= isset($properties['organizer_url'] ) ? $properties['organizer_url'] : get_post_meta( $post->ID , 'schema_properties_Event_organizer_url', true);
			
			if ( $organizer_name != '') { 
				$schema['organizer'] = array(
					'@type' => 'Organization',
					'name' 	=> $organizer_name,
					'url' 	=> $organizer_url
				);
			}
			
			// Offer Price
			$offer_price			= isset($properties['offer_price']) ? $properties['offer_price'] : get_post_meta( $post->ID , 'schema_properties_Event_offer_price', true);
			$offer_priceCurrency	= isset($properties['offer_priceCurrency']) ? $properties['offer_priceCurrency'] : get_post_meta( $post->ID , 'schema_properties_Event_offer_priceCurrency', true);
			$offer_availability 	= isset($properties['offer_availability']) ? $properties['offer_availability'] : get_post_meta( $post->ID , 'schema_properties_Event_offer_availability', true);
			$offer_validFrom 		= isset($properties['offer_validFrom']) ? $properties['offer_validFrom'] : get_post_meta( $post->ID , 'schema_properties_Event_offer_validFrom', true);
			$offer_url		 		= isset($properties['offer_url']) ? $properties['offer_url'] : get_post_meta( $post->ID , 'schema_properties_Event_offer_url', true);
			
			$schema['offers'] = array
			(
				'@type' 		=> 'Offer',
				'price'			=> $offer_price,
				'priceCurrency'	=> $offer_priceCurrency,
				'availability'	=> 'https://schema.org/' . $offer_availability,
				'validFrom'		=> $offer_validFrom,
				'url'			=> ('' != $offer_url) ? $offer_url : get_permalink( $post->ID )
			);
			
			// Address
			$venue_name			= isset($properties['venue_name'] ) ? $properties['venue_name'] : get_post_meta( $post->ID , 'schema_properties_Event_venue_name', true);
			$streetAddress		= isset($properties['streetAddress'] ) ? $properties['streetAddress'] : get_post_meta( $post->ID , 'schema_properties_Event_streetAddress', true);
			$streetAddress_2 	= isset($properties['streetAddress_2'] ) ? $properties['streetAddress_2'] : get_post_meta( $post->ID , 'schema_properties_Event_streetAddress_2', true);
			$streetAddress_3 	= isset($properties['streetAddress_3'] ) ? $properties['streetAddress_3'] :  get_post_meta( $post->ID , 'schema_properties_Event_streetAddress_3', true);
			$addressLocality	= isset($properties['addressLocality'] ) ? $properties['addressLocality'] : get_post_meta( $post->ID , 'schema_properties_Event_addressLocality', true);
			$addressRegion 		= isset($properties['addressRegion'] ) ? $properties['addressRegion'] : get_post_meta( $post->ID , 'schema_properties_Event_addressRegion', true);
			$postalCode 		= isset($properties['postalCode'] ) ? $properties['postalCode'] : get_post_meta( $post->ID , 'schema_properties_Event_postalCode', true);
			$addressCountry 	= isset($properties['addressCountry'] ) ? $properties['addressCountry'] : get_post_meta( $post->ID , 'schema_properties_Event_addressCountry', true);
			
			if ( isset($streetAddress) && $streetAddress != '' 
				|| isset($streetAddress_2) && $streetAddress_2 != '' 
				|| isset($streetAddress_3) && $streetAddress_3 != '' 
				|| isset($postalCode) && $postalCode != '' ) {
				
				// Set location markup
				$schema['location'] = array
				(
					'@type' => 'Place',
					'name'	=> $venue_name,
					'address'	=> array
					(
						'streetAddress' 	=> $streetAddress . ' ' . $streetAddress_2 . ' ' . $streetAddress_3, // join the 3 address lines
						'addressLocality' 	=> $addressLocality,
						'addressRegion' 	=> $addressRegion,
						'postalCode' 		=> $postalCode,
						'addressCountry' 	=> $addressCountry,
					)
				);
			}

			// Geo Location
			$latitude 	= isset($properties['geo_latitude'] ) ? $properties['geo_latitude'] : get_post_meta( $post->ID , 'schema_properties_Event_geo_latitude', true);
			$longitude 	= isset($properties['geo_longitude'] ) ? $properties['geo_longitude'] : get_post_meta( $post->ID , 'schema_properties_Event_geo_longitude', true);
			
			if ( isset($latitude) && $latitude != '' || isset($longitude) && $longitude != '' ) {
				$schema['location']['geo'] = array
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
			
			// Is Accessible For Free ?
			//
			if ( isset($schema['isAccessibleForFree']) ) {
				
				if ( $schema['isAccessibleForFree'] == 1 ) {
					// True
					$schema['isAccessibleForFree'] = 'True';
						
				} elseif ( $schema['isAccessibleForFree'] == 0 ) {
					// False
					$schema['isAccessibleForFree'] = 'False';
				}
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
			
			// Convert to timezone per Google guidelines
			// @source: https://developers.google.com/search/docs/data-types/event#date-time-best-guidelines
			//
			if (  isset($schema['startDate']) && $schema['startDate'] != '' )
				$schema['startDate'] = get_date_from_gmt( $schema['startDate'], 'Y-m-d H:i:sP' );
			
			if (  isset($schema['endDate']) && $schema['endDate'] != '' )
				$schema['endDate'] = get_date_from_gmt( $schema['endDate'], 'Y-m-d H:i:sP' );

			// Unset auto generated properties
			//
			unset($schema['performer_name']);
			unset($schema['organizer_name']);
			unset($schema['organizer_url']);
			unset($schema['offer_price']);
			unset($schema['offer_priceCurrency']);
			unset($schema['offer_availability']);
			unset($schema['offer_validFrom']);
			unset($schema['offer_url']);
			unset($schema['venue_name']);
			unset($schema['streetAddress']);
			unset($schema['addressLocality']);
			unset($schema['addressRegion']);
			unset($schema['postalCode']);
			unset($schema['addressCountry']);
			unset($schema['geo_latitude']);
			unset($schema['geo_longitude']);
			
			return apply_filters( 'schema_output_Event', $schema );
		}
	}
	
	new Schema_WP_Event();
	
endif;
