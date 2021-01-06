<?php
/**
 * @package Schema Premium - Extension : Default Image
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

//add_filter('schema_output', 									'schema_premium_do_singular_default_image');
add_filter('schema_singular_output', 							'schema_premium_do_singular_default_image');
add_filter('schema_output_Blog_Post', 							'schema_premium_do_singular_default_image');
add_filter('schema_output_blog_single_ListItem', 				'schema_premium_do_singular_default_image');
add_filter('schema_output_post_type_archive_single_ListItem', 	'schema_premium_do_singular_default_image');
add_filter('schema_output_terms_single', 						'schema_premium_do_singular_default_image');
/**
 * Defaulf Image
 *
 * @since 1.0.0
 */
function schema_premium_do_singular_default_image( $schema ) {
	
	global $post;

	$default_image = schema_wp_get_option( 'default_image' );
	
	if ( ! isset($default_image) || $default_image == '' ) 
		return $schema;
	
	/*
	if ( wp_http_validate_url( $default_image ) ) {
    	$url 		= esc_url($default_image);
		$new_media 	= getimagesize($url);
		$width 		= isset($new_media[0]) ? $new_media[0] : 696;
		$height 	= isset($new_media[1]) ? $new_media[1] : '';
	} else {
		$new_media = wp_get_attachment_image_src( $default_image, 'full' );
		$url 	= isset($new_media[0]) ? $new_media[0] : '';
		$width	= isset($new_media[1]) ? $new_media[1] : 696;
		$height	= isset($new_media[2]) ? $new_media[2] : '';
	}
	*/

	// Check if an external image has been used
	// @since 1.1.2.4
	//
	if ( schema_premium_isexternal( $default_image ) ) {
		$url = esc_url($default_image);
		// @since 1.2.1
		$file_headers = @get_headers($url);
		if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
			$exists = false;
		}
		else {
			$exists = true;
		}
		if ($exists) {
			$new_media 	= getimagesize($url);
			$width 		= isset($new_media[0]) ? $new_media[0] : 1200;
			$height 	= isset($new_media[1]) ? $new_media[1] : '';
		}
	} else {
		$default_image_id = attachment_url_to_postid( $default_image );
		$new_media = wp_get_attachment_image_src( $default_image_id, 'full' );
		$url 	= isset($new_media[0]) ? $new_media[0] : '';
		$width	= isset($new_media[1]) ? $new_media[1] : 1200;
		$height	= isset($new_media[2]) ? $new_media[2] : '';
	}

	if ( is_singular() ) {
		foreach ( $schema as $items => $item ) {
		
			if ( ! isset($schema[$items]['image']) || empty($schema[$items]['image']) ) {
				$schema[$items]['image'] = array (
					'@type'		=> 'ImageObject',
					'url' 		=> $url,
					'width' 	=> $width,
					'height' 	=> $height,
				);
			}
			
			// Add default image to itemReviewed
			// @since 1.2
			//
			if ( isset($schema[$items]['@type']) && $schema[$items]['@type'] == 'Review' ) {
				if ( ! isset($schema[$items]['itemReviewed']['image']) || empty($schema[$items]['itemReviewed']['image']) ) {
					$schema[$items]['itemReviewed']['image'] = array (
						'@type'		=> 'ImageObject',
						'url' 		=> $url,
						'width' 	=> $width,
						'height' 	=> $height,
					);
				}
			}
		}

	} elseif ( schema_wp_is_blog() || is_category() || is_tag() || is_tax() || is_post_type_archive() ) {
		
		if ( ! isset($schema['image']) || empty($schema['image']) ) {
			$schema['image'] = array (
				'@type'		=> 'ImageObject',
				'url' 		=> $url,
				'width' 	=> $width,
				'height' 	=> $height,
			);
		}
	}
	
	// debug
	//echo '<pre>'; print_r($schema); echo '</pre>';
	
	return $schema;
}
