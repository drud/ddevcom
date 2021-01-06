<?php
/**
 * @package Schema Premium - Extension : Defragment
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

//add_filter('schema_output', 'schema_premium_do_defragment', 99 );
add_filter('schema_singular_output', 'schema_premium_do_defragment', 99 );
//remove_action( 'wp', 'SCHEMA_WP_Breadcrumbs::instance' );
/**
 * Defragmented schema markup output
 *
 * @since 1.0.0
 */
function schema_premium_do_defragment( $schema ) {
	
	global $post;

	/*
	$defragment_enabled = schema_wp_get_option( 'defragment' );
	
	if ( ! isset($defragment_enabled) || $defragment_enabled == '' ) 
		return $schema;
	*/

	//echo count($schema);
	//echo '<pre>'; print_r($schema); echo '</pre>';exit;

	if ( is_home() || is_front_page() || ! is_singular() )
		return $schema;

	// Supported types
	//
	$supported_types = array(
		'Article', 'AdvertiserContentArticle', 'NewsArticle', 'Report', 'SatiricalArticle', 'ScholarlyArticle', 'SocialMediaPosting', 'TechArticle',
		'BlogPosting',
		'FAQPage',
		'Product',
		'Review',
		'LocalBusiness'
	);

	if ( ! in_array( $schema['@type'], $supported_types ) )
		return $schema;

	// All is good...
	// Let's start
	//
	//

	// SiteLinks Search Box
	//
	$Website = schema_premium_get_sitelinks_search_box_markup();

	// Local Business
	//
	//$local_business_options = new schema_premium_local_business_options();
	//$local_business = $local_business_options->schema_markup();
	
	// Breadcrumbs
	//
	$breadcrumb 	= SCHEMA_WP_Breadcrumbs_Defragment::instance();
	$breadcrumbs 	= $breadcrumb->get_crumbs();
	
	// Primary Image Of Page
	//
	$primaryImageOfPage = $schema['image'];
	
	// WebPage markup
	//
	$WebPage =  array(
		'@type' 				=> 'WebPage',
		'@id'					=> $schema['url'] . '#webpage',
		'url'					=> $schema['url'],
		'name'					=> $schema['name'],
		'datePublished'			=> $schema['datePublished'],
		'dateModified'			=> $schema['dateModified'],
		'lastReviewed'			=> $schema['dateModified'],
		'reviewedBy'			=> $schema['author'],
		'description'			=> $schema['description'],
		'inLanguage'			=> get_locale(), //'en-US',
		'isPartOf'				=> $Website,
		'hasPart'				=>  array(
			'@type'	 => 'Book',
			'name'	 => 'Helloo',
			'bookFormat' => 'EBook',	
			'aggregateRating'	 => array(
				'@type' => 'AggregateRating',
				'reviewCount' => 20,
			),	
			'name'	 => 'Helloo',		
		),
		'primaryImageOfPage'	=> $primaryImageOfPage,
		'breadcrumb'			=> $breadcrumbs,
		'potentialAction'		=> array(
			'@type'	 => 'ReadAction',
			'target' => array(
				'@type'			=> 'EntryPoint',
				'urlTemplate'	=> $schema['url']
			)
		)
	);

	// Now...
	// Let's use WebPage in our markup
	//
	//
	$schema['mainEntityOfPage'] = $WebPage;
	//$schema['isPartOf'] 		= $WebPage;

	//$schema['@id'] = $schema['url'] . '#article';
	//$graph['@graph'][] = $schema;

	//return $graph;
 
	// debug
	//echo '<pre>'; print_r($schema); echo '</pre>';//exit;
	
	return $schema;
}
