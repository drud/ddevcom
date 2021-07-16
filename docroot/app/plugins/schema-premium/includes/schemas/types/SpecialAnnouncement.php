<?php
/**
 * @package Schema Premium - Class Schema Special Announcement
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_SpecialAnnouncement') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_SpecialAnnouncement extends Schema_WP_CreativeWork {
		
		/** @var string Current Type */
    	protected $type = 'SpecialAnnouncement';
		
		/** @var string Current Parent Type */
    	protected $parent_type = 'CreativeWork';
		
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
			
			return 'SpecialAnnouncement';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Special Announcement', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A SpecialAnnouncement combines a simple date-stamped textual information update with contextualized Web links and other structured data. It represents an information update made by a locally-oriented organization, for example schools, pharmacies, healthcare providers, community groups, police, local government.', 'schema-premium');
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
			
			return apply_filters( 'schema_wp_SpecialAnnouncement', $schema );
		}
		
		/**
		* Get sub types
		*
		* @since 1.0.0
		* @return array
		*/
		public function subtypes() {
			
			return apply_filters( 'schema_wp_subtypes_SpecialAnnouncement', array() );
		}
		
		/**
		* Get properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {
			
			$properties = array(
				
				'name' => array(
					'label' 		=> __('Name', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' => 'post_title',
					'instructions' 	=> __('The short title of the COVID-19 announcement. For example: "Stanford announces COVID-19 testing facility".', 'schema-premium'),
					'required' 		=> true
				),
				'datePosted' => array(
					'label'			=> __('Date Posted', 'schema-premium'),
					'rangeIncludes' => array('Date', 'DateTime'),
					'field_type' 	=> 'date_time_picker',
					'markup_value' 	=> 'post_date',
					'instructions' 	=> __('The date that the COVID-19 announcement was published.', 'schema-premium'),
					'display_format' => get_option( 'date_format' ), // WP
					'return_format' => 'Y-m-d',
					'required' 		=> true
				),
				'expires' => array(
					'label'			=> __('Expires', 'schema-premium'),
					'rangeIncludes' => array('Date', 'DateTime'),
					'field_type' 	=> 'date_time_picker',
					'markup_value' 	=> 'new_custom_field',
					'instructions' 	=> __('The date in which the content expires and is no longer useful or available. Disable this property if you do not know when the content will expire.', 'schema-premium'),
					'display_format' => get_option( 'date_format' ), // WP
					'return_format' => 'Y-m-d'
				),
				'category' => array(
					'label' 		=> __('Category', 'schema-premium'),
					'rangeIncludes' => array('URL'),
					'field_type' 	=> 'url',
					'markup_value' 	=> 'new_custom_field',
					'instructions' 	=> __('The URL that describes the category for the special announcement. Set the category to the Wikipedia page for COVID-19: <small>https://www.wikidata.org/wiki/Q81068910</small>', 'schema-premium'),
					'default_value' => '',
					'placeholder' => 'https://',
				),
				'quarantineGuidelines' => array(
					'label' 		=> __('Quarantine Guidelines', 'schema-premium'),
					'rangeIncludes' => array('URL', 'WebContent'),
					'field_type' 	=> 'url',
					'markup_value' 	=> 'new_custom_field',
					'instructions' 	=> __('Guidelines about quarantine rules in the context of COVID-19, if applicable to the announcement.', 'schema-premium'),
					'default_value' => '',
					'placeholder' => 'https://',
				),
				'diseasePreventionInfo' => array(
					'label' 		=> __('Disease PreventionInfo', 'schema-premium'),
					'rangeIncludes' => array('URL', 'WebContent', 'Dataset', 'Observation'),
					'field_type' 	=> 'url',
					'markup_value' 	=> 'new_custom_field',
					'instructions' 	=> __('If applicable to the announcement, the statistical information about the spread of a disease. When a WebContent URL is provided, the page indicated might also contain more markup.', 'schema-premium'),
					'default_value' => '',
					'placeholder' => 'https://',
				),
				'text' => array(
					'label' 		=> __('Text', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'textarea',
					'markup_value' 	=> 'post_content',
					'instructions' 	=> __('The textual summary of the COVID-19 announcement.', 'schema-premium'),
				),
				'spatialCoverage' => array(
					'label' 		=> __('Spatial Coverage', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'repeater',
					'layout'		=> 'block',
					'markup_value' 	=> 'new_custom_field',
					'button_label' 	=> __('Add Geographic Region', 'schema-premium'),
					'instructions' 	=> __('The geographic region that is the focus of the special announcement, if applicable.', 'schema-premium'),
					'sub_fields' 	=>  array(
						'AdministrativeArea_name' => array(
							'label' 		=> '',
							'rangeIncludes' => array('Text'),
							'field_type' 	=> 'text',
							'markup_value' => 'new_custom_field',
							'instructions' 	=> '',
							'placeholder' => __('The geographic region that is the focus of the special announcement', 'schema-premium'),
						),
					), // end sub fields
				)
			);

			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 30 );

			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

			return apply_filters( 'schema_properties_SpecialAnnouncement', $properties );	
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
			
			// Putting all together
			//
			$schema['@context'] =  'https://schema.org';
			$schema['@type'] 	=  $this->type;
		
			// Get main entity of page
			//
			$schema['mainEntityOfPage'] = array
			(
				'@type' => 'WebPage',
				'@id' => get_permalink( $post->ID ) . '#webpage'
			);
			
			// Get properties
			//
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			// debug
			//echo '<pre>'; print_r($properties); echo '</pre>';
	
			$schema['url'] 				= isset($properties['url'] ) ? $properties['url'] : get_permalink( $post->ID );
			$schema['headline'] 		= isset($properties['headline'] ) ? $properties['headline'] : '';
			$schema['description'] 		= isset($properties['description'] ) ? $properties['description'] : schema_wp_get_description( $post->ID );
			$schema['image'] 			= isset($properties['image']) ? $properties['image'] : schema_wp_get_media( $post->ID );
			
			$schema['datePublished']	= isset($properties['datePublished'] ) ? $properties['datePublished'] : get_the_date( 'c', $post->ID );
			$schema['dateModified']		= isset($properties['dateModified'] ) ? $properties['dateModified'] : get_post_modified_time( 'c', false, $post->ID, false );
			
			$schema['datePosted']		= isset($properties['datePosted'] ) ? $properties['datePosted'] : get_the_date( 'c', $post->ID );

			if ( isset($properties['expires']) ) {
				$schema['expires'] = $properties['expires'];
			}
			
			// Statick !
			//
			// The URL that describes the category for the special announcement. 
			// Set the category to the Wikipedia page for COVID-19: https://www.wikidata.org/wiki/Q81068910
			//
			$schema['category'] = isset($properties['category'] ) ? $properties['category'] : 'https://www.wikidata.org/wiki/Q81068910';
			
			if ( isset($properties['quarantineGuidelines']) ) {
				$schema['quarantineGuidelines'] = $properties['quarantineGuidelines'];
			}

			if ( isset($properties['diseasePreventionInfo']) ) {
				$schema['diseasePreventionInfo'] = $properties['diseasePreventionInfo'];
			}
			
			// Get Spatial Coverage
			//
			$schema['SpatialCoverage'] = $this->get_spatial_coverage();
			
			// Unset auto generated properties
			//
			
			// Merge schema and properties arrays
			// Make sure $properties is an array before merging
			// 
			if ( is_array($properties) ) {
				$schema = array_merge($schema, $properties);
			}
			
			// Merge parent schema 
			//
			$schema = array_merge( parent::schema_output($post->ID), $schema );

			return $this->schema_output_filter($schema);
		}
		
		/**
		* Apply filters to markup output
		*
		* @since 1.1.2
		* @return array
		*/
		public function schema_output_filter( $schema ) {
			
			return apply_filters( 'schema_output_SpecialAnnouncement', $schema );
		}

		/**
		* Get SpatialCoverage
		*
		* @since 1.0.0
		* @return array
		*/
		public function get_spatial_coverage() {
	
			$output = array();
	
			$count = get_post_meta( get_the_ID(), 'schema_properties_SpecialAnnouncement_spatialCoverage', true );
	
			if ( isset( $count ) && $count >= 0 ) {
		 
				for( $i=0; $i < $count; $i++ ) {
					$name 	= get_post_meta( get_the_ID(), 'schema_properties_SpecialAnnouncement_spatialCoverage_' . $i . '_AdministrativeArea_name', true );

					$output[] = array
					(
						'@type' => 'AdministrativeArea',
						'name' 	=> strip_tags($name)
					);
				}
		
			}
	
			return $output;
		}

	}
	
	new Schema_WP_SpecialAnnouncement();
	
endif;
