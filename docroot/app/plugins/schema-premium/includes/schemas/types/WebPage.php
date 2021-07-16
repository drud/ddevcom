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
	class Schema_WP_WebPage extends Schema_WP_CreativeWork {
		
		/** @var string Currenct Type */
    	protected $type = 'WebPage';
		
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
			
			return 'WebPage';
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
				'RealEstateListing' => __('Real Estate Listing', 'schema-premium'),
				//'SearchResultsPage' => __('Search Results Page', 'schema-premium'),				
        	);
				
			return apply_filters( 'schema_wp_subtypes_WebPage', $subtypes );
		}
		
		/**
		* Properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {
			
			$properties = array (
					
				'primaryImageOfPage' => array(
					'label' 		=> __('Primary Image Of Page', 'schema-premium'),
					'rangeIncludes' => array('ImageObject'),
					'field_type' 	=> 'image',
					'markup_value'  => 'featured_image',
					'instructions' 	=> __('Indicates the main image on the page.', 'schema-premium'),
					'required' 		=> true
				),
				'lastReviewed' => array(
					'label' 		=> __('Last Reviewed Date', 'schema-premium'),
					'rangeIncludes' => array('Date'),
					'field_type' 	=> 'date_time_picker',
					'markup_value'  => 'post_modified',
					'instructions' 	=> __('Date on which the content on this web page was last reviewed for accuracy and/or completeness.', 'schema-premium'),
					'display_format' => get_option( 'date_format' ), // WP
					'return_format' => 'Y-m-d',
				),
				'reviewedBy' => array(
					'label' 		=> __('Reviewed By Person', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'author_name',
					'instructions' 	=> __('Person that have reviewed the content on this web page for accuracy and/or completeness.', 'schema-premium'),
				)
			);
			
			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 30 );

			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

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
			
			// Get properties
			//
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			// Get main entity of page
			//
			$schema['mainEntityOfPage'] = array
			(
				'@type' => 'WebPage',
				'@id' => get_permalink( $post->ID ) . '#webpage'
			);
			
			$schema['primaryImageOfPage']	= isset($properties['primaryImageOfPage']) ? $properties['primaryImageOfPage'] : schema_wp_get_media( $post->ID );
			$schema['lastReviewed']		= isset($properties['lastReviewed'] ) ? $properties['lastReviewed'] : get_post_modified_time( 'c', false, $post->ID, false );
			
			if( isset($properties['reviewedBy'] ) ) { 
				$schema['reviewedBy'] = array (
					'@type'	=> 'Person',
					'name'	=> $properties['reviewedBy']
				);
			} else {
				$schema['reviewedBy'] = schema_wp_get_author_array( $post->ID );
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
			
			return apply_filters( 'schema_output_WebPage', $schema );
		}
	}
	
	new Schema_WP_WebPage();
	
endif;
