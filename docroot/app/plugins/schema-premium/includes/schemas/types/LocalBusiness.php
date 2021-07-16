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
	class Schema_WP_LocalBusiness extends Schema_WP_Organization {
		
		/** @var string Currenct Type */
    	protected $type = 'LocalBusiness';
		
		/** @var string Current Parent Type */
		protected $parent_type = 'Organization';

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
		* Get schema type 
		*
		* @since 1.2
		* @return string
		*/
		public function type() {
			
			return 'LocalBusiness';
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
				
				'currenciesAccepted' => array(
					'label' 		=> __('Currencies Accepted', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'select',
					'markup_value' => 'disabled',
					'choices' 		=> schema_wp_get_currencies(),
					'instructions' 	=> __('The currency accepted.', 'schema-premium'),
					'allow_null'	=> true,
					'multiple' 		=> 1,
					'ui' 			=> 1,
				),
				'paymentAccepted' => array(
					'label' 		=> __('Payment Accepted', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value'  => 'disabled',
					'instructions' 	=> __('Cash, Credit Card, Cryptocurrency, Local Exchange Tradings System, etc.', 'schema-premium'),
				),
				'priceRange' => array(
					'label' 		=> __('Price Range', 'schema-premium'),
					'rangeIncludes' => array('Text'),
					'field_type' 	=> 'text',
					'markup_value' => 'disabled',
					'instructions' 	=> __('The relative price range of a business, commonly specified by either a numerical range (for example, $10-15) or a normalized number of currency signs (for example, $$$).', 'schema-premium'),
				)
			);
			
			// Wrap properties in tabs 
			//
			$properties = schema_properties_wrap_in_tabs( $properties, self::type(), self::label(), self::comment(), 20 );
			
			// Merge parent properties 
			//
			$properties = array_merge( parent::properties(), $properties );

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
			
			// Putting all together
			//
			//$schema['@context'] =  'https://schema.org';
			//$schema['@type'] 	=  $this->type;
			/*
			$schema['mainEntityOfPage'] = array
			(
				'@type' => 'WebPage',
				'@id' => get_permalink( $post->ID )
			);
			*/
			
			
			// Get properties
			//
			$properties = schema_wp_get_properties_markup_output( $post->ID, $this->properties(), $this->type );
			
			// Merge parent schema 
			//
			$schema = array_merge( parent::schema_output($post->ID), $schema );

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

			//unset($schema['review']);
			//unset($schema['review_author']);

			unset($schema['streetAddress']);
			unset($schema['addressLocality']);
			unset($schema['addressRegion']);
			unset($schema['postalCode']);
			unset($schema['addressCountry']);
			unset($schema['geo_latitude']);
			unset($schema['geo_longitude']);
			
			return apply_filters( 'schema_output_LocalBusiness', $schema );
		}
	}
	
	new Schema_WP_LocalBusiness();
	
endif;
