<?php
/**
 * @package Schema Premium - Class Schema Real Estate Listing
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_RealEstateListing') ) :
	/**
	 * Schema AboutPage
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_RealEstateListing extends Schema_WP_WebPage {
		
		/** @var string Currenct Type */
    	protected $type = 'RealEstateListing';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'WebPage';

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
			
			return 'RealEstateListing';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Real Estate Listing', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A listing that describes one or more real-estate Offers (whose businessFunction is typically to lease out, or to sell).', 'schema-premium');
		}

		/**
		* Properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {
			
			$properties = array (
					
				'datePosted' => array(
					'label' 		=> __('Date Posted', 'schema-premium'),
					'rangeIncludes' => array('Date', 'DateTime'),
					'field_type' 	=> 'date_time_picker',
					'markup_value'  => 'post_date',
					'instructions' 	=> __('Publication date of an online listing..', 'schema-premium'),
					'display_format' => get_option( 'date_format' ), // WP
					'return_format' => 'Y-m-d',
				),
				// Lease Length
				'leaseLength' => array(
					'label' 		=> __('Lease Length', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'group',
					'layout'		=> 'block',
					'markup_value' => 'new_custom_field',
					'instructions' 	=> __('Length of the lease for some Accommodation, either particular to some Offer or in some cases intrinsic to the property.', 'schema-premium'),
					'sub_fields' 	=>  array(
						'years' => array(
							'label' 		=> __('Years', 'schema-premium'),
							'rangeIncludes' => array('Text'),
							'field_type' 	=> 'number',
							'markup_value' => 'new_custom_field',
							'instructions' 	=> '',
							'width' => '25'
						),
						'months' => array(
							'label' 		=> __('Months', 'schema-premium'),
							'rangeIncludes' => array('Text'),
							'field_type' 	=> 'number',
							'markup_value' => 'new_custom_field',
							'instructions' 	=> '',
							'width' => '25'
						),
						'days' => array(
							'label' 		=> __('Days', 'schema-premium'),
							'rangeIncludes' => array('Text'),
							'field_type' 	=> 'number',
							'markup_value' => 'new_custom_field',
							'instructions' 	=> '',
							'width' => '25'
						),
						'time' => array(
							'label' 		=> __('Hours / Minutes / Seconds', 'schema-premium'),
							'rangeIncludes' => array('Time'),
							'field_type' 	=> 'time_picker',
							'markup_value' => 'new_custom_field',
							'instructions' 	=> '',
							'display_format' => 'H:i:s',
							'return_format' => 'H:i:s',
							'width' => '25'
						)
					),
				),
			);
			
			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 30 );

			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

			return apply_filters( 'schema_properties_RealEstateListing', $properties );		
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
			
			$schema = array();
			
			// Get properties
			//
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			// Get main entity of page
			//
			$schema['mainEntityOfPage'] = array
			(
				'@type' => 'WebPage',
				'@id' => get_permalink( $post->ID )
			);
			
			// Get leaseLength
			//
			$years 	= get_post_meta( $post->ID , 'schema_properties_WebPage_leaseLength_years', true);
			$months = get_post_meta( $post->ID , 'schema_properties_WebPage_leaseLength_months', true);
			$days 	= get_post_meta( $post->ID , 'schema_properties_WebPage_leaseLength_days', true);
			$time 	= get_post_meta( $post->ID , 'schema_properties_WebPage_leaseLength_time', true);
			
			if ( isset($years) && $years != '' 
				|| isset($months) && $months != '' 
				|| isset($days) && $days != ''
				|| isset($time) && $time != '' && $time != '00:00:00' ) {
				
					$duration = array(
						'year' 	=> $years,
						'month' => $months, 
						'day' 	=> $days,
						'time' 	=> $time
					);
					
					$duration = schema_premium_format_date_time_to_PT( $duration );
					
				$schema['leaseLength'] = $duration;
			}

			// Merge parent schema 
			//
			$schema = array_merge( parent::schema_output($post->ID), $schema );

			// debug
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
			
			return apply_filters( 'schema_output_RealEstateListing', $schema );
		}
	}
	
	//new Schema_WP_RealEstateListing();
	
endif;
