<?php
/**
 * @package Schema Premium - Class Schema DeliveryEvent
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_DeliveryEvent') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_DeliveryEvent extends Schema_WP_Event {
		
		/** @var string Currenct Type */
    	protected $type = 'DeliveryEvent';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'Event';

		/**
	 	* Constructor
	 	*
	 	* @since 1.0.0
	 	*/
		public function __construct () {
		
			// emty __construct
		}
		
		/**
		* Get schema type 
		*
		* @since 1.2
		* @return string
		*/
		public function type() {
			
			return 'DeliveryEvent';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Delivery Event', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('An event involving the delivery of an item.', 'schema-premium');
		}

		/**
		* Get properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {

			$properties = array(

				'accessCode' => array(
					'label' 		=> __('Access Code', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' 	=> 'disabled',
					'instructions' 	=> __('Password, PIN, or access code needed for delivery (e.g. from a locker).', 'schema-premium'),
				),
				'availableFrom' => array(
					'label' 		 => __('Available From', 'schema-premium'),
					'rangeIncludes'  => array('Date', 'DateTime'),
					'field_type' 	 => 'date_time_picker',
					'markup_value'   => 'new_custom_field',
					'instructions' 	 => __('When the item is available for pickup from the store, locker, etc.', 'schema-premium'),
					'display_format' => get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), // WP
					'return_format'  => 'Y-m-d g:i a',
				),
				'availableThrough' => array(
					'label' 		 => __('Available Through', 'schema-premium'),
					'rangeIncludes'  => array('Date', 'DateTime'),
					'field_type' 	 => 'date_time_picker',
					'markup_value'   => 'new_custom_field',
					'instructions' 	 => __('After this date, the item will no longer be available for pickup.', 'schema-premium'),
					'display_format' => get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), // WP
					'return_format'  => 'Y-m-d g:i a',
				),
				'hasDeliveryMethod' => array(
					'label' 		=> __('Delivery Method', 'schema-premium'),
					'rangeIncludes' => array('DeliveryMethod'),
					'field_type' 	=> 'select',
					'choices' 		=> array
					(
						'' => '- ' . __('Select', 'schema-premium') . ' -',
						'DeliveryModeDirectDownload' 	=> __('Direct Download', 'schema-premium'),
						'DeliveryModeFreight' 			=> __('Freight', 'schema-premium'),
						'DeliveryModeMail' 				=> __('Mail', 'schema-premium'),
						'DeliveryModeOwnFleet' 			=> __('Own Fleet', 'schema-premium'),
						'DeliveryModePickUp' 			=> __('Pick Up', 'schema-premium'),
						'DHL' 							=> __('DHL', 'schema-premium'),
						'FederalExpress' 				=> __('Federal Express', 'schema-premium'),
						'UPS' 							=> __('UPS', 'schema-premium')
					),
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('Method used for delivery or shipping.', 'schema-premium'),
				)
			);

			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 40 );
			
			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

			return apply_filters( 'schema_properties_DeliveryEvent', $properties );	
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
		
			$schema['mainEntityOfPage'] = array
			(
				'@type' => 'WebPage',
				'@id' => get_permalink( $post->ID )
			);

			// Get properties
			//
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			// provider : Organization
			//
			if( isset($properties['hasDeliveryMethod']) ) { 
				$good_relation_url = 'http://purl.org/goodrelations/v1#';
				$properties['hasDeliveryMethod'] = $good_relation_url . $properties['hasDeliveryMethod'];
			}
			
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

			return apply_filters( 'schema_output_DeliveryEvent', $schema );
		}
	
	}
	
	//new Schema_WP_DeliveryEvent();
	
endif;
