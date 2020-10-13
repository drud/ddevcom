<?php
/**
 * @package Schema Premium - Class Schema LocalBusiness
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_LocalBusiness') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_LocalBusiness {
		
		/** @var string Currenct Type */
    	protected $type = 'LocalBusiness';
		
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
			add_filter( 'schema_premium_meta_is_opennings', array( $this, 'support_opennings' ) );
		}
		
		/**
		* Get schema type label
		*
		* @since 1.0.0
		* @return array
		*/
		public function label() {
			
			return __('Local Business', 'schema-premium');
		}
		
		/**
		* Get schema type comment
		*
		* @since 1.0.0
		* @return array
		*/
		public function comment() {
			
			return __('A particular physical business or branch of an organization. Examples of LocalBusiness include a restaurant, a particular branch of a restaurant chain, a branch of a bank, a medical practice, a club, a bowling alley, etc.', 'schema-premium');
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
		* Add support for openning hours post meta, by fileting is_opennings array
		*
		* @since 1.0.0
		* @return array
		*/
		public function support_opennings( $is_opennings ) {
			
			$supported_types 	= array($this->type);
			$sub_types 			= $this->subtypes();

			if ( is_array( $sub_types ) && ! empty( $sub_types ) ) {
				foreach ( $sub_types as $sub_types_key => $sub_typs ) {
					foreach ( $sub_typs as $sub_type_key => $subtype_data ) {
						$supported_types[] = $sub_type_key;
					}
				}
			}
			
			if ( empty ( $is_opennings ) ) {
				return $supported_types;
			} else {
				return array_merge( $is_opennings,  $supported_types );
			}
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
			
			return apply_filters( 'schema_wp_LocalBusiness', $schema );
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
				'Local Business' => array
				(
            		'AnimalShelter' 				=> __('Animal Shelter', 'schema-premium'),
					'AutomotiveBusiness' 			=> __('Automotive Business', 'schema-premium'),
					'ChildCare'						=> __('Child Care', 'schema-premium'),
					'Dentist' 						=> __('Dentist', 'schema-premium'),
					'DryCleaningOrLaundry' 			=> __('Dry Cleaning or Laundry', 'schema-premium'),
					'EmergencyService'				=> __('Emergency Service', 'schema-premium'),
					'EmploymentAgency' 				=> __('Employment Agency', 'schema-premium'),
					'EntertainmentBusiness' 		=> __('Entertainment Business', 'schema-premium'),
					'FinancialService' 				=> __('Financial Service', 'schema-premium'),
					'FoodEstablishment' 			=> __('Food Establishment', 'schema-premium'),
					'GovernmentOffice' 				=> __('Government Office', 'schema-premium'),
					'HealthAndBeautyBusiness' 		=> __('Health and Beauty Business', 'schema-premium'),
					'HomeAndConstructionBusiness' 	=> __('Home and Construction Business', 'schema-premium'),
					'InternetCafe' 					=> __('Internet Cafe', 'schema-premium'),
					'LegalService' 					=> __('Legal Service', 'schema-premium'),
					'Library' 						=> __('Library', 'schema-premium'),
					'LodgingBusiness' 				=> __('Lodging Business', 'schema-premium'),
					'MedicalBusiness' 				=> __('Medical Business', 'schema-premium'), // More specific Types available in extensions
					'ProfessionalService' 			=> __('Professional Service', 'schema-premium'),
					'RadioStation' 					=> __('Radio Station', 'schema-premium'),
					'RealEstateAgent' 				=> __('Real Estate Agent', 'schema-premium'),
					'RecyclingCenter' 				=> __('Recycling Center', 'schema-premium'),
					'SelfStorage' 					=> __('Self Storage', 'schema-premium'),
					'ShoppingCenter' 				=> __('Shopping Center', 'schema-premium'),
					'SportsActivityLocation' 		=> __('Sports Activity Location', 'schema-premium'),
					'Store' 						=> __('Store', 'schema-premium'),
					'TelevisionStation' 			=> __('Television Station', 'schema-premium'),
					'TouristInformationCenter' 		=> __('Tourist Information Center', 'schema-premium'),
					'TravelAgency' 					=> __('Travel Agency', 'schema-premium')
				),
				'Automotive Business' => array
				(
            		'AutoBodyShop' 		=> __('Auto Body Shop', 'schema-premium'),
					'AutoDealer' 		=> __('Auto Dealer', 'schema-premium'),
					'AutoPartsStore'	=> __('Auto Parts Store', 'schema-premium'),
					'AutoRental' 		=> __('Auto Rental', 'schema-premium'),
					'AutoRepair' 		=> __('Auto Repair', 'schema-premium'),
					'AutoWash' 			=> __('Auto Wash', 'schema-premium'),
					'GasStation' 		=> __('Gas Station', 'schema-premium'),
					'MotorcycleDealer' 	=> __('Motorcycle Dealer', 'schema-premium'),
					'MotorcycleRepair' 	=> __('Motorcycle Repair', 'schema-premium')
				),
				'Emergency Service' => array
				(
            		'FireStation' 		=> __('Fire Station', 'schema-premium'),
					'Hospital' 			=> __('Hospital', 'schema-premium'),
					'PoliceStation'		=> __('Police Station', 'schema-premium')
				),
				'Entertainment Business' => array
				(
            		'AdultEntertainment'	=> __('Adult Entertainment', 'schema-premium'),
					'AmusementPark' 		=> __('Amusement Park', 'schema-premium'),
					'ArtGallery'			=> __('Art Gallery', 'schema-premium'),
					'Casino' 				=> __('Casino', 'schema-premium'),
					'ComedyClub' 			=> __('Comedy Club', 'schema-premium'),
					'MovieTheater' 			=> __('Movie Theater', 'schema-premium'),
					'NightClub' 			=> __('Night Club', 'schema-premium')
				),	
				'Financial Service' => array
				(
            		'AccountingService'	=> __('Accounting Service', 'schema-premium'),
					'AutomatedTeller' 	=> __('Automated Teller', 'schema-premium'),
					'BankOrCreditUnion'	=> __('Bank or CreditUnion', 'schema-premium'),
					'InsuranceAgency' 	=> __('Insurance Agency', 'schema-premium')
				),	
				'Food Establishment' => array
				(
            		'Bakery'				=> __('Bakery', 'schema-premium'),
					'BarOrPub' 				=> __('Bar or Pub', 'schema-premium'),
					'Brewery'				=> __('Brewery', 'schema-premium'),
					'CafeOrCoffeeShop' 		=> __('Cafe or Coffee Shop', 'schema-premium'),
					'FastFoodRestaurant'	=> __('Fast Food Restaurant', 'schema-premium'),
					'IceCreamShop'			=> __('Ice Cream Shop', 'schema-premium'),
					'Restaurant'			=> __('Restaurant', 'schema-premium'),
					'Winery'				=> __('Winery', 'schema-premium'),
					// More specific Types available in extensions
					'Distillery'			=> __('Distillery', 'schema-premium'),
				),
				'Government Office' => array
				(
            		'PostOffice' => __('Post Office', 'schema-premium')
				),	
				'Health and Beauty Business' => array
				(
            		'BeautySalon'	=> __('Beauty Salon', 'schema-premium'),
					'DaySpa' 		=> __('Day Spa', 'schema-premium'),
					'HairSalon'		=> __('Hair Salon', 'schema-premium'),
					'HealthClub' 	=> __('Health Club', 'schema-premium'),
					'NailSalon' 	=> __('Nail Salon', 'schema-premium'),
					'TattooParlor' 	=> __('Tattoo Parlor', 'schema-premium')
				),	
				'Home and Construction Business' => array
				(
            		'Electrician'		=> __('Electrician', 'schema-premium'),
					'GeneralContractor' => __('General Contractor', 'schema-premium'),
					'HVACBusiness'		=> __('HVAC Business', 'schema-premium'),
					'HousePainter' 		=> __('House Painter', 'schema-premium'),
					'Locksmith'			=> __('Locksmith', 'schema-premium'),
					'MovingCompany'		=> __('Moving Company', 'schema-premium'),
					'Plumber'			=> __('Plumber', 'schema-premium'),
					'RoofingContractor'	=> __('Roofing Contractor', 'schema-premium')
				),
				'Legal Service' => array
				(
            		'Attorney' 	=> __('Attorney', 'schema-premium'),
					'Notary' 	=> __('Notary', 'schema-premium')
				),
				'Lodging Business' => array
				(
            		'BedAndBreakfast'	=> __('Bed and Breakfast', 'schema-premium'),
					'Campground'		=> __('Campground', 'schema-premium'),
					'Hostel'			=> __('Hostel', 'schema-premium'),
					'Hotel' 			=> __('Hotel', 'schema-premium'),
					'Motel'				=> __('Motel', 'schema-premium'),
					'Resort'			=> __('Resort', 'schema-premium')
				),
				'Medical Business' => array
				(
					'CommunityHealth'	=> __('Community Health', 'schema-premium'),
					'Dentist'			=> __('Dentist', 'schema-premium'),
					'Dermatology'		=> __('Dermatology', 'schema-premium'),
					'DietNutrition'		=> __('Diet Nutrition', 'schema-premium'),
					'Emergency'			=> __('Emergency', 'schema-premium'),
					'Geriatric'			=> __('Geriatric', 'schema-premium'),
					'Gynecologic'		=> __('Gynecologic', 'schema-premium'),
					'MedicalClinic'		=> __('Medical Clinic', 'schema-premium'),
					'Midwifery'			=> __('Midwifery', 'schema-premium'),
					'Nursing'			=> __('Nursing', 'schema-premium'),
					'Obstetric'			=> __('Obstetric', 'schema-premium'),
					'Oncologic'			=> __('Oncologic', 'schema-premium'),
					'Optician'			=> __('Optician', 'schema-premium'),
					'Optometric'		=> __('Optometric', 'schema-premium'),
					'Otolaryngologic'	=> __('Otolaryngologic', 'schema-premium'),
					'Pediatric'			=> __('Pediatric', 'schema-premium'),
					'Pharmacy'			=> __('Pharmacy', 'schema-premium'),
					'Physician'			=> __('Physician', 'schema-premium'),
					'Physiotherapy'		=> __('Physiotherapy', 'schema-premium'),
					'PlasticSurgery'	=> __('Plastic Surgery', 'schema-premium'),
					'Podiatric'			=> __('Podiatric', 'schema-premium'),
					'PrimaryCare'		=> __('Primary Care', 'schema-premium'),
					'Psychiatric'		=> __('Psychiatric', 'schema-premium'),
					'PublicHealth'		=> __('Public Health', 'schema-premium'),
				),
				'Sports Activity Location' => array
				(
            		'BowlingAlley'			=> __('Bowling Alleyt', 'schema-premium'),
					'ExerciseGym'			=> __('Exercise Gym', 'schema-premium'),
					'GolfCourse'			=> __('Golf Course', 'schema-premium'),
					'HealthClub' 			=> __('Health Club', 'schema-premium'),
					'PublicSwimmingPool'	=> __('Public Swimming Pool', 'schema-premium'),
					'SkiResort'				=> __('Ski Resort', 'schema-premium'),
					'SportsClub'			=> __('Sports Club', 'schema-premium'),
					'StadiumOrArena'		=> __('Stadium or Arena', 'schema-premium'),
					'TennisComplex'			=> __('Tennis Complex', 'schema-premium')
				),	
				'Store' => array
				(
            		'AutoPartsStore'		=> __('Auto Parts Store', 'schema-premium'),
					'BikeStore'				=> __('Bike Store', 'schema-premium'),
					'BookStore'				=> __('Book Store', 'schema-premium'),
					'ClothingStore' 		=> __('Clothing Store', 'schema-premium'),
					'ComputerStore'			=> __('Computer Store', 'schema-premium'),
					'ConvenienceStore'		=> __('Convenience Store', 'schema-premium'),
					'DepartmentStore'		=> __('Department Store', 'schema-premium'),
					'ElectronicsStore'		=> __('Electronics Store', 'schema-premium'),
					'Florist'				=> __('Florist', 'schema-premium'),
					'FurnitureStore'		=> __('Furniture Store', 'schema-premium'),
					'GardenStore'			=> __('Garden Store', 'schema-premium'),
					'GroceryStore'			=> __('Grocery Store', 'schema-premium'),
					'HardwareStore'			=> __('Hardware Store', 'schema-premium'),
					'HobbyShop'				=> __('Hobby Shop', 'schema-premium'),
					'HomeGoodsStore'		=> __('Home Goods Store', 'schema-premium'),
					'JewelryStore'			=> __('Jewelry Store', 'schema-premium'),
					'LiquorStore'			=> __('Liquor Store', 'schema-premium'),
					'MensClothingStore'		=> __('Mens Clothing Store', 'schema-premium'),
					'MobilePhoneStore'		=> __('Mobile Phone Store', 'schema-premium'),
					'MovieRentalStore'		=> __('Movie Rental Store', 'schema-premium'),
					'MusicStore'			=> __('Music Store', 'schema-premium'),
					'OfficeEquipmentStore'	=> __('Office Equipment Store', 'schema-premium'),
					'OutletStore'			=> __('Outlet Store', 'schema-premium'),
					'PawnShop'				=> __('Pawn Shop', 'schema-premium'),
					'PetStore'				=> __('Pet Store', 'schema-premium'),
					'ShoeStore'				=> __('Shoe Store', 'schema-premium'),
					'SportingGoodsStore'	=> __('Sporting Goods Store', 'schema-premium'),
					'TireShop'				=> __('Tire Shop', 'schema-premium'),
					'ToyStore'				=> __('Toy Store', 'schema-premium'),
					'WholesaleStore'		=> __('Wholesale Store', 'schema-premium')
				),				
        	);
				
			return apply_filters( 'schema_wp_subtypes_LocalBusiness', $subtypes );
		}
		
		/**
		* Get properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {
			
			$properties = array (
					
				'name' => array(
					'label' 		=> __('Name', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' => 'post_title',
					'instructions' 	=> __('The name of the business.', 'schema-premium'),
					'required' 		=> true
				),
				'url' => array(
					'label' 		=> __('URL', 'schema-premium'),
					'rangeIncludes' => array('URL'),
					'field_type' 	=> 'url',
					'markup_value' => 'site_url',
					'instructions' 	=> __('The fully-qualified URL of the specific business location.', 'schema-premium'),
					'placeholder'	=> 'https://'
				),
				'image' => array(
					'label' 		=> __('Image', 'schema-premium'),
					'rangeIncludes' => array('ImageObject', 'URL'),
					'field_type' 	=> 'image',
					'markup_value' => 'featured_image',
					'instructions' 	=> __('An image of the business.', 'schema-premium'),
					'required' 		=> true
				),
				'telephone' => array(
					'label' 		=> __('Telephone', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' => 'new_custom_field',
					'instructions' 	=> __('A business phone number meant to be the primary contact method for customers. Be sure to include the country code and area code in the phone number.', 'schema-premium'),
					'placeholder'	=> '+1-123-456-7890'
				),
				'priceRange' => array(
					'label' 		=> __('Price Range', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'select',
					'markup_value' => 'new_custom_field',
					'choices' 		=> array
					(
						'$' => '$',
						'$$' => '$$',
						'$$$' => '$$$',
						'$$$$' => '$$$$',
						'$$$$$' => '$$$$$' 
					),
					'instructions' 	=> __('The price range of the business, for example: $$$.', 'schema-premium'),
					'allow_null'	=> true
				),
				'description' => array(
					'label' 		=> __('Description', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'textarea',
					'markup_value' => 'post_excerpt',
					'instructions' 	=> __('A description of the business.', 'schema-premium'),
				),
				'review' => array(
					'label' 		=> __('Review', 'schema-premium'),
					'rangeIncludes' => array('Number'),
					'field_type' 	=> 'star_rating',
					'markup_value' 	=> 'new_custom_field',
					'instructions' 	=> __('The rating given for this business.', 'schema-premium'),
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
					'instructions' 	=> __('The author name of this review.', 'schema-premium'),
				),
				'ratingValue' => array(
					'label' 		=> __('Rating Value', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' => 'new_custom_field',
					'instructions' 	=> __('The aggregate rating for the business.', 'schema-premium'),
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
				// Address
				'address' => array(
					'label' 		=> __('Adress', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'group',
					'layout'		=> 'block',
					'markup_value' => 'new_custom_field',
					'instructions' 	=> __('Address of the specific business location.', 'schema-premium'),
					'sub_fields' 	=>  array(
						'streetAddress' => array(
							'label' 		=> __('Street Address', 'schema-premium'),
							'rangeIncludes' => array('Text'),
							'field_type' 	=> 'text',
							'markup_value' => 'new_custom_field',
							'instructions' 	=> '',
							'required' 		=> true,
							'width' => '50'
						),
						'streetAddress_2' => array(
							'label' 		=> __('Street Address 2', 'schema-premium'),
							'rangeIncludes' => array('Text'),
							'field_type' 	=> 'text',
							'markup_value' 	=> 'disabled',
							'instructions' 	=> '',
							'parent' 		=> 'address',
							'width' => '50'
						),
						'streetAddress_3' => array(
							'label' 		=> __('Street Address 3', 'schema-premium'),
							'rangeIncludes' => array('Text'),
							'field_type' 	=> 'text',
							'markup_value' => 'disabled',
							'instructions' 	=> '',
							'width' => '50'
						),
						'addressLocality' => array(
							'label' 		=> __('Locality / City', 'schema-premium'),
							'rangeIncludes' => array('Text'),
							'field_type' 	=> 'text',
							'markup_value' => 'new_custom_field',
							'instructions' 	=> '',
							'required' 		=> true,
							'width' => '25'
						),
						'addressRegion' => array(
							'label' 		=> __('State or Province', 'schema-premium'),
							'rangeIncludes' => array('Text'),
							'field_type' 	=> 'text',
							'markup_value' => 'new_custom_field',
							'instructions' 	=> '',
							'required' 		=> true,
							'width' => '25'
						),
						'postalCode' => array(
							'label' 		=> __('Zip / Postal Code', 'schema-premium'),
							'rangeIncludes' => array('Text'),
							'field_type' 	=> 'text',
							'markup_value' => 'new_custom_field',
							'instructions' 	=> '',
							'required' 		=> true,
							'width' => '25'
						),
						'addressCountry' => array(
							'label' 		=> __('Country', 'schema-premium'),
							'rangeIncludes' => array('Country', 'Text'),
							'field_type' 	=> 'countries_select',
							'markup_value' => 'new_custom_field',
							'instructions' 	=> '',
							'required' 		=> true,
							'allow_null' 	=> true,
							'ui' 			=> true,
							'width' => '25'
						)
					),
				),
				
				// Geo Location
				'geo' => array(
					'label' 		=> __('Geo Location', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'group',
					'layout'		=> 'block',
					'markup_value' => 'new_custom_field',
					'instructions' 	=> __('The Geo location of the business. The precision should be at least 5 decimal places.', 'schema-premium'),
					'sub_fields' 	=>  array(
						'latitude' => array(
							'label' 		=> __('Latitude', 'schema-premium'),
							'rangeIncludes' => array('Text'),
							'field_type' 	=> 'number',
							'markup_value' => 'new_custom_field',
							//'instructions' 	=> __('The latitude of the business location. The precision should be at least 5 decimal places.', 'schema-premium'),
							'width' => '50'
						),
						'longitude' => array(
							'label' 		=> __('Longitude', 'schema-premium'),
							'rangeIncludes' => array('Text'),
							'field_type' 	=> 'number',
							'markup_value' => 'new_custom_field',
							//'instructions' 	=> __('The longitude of the business location. The precision should be at least 5 decimal places.', 'schema-premium'),
							'width' => '50'
						)
					)
				),
			);
			
			return apply_filters( 'schema_properties_LocalBusiness', $properties );	
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
			
			$schema	= array();
			
			// Get properties
			//
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			// Putting all together
			//
			$schema['@context'] =  'http://schema.org';
			$schema['@type'] 	=  $this->type;
			/*
			$schema['mainEntityOfPage'] = array
			(
				'@type' => 'WebPage',
				'@id' => get_permalink( $post->ID )
			);
			*/
			$name						= schema_wp_get_the_title( $post->ID );
			$schema['name']				= apply_filters( 'schema_wp_filter_name', $name );
			
			$schema['description']		= schema_wp_get_description( $post->ID );
    		$schema['image'] 			= schema_wp_get_media( $post->ID );
			$schema['telephone'] 		= get_post_meta( $post->ID , 'schema_properties_LocalBusiness_telephone', true);
			$schema['priceRange'] 		= get_post_meta( $post->ID , 'schema_properties_LocalBusiness_priceRange', true);
			
			// Address
			$streetAddress		= get_post_meta( $post->ID , 'schema_properties_LocalBusiness_address_streetAddress', true);
			$streetAddress_2 	= get_post_meta( $post->ID , 'schema_properties_LocalBusiness_address_streetAddress_2', true);
			$streetAddress_3 	= get_post_meta( $post->ID , 'schema_properties_LocalBusiness_address_streetAddress_3', true);
			$addressLocality	= get_post_meta( $post->ID , 'schema_properties_LocalBusiness_address_addressLocality', true);
			$addressRegion 		= get_post_meta( $post->ID , 'schema_properties_LocalBusiness_address_addressRegion', true);
			$postalCode 		= get_post_meta( $post->ID , 'schema_properties_LocalBusiness_address_postalCode', true);
			$addressCountry 	= get_post_meta( $post->ID , 'schema_properties_LocalBusiness_address_addressCountry', true);
			
			if ( isset($streetAddress) && $streetAddress != '' 
				|| isset($streetAddress_2) && $streetAddress_2 != '' 
				|| isset($streetAddress_3) && $streetAddress_3 != '' 
				|| isset($postalCode) && $postalCode != '' ) {
				
				$schema['address'] = array
				(
					'@type' => 'PostalAddress',
					'streetAddress' 	=> $streetAddress . ' ' . $streetAddress_2 . ' ' . $streetAddress_3, // join the 3 address lines
					'addressLocality' 	=> $addressLocality,
					'addressRegion' 	=> $addressRegion,
					'postalCode' 		=> $postalCode,
					'addressCountry' 	=> $addressCountry,		
				);
			}
			
			// Geo Location
			$latitude 	= get_post_meta( $post->ID , 'schema_properties_LocalBusiness_geo_latitude', true);
			$longitude 	= get_post_meta( $post->ID , 'schema_properties_LocalBusiness_geo_longitude', true);
			
			if ( isset($latitude) && $latitude != '' || isset($longitude) && $longitude != '' ) {
				$schema['geo'] = array
				(
					'@type' => 'GeoCoordinates',
					'latitude' 	=> $latitude, 
					'longitude'	=> $longitude	
				);
			}
			
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

			// Address: merg two arrays
			if ( !empty($schema['address']) && !empty($properties['address'])) {
				$properties['address'] = array_replace_recursive( $schema['address'], $properties['address'] );
			}
			
			// Geo: merg two arrays
			if ( !empty($schema['geo']) && !empty($properties['geo'])) {
				$properties['geo'] 	= array_replace_recursive( $schema['geo'], $properties['geo'] );
				$schema['geo'] 		= $properties['geo'];
				
				// Make sure this is added!
				$schema['geo']['@type'] = 'GeoCoordinates'; 
			}
			
			// Unset unwanted values
			//
			unset($properties['review']);
			unset($properties['review_author']);
			unset($properties['ratingValue']);
			unset($properties['reviewCount']);

			// Make sure $properties is an array 
			// 
			if ( is_array($properties) ) {
				$schema = array_replace_recursive( $schema, $properties );
			}
			
			// Unset unwanted values
			unset($schema['address']['streetAddress_2']);
			unset($schema['address']['streetAddress_3']);
			
			// Debug
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
			
			return apply_filters( 'schema_output_LocalBusiness', $schema );
		}
	}
	
	new Schema_WP_LocalBusiness();
	
endif;
