<?php
/**
 *  Author extention
 *
 *  Adds schema Author for Article types
 *
 *  @since 1.0.0
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//add_filter( 'schema_output', 'schema_wp_do_author' );
/**
 * Filter schema markup output, via schema_output filter  
 *
 * @since 1.0.0
 * @return array 
 */
function schema_wp_do_author( $schema ) {
	
	global $post;
	
	if ( ! isset($schema["@type"]) ) return $schema;
	
	$schema_type			= $schema["@type"];
	$support_article_types 	= schema_wp_get_support_article_types();
	$types_supports_author	= schema_premium_get_types_supports_author();
	$author					= schema_wp_get_author_array($post->ID);
	
	if ( in_array( $schema_type, $support_article_types, false) || in_array( $schema_type, $types_supports_author, false) )
		$schema["author"] = $author;
	
	return $schema;
}

/**
 * Get author array
 *
 * @since 1.0.0
 * @return array
 */
function schema_wp_get_author_array( $post_id = null, $author_id = null ) {
	
	global $post;
	
	// Set post ID
	//
	if ( ! isset($post_id) ) {
		$post_id = isset($post->ID) ? $post->ID: null;
	}

	// Make sure we do have a post ID set
	// @since 1.2
	//
	if ( ! isset($post_id) ) {
		return;
	}

	// Get author from post content
	//
	$content_post	= get_post( $post_id );
	$post_author	= ( isset($author_id) ) ? get_userdata( $author_id ) : get_userdata( $content_post->post_author );
	
	if (!is_object($post_author)) {
		return;
	}
	
	$email = ( isset($post_author->user_email) ) ? $post_author->user_email : ''; 
	
	// Debug
	//
	//print_r($post_author);exit;
	
	// Author URL
	//
	$url_enable = schema_wp_get_option( 'author_url_enable' );
	$url 		= ( $url_enable == true ) ? esc_url( get_author_posts_url( $post_author->ID ) ) : '';
	
	$author = array (
		'@type'	=> 'Person',
		'name'	=> apply_filters ( 'schema_wp_filter_author_name', $post_author->display_name )
	);
	
	// URL
	// @since 1.1.2.8
	//
	if ( '' != $url ) {
		$author['url'] = $url;
	} else {
		$website 	= esc_attr( stripslashes( get_the_author_meta( 'url', $post_author->ID ) ) );
		if ( '' != $website )
			$author['url'] = $website;
	}

	if ( get_the_author_meta( 'description', $post_author->ID ) ) {
		$author['description'] = strip_tags( get_the_author_meta( 'description', $post_author->ID ) );
	}
	
	// Get gravatar
	//
	$gravatar_enable = schema_wp_get_option( 'gravatar_image_enable' );
	
	if ( $gravatar_enable == true  && schema_wp_validate_gravatar( $email ) ) {
		// Default = 96px, since it is a squre image, width = height
		$image_size	= apply_filters( 'schema_wp_get_author_array_img_size', 96 ); 
		
		// Get an array of args
		//
		$args = array(
						'size' => $image_size,
					);
		
		$image_url	= get_avatar_url( $email, $args );

		if ( $image_url ) {
			$author['image'] = array (
				'@type'		=> 'ImageObject',
				'url' 		=> $image_url,
				'height' 	=> $image_size, 
				'width' 	=> $image_size
			);
		}
	}
	
	// sameAs
	//
	$website 	= esc_attr( stripslashes( get_the_author_meta( 'user_url', $post_author->ID ) ) );
	$facebook 	= esc_attr( stripslashes( get_the_author_meta( 'facebook', $post_author->ID) ) );
	$twitter 	= esc_attr( stripslashes( get_the_author_meta( 'twitter', $post_author->ID ) ) );
	$instagram 	= esc_attr( stripslashes( get_the_author_meta( 'instagram', $post_author->ID ) ) );
	$youtube 	= esc_attr( stripslashes( get_the_author_meta( 'youtube', $post_author->ID ) ) );
	$linkedin 	= esc_attr( stripslashes( get_the_author_meta( 'linkedin', $post_author->ID ) ) );
	$myspace 	= esc_attr( stripslashes( get_the_author_meta( 'myspace', $post_author->ID ) ) );
	$pinterest 	= esc_attr( stripslashes( get_the_author_meta( 'pinterest', $post_author->ID ) ) );
	$soundcloud = esc_attr( stripslashes( get_the_author_meta( 'soundcloud', $post_author->ID ) ) );
	$tumblr 	= esc_attr( stripslashes( get_the_author_meta( 'tumblr', $post_author->ID ) ) );
	$github 	= esc_attr( stripslashes( get_the_author_meta( 'github', $post_author->ID ) ) );
	
	// Add full URL	to Twitter
	//
	if ( isset($twitter) && $twitter != '' ) $twitter = 'https://twitter.com/' . $twitter;
	
	$sameAs_links = array( $website, $facebook, $twitter, $instagram, $youtube, $linkedin, $myspace, $pinterest, $soundcloud, $tumblr, $github);
	
	$social = array();
	
	// Remove empty fields
	//
	foreach( $sameAs_links as $sameAs_link ) {
		if ( $sameAs_link != '' ) $social[] = $sameAs_link;
	}
	
	if ( ! empty($social) ) {
		$author["sameAs"] = $social;
	}
	
	return apply_filters( 'schema_wp_author', $author );
}
