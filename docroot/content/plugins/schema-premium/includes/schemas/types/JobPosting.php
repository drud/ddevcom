<?php
/**
 * @package Schema Premium - Class Schema BlogPosting
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_JobPosting') ) :
	/**
	 * Schema BlogPosting
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_JobPosting {
		
		/** @var string Currenct Type */
    	protected $type = 'JobPosting';
		
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
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Job Posting', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A listing that describes a job opening in a certain organization.', 'schema-premium');
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
			
			return apply_filters( 'schema_wp_JobPosting', $schema );
		}
		
		/**
		* Get sub types
		*
		* @since 1.0.0
		* @return array
		*/
		public function subtypes() {
			
			$subtypes = array ();
				
			return apply_filters( 'schema_wp_subtypes_JobPosting', $subtypes );
		}
		
		/**
		* Get properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {
			
			$properties = array (
					/*
					'url' => array(
						'label' 		=> __('URL', 'schema-premium'),
						'rangeIncludes' => array('URL'),
						'field_type' 	=> 'url',
						'markup_value' => 'post_permalink',
						'instructions' 	=> __('URL of the job posting.', 'schema-premium'),
						'placeholder' 	=> 'https://'
					),*/
					'title' => array(
						'label' 		=> __('Job Title', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('The title of the job (not the title of the posting). For example, "Software Engineer" or "Barista".', 'schema-premium'),
						'required' 		=> true
					),
					'hiringOrganization' => array(
						'label' 		=> __('Hiring Organization', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'site_title',
						'instructions' 	=> __('The organization offering the job position.', 'schema-premium'),
						'required' 		=> true
					),
					'hiringOrganization_sameAs' => array(
						'label' 		=> __('Hiring Organization URL', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'url',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('URL of a reference Web page that unambiguously indicates the item\'s identity. E.g. the URL of the item\'s Wikipedia page, Wikidata entry, or official website.', 'schema-premium'),
						'required' 		=> true
					),
					'hiringOrganization_logo' => array(
						'label' 		=> __('Hiring Organization Logo', 'schema-premium'),
						'rangeIncludes' => array('ImageObject', 'URL'),
						'field_type' 	=> 'image',
						'markup_value' => 'new_custom_field',
						'return_format' => 'url',
						'instructions' 	=> __('Logo of the Hiring Organization.', 'schema-premium')
					),
					'industry' => array(
						'label' 		=> __('Industry', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('The industry associated with the job position.', 'schema-premium'),
					),
					'employmentType' => array(
						'label' 		=> __('Employment Type', 'schema-premium'),
						'rangeIncludes'	=> array('Text'),
						'field_type' 	=> 'select',
						'choices'		=> array(
													'FULL_TIME' => 'Full Time',
													'PART_TIME' => 'Part Time',
													'CONTRACTOR' => 'Contractor',
													'TEMPORARY' => 'Temporary',
													'INTERN' => 'Internship',
													'VOLUNTEER' => 'Volunteer',
													'PER_DIEM' => 'Per diem',
													'OTHER' => 'Other',
												),
						'multiple' 		=> true,
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('Type of employment.', 'schema-premium'),
						'ui' 			=> true,
						//'ajax' 			=> true,
					),
					'baseSalary' => array(
						'label' 		=> __('Base Salary', 'schema-premium'),
						'rangeIncludes' => array('MonetaryAmount'),
						'field_type' 	=> 'number',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('The actual base salary for the job, as provided by the employer (not an estimate).', 'schema-premium'),
						'required' 		=> true
					),
					'currency' => array(
						'label' 		=> __('Currency', 'schema-premium'),
						'rangeIncludes' => array('MonetaryAmount'),
						'field_type' 	=> 'currency_select',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('The currency used for the main salary information in this job posting.', 'schema-premium'),
					),
					'unitText' => array(
						'label' 		=> __('Salary Per Unit', 'schema-premium'),
						'rangeIncludes'	=> array('Text'),
						'field_type' 	=> 'select',
						'choices'		=> array
							(
								'HOUR' => 'Hour',
								'DAY' => 'Day',
								'WEEK' => 'Week',
								'MONTH' => 'Month',
								'YEAR' => 'Year',
							),
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('Salary per unit.', 'schema-premium'),
					),
					'datePosted' => array(
						'label' 		=> __('Date Posted', 'schema-premium'),
						'rangeIncludes' => array('Date'),
						'field_type' 	=> 'date_picker',
						'markup_value' => 'post_date',
						'instructions' 	=> __('Publication date for the job posting.', 'schema-premium'),
						'display_format' => get_option( 'date_format' ), // WP
						'return_format' => 'Y-m-d',
						'required' 		=> true
					),
					'validThrough' => array(
						'label' 		=> __('Valid Through', 'schema-premium'),
						'rangeIncludes'	=> array('DateTime'),
						'field_type' 	=> 'date_time_picker',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('The date after when the job posting is not valid.', 'schema-premium'),
						'display_format' => get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), // WP
                        'return_format' => 'Y-m-d g:i a',
					),
					'image' => array(
						'label' 		=> __('Image', 'schema-premium'),
						'rangeIncludes' => array('ImageObject', 'URL'),
						'field_type' 	=> 'image',
						'markup_value' => 'featured_image',
						'instructions' 	=> __('An image of the job posting.', 'schema-premium'),
					),
					'description' => array(
						'label' 		=> __('Description', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'textarea',
						'markup_value' => 'post_excerpt',
						'instructions' 	=> __('A description of the job.', 'schema-premium'),
					),
					
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
					
					'jobLocation_additionalProperty' => array(
						'label' 		=> __('Telecommuting', 'schema-premium'),
						'rangeIncludes' => array('Bool'),
						'field_type' 	=> 'true_false',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('For jobs in which the employee works remotely 100% of the time and therefore works from home.', 'schema-premium'),
						'ui' 			=> 1,
						'ui_on_text' 	=> __('Remotly', 'schema-premium'),
						'ui_off_text' 	=> __('In-Office', 'schema-premium')
					)
				);
			
			return apply_filters( 'schema_properties_JobPosting', $properties );	
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
			
			$schema			= array();
			
			// Putting all together
			//
			$schema['@context'] 		=  'http://schema.org';
			$schema['@type'] 			=  $this->type;
		
			$schema['mainEntityOfPage'] = array
			(
				'@type' => 'WebPage',
				'@id' => get_permalink( $post->ID )
			);
			
			// Get properties
			//
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			$hiringOrganization_logo_id	= isset($properties['hiringOrganization_logo']) ? $properties['hiringOrganization_logo'] : '';
			$image_attributes 			= ( '' != $hiringOrganization_logo_id ) ? wp_get_attachment_image_src( $hiringOrganization_logo_id ) : false;
			$hiringOrganization_logo 	= ( $image_attributes ) ? $image_attributes[0] : '';
			
			// Hiring Organization
			//
			$schema['hiringOrganization'] = array
			(
				'@type' 	=> 'Organization',
				'name' 		=> isset($properties['hiringOrganization']) ? $properties['hiringOrganization'] : get_bloginfo( 'name' ),
				'sameAs' 	=> isset($properties['hiringOrganization_sameAs']) ? $properties['hiringOrganization_sameAs'] : '',
				'logo' 		=> $hiringOrganization_logo,
			);
			
			// baseSalary
			//
			$schema['baseSalary'] = array
			(
				'@type' => 'MonetaryAmount',
				'currency' => isset($properties['currency']) ? $properties['currency'] : '',
				'value' => array
				(
					'@type' => 'QuantitativeValue',
					'value' => isset($properties['baseSalary']) ? $properties['baseSalary'] : '',
					'unitText' => isset($properties['unitText']) ? $properties['unitText'] : '',
				),
			);
			
			// jobLocation
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
				
				$schema['jobLocation'] = array
				(
					'@type' => 'Place',
					'address' => array
					(
						'@type' => 'PostalAddress',
						'streetAddress' 	=> $streetAddress . ' ' . $streetAddress_2 . ' ' . $streetAddress_3, // join the 3 address lines
						'addressLocality' 	=> $addressLocality,
						'addressRegion' 	=> $addressRegion,
						'postalCode' 		=> $postalCode,
						'addressCountry' 	=> $addressCountry,
					),
				);
			}
			
			// jobLocation : additionalProperty
			$additionalProperty = isset($properties['additionalProperty']) ? $properties['additionalProperty'] : '';
			
			if ( isset($additionalProperty) && $additionalProperty != '' ) {
				$schema['jobLocation']['additionalProperty'] = array
				(
					'@type' => 'PropertyValue',
					'value' => 'TELECOMMUTE'
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
			
			unset($properties['currency']);
			unset($properties['unitText']);
			unset($properties['baseSalary']);
			
			unset($properties['hiringOrganization_sameAs']);
			unset($properties['hiringOrganization_logo']);
			unset($properties['jobLocation_additionalProperty']);
			
			// Merge schema and properties arrays
			// Make sure $properties is an array before merging
			// 
			if ( is_array($properties) ) {
				$schema = array_merge($schema, $properties);
			}
			
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
			
			return apply_filters( 'schema_output_JobPosting', $schema );
		}
	}
	
	new Schema_WP_JobPosting();
	
endif;
