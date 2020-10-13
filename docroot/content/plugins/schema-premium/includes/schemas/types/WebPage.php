<?php
/**
 * @package Schema Premium - Class Schema Web Page
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_WebPage') ) :
	/**
	 * Schema WebPage
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_WebPage {
		
		/** @var string Currenct Type */
    	protected $type = 'WebPage';
		
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
			
			return __('Web Page', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A web page.', 'schema-premium');
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
			
			return apply_filters( 'schema_wp_WebPage', $schema );
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
            	'AboutPage' 		=> __('About Page', 'schema-premium'),
				'CheckoutPage' 		=> __('Checkout Page', 'schema-premium'),
				//'CollectionPage'	=> __('Collection Page', 'schema-premium'),
				//'ContactPage' 		=> __('Contact Page', 'schema-premium'),
				//'FAQPage' 			=> __('FAQ Page', 'schema-premium'),
				//'ItemPage' 			=> __('Item Page', 'schema-premium'),
				'MedicalWebPage' 	=> __('Medical Web Page', 'schema-premium'),
				'ProfilePage' 		=> __('Profile Page', 'schema-premium'),
				'QAPage' 			=> __('Q&A Page', 'schema-premium'),
				//'RealEstateListing' => __('Real Estate Listing', 'schema-premium'),
				//'SearchResultsPage' => __('Search Results Page', 'schema-premium'),				
        	);
				
			return apply_filters( 'schema_wp_subtypes_WebPage', $subtypes );
		}
		
		/**
		* Get properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {
			
			$properties = array (
					
					'url' => array(
						'label' 		=> __('URL', 'schema-premium'),
						'rangeIncludes' => array('URL'),
						'field_type' 	=> 'url',
						'markup_value' => 'post_permalink',
						'instructions' 	=> __('URL of the web page.', 'schema-premium'),
						'placeholder' 	=> 'https://'
					),
					'headline' => array(
						'label' 		=> __('Headline', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'post_title',
						'instructions' 	=> __('Headline of the web page', 'schema-premium'),
						'required' 		=> true
					),
					'alternativeHeadline' => array(
						'label' 		=> __('Alternative Headline', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'disabled',
						'instructions' 	=> __('Secondary title for this web page.', 'schema-premium')
					),
					'image' => array(
						'label' 		=> __('Image', 'schema-premium'),
						'rangeIncludes' => array('ImageObject', 'URL'),
						'field_type' 	=> 'image',
						'markup_value' => 'featured_image',
						'instructions' 	=> __('An image of the web page.', 'schema-premium'),
						'required' 		=> true
					),
					'datePublished' => array(
						'label'			=> __('Published Date', 'schema-premium'),
						'rangeIncludes' => array('Date', 'DateTime'),
						'field_type' 	=> 'date_time_picker',
						'markup_value' => 'post_date',
						'instructions' 	=> __('Date of first publication of the web page.', 'schema-premium'),
						'display_format' => get_option( 'date_format' ), // WP
						'return_format' => 'Y-m-d',
						'required' 		=> true
					),
					'dateModified' => array(
						'label' 		=> __('Modified Date', 'schema-premium'),
						'rangeIncludes' => array('Date', 'DateTime'),
						'field_type' 	=> 'date_time_picker',
						'markup_value' => 'post_modified',
						'instructions' 	=> __('The date on which the web page was most recently modified', 'schema-premium'),
						'display_format' => get_option( 'date_format' ), // WP
						'return_format' => 'Y-m-d',
					),
					'lastReviewed' => array(
						'label' 		=> __('Last Reviewed Date', 'schema-premium'),
						'rangeIncludes' => array('Date'),
						'field_type' 	=> 'date_time_picker',
						'markup_value' => 'post_modified',
						'instructions' 	=> __('Date on which the content on this web page was last reviewed for accuracy and/or completeness.', 'schema-premium'),
						'display_format' => get_option( 'date_format' ), // WP
						'return_format' => 'Y-m-d',
					),
					'reviewedBy' => array(
						'label' 		=> __('Reviewed By Person', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'author_name',
						'instructions' 	=> __('Person that have reviewed the content on this web page for accuracy and/or completeness.', 'schema-premium'),
					),
					'author' => array(
						'label' 		=> __('Author Name', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'author_name',
						'instructions' 	=> __('The author name of this web page.', 'schema-premium'),
						'required' 		=> true
					),
					'description' => array(
						'label' 		=> __('Description', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'textarea',
						'markup_value' => 'post_excerpt',
						'instructions' 	=> __('A description of the web page.', 'schema-premium'),
					)
				);
			
			return apply_filters( 'schema_properties_WebPage', $properties );	
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
			$schema['@context'] 		=  'http://schema.org';
			$schema['@type'] 			=  $this->type;
		
			$schema['mainEntityOfPage'] = array
			(
				'@type' => 'WebPage',
				'@id' => get_permalink( $post->ID )
			);
			
			// Get properties
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			$schema['url'] 				= isset($properties['url'] ) ? $properties['url'] : get_permalink( $post->ID );
			$schema['headline'] 		= isset($properties['headline'] ) ? $properties['headline'] : '';
			$schema['description'] 		= isset($properties['description'] ) ? $properties['description'] : schema_wp_get_description( $post->ID );
			$schema['image'] 			= isset($properties['image']) ? $properties['image'] : schema_wp_get_media( $post->ID );
			
			$schema['datePublished']	= isset($properties['datePublished'] ) ? $properties['datePublished'] : get_the_date( 'c', $post->ID );
			$schema['dateModified']		= isset($properties['dateModified'] ) ? $properties['dateModified'] : get_post_modified_time( 'c', false, $post->ID, false );
			$schema['lastReviewed']		= isset($properties['lastReviewed'] ) ? $properties['lastReviewed'] : get_post_modified_time( 'c', false, $post->ID, false );
			
			if( isset($properties['reviewedBy'] ) ) { 
				$schema['reviewedBy'] = array (
					'@type'	=> 'Person',
					'name'	=> $properties['reviewedBy']
				);
			}else {
				$schema['reviewedBy'] = schema_wp_get_author_array( $post->ID );
			}
			
			if( isset($properties['author'] ) ) { 
				$schema['author'] = array (
					'@type'	=> 'Person',
					'name'	=> $properties['author']
				);
			} else {
				$schema['author'] = schema_wp_get_author_array( $post->ID );
			}
			
			$schema['publisher']	= schema_wp_get_publisher_array();
			
			$schema['keywords']		= schema_wp_get_post_tags( $post->ID );
			
			// Unset auto generated properties
			unset($properties['author']);
			unset($properties['reviewedBy']);			
			
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
			
			return apply_filters( 'schema_output_WebPage', $schema );
		}

	}
	
	new Schema_WP_WebPage();
	
endif;
