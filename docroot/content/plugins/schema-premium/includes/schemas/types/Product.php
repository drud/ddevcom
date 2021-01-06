<?php
/**
 * @package Schema Premium - Class Schema Product
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Product') ) :
	/**
	 * Class
	 *
	 * @since 1.0.1
	 */
	class Schema_WP_Product extends Schema_WP_Thing {
		
		/** @var string Current Type */
		protected $type = 'Product';
		
		/** @var string Current Parent Type */
    	protected $parent_type = 'Thing';
		
		/**
	 	* Constructor
	 	*
	 	* @since 1.0.1
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
			
			return 'Product';
		}

		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Product', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('Add markup to your product pages so Google can provide detailed product information in rich Search results.', 'schema-premium');
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
			
			return apply_filters( 'schema_wp_Product', $schema );
		}
		
		/**
		* Get sub types
		*
		* @since 1.0.0
		* @return array
		*/
		public function subtypes() {
			
			// This is not used yet!
			// @TODO release these when types are completed
			$subtypes = array
			(	
				/*
				'IndividualProduct'	=> __('Individual Product', 'schema-premium'),
				'ProductCollection'	=> __('Product Collection', 'schema-premium'),
				'ProductGroup'		=> __('Product Group', 'schema-premium'),
				'ProductModel' 		=> __('Product Model', 'schema-premium'),
				'SomeProducts' 		=> __('Some Products', 'schema-premium'),
				'Vehicle' 			=> __('Vehicle', 'schema-premium'),
				*/
			);
				
			return apply_filters( 'schema_wp_subtypes_Product', $subtypes );
		}
		
		/**
		* Get properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {
			
			$properties = array (
				
				'award' => array(
					'label' 		=> __('Award', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('An award won by or for this item.', 'schema-premium'),
				),
				'brand' => array(
					'label' 		=> __('Brand', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('The brand of the product.', 'schema-premium'),
				),
				'slogan' => array(
					'label' 		=> __('Slogan', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('A slogan or motto associated with the item.', 'schema-premium'),
				),
				'color' => array(
					'label' 		=> __('Color', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The color of the product.', 'schema-premium'),
				),
				'sku' => array(
					'label' 		=> __('SKU', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' => 'new_custom_field',
					'instructions' 	=> __('The Stock Keeping Unit (SKU).', 'schema-premium'),
				),
				'gtin8' => array(
					'label' 		=> __('GTIN-8', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The GTIN-8 code of the product, or the product to which the offer refers.', 'schema-premium'),
				),
				'gtin12' => array(
					'label' 		=> __('GTIN-12', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The GTIN-12 code of the product, or the product to which the offer refers.', 'schema-premium'),
				),
				'gtin13' => array(
					'label' 		=> __('GTIN-13', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The GTIN-13 code of the product, or the product to which the offer refers.', 'schema-premium'),
				),
				'gtin14' => array(
					'label' 		=> __('GTIN-14', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The GTIN-14 code of the product, or the product to which the offer refers.', 'schema-premium'),
				),
				'mpn' => array(
					'label' 		=> __('MPN', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The Manufacturer Part Number (MPN) of the product, or the product to which the offer refers.', 'schema-premium'),
				),
				'priceCurrency'		=> array(
					'label' 		=> __('Currency', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'currency_select',
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('The currency of the price.', 'schema-premium'),
					'required' 		=> true
				),
				'price' => array(
					'label' 		=> __('Price', 'schema-premium'),
					'rangeIncludes' => array('Text', 'Number'),
					'field_type' 	=> 'text',
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('The offer price of a product.', 'schema-premium'),
					'required' 		=> true
				),
				'lowPrice' => array(
					'label' 		=> __('Low Price', 'schema-premium'),
					'rangeIncludes' => array('Text', 'Number'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The lowest price of all offers available. (use this if you have aggregate offers within a product)', 'schema-premium'),
					//'required' 		=> true
				),
				'highPrice' => array(
					'label' 		=> __('High Price', 'schema-premium'),
					'rangeIncludes' => array('Text', 'Number'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The highest price of all offers available. (use this if you have aggregate offers within a product)', 'schema-premium'),
					//'required' 		=> true
				),
				'offerCount' => array(
					'label' 		=> __('Offer Count', 'schema-premium'),
					'rangeIncludes' => array('Text', 'Number'),
					'field_type' 	=> 'number',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('The number of offers for the product. (use this if you have aggregate offers within a product)', 'schema-premium'),
				),
				'offerUrl' => array(
					'label' 		=> __('Offer URL', 'schema-premium'),
					'rangeIncludes' => array('URL'),
					'field_type' 	=> 'url',
					'markup_value'  => 'post_permalink',
					'instructions' 	=> __('URL of the the offer.', 'schema-premium'),
					'placeholder' 	=> 'https://'
				),
				'priceValidUntil' => array(
					'label' 		=> __('Price Valid Until', 'schema-premium'),
					'rangeIncludes' => array('Date'),
					'field_type' 	=> 'date_picker',
					'markup_value' => 'new_custom_field',
					'instructions' 	=> __('The date after which the price will no longer be available.', 'schema-premium'),
					'display_format' => get_option( 'date_format' ), // WP
					'return_format' => 'Y-m-d',
					'required' 		=> true
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
					'required' 		=> true
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
					'markup_value'  => 'new_custom_field',
					'instructions' 	=> __('Product condition.', 'schema-premium'),
				),
				'seller' => array(
					'label' 		=> __('Seller', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'site_title',
					'instructions' 	=> __('The name of organization offering the product.', 'schema-premium'),
				),
				'productionDate' => array(
					'label' 		 => __('Production Date', 'schema-premium'),
					'rangeIncludes'  => array('Date'),
					'field_type' 	 => 'date_picker',
					'markup_value'   => 'disabled',
					'instructions' 	 => __('The date of production of the item, e.g. vehicle.', 'schema-premium'),
					'display_format' => get_option( 'date_format' ), // WP
					'return_format'  => 'Y-m-d'
				),
				'purchaseDate' => array(
					'label' 		 => __('Purchase Date', 'schema-premium'),
					'rangeIncludes'  => array('Date'),
					'field_type' 	 => 'date_picker',
					'markup_value'   => 'disabled',
					'instructions' 	 => __('The date the item e.g. vehicle was purchased by the current owner.', 'schema-premium'),
					'display_format' => get_option( 'date_format' ), // WP
					'return_format'  => 'Y-m-d'
				),
				'releaseDate' => array(
					'label' 		 => __('Release Date', 'schema-premium'),
					'rangeIncludes'  => array('Date'),
					'field_type' 	 => 'date_picker',
					'markup_value'   => 'disabled',
					'instructions' 	 => __('The release date of a product or product model. This can be used to distinguish the exact variant of a product.', 'schema-premium'),
					'display_format' => get_option( 'date_format' ), // WP
					'return_format'  => 'Y-m-d'
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
					'conditional_logic' => array(
						array(
							array(
								'field' => 'properties_ratingValue',
								'operator' => '==',
								'value' => 'fixed_rating_field',
							),
						),
						array(
							array(
								'field' => 'properties_ratingValue',
								'operator' => '==',
								'value' => 'new_custom_field',
							),
						),
						array(
							array(
								'field' => 'properties_ratingValue',
								'operator' => '==',
								'value' => 'existing_custom_field',
							),
						),
					),
					'instructions' 	=> __('The count of total number of reviews.', 'schema-premium'),
				),
			);
			
			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 20 );
			
			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

			return apply_filters( 'schema_properties_Product', $properties );	
		}
		
		/**
		* Schema output
		*
		* @since 1.0.0
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
			
			// Put all together
			//
			$schema['@context'] = 'https://schema.org';
			$schema['@type'] 	= $this->type;
			
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
			// An offer to sell the product. Includes a nested Offer or AggregateOffer.
			//
			$schema['offers'] 	= array
			(
				'@type' 			=> 'Offer',
				'url'				=> isset($properties['offerUrl']) ? $properties['offerUrl'] : get_permalink( $post->ID ),
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

			// AggregateOffer
			// @since 1.0.3
			// @updated 1.1.2.7
			//
			if ( isset($properties['lowPrice']) && isset($properties['highPrice']) ) {
				$schema['offers']['@type'] = 'AggregateOffer';
				$schema['offers']['lowPrice'] = $properties['lowPrice'];
				$schema['offers']['highPrice'] = $properties['highPrice'];
				$offerCount = ($properties['lowPrice'] == $properties['highPrice']) ? 1 : 2;
				$schema['offers']['offerCount'] = isset($properties['offerCount']) ? $properties['offerCount'] : $offerCount; // default to 2 if not set
			}
			
			// Review
			//
			if ( isset($properties['review']) && $properties['review'] != 0 && $properties['review'] != '' ) {
				$schema['review'] 	= array
				(
					'@type' 		=> 'Review',
					'reviewRating'	=> array (
						'@type' 		=> 'Rating',
						'bestRating' 	=> 5,
						'ratingValue' 	=> isset($properties['review']) ? $properties['review'] : '',
						'worstRating' 	=> 1
					)
				);		
				// Review author
				//
				if ( isset($properties['review_author']) ) {
					$schema['review']['author'] = array(
						'@type'	=> 'Person',
						'name' => $properties['review_author']
					);
				} else {
					$schema['review']['author'] = schema_wp_get_author_array();
				}

				// Unset review property
				//
				unset($properties['review']);
			}
			
			// Aggregate rating
			//
			if ( isset($properties['reviewCount']) && $properties['reviewCount'] > 0 ) {
				$schema['aggregateRating'] 	= array
				(
					'@type' 		=> 'AggregateRating',
					'bestRating' 	=> 5,
					'ratingValue' 	=> isset($properties['ratingValue']) ? $properties['ratingValue'] : '',
					'reviewCount' 	=> isset($properties['reviewCount']) ? $properties['reviewCount'] : '',
					'worstRating' 	=> 1
				);
			}
			
			// Merge schema and properties arrays
			// Make sure $properties is an array before merging
			// 
			if ( is_array($properties) ) {
				
				$schema = array_merge( $schema, $properties );
			}
			
			// Merge parent schema 
			//
			$schema = array_merge( parent::schema_output($post->ID), $schema );

			// Unset auto generated properties
			//
			unset($schema['priceCurrency']);
			unset($schema['seller']);

			// debug
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

			// Unset auto generated properties
				//
				unset($schema['priceCurrency']);
				unset($schema['price']);
				unset($schema['lowPrice']);
				unset($schema['highPrice']);
				unset($schema['offerCount']);
				unset($schema['offerUrl']);
				unset($schema['priceValidUntil']);
				unset($schema['availability']);
				unset($schema['itemCondition']);
				unset($schema['seller']);
				//unset($schema['review']);
				unset($schema['review_author']);
				unset($schema['ratingValue']);
				unset($schema['reviewCount']);
			
			return apply_filters( 'schema_output_Product', $schema );
		}
	}
	
	new Schema_WP_Product();
	
endif;
