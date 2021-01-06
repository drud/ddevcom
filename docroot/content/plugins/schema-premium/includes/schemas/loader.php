<?php
/**
 * Schema Types Loader
 *
 * @since 1.0.0
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Make sure Thing class is loaded first
//
require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/types/Thing.php' ;

// Make sure Organization class is loaded eariler
//
require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/types/Organization.php' ;

// Make sure CreativeWork class is loaded eariler
//
require_once SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/types/CreativeWork.php' ;

// Auto load other main schema types 
//
foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/types/*.php' ) as $filename ) {
	require_once $filename;
}

// Article
//
foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/Article/*.php' ) as $filename ) {
	require_once $filename;
}
	foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/Article/SocialMediaPosting/*.php' ) as $filename ) {
		require_once $filename;
	}
foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/Event/*.php' ) as $filename ) {
	require_once $filename;
}

// Book
//
foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/Book/*.php' ) as $filename ) {
	require_once $filename;
}

// HowTo
//
foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/HowTo/*.php' ) as $filename ) {
	require_once $filename;
}

// LocalBusiness
//
foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/LocalBusiness/*.php' ) as $filename ) {
	require_once $filename;
}
	foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/LocalBusiness/AutomtiveBusiness/*.php' ) as $filename ) {
		require_once $filename;
	}
	foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/LocalBusiness/EmergencyService/*.php' ) as $filename ) {
		require_once $filename;
	}
	foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/LocalBusiness/EntertainmentBusiness/*.php' ) as $filename ) {
		require_once $filename;
	}
	foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/LocalBusiness/FinancialService/*.php' ) as $filename ) {
		require_once $filename;
	}
	foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/LocalBusiness/FoodEstablishment/*.php' ) as $filename ) {
		require_once $filename;
	}
	foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/LocalBusiness/GovernmentOffice/*.php' ) as $filename ) {
		require_once $filename;
	}
	foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/LocalBusiness/HealthAndBeautyBusiness/*.php' ) as $filename ) {
		require_once $filename;
	}
	foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/LocalBusiness/HomeAndConstructionBusiness/*.php' ) as $filename ) {
		require_once $filename;
	}
	foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/LocalBusiness/LegalService/*.php' ) as $filename ) {
		require_once $filename;
	}
	foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/LocalBusiness/LodgingBusiness/*.php' ) as $filename ) {
		require_once $filename;
	}
	foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/LocalBusiness/SportsActivityLocation/*.php' ) as $filename ) {
		require_once $filename;
	}
	foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/LocalBusiness/MedicalBusiness/*.php' ) as $filename ) {
		require_once $filename;
	}
	foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/LocalBusiness/Store/*.php' ) as $filename ) {
		require_once $filename;
	}
	foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/LocalBusiness/LegalService/*.php' ) as $filename ) {
		require_once $filename;
	}


// Place
//
foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/Place/*.php' ) as $filename ) {
    require_once $filename;
}
    foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/Place/Accommodation/*.php' ) as $filename ) {
        require_once $filename;
    }

foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/SoftwareApplication/*.php' ) as $filename ) {
	require_once $filename;
}

foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/WebPage/*.php' ) as $filename ) {
	require_once $filename;
}
