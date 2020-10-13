<?php
/**
 *	SiteLinks Search Box
 *
 * @since 1.0.0
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'schema_output_before', 'schema_premium_output_sitelinks_search_box' );
/**
 * The main function responsible for output schema json-ld 
 *
 * @since 1.0.0
 * @return schema json-ld final output
 */
function schema_premium_output_sitelinks_search_box() {
	
	// Run only on front page 
	if ( is_front_page() ) {
		
		$schema = schema_premium_get_sitelinks_search_box_markup();
		$schema = apply_filters( 'schema_wp_output_sitelinks_search_box', $schema );
		
		$markup = new Schema_WP_Output();
		$markup->json_output( $schema );
	}
}

/**
 * Get SiteLinks Search Box schema makrup
 *
 * @since 1.0.9
 * @return array or null
 */

function schema_premium_get_sitelinks_search_box_markup() {
	
	$output 				= '';
	$sitelinks_search_box	= schema_wp_get_option( 'sitelinks_search_box' );
	$site_name_enable		= schema_wp_get_option( 'site_name_enable' );
	$site_name				= schema_wp_get_option( 'site_name' );
	$site_alternate_name	= schema_wp_get_option( 'site_alternate_name' );
	
	if ( ! isset($sitelinks_search_box) || ! $sitelinks_search_box ) return;
	
	$schema = array(
		'@context'	=> 'http://schema.org',
		'@type'		=> 'WebSite',
		'@id'		=> "#website",
		'url'		=> get_home_url(),
		'potentialAction' => array(
			'@type'			=> 'SearchAction',
			'target'		=> get_home_url() . '/?s={search_term_string}',
			'query-input' 	=> 'required name=search_term_string'
		),
	);
	
	if ( $site_name_enable ) {
		$schema['name'] = $site_name;
		if ( $site_alternate_name ) $schema['alternateName'] =  $site_alternate_name;
	}
	
	return $schema;
}


//add_action('schema_output_before', 'schema_premium_output_sitelinks_search_box_disable');
/**
 * Disable SiteLinks Search Box
 *
 * This function was disabled @since 1.5.9.2, I don't see it important!
 * @since 1.0.0
 * @return meta
 */
 /*
function schema_premium_output_sitelinks_search_box_disable() {
	
	// Run only on front page 
	if ( is_front_page() ) {
		
		$sitelinks_search_box_disable	= schema_wp_get_option( 'sitelinks_search_box_disable' );
		
		if ( isset($sitelinks_search_box_disable) && $sitelinks_search_box_disable == 1 ) {
			echo "\n";
			echo '<!-- Tell Google not to show a Sitelinks search box -->';
			echo "\n";
			echo '<meta name="google" content="nositelinkssearchbox" />';
			echo "\n\n";
		}
	}
}
*/
