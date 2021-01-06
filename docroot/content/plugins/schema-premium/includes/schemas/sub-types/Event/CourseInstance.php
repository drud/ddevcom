<?php
/**
 * @package Schema Premium - Class Schema  CourseInstance
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_ CourseInstance') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_CourseInstance extends Schema_WP_Event {
		
		/** @var string Currenct Type */
    	protected $type = 'CourseInstance';
		
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
			
			return 'CourseInstance';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Course Instance', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('An instance of a Course which is distinct from other instances because it is offered at a different time or location or through different media or modes of study or to a specific section of students.', 'schema-premium');
		}

		/**
		* Get properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {

			$properties = array(

				'courseMode' => array(
					'label' 		=> __('Course Mode', 'schema-premium'),
					'rangeIncludes' => array('Text', 'URL'),
					'field_type' 	=> 'text',
					'markup_value' 	=> 'disabled',
					'instructions' 	=> __('The medium or means of delivery of the course instance or the mode of study.', 'schema-premium'),
				),
				'courseWorkload' => array(
					'label' 		=> __('Course Workload', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The amount of work expected of students taking the course, often provided as a figure per week or per month, and may be broken down by type.', 'schema-premium'),
				),
				'instructor' => array(
					'label' 		=> __('Instructor', 'schema-premium'),
					'rangeIncludes' => array('Person'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('A person assigned to instruct or provide instructional assistance for the Course Instance.', 'schema-premium'),
				)
			);

			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 40 );
			
			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

			return apply_filters( 'schema_properties_CourseInstance', $properties );	
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
			if( isset($properties['instructor'] ) ) { 
				$schema['instructor'] = array (
					'@type'	=> 'Person',
					'name'	=> $properties['instructor']
				);
			} else {
				$schema['instructor'] = schema_wp_get_publisher_array();
			}
			
			// Merge schema and properties arrays
			// Make sure $properties is an array before merging
			// 
			if ( is_array($properties) ) {

				// Unset auto generated properties
				unset($properties['instructor']);

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

			return apply_filters( 'schema_output_CourseInstance', $schema );
		}
	}
	
	//new Schema_WP_CourseInstance();
	
endif;
