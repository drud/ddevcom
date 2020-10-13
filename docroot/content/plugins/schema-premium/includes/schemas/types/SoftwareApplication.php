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
	class Schema_WP_SoftwareApplication {
		
		/** @var string Current Type */
    	protected $type = 'SoftwareApplication';
		
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
					'MobileApplication' 	=> __('Mobile Application', 'schema-premium'),
					/*'VideoGame' 			=> __('Video Game', 'schema-premium'),*/
					'WebApplication'		=> __('Web Application', 'schema-premium'),
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
					
					'url' => array(
						'label' 		=> __('URL', 'schema-premium'),
						'rangeIncludes' => array('URL'),
						'field_type' 	=> 'url',
						'markup_value' => 'post_permalink',
						'instructions' 	=> __('A URL to the software web page (that includes the Offer).', 'schema-premium'),
						'placeholder' 	=> 'https://'
					),
					'name' => array(
						'label' 		=> __('Name', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'post_title',
						'instructions' 	=> __('The name of the software.', 'schema-premium'),
						'required' 		=> true
					),
					'alternateName' => array(
						'label' 		=> __('Alternate Name', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('An alias for the software.', 'schema-premium'),
					),
					'operatingSystem' => array(
						'label' 		=> __('Operating System', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('Operating systems supported (Windows 7, OSX 10.6, Android 1.6)', 'schema-premium'),
					),
					'applicationCategory' => array(
						'label' 		=> __('Application Category', 'schema-premium'),
						'rangeIncludes'	=> array('Text'),
						'field_type' 	=> 'select',
						'choices'		=> array
							(
								''		=> '- ' . __('Select', 'schema-premium') . ' -',
								'GameApplication'				=> 'Game Application',
								'SocialNetworkingApplication' 	=> 'Social Networking Application',
								'TravelApplication' 			=> 'Travel Application',
								'ShoppingApplication' 			=> 'Shopping Application',
								'SportsApplication' 			=> 'Sports Application',
								'LifestyleApplication' 			=> 'Lifestyle Application',
								'BusinessApplication' 			=> 'Business Application',
								'DesignApplication' 			=> 'Design Application',
								'DeveloperApplication' 			=> 'Developer Application',
								'DriverApplication' 			=> 'Driver Application',
								'EducationalApplication' 		=> 'Educational Application',
								'HealthApplication' 			=> 'Health Application',
								'FinanceApplication' 			=> 'Finance Application',
								'SecurityApplication' 			=> 'Security Application',
								'BrowserApplication' 			=> 'Browser Application',
								'CommunicationApplication' 		=> 'Communication Application',
								'DesktopEnhancementApplication' => 'Desktop Enhancement Application',
								'EntertainmentApplication' 		=> 'Entertainment Application',
								'MultimediaApplication'			=> 'Multimedia Application',
								'HomeApplication' 				=> 'HomeApplication',
								'UtilitiesApplication' 			=> 'Utilities Application',
								'ReferenceApplication' 			=> 'Reference Application',
							),
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('The type of software application.', 'schema-premium'),
					),
					'softwareVersion' => array(
						'label' 		=> __('Software Version', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('Version of the software instance', 'schema-premium'),
					),
					'image' => array(
						'label' 		=> __('Image', 'schema-premium'),
						'rangeIncludes' => array('ImageObject', 'URL'),
						'field_type' 	=> 'image',
						'markup_value' => 'featured_image',
						'instructions' 	=> __('An image of the product.', 'schema-premium'),
						'required' 		=> true
					),
					'screenshot' => array(
						'label' 		=> __('Screenshot', 'schema-premium'),
						'rangeIncludes' => array('ImageObject', 'URL'),
						'field_type' 	=> 'image',
						'markup_value' => 'featured_image',
						'instructions' 	=> __('A link to a screenshot image of the app.', 'schema-premium'),
					),
					'description' => array(
						'label' 		=> __('Description', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'textarea',
						'markup_value' => 'post_excerpt',
						'instructions' 	=> __('Product description.', 'schema-premium'),
					),
					'releaseNotes' => array(
						'label' 		=> __('Release Notes', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'textarea',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('Description of what changed in this version.', 'schema-premium'),
					),
					'priceCurrency'		=> array(
						'label' 		=> __('Currency', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'currency_select',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('The currency of the price.', 'schema-premium'),
						//'required' 		=> true
					),
					'price' => array(
						'label' 		=> __('Price', 'schema-premium'),
						'rangeIncludes' => array('Text', 'Number'),
						'field_type' 	=> 'text',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('The offer price of a product.', 'schema-premium'),
						//'required' 		=> true
					),
					'priceValidUntil' => array(
						'label' 		=> __('Price Valid Until', 'schema-premium'),
						'rangeIncludes' => array('Date'),
						'field_type' 	=> 'date_picker',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('The date after which the price will no longer be available.', 'schema-premium'),
						'display_format' => get_option( 'date_format' ), // WP
						'return_format' => 'Y-m-d',
						//'required' 		=> true
					),
					'availability' => array(
						'label' 		=> __('Availability', 'schema-premium'),
						'rangeIncludes'	=> array('Text'),
						'field_type' 	=> 'select',
						'choices'		=> array
							(
								''		=> '- ' . __('Select', 'schema-premium') . ' -',
								'Discontinued'			=> 'Discontinued',
								'InStock' 				=> 'In Stock',
								'InStoreOnly' 			=> 'In Store Only',
								'LimitedAvailability' 	=> 'Limited Availability',
								'OnlineOnly' 			=> 'Online Only',
								'OutOfStock' 			=> 'Out Of Stock',
								'PreOrder' 				=> 'Pre-Order',
								'PreSale' 				=> 'Pre-Sale',
								'SoldOut' 				=> 'Sold Out',
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
								''		=> '- ' . __('Select', 'schema-premium') . ' -',
								'DamagedCondition'		=> 'Damaged Condition',
								'NewCondition' 			=> 'New Condition',
								'RefurbishedCondition' 	=> 'Refurbished Condition',
								'UsedCondition' 		=> 'Used Condition'
							),
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('Product condition.', 'schema-premium'),
					),
					'seller' => array(
						'label' 		=> __('Seller', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'site_title',
						'instructions' 	=> __('The name of organization offering the product.', 'schema-premium'),
					),
					'review' => array(
						'label' 		=> __('Review', 'schema-premium'),
						'rangeIncludes' => array('Number'),
						'field_type' 	=> 'star_rating',
						'markup_value' 	=> 'new_custom_field',
						'instructions' 	=> __('The rating given for this product.', 'schema-premium'),
						'max_stars' => 5,
						'return_type' => 0,
						'choices' => array(
							5 => '5',
							'4.5' => '4.5',
							4 => '4',
							'3.5' => '3.5',
							3 => '3',
							'2.5' => '2.5',
							2 => '2',
							'1.5' => '1.5',
							1 => '1',
							'0.5' => '0.5'
						),
						'other_choice' => 0,
						'save_other_choice' => 0,
						'default_value' => '',
						'layout' => 'horizontal'
					),
					'review_author' => array(
						'label' 		=> __('Review Author', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'author_name',
						'instructions' 	=> __('The author name of this product review.', 'schema-premium'),
					),
					'ratingValue' => array(
						'label' 		=> __('Rating Value', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('The aggregate rating for the product.', 'schema-premium'),
					),
					'reviewCount' => array(
						'label' 		=> __('Review Count', 'schema-premium'),
						'rangeIncludes' => array('Text'),
						'field_type' 	=> 'text',
						'markup_value' => 'new_custom_field',
						'instructions' 	=> __('The count of total number of reviews.', 'schema-premium'),
					),
				);
			
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
			$schema['@context'] 			=  'http://schema.org';
			$schema['@type'] 				=  $this->type;
		
			$schema['mainEntityOfPage'] 	= array
			(
				'@type' => 'WebPage',
				'@id' => get_permalink( $post->ID )
			);
	
			$schema['url'] 			= get_permalink( $post->ID );
			
			$schema['description']	= schema_wp_get_description( $post->ID );
		
			$schema['keywords']		= schema_wp_get_post_tags( $post->ID );
	
			$schema['image'] 		= schema_wp_get_media( $post->ID );
	
			// Get properties
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
				'seller'			=> array (
					'@type' 			=> 'Organization',
					'name'				=> isset($properties['seller']) ? $properties['seller'] : get_bloginfo( 'name' )
				)
			);
			
			// Review
			if ( isset($properties['review']) && $properties['review'] != 0 && $properties['review'] != '' ) {
				$schema['review'] 	= array
				(
					'@type' 		=> 'Review',
					'reviewRating'	=> array (
						'@type' 		=> 'Rating',
						'ratingValue' 	=> isset($properties['review']) ? $properties['review'] : '',
						'bestRating' 	=> 5
					)
				);		
				// review author
				if ( isset($properties['review_author']) ) {
					$schema['review']['author'] = array(
						'@type'	=> 'Person',
						'name' => $properties['review_author']
					);
				} else {
					$schema['review']['author'] = schema_wp_get_author_array();
				}
			}
			
			// Aggregate rating
			if ( isset($properties['reviewCount']) && $properties['reviewCount'] > 0 ) {
				$schema['aggregateRating'] 	= array
				(
					'@type' 		=> 'AggregateRating',
					'ratingValue' 	=> isset($properties['ratingValue']) ? $properties['ratingValue'] : '',
					'reviewCount' 	=> isset($properties['reviewCount']) ? $properties['reviewCount'] : '',
				);
			}
			
			// Unset auto generated properties
			unset($properties['priceCurrency']);
			unset($properties['price']);
			unset($properties['priceValidUntil']);
			unset($properties['availability']);
			unset($properties['itemCondition']);
			unset($properties['seller']);
			unset($properties['review']);
			unset($properties['review_author']);
			unset($properties['ratingValue']);
			unset($properties['reviewCount']);
			
			// Merge schema and properties arrays
			// Make sure $properties is an array before merging
			// 
			if ( is_array($properties) ) {
				$schema = array_merge($schema, $properties);
			}
			
			return $this->schema_output_filter($schema);
		}

		/**
		* Apply filters to markup output
		*
		* @since 1.1.2.8
		* @return array
		*/
		public function schema_output_filter( $schema ) {
			
			return apply_filters( 'schema_output_SoftwareApplication', $schema );
		}
	}
	
	new Schema_WP_SoftwareApplication();
	
endif;
