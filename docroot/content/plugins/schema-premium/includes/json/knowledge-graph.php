<?php
/**
 * Knowledge Graph
 *
 * @since 1.0.0
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'schema_knowledge_graph_output_before', 'schema_premium_do_output_knowledge_graph' );
/*
* Output Knowledge Graph markup only on the front page
*
* @since 1.0.0
*/
function schema_premium_do_output_knowledge_graph( $knowledge_graph ) {
	
	// Output Knowledge Graph only on front page
	//
	if ( ! is_front_page() ) 
		return;
	
	return apply_filters( 'schema_knowledge_graph_output', $knowledge_graph );
}

add_action( 'schema_output_before', 'schema_premium_output_knowledge_graph' );
/**
 * The main function responsible for output schema json-ld 
 *
 * @since 1.0.0
 * @return schema json-ld final output
 */
function schema_premium_output_knowledge_graph() {
	
	$knowledge_graph = schema_premium_get_knowledge_graph_json();

	if ( $knowledge_graph )  {
		
		$knowledge_graph = apply_filters( 'schema_knowledge_graph_output_before', $knowledge_graph );
		
		$markup = new Schema_WP_Output();
		$markup->json_output( $knowledge_graph );
	}
}

/**
 * The main function responsible for putting schema array all together
 *
 * @param string $type for schema type (example: Organization)
 * @since 1.0.0
 * @return array, schema output
 */
function schema_premium_get_knowledge_graph_json() {
	
	$organization_or_person = schema_wp_get_option( 'organization_or_person' );
	
	if ( empty($organization_or_person) ) return;
	
	switch ( $organization_or_person ) {
		case "organization":
			$type = 'Organization';
			break;
		case "person":
			$type = 'Person';
			break;
	}
	
	$schema = array();
	
	$name	= schema_wp_get_option( 'name' );
	$url	= esc_attr( stripslashes( schema_wp_get_option( 'url' ) ) );
	
	if ( empty($name) || empty($url) ) return;
	
	$schema['@context'] = "https://schema.org";
	$schema['@type'] 	= $type;
	$schema['@id'] 		= $url . '#' . $organization_or_person;
	
	if ( ! empty($name) ) $schema['name'] 	= $name;
	if ( ! empty($url) ) $schema['url'] 	= $url;
	
	// Add logo
	// @since 1.0.9
	// Set logo only when type = Organization
	//
	if ( $type == 'Organization' ) {
		$logo = esc_attr( stripslashes( schema_wp_get_option( 'logo' ) ) );
		if ( ! empty($logo) ) {
			$logo_attachment_id = attachment_url_to_postid( $logo );
			// If the above function fails, we can use the commented one below:
			//$logo_attachment_id = schema_wp_get_attachment_id_from_url( $logo );
	 		if ( ! empty($logo_attachment_id) ) {
	 			$schema['logo'] = schema_wp_get_image_object_by_attachment_id( $logo_attachment_id );
				$schema['logo']['@id'] = $url . '#logo'; 
				$schema['image'] = schema_wp_get_image_object_by_attachment_id( $logo_attachment_id );
				$schema['image']['@id'] = $url . '#logo'; 
	 		} else {
				// It's external, use image url only
				//
				$schema['logo'] = $logo;
			}
	 	}
	}
	
	// Get corporate contacts types array
	//
	$corporate_contacts_types = schema_premium_get_corporate_contacts_types_array();
	//
	// Add contact
	//
	if ( ! empty($corporate_contacts_types) ) {
		$schema["contactPoint"] = $corporate_contacts_types;
	}
	
	// Get social links array
	//
	$social = schema_wp_get_social_array();
	
	// Add sameAs
	//
	if ( ! empty($social) ) {
		$schema["sameAs"] = $social;
	}
	
	return apply_filters( 'schema_wp_knowledge_graph_json', $schema );
}

/**
 * Get Get corporate contacts types array
 *
 * @since 1.0.0
 * @return array
 */
function schema_premium_get_corporate_contacts_types_array() {
	
	$corporate_contacts_types	= array();
	
	$corporate_contacts_telephone		= ( schema_wp_get_option( 'corporate_contacts_telephone' ) ) ? schema_wp_get_option( 'corporate_contacts_telephone' ) : '';
	$corporate_contacts_url				= ( schema_wp_get_option( 'corporate_contacts_url' ) ) ? schema_wp_get_option( 'corporate_contacts_url' ) : '';
	$corporate_contacts_contact_type	= ( schema_wp_get_option( 'corporate_contacts_contact_type' ) ) ? schema_wp_get_option( 'corporate_contacts_contact_type' ) : '';
	
	if ( $corporate_contacts_telephone || $corporate_contacts_url )  {
		
		// Remove dashes and replace it with a space
		$corporate_contacts_telephone		= str_replace("_", " ", $corporate_contacts_telephone);
		$corporate_contacts_contact_type	= str_replace("_", " ", $corporate_contacts_contact_type);
	
		$corporate_contacts_types = array(
			'@type'			=> 'ContactPoint',	// default required value
			'telephone'		=> $corporate_contacts_telephone,
			'url'			=> $corporate_contacts_url,
			'contactType'	=> $corporate_contacts_contact_type
		);
	}
	
	return $corporate_contacts_types;
}

/**
 * Get social links array
 *
 * @since 1.0.0
 * @return array
 */
function schema_wp_get_social_array() {
	
	$social = array();
	
	$google 	= esc_attr( stripslashes( schema_wp_get_option( 'google' ) ) );
	$facebook 	= esc_attr( stripslashes( schema_wp_get_option( 'facebook') ) );
	$twitter 	= esc_attr( stripslashes( schema_wp_get_option( 'twitter' ) ) );
	$instagram 	= esc_attr( stripslashes( schema_wp_get_option( 'instagram' ) ) );
	$youtube 	= esc_attr( stripslashes( schema_wp_get_option( 'youtube' ) ) );
	$linkedin 	= esc_attr( stripslashes( schema_wp_get_option( 'linkedin' ) ) );
	$myspace 	= esc_attr( stripslashes( schema_wp_get_option( 'myspace' ) ) );
	$pinterest 	= esc_attr( stripslashes( schema_wp_get_option( 'pinterest' ) ) );
	$soundcloud = esc_attr( stripslashes( schema_wp_get_option( 'soundcloud' ) ) );
	$tumblr 	= esc_attr( stripslashes( schema_wp_get_option( 'tumblr' ) ) );
	
	$social_links = array( $google, $facebook, $twitter, $instagram, $youtube, $linkedin, $myspace, $pinterest, $soundcloud, $tumblr );
	
	// Remove empty fields
	foreach( $social_links as $profile ) {
		if ( $profile != '' ) $social[] = $profile;
	}
	
	return $social;
}
