<?php
/**
 * @package Schema Premium - Class Schema SoftwareApplication
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_SoftwareApplication') ) :
	/**
	 * Class
	 *
	 * @since 1.0.2
	 */
	class Schema_WP_SoftwareApplication extends Schema_WP_CreativeWork {
		
		/** @var string Current Type */
    	protected $type = 'SoftwareApplication';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'CreativeWork';
		
		/**
	 	* Constructor
	 	*
	 	* @since 1.0.2
	 	*/
		public function __construct () {
			
			$this->init();
		}
	
		/**
		* Init
		*
		* @since 1.0.2
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
			
			return 'SoftwareApplication';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.2
		* @return array
		*/
		public function label() {
			
			return __('Software Application', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.2
		* @return array
		*/
		public function comment() {
			
			return __('A software application.', 'schema-premium');
		}
		
		/**
		* Extend schema types
		*
		* @since 1.0.2
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
		* @since 1.0.2
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
			
			return apply_filters( 'schema_wp_SoftwareApplication', $schema );
		}
		
		/**
		* Get sub types
		*
		* @since 1.0.2
		* @return array
		*/
		public function subtypes() {
		
			$subtypes = array
			(	
				'Software Application' => array
				(
					'MobileApplication' => __('Mobile Application', 'schema-premium'),
					'VideoGame' 		=> __('Video Game', 'schema-premium'),
					'WebApplication'	=> __('Web Application', 'schema-premium'),
				)			
        	);
				
			return apply_filters( 'schema_wp_subtypes_SoftwareApplication', $subtypes );
		}
		
		/**
		* Get properties
		*
		* @since 1.0.2
		* @return array
		*/
		public function properties() {
			
			$properties = array (
				
				'applicationCategory' => array(
					'label' 		=> __('Application Category', 'schema-premium'),
					'rangeIncludes'	=> array('Text', 'URL'),
					'field_type' 	=> 'select',
					'choices'		=> array
						(
							'' 								=> '- ' . __('Select', 'schema-premium') . ' -',
							'GameApplication'				=> __('Game Application', 'schema-premium'),
							'SocialNetworkingApplication' 	=>  __('Social Networking Application', 'schema-premium'),
							'TravelApplication' 			=>  __('Travel Application', 'schema-premium'),
							'ShoppingApplication' 			=>  __('Shopping Application', 'schema-premium'),
							'SportsApplication' 			=>  __('Sports Application', 'schema-premium'),
							'LifestyleApplication' 			=>  __('Lifestyle Application', 'schema-premium'),
							'BusinessApplication' 			=>  __('Business Application', 'schema-premium'),
							'DesignApplication' 			=>  __('Design Application', 'schema-premium'),
							'DeveloperApplication' 			=>  __('Developer Application', 'schema-premium'),
							'DriverApplication' 			=>  __('Driver Application', 'schema-premium'),
							'EducationalApplication' 		=>  __('Educational Application', 'schema-premium'),
							'HealthApplication' 			=>  __('Health Application', 'schema-premium'),
							'FinanceApplication' 			=>  __('Finance Application', 'schema-premium'),
							'SecurityApplication' 			=>  __('Security Application', 'schema-premium'),
							'BrowserApplication' 			=>  __('Browser Application', 'schema-premium'),
							'CommunicationApplication' 		=>  __('Communication Application', 'schema-premium'),
							'DesktopEnhancementApplication' =>  __('Desktop Enhancement Application', 'schema-premium'),
							'EntertainmentApplication' 		=>  __('Entertainment Application', 'schema-premium'),
							'MultimediaApplication'			=>  __('Multimedia Application', 'schema-premium'),
							'HomeApplication' 				=>  __('HomeApplication', 'schema-premium'),
							'UtilitiesApplication' 			=>  __('Utilities Application', 'schema-premium'),
							'ReferenceApplication' 			=>  __('Reference Application', 'schema-premium'),
						),
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('The type of software application.', 'schema-premium'),
				),
				'applicationSubCategory' => array(
					'label' 		=> __('Application Sub Category', 'schema-premium'),
					'rangeIncludes' => array('Text', 'URL'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('Subcategory of the application, e.g. Arcade Game.', 'schema-premium'),
				),
				'applicationSuite' => array(
					'label' 		=> __('Application Suite', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The name of the application suite to which the application belongs (e.g. Excel belongs to Office)', 'schema-premium'),
				),
				'availableOnDevice' => array(
					'label' 		=> __('Available On Device', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('Device required to run the application. Used in cases where a specific make/model is required to run the application.', 'schema-premium'),
				),
				// Countries
				'countriesNotSupported' => array(
					'label' 		=> __('Countries Not Supported', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'select',
					'choices'		=> schema_wp_get_countries(),
					'markup_value'  => 'disabled',
					'multiple' 		=> 1,
					'ui' 			=> 1,
					'instructions' 	=> __('Countries for which the application is not supported. You can also provide the two-letter ISO 3166-1 alpha-2 country code.', 'schema-premium'),
				),
				'countriesSupported' => array(
					'label' 		=> __('Countries Supported', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'select',
					'choices'		=> schema_wp_get_countries(),
					'markup_value'  => 'disabled',
					'multiple' 		=> 1,
					'ui' 			=> 1,
					'instructions' 	=> __('Countries for which the application is supported. You can also provide the two-letter ISO 3166-1 alpha-2 country code.', 'schema-premium'),
				),
				// URL 
				'downloadUrl' => array(
					'label' 		=> __('Download Url', 'schema-premium'),
					'rangeIncludes' => array('URL'),
					'field_type' 	=> 'url',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('If the file can be downloaded, URL to download the binary.', 'schema-premium'),
				),
				'installUrl' => array(
					'label' 		=> __('Install Url', 'schema-premium'),
					'rangeIncludes' => array('URL'),
					'field_type' 	=> 'url',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('URL at which the app may be installed, if different from the URL of the item.', 'schema-premium'),
				),
				'fileSize' => array(
					'label' 		=> __('File Size', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('Size of the application / package (e.g. 18MB). In the absence of a unit (MB, KB etc.), KB will be assumed.', 'schema-premium'),
				),
				'memoryRequirements' => array(
					'label' 		=> __('Memory Requirements', 'schema-premium'),
					'rangeIncludes' => array('Text', 'URL'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('Minimum memory requirements.', 'schema-premium'),
				),
				'operatingSystem' => array(
					'label' 		=> __('Operating System', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('Operating systems supported (Windows 7, OSX 10.6, Android 1.6).', 'schema-premium'),
				),
				'permissions' => array(
					'label' 		=> __('Permissions', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('Permission(s) required to run the app (for example, a mobile app may require full internet access or may run only on wifi).', 'schema-premium'),
				),
				'processorRequirements' => array(
					'label' 		=> __('Processor Requirements', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('Processor architecture required to run the application (e.g. IA64).', 'schema-premium'),
				),
				'releaseNotes' => array(
					'label' 		=> __('Release Notes', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'textarea',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('Description of what changed in this version.', 'schema-premium'),
				),
				'screenshot' => array(
					'label' 		=> __('Screenshot', 'schema-premium'),
					'rangeIncludes' => array('ImageObject', 'URL'),
					'field_type' 	=> 'image',
					'markup_value'  => 'featured_image',
					'instructions' 	=> __('A link to a screenshot image of the app.', 'schema-premium'),
				),
				'softwareRequirements' => array(
					'label' 		=> __('Software Requirements', 'schema-premium'),
					'rangeIncludes' => array('Text', 'URL'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('Component dependency requirements for application. This includes runtime environments and shared libraries that are not included in the application distribution package, but required to run the application (Examples: DirectX, Java or .NET runtime).', 'schema-premium'),
				),
				'softwareVersion' => array(
					'label' 		=> __('Software Version', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('Version of the software instance.', 'schema-premium'),
				),
				'storageRequirements' => array(
					'label' 		=> __('Software Requirements', 'schema-premium'),
					'rangeIncludes' => array('Text', 'URL'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('Storage requirements (free space required).', 'schema-premium'),
				),
				// offers
				'priceCurrency'		=> array(
					'label' 		=> __('Currency', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'currency_select',
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('The currency of the price.', 'schema-premium'),
					//'required' 		=> true
				),
				'price' => array(
					'label' 		=> __('Price', 'schema-premium'),
					'rangeIncludes' => array('Text', 'Number'),
					'field_type' 	=> 'text',
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('The offer price of a product.', 'schema-premium'),
					//'required' 		=> true
				),
				'priceValidUntil' => array(
					'label' 		 => __('Price Valid Until', 'schema-premium'),
					'rangeIncludes'  => array('Date'),
					'field_type' 	 => 'date_picker',
					'markup_value'   => 'new_custom_field',
					'instructions' 	 => __('The date after which the price will no longer be available.', 'schema-premium'),
					'display_format' => get_option( 'date_format' ), // WP
					'return_format'  => 'Y-m-d',
					//'required' 		=> true
				),
				'availability' => array(
					'label' 		=> __('Availability', 'schema-premium'),
					'rangeIncludes'	=> array('Text'),
					'field_type' 	=> 'select',
					'choices'		=> array
						(
							''						=> '- ' . __('Select', 'schema-premium') . ' -',
							'Discontinued'			=> __('Discontinued', 'schema-premium'),
							'InStock' 				=> __('In Stock', 'schema-premium'),
							'InStoreOnly' 			=> __('In Store Only', 'schema-premium'),
							'LimitedAvailability' 	=> __('Limited Availability', 'schema-premium'),
							'OnlineOnly' 			=> __('Online Only', 'schema-premium'),
							'OutOfStock' 			=> __('Out Of Stock', 'schema-premium'),
							'PreOrder' 				=> __('Pre-Order', 'schema-premium'),
							'PreSale' 				=> __('Pre-Sale', 'schema-premium'),
							'SoldOut' 				=> __('Sold Out', 'schema-premium'),
						),
					'markup_value' => 'new_custom_field',
					'instructions' 	=> __('Product availability.', 'schema-premium'),
				),
				'itemCondition' => array(
					'label' 		=> __('Condition', 'schema-premium'),
					'rangeIncludes'	=> array('OfferItemCondition ', 'Text'),
					'field_type' 	=> 'select',
					'choices'		=> array
						(
							''						=> '- ' . __('Select', 'schema-premium') . ' -',
							'DamagedCondition'		=> __('Damaged Condition', 'schema-premium'),
							'NewCondition' 			=> __('New Condition', 'schema-premium'),
							'RefurbishedCondition' 	=> __('Refurbished Condition', 'schema-premium'),
							'UsedCondition' 		=> __('Used Condition', 'schema-premium')
						),
					'markup_value' => 'new_custom_field',
					'instructions' 	=> __('Product condition.', 'schema-premium'),
				), // end of offers
			);
			
			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 30 );

			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

			return apply_filters( 'schema_properties_SoftwareApplication', $properties );	
		}
		
		/**
		* Schema output
		*
		* @since 1.0.2
		* @return array
		*/
		public function schema_output( $post_id = null ) {
			
			global $product;
			
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
			
			// Offers
			$schema['offers'] 	= array
			(
				'@type' 			=> 'Offer',
				'url'				=> get_permalink( $post->ID ),
				'priceCurrency'		=> isset($properties['priceCurrency']) ? $properties['priceCurrency'] : '',
				'price' 			=> isset($properties['price']) ? $properties['price'] : '',
				'priceValidUntil' 	=> isset($properties['priceValidUntil']) ? $properties['priceValidUntil'] : '',
				'availability' 		=> isset($properties['availability']) ? $properties['availability'] : '',
				'itemCondition'		=> isset($properties['itemCondition']) ? $properties['itemCondition'] : '',
			);
			
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
		* @since 1.1.2.8
		* @return array
		*/
		public function schema_output_filter( $schema ) {
			
			// Unset auto generated properties
			//
			unset($schema['priceCurrency']);
			unset($schema['price']);
			unset($schema['priceValidUntil']);
			unset($schema['availability']);
			unset($schema['itemCondition']);

			unset($schema['review']);
			unset($schema['ratingValue']);
			unset($schema['reviewCount']);

			return apply_filters( 'schema_output_SoftwareApplication', $schema );
		}
	}
	
	new Schema_WP_SoftwareApplication();
	
endif;
