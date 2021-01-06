<?php
/**
 * Misc Functions
 *
 * @package     Schema
 * @subpackage  Functions
 * @copyright   Copyright (c) 2018, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Check if schema markup is enabled in post meta
 *
 * @since 1.1.2.8
 * @return bool true or false
 */
function schema_premium_is_disabled( $post_id = null ) {

	if ( ! isset($post_id) ) 
		$post_id = schema_premium_get_post_ID();

	$schema_disabled = get_post_meta( $post_id, 'schema_disabled', true );

	if ( isset($schema_disabled) ) {
		if ( $schema_disabled == 1 ) {
			return true;
		}
	}

	return false;
}

/**
 * Check if post has enabled schema markup match
 *
 * @since 1.1.4
 * @param  $post_id
 * @return bool or array of taargget match
 */
function schema_premium_is_match( $post_id = null ) {

	if ( ! isset($post_id) ) 
		$post_id = schema_premium_get_post_ID();

	if ( schema_premium_is_disabled( $post_id ) )
		return false;

	$location_target_match = schema_premium_get_location_target_match( $post_id );

	if ( empty($location_target_match) ) 
		return false;
		
	foreach ( $location_target_match as $target_match ) {
		
		if ( isset($target_match['match']) && $target_match['match'] == 1 ) { // Match?
			return $target_match;
		}
	}

	return false;
}

/**
 * Get post ID anywhere
 *
 * @since 1.0.0
 *
 * @param int $post_type The post type.
 * @return string post ID, or false
 */
function schema_premium_get_post_ID() {
	
	if( ! is_admin() ){
   
		global $post;
		
		$post_id = isset($post->ID) ? $post->ID : 0;
    
	} else {
    
		if ( isset( $_GET['post'] ) ) {
			$post_id = $_GET['post'];
		} elseif ( isset( $_POST['post_ID'] ) ){
			$post_id = $_POST['post_ID'];
    	} else {
        	$post_id = '0';
    	} 
	}
	
	return $post_id;
}

/**
 * Get an array of enabled post types
 * 
 * Used by WPHeader and WPFooter
 *
 * @since 1.5.9.6
 * @return array of enabled post types, schema type
 */
function schema_wp_cpt_get_enabled_post_types() {
	
	$cpt_enabled = array();
	
	$args = array(
					'post_type'			=> 'schema',
					'post_status'		=> 'publish',
					'posts_per_page'	=> -1
				);
				
	$schemas_query = new WP_Query( $args );
	
	$schemas = $schemas_query->get_posts();
	
	// If there is no schema types set, return and empty array
	if ( empty($schemas) ) return array();
	
	foreach( $schemas as $schema ) : 
		
		$schema_post_types = get_post_meta( $schema->ID, '_schema_post_types'	, true );
		
		// Build our array
		$cpt_enabled[] = (is_array($schema_post_types)) ? reset($schema_post_types) : array();
		
	endforeach;
	
	wp_reset_postdata();
	
	// debug
	//echo '<pre>'; print_r($cpt_enabled); echo '</pre>'; exit;
	//echo reset($cpt_enabled[0]);
	return apply_filters('schema_wp_cpt_enabled_post_types', $cpt_enabled);
}

/**
 * Get supported schema.org types
 *
 * @since 1.2
 * @return array
 */
function schema_premium_get_supported_schemas() {

	$supported_schemas = apply_filters( 'schema_wp_types', array() ); 

	foreach ( $supported_schemas as $schema => $details ) {
		$schemas[$details['value']] = $details['label'];
	}

	return $schemas;
}

/**
 * Add Types to Schema types options array
 *
 * @since 1.0.0
 * @param  $schema_type schema.org type
 * @return array, void
 */
function schema_wp_get_default_schemas( $schema_type = 'Article' ) {
	
	$schema_default =  apply_filters( 'schema_wp_get_default_schemas', array() );
	
	//echo '<pre>'; print_r($schema_default); echo '</pre>';
	
	if ( isset($schema_default[$schema_type]) ) {
		
		return $schema_default[$schema_type];
	}
}

/**
 * Get publisher array
 *
 * @since 1.0.0
 * @return array
 */
function schema_wp_get_publisher_array() {
	
	$publisher = array();

	// Get site name
	//
	$name = schema_wp_get_option( 'name' );
	
	// Use site name as organization name for publisher if not presented in plugin settings
	//
	if ( empty($name) ) {
		$name = get_bloginfo( 'name' );
	}
	
	// Get site url
	//
	$url = schema_wp_get_option( 'url' );

	if ( empty($url) ) {
		$url = site_url();
	}

	$url = esc_attr( stripslashes( $url ) );

	// Get site tagline
	//
	$site_description = get_bloginfo( 'description' );

	$logo = esc_attr( stripslashes( schema_wp_get_option( 'publisher_logo'  ) ) );
	
	$publisher = array(
		'@type'	=> "Organization",	// default required value
		'@id' => $url . '#organization', // this cause an error in markup when there is more than one instanse of markup
		'url' => $url, // @since 1.2.1
		'name'	=> wp_filter_nohtml_kses($name),
		'description' => $site_description,
		'logo'	=> array(
    		'@type' => 'ImageObject',
			'@id' => $url . '#logo', 
    		'url' => $logo,
    		'width' => 600,
			'height' => 60
		),
		'image'	=> array(
    		'@type' => 'ImageObject',
			'@id' => $url . '#logo', 
    		'url' => $logo,
    		'width' => 600,
			'height' => 60
		)
	);

	// Get social links array
	// @since 1.2
	//
	$social = schema_wp_get_social_array();
	
	// Add sameAs
	//
	if ( ! empty($social) ) {
		$publisher["sameAs"] = $social;
	}
	
	// debug
	//echo'<pre>';print_r($publisher);echo'</pre>';
	
	return apply_filters( 'schema_wp_publisher', $publisher );
}

/**
 * Get headline 
 *
 * @since 1.0.0
 * return string
 */
function schema_wp_get_the_title( $post_id = null ) {
	
	global $post;
	
	if ( ! isset($post_id) ) $post_id = $post->ID;
	
	// Get headline
	$title = wp_filter_nohtml_kses( get_the_title( $post_id ) );
	$title = schema_premium_get_truncate_to_word( $title );	
	
	return apply_filters( 'schema_wp_get_the_title', $title );
}

/**
 * Get description 
 *
 * @since 1.0.0
 * return string
 */
function schema_wp_get_description( $post_id = null, $content_length = 'short', $strip_all_tags = true ) {
	
	global $post;
	
	if ( ! isset($post_id) ) $post_id = $post->ID;
	
	// Get post content
	//
	$content_post	= get_post($post_id);
	
	// Get description
	//
	$full_content	= apply_filters('the_content', $content_post->post_content);
	$excerpt		= $content_post->post_excerpt;
	
	// Strip shortcodes 
	//
	$full_content	= preg_replace('#\[[^\]]+\]#', '', $full_content);
 
	if ( $strip_all_tags ) {
		// Strip tags
		//
		$full_content = wp_strip_all_tags( $full_content );
	}
	
	// Filter content before it gets shorter ;)
	//
	$full_content = apply_filters( 'schema_wp_filter_content', $full_content );
	
	switch( $content_length ) {
		
		case 'short':

			$desc_word_count	= apply_filters( 'schema_wp_filter_description_word_count', 49 );
			$short_content		= wp_trim_words( $full_content, $desc_word_count, '' ); 
			$description		= ( $excerpt != '' ) ? $excerpt : $short_content; 
			break;

		case 'full':

			$description = $full_content;
			break;
	}
	
	$description = apply_filters( 'schema_wp_filter_description', $description ); 
	
	return $description;
}

/**
 * Subtract string words by character number
 *
 * @since 1.2
 * return string
 */
function schema_wp_get_substrwords( $text, $maxchar, $end = '...' ) {
	
	if (strlen($text) > $maxchar || $text == '') {
        $words = preg_split('/\s/', $text);      
        $output = '';
        $i      = 0;
		
		while (1) {
            $length = strlen($output)+strlen($words[$i]);
            if ($length > $maxchar) {
                break;
            } 
            else {
                $output .= " " . $words[$i];
                ++$i;
            }
        }
        $output .= $end;
    } 
    else {
        $output = $text;
	}
	
    return $output;
}

/**
 * Get Media
 *
 * @since 1.0.0
 * @return array 
 */
function schema_wp_get_media( $post_id = null ) {
	
	global $post;
	
	if ( ! isset( $post_id ) ) $post_id = $post->ID;
	
	$media = array();
	
	// Featured image
	$image_attributes	= wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'full' );
    $image_url			= isset($image_attributes[0]) ? $image_attributes[0] : '';
	$image_width		= ( isset($image_attributes[1]) && $image_attributes[1] > 696 ) ? $image_attributes[1] : 696; // Images should be at least 696 pixels wide
	$image_height		= isset($image_attributes[2]) ? $image_attributes[2] : '';
	
	// Thesis 2.x Post Image
	$my_theme = wp_get_theme();
	if ( $my_theme->get( 'Name' ) == 'Thesis') {
		$image_attributes	= get_post_meta( $post_id, '_thesis_post_image', true);
		if ( ! empty($image_attributes) ) {
			$image_url			= $image_attributes['image']['url'];
			// Make sure url is valid
			if ( filter_var( $image_url, FILTER_VALIDATE_URL ) === FALSE ) {
    			//die('Not a valid URL');
				$image_url			= get_site_url() . $image_attributes['image']['url'];
			}
			$image_width		= ( $image_attributes['image']['width'] > 696 ) ? $image_attributes['image']['width'] : 696;
			$image_height		= $image_attributes['image']['height'];
		}
	}
	
	// Try something else...
	if ( ! isset($image_url) || $image_url == '' ) {
		// Make sure that PHP-XML extension is installed before parsing page HTML
		if ( extension_loaded('xml') || extension_loaded('SimpleXML')) {
			
			if ( isset($post->post_content) ) {
				$Document = new DOMDocument();
				// This triggers a warning, so we will disable error reporting
				libxml_use_internal_errors(true);
				@$Document->loadHTML( $post->post_content );
				// Clear errors
				libxml_clear_errors();
				$DocumentImages = $Document->getElementsByTagName( 'img' );

				if ( $DocumentImages->length ) {
					$image_url 		= $DocumentImages->item( 0 )->getAttribute( 'src' );
					$image_width 	= ( $DocumentImages->item( 0 )->getAttribute( 'width' ) > 696 ) ? $DocumentImages->item( 0 )->getAttribute( 'width' ) : 696;
					$image_height	= $DocumentImages->item( 0 )->getAttribute( 'height' );
				}
			}
		}
	}	
			
	// Check if there is no image url, width, or height, then return an empy array
	if ( ! isset($image_url) || $image_url == '' ) return $media;

	if ( ! isset($image_width) || $image_width == '' ) return $media;
	if ( ! isset($image_height) || $image_height == '' ) return $media;
	
	$media = array (
		'@type' 	=> 'ImageObject',
		'url' 		=> $image_url,
		'width' 	=> $image_width,
		'height' 	=> $image_height,
		);
	
	// debug
	//echo '<pre>'; print_r($media); echo '</pre>';
	
	return apply_filters( 'schema_wp_filter_media', $media );
}

/**
 *  Get image url by attachment ID 
 *
 * @param string $attachment_id The attachment id
 * @return string 
 * @since 1.2
 */
function schema_wp_get_image_url_by_attachment_id( $attachment_id ) {
	
	if ( ! isset($attachment_id) ) 
		return;
	
	$image_attributes = wp_get_attachment_image_src( $attachment_id, 'full' );
	
	$url = '';

	if ( isset($image_attributes[0]) ) {
		$url = $image_attributes[0];
	}
	
	// debug
	//echo'<pre>';print_r($image_attributes);echo'</pre>';exit;
	
	return $url;
}

/**
 *  Retrieves the attachment ID from the file URL
 *
 * @param string $image_url The attachment image url
 * @return string - attachment ID 
 * @since 1.0.9
 */
function schema_wp_get_attachment_id_from_url( $image_url ) {
	
	global $wpdb;
	
	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
	
	return $attachment[0]; 
}

/**
 *  Get ImageObject by attachment ID 
 *
 * @param string $image_url The attachment image url
 * @return array ImageObject
 * @since 1.0.9
 */
function schema_wp_get_image_object_by_attachment_id( $attachment_id ) {
	
	if ( ! isset($attachment_id) ) 
		return array();
	
	$ImageObject = array();
	
	// Featured image
	$image_attributes = wp_get_attachment_image_src( $attachment_id, 'full' );
	
	if ( isset($image_attributes[0]) ) {
		$url		= $image_attributes[0];
		$width		= $image_attributes[1];
		$height		= $image_attributes[2];
		
		$ImageObject = array (
			'@type' 	=> 'ImageObject',
			'url' 		=> $url,
			'width'		=> $width,
			'height' 	=> $height,
		);
		
		// Add caption
		$caption = wp_get_attachment_caption( $attachment_id );
		If ($caption) { 
			$ImageObject['caption'] = $caption;
		}
	}
	
	// debug
	//echo'<pre>';print_r($image_attributes);echo'</pre>';exit;
	
	return $ImageObject;
}

/**
 * Get property image when set to new custm field
 *
 * @since 1.0.1
 * @return array 
 */
function schema_premium_get_property_image_new_custom_field( $attachment_id = null ) {
	
	global $post;

	if ( ! isset( $post_id ) ) $post_id = $post->ID;
	
	$media = array();
	
	// Get image details
	$image_attributes	= wp_get_attachment_image_src( $attachment_id, 'full' );
	$image_url			= $image_attributes[0];
	$image_width		= ( $image_attributes[1] > 696 ) ? $image_attributes[1] : 696; // Images should be at least 696 pixels wide
	$image_height		= $image_attributes[2];
	
	// Check if there is no image url, width, or height, then return an empy array
	if ( ! isset($image_url) || $image_url == '' ) return $media;

	if ( ! isset($image_width) || $image_width == '' ) return $media;
	if ( ! isset($image_height) || $image_height == '' ) return $media;
	
	$media = array (
		'@type' 	=> 'ImageObject',
		'url' 		=> $image_url,
		'width' 	=> $image_width,
		'height' 	=> $image_height,
	);
	
	// debug
	//echo '<pre>'; print_r($media); echo '</pre>';
	
	return apply_filters( 'schema_premium_filter_property_image', $media );
}

/**
 * Get property images when set to new custm field
 * 
 * Used for schema.org types with multible images
 *
 * @since 1.1.3
 * @return array 
 */
function schema_premium_get_property_images_new_custom_field( $post_id = null, $schema_type  = null) {
	
	global $post;
	
	if ( ! isset($schema_type) )
		return;

	if ( ! isset( $post_id ) ) $post_id = $post->ID;
	
	$media = array();
	
	$count = get_post_meta( get_the_ID(), 'schema_properties_' . $schema_type . '_images', true );
	
	if ( isset( $count ) && $count >= 0 ) {
	
		for( $i=0; $i < $count; $i++ ) {
			
			$step_no = $i + 1;
			
			$attachment_id = get_post_meta( get_the_ID(), 'schema_properties_' . $schema_type . '_images_' . $i . '_image_id', true );

			// Get image details
			$image_attributes	= wp_get_attachment_image_src( $attachment_id, 'full' );
			$media[] 			= $image_attributes[0];
		}
	}

	return apply_filters( 'schema_premium_filter_property_images', $media );
}

/**
 * Validate gravatar by email or id
 *
 * Utility function to check if a gravatar exists for a given email or id
 *
 * @link https://gist.github.com/justinph/5197810
 *
 * @since 1.0.0
 * @param int|string|object $id_or_email A user ID,  email address, or comment object
 * @return bool if the gravatar exists or not
 */
function schema_wp_validate_gravatar( $email ) {

	$hashkey	= md5(strtolower(trim($email)));
	
	$uri 		= 'https://www.gravatar.com/avatar/' . $hashkey;
	$data 		= get_transient($hashkey);
	
	if (false === $data) {
		$response = wp_remote_head($uri);
		if( is_wp_error($response) ) {
			$data = 'not200';
		} else {
			$data = $response['response']['code'];
		}
	    set_transient( $hashkey, $data, $expiration = 60*5);
	}		
	
	if ($data == '200'){
		return true;
	} else {
		return false;
	}
}

/**
 * Get post single category,
 * the first category, to be used as Article section 
 *
 * @param int $post_id The post ID.
 * @since 1.0.0
 */
function schema_wp_get_post_category( $post_id ) {
	
	if ( isset($post_id) ) {
		$post = get_post($post_id);
	} else {
		global $post;
	}
	
	$cats		= get_the_category($post->ID);
	$cat		= !empty($cats) ? $cats : array();
	$category	= (isset($cat[0]->cat_name)) ? $cat[0]->cat_name : '';
   
   return $category;
}
	
/**
 * Get post tags separate by commas,
 * to be used as schema keywords for BlogPosting
 *
 * @param int $post_id The post ID.
 * @since 1.0.0
 */
function schema_wp_get_post_tags( $post_id ) {
	
	if ( isset($post_id) ) {
		$post = get_post($post_id);
	} else {
		global $post;
	}
	
	$tags = '';
	$posttags = get_the_tags($post->ID);
    if ($posttags) {
       $taglist = "";
       foreach($posttags as $tag) {
           $taglist .=  $tag->name . ', '; 
       }
      $tags =  rtrim($taglist, ", ");
   }
   
   return $tags;
}

/**
 * Get supported Article types 
 *
 * @todo Check this function and try to get subtypes within the Article class instead. 
 *
 * @since 1.0.0
 * @return array 
 */
function schema_wp_get_support_article_types() {

	$support_article_types = array( 'Article', 'BlogPosting', 'NewsArticle', 'Report', 'ScholarlyArticle', 'TechArticle', 'AdvertiserContentArticle', 'SatiricalArticle' );
	
	return apply_filters( 'schema_wp_support_article_types', $support_article_types );
}

/**
 * Get types that supports author markup 
 *
 * @since 1.0.1
 * @return array 
 */
function schema_premium_get_types_supports_author() {

	$types = array( 'Review', 'Course', 'Recipe' );
	
	return apply_filters( 'schema_premium_support_author', $types );
}

/**
 * Get address markup 
 *
 * @since 1.2
 * @return array 
 */
function schema_premium_get_address( $properties = array() ) {

	if ( empty($properties) )
		return;

	$address = array();
	
	// Address
	//
	$streetAddress		= isset($properties['streetAddress']) ? $properties['streetAddress'] : '';
	$streetAddress_2 	= isset($properties['streetAddress_2']) ? $properties['streetAddress_2'] : '';
	$streetAddress_3 	= isset($properties['streetAddress_3']) ? $properties['streetAddress_3'] : '';
	$addressLocality	= isset($properties['addressLocality']) ? $properties['addressLocality'] : '';
	$addressRegion 		= isset($properties['addressRegion']) ? $properties['addressRegion'] : '';
	$postalCode 		= isset($properties['postalCode']) ? $properties['postalCode'] : '';
	$addressCountry 	= isset($properties['addressCountry']) ? $properties['addressCountry'] : '';
	
	if ( isset($streetAddress) && $streetAddress != '' 
		|| isset($streetAddress_2) && $streetAddress_2 != '' 
		|| isset($streetAddress_3) && $streetAddress_3 != '' 
		|| isset($postalCode) && $postalCode != '' ) {
		
		$address = array
		(
			'@type' => 'PostalAddress',
			'streetAddress' 	=> $streetAddress . ' ' . $streetAddress_2 . ' ' . $streetAddress_3, // join the 3 address lines
			'addressLocality' 	=> $addressLocality,
			'addressRegion' 	=> $addressRegion,
			'postalCode' 		=> $postalCode,
			'addressCountry' 	=> $addressCountry,		
		);
	}
	
	return apply_filters( 'schema_premium_get_address', $address );
}

/**
 * Get formated time duration coded as PT1H25M
 *
 * @since 1.0.1
 * @return array 
 */
function schema_premium_format_time_to_PT( $time ) {
	
	$timearr = explode( ':', $time );
	
	$hour 	= isset($timearr[0]) ? $timearr[0] . 'H' : '';
	$min 	= isset($timearr[1]) ? $timearr[1] . 'M' : '';
	$sec 	= isset($timearr[2]) ? $timearr[2] . 'S' : '';
	
	$coded_time = 'PT' . $hour . $min . $sec;
	
	return $coded_time;
}

/**
 * Get formated date time duration coded as P1Y6MT10H15M50S (P0003-06-4T1H25M)
 *
 * @since 1.2
 * @return array 
 */
function schema_premium_format_date_time_to_PT( $duration ) {
	
	if ( ! array($duration) )
		return false;

	$year 	= isset($duration['year']) && $duration['year'] != '' ? $duration['year'] . 'Y' : '';
	$month 	= isset($duration['month']) && $duration['month'] != '' ? $duration['month'] . 'M' : '';
	$day 	= isset($duration['day']) && $duration['day'] != '' ? $duration['day'] . 'D' : '';
	$time 	= isset($duration['time']) ? $duration['time'] : '';

	// Deal with time
	//
	$timearr = explode( ':', $time );
	$hour 	= isset($timearr[0]) ? $timearr[0] . 'H' : '';
	$min 	= isset($timearr[1]) ? $timearr[1] . 'M' : '';
	$sec 	= isset($timearr[2]) ? $timearr[2] . 'S' : '';
	
	// Put duration all together
	//
	$coded_time = 'P'. $year . $month . $day . 'T' . $hour . $min . $sec;
	
	return $coded_time;
}

/**
 * Get the Sum of two times
 *
 * @since 1.0.1
 * @return array 
 */
function schema_premium_get_time_sum( $time1, $time2 ) {
	
	$secs = strtotime($time1)-strtotime("00:00:00");
	$sum = date("H:i:s",strtotime($time2)+$secs);
	
	// Debug
	//echo "<pre>";print_r($sum);echo "</pre>"; 
	
	return $sum;
}

/**
 * Get time Seconds in ISO format, used to calculate Video & Audio duration
 *
 * @link http://stackoverflow.com/questions/13301142/php-how-to-convert-string-duration-to-iso-8601-duration-format-ie-30-minute
 * @param string $time
 * @since 1.0.0
 * @return string The time Seconds in ISO format
 */
function schema_wp_get_time_second_to_iso8601_duration( $time ) {
	
	$units = array(
        "Y" => 365*24*3600,
        "D" =>     24*3600,
        "H" =>        3600,
        "M" =>          60,
        "S" =>           1,
    );

    $str = "P";
    $istime = false;

    foreach ($units as $unitName => &$unit) {
        $quot  = intval($time / $unit);
        $time -= $quot * $unit;
        $unit  = $quot;
        if ($unit > 0) {
            if (!$istime && in_array($unitName, array("H", "M", "S"))) { // There may be a better way to do this
                $str .= "T";
                $istime = true;
            }
            $str .= strval($unit) . $unitName;
        }
    }

    return $str;
}

/**
 * Retrieves all the available currencies.
 *
 * @since   1.2
 * @return  array
 */
function schema_wp_get_countries() {
		
	$countries = array
	(
	  "AF" => "Afghanistan",
	  "AL" => "Albania",
	  "DZ" => "Algeria",
	  "AS" => "American Samoa",
	  "AD" => "Andorra",
	  "AO" => "Angola",
	  "AI" => "Anguilla",
	  "AQ" => "Antarctica",
	  "AG" => "Antigua and Barbuda",
	  "AR" => "Argentina",
	  "AM" => "Armenia",
	  "AW" => "Aruba",
	  "AU" => "Australia",
	  "AT" => "Austria",
	  "AZ" => "Azerbaijan",
	  "BS" => "Bahamas",
	  "BH" => "Bahrain",
	  "BD" => "Bangladesh",
	  "BB" => "Barbados",
	  "BY" => "Belarus",
	  "BE" => "Belgium",
	  "BZ" => "Belize",
	  "BJ" => "Benin",
	  "BM" => "Bermuda",
	  "BT" => "Bhutan",
	  "BO" => "Bolivia",
	  "BA" => "Bosnia and Herzegovina",
	  "BW" => "Botswana",
	  "BV" => "Bouvet Island",
	  "BR" => "Brazil",
	  "BQ" => "British Antarctic Territory",
	  "IO" => "British Indian Ocean Territory",
	  "VG" => "British Virgin Islands",
	  "BN" => "Brunei",
	  "BG" => "Bulgaria",
	  "BF" => "Burkina Faso",
	  "BI" => "Burundi",
	  "KH" => "Cambodia",
	  "CM" => "Cameroon",
	  "CA" => "Canada",
	  "CT" => "Canton and Enderbury Islands",
	  "CV" => "Cape Verde",
	  "KY" => "Cayman Islands",
	  "CF" => "Central African Republic",
	  "TD" => "Chad",
	  "CL" => "Chile",
	  "CN" => "China",
	  "CX" => "Christmas Island",
	  "CC" => "Cocos [Keeling] Islands",
	  "CO" => "Colombia",
	  "KM" => "Comoros",
	  "CG" => "Congo - Brazzaville",
	  "CD" => "Congo - Kinshasa",
	  "CK" => "Cook Islands",
	  "CR" => "Costa Rica",
	  "HR" => "Croatia",
	  "CU" => "Cuba",
	  "CY" => "Cyprus",
	  "CZ" => "Czech Republic",
	  "CI" => "Côte d’Ivoire",
	  "DK" => "Denmark",
	  "DJ" => "Djibouti",
	  "DM" => "Dominica",
	  "DO" => "Dominican Republic",
	  "NQ" => "Dronning Maud Land",
	  "DD" => "East Germany",
	  "EC" => "Ecuador",
	  "EG" => "Egypt",
	  "SV" => "El Salvador",
	  "GQ" => "Equatorial Guinea",
	  "ER" => "Eritrea",
	  "EE" => "Estonia",
	  "ET" => "Ethiopia",
	  "FK" => "Falkland Islands",
	  "FO" => "Faroe Islands",
	  "FJ" => "Fiji",
	  "FI" => "Finland",
	  "FR" => "France",
	  "GF" => "French Guiana",
	  "PF" => "French Polynesia",
	  "TF" => "French Southern Territories",
	  "FQ" => "French Southern and Antarctic Territories",
	  "GA" => "Gabon",
	  "GM" => "Gambia",
	  "GE" => "Georgia",
	  "DE" => "Germany",
	  "GH" => "Ghana",
	  "GI" => "Gibraltar",
	  "GR" => "Greece",
	  "GL" => "Greenland",
	  "GD" => "Grenada",
	  "GP" => "Guadeloupe",
	  "GU" => "Guam",
	  "GT" => "Guatemala",
	  "GG" => "Guernsey",
	  "GN" => "Guinea",
	  "GW" => "Guinea-Bissau",
	  "GY" => "Guyana",
	  "HT" => "Haiti",
	  "HM" => "Heard Island and McDonald Islands",
	  "HN" => "Honduras",
	  "HK" => "Hong Kong SAR China",
	  "HU" => "Hungary",
	  "IS" => "Iceland",
	  "IN" => "India",
	  "ID" => "Indonesia",
	  "IR" => "Iran",
	  "IQ" => "Iraq",
	  "IE" => "Ireland",
	  "IM" => "Isle of Man",
	  "IL" => "Israel",
	  "IT" => "Italy",
	  "JM" => "Jamaica",
	  "JP" => "Japan",
	  "JE" => "Jersey",
	  "JT" => "Johnston Island",
	  "JO" => "Jordan",
	  "KZ" => "Kazakhstan",
	  "KE" => "Kenya",
	  "KI" => "Kiribati",
	  "KW" => "Kuwait",
	  "KG" => "Kyrgyzstan",
	  "LA" => "Laos",
	  "LV" => "Latvia",
	  "LB" => "Lebanon",
	  "LS" => "Lesotho",
	  "LR" => "Liberia",
	  "LY" => "Libya",
	  "LI" => "Liechtenstein",
	  "LT" => "Lithuania",
	  "LU" => "Luxembourg",
	  "MO" => "Macau SAR China",
	  "MK" => "Macedonia",
	  "MG" => "Madagascar",
	  "MW" => "Malawi",
	  "MY" => "Malaysia",
	  "MV" => "Maldives",
	  "ML" => "Mali",
	  "MT" => "Malta",
	  "MH" => "Marshall Islands",
	  "MQ" => "Martinique",
	  "MR" => "Mauritania",
	  "MU" => "Mauritius",
	  "YT" => "Mayotte",
	  "FX" => "Metropolitan France",
	  "MX" => "Mexico",
	  "FM" => "Micronesia",
	  "MI" => "Midway Islands",
	  "MD" => "Moldova",
	  "MC" => "Monaco",
	  "MN" => "Mongolia",
	  "ME" => "Montenegro",
	  "MS" => "Montserrat",
	  "MA" => "Morocco",
	  "MZ" => "Mozambique",
	  "MM" => "Myanmar [Burma]",
	  "NA" => "Namibia",
	  "NR" => "Nauru",
	  "NP" => "Nepal",
	  "NL" => "Netherlands",
	  "AN" => "Netherlands Antilles",
	  "NT" => "Neutral Zone",
	  "NC" => "New Caledonia",
	  "NZ" => "New Zealand",
	  "NI" => "Nicaragua",
	  "NE" => "Niger",
	  "NG" => "Nigeria",
	  "NU" => "Niue",
	  "NF" => "Norfolk Island",
	  "KP" => "North Korea",
	  "VD" => "North Vietnam",
	  "MP" => "Northern Mariana Islands",
	  "NO" => "Norway",
	  "OM" => "Oman",
	  "PC" => "Pacific Islands Trust Territory",
	  "PK" => "Pakistan",
	  "PW" => "Palau",
	  "PS" => "Palestinian Territories",
	  "PA" => "Panama",
	  "PZ" => "Panama Canal Zone",
	  "PG" => "Papua New Guinea",
	  "PY" => "Paraguay",
	  "YD" => "People's Democratic Republic of Yemen",
	  "PE" => "Peru",
	  "PH" => "Philippines",
	  "PN" => "Pitcairn Islands",
	  "PL" => "Poland",
	  "PT" => "Portugal",
	  "PR" => "Puerto Rico",
	  "QA" => "Qatar",
	  "RO" => "Romania",
	  "RU" => "Russia",
	  "RW" => "Rwanda",
	  "RE" => "Réunion",
	  "BL" => "Saint Barthélemy",
	  "SH" => "Saint Helena",
	  "KN" => "Saint Kitts and Nevis",
	  "LC" => "Saint Lucia",
	  "MF" => "Saint Martin",
	  "PM" => "Saint Pierre and Miquelon",
	  "VC" => "Saint Vincent and the Grenadines",
	  "WS" => "Samoa",
	  "SM" => "San Marino",
	  "SA" => "Saudi Arabia",
	  "SN" => "Senegal",
	  "RS" => "Serbia",
	  "CS" => "Serbia and Montenegro",
	  "SC" => "Seychelles",
	  "SL" => "Sierra Leone",
	  "SG" => "Singapore",
	  "SK" => "Slovakia",
	  "SI" => "Slovenia",
	  "SB" => "Solomon Islands",
	  "SO" => "Somalia",
	  "ZA" => "South Africa",
	  "GS" => "South Georgia and the South Sandwich Islands",
	  "KR" => "South Korea",
	  "ES" => "Spain",
	  "LK" => "Sri Lanka",
	  "SD" => "Sudan",
	  "SR" => "Suriname",
	  "SJ" => "Svalbard and Jan Mayen",
	  "SZ" => "Swaziland",
	  "SE" => "Sweden",
	  "CH" => "Switzerland",
	  "SY" => "Syria",
	  "ST" => "São Tomé and Príncipe",
	  "TW" => "Taiwan",
	  "TJ" => "Tajikistan",
	  "TZ" => "Tanzania",
	  "TH" => "Thailand",
	  "TL" => "Timor-Leste",
	  "TG" => "Togo",
	  "TK" => "Tokelau",
	  "TO" => "Tonga",
	  "TT" => "Trinidad and Tobago",
	  "TN" => "Tunisia",
	  "TR" => "Turkey",
	  "TM" => "Turkmenistan",
	  "TC" => "Turks and Caicos Islands",
	  "TV" => "Tuvalu",
	  "UM" => "U.S. Minor Outlying Islands",
	  "PU" => "U.S. Miscellaneous Pacific Islands",
	  "VI" => "U.S. Virgin Islands",
	  "UG" => "Uganda",
	  "UA" => "Ukraine",
	  "SU" => "Union of Soviet Socialist Republics",
	  "AE" => "United Arab Emirates",
	  "GB" => "United Kingdom",
	  "US" => "United States",
	  "ZZ" => "Unknown or Invalid Region",
	  "UY" => "Uruguay",
	  "UZ" => "Uzbekistan",
	  "VU" => "Vanuatu",
	  "VA" => "Vatican City",
	  "VE" => "Venezuela",
	  "VN" => "Vietnam",
	  "WK" => "Wake Island",
	  "WF" => "Wallis and Futuna",
	  "EH" => "Western Sahara",
	  "YE" => "Yemen",
	  "ZM" => "Zambia",
	  "ZW" => "Zimbabwe",
	  "AX" => "Åland Islands"
	);				
				
	return $countries;
}

/**
 * Retrieves all the available currencies.
 *
 * @since   1.0.0
 * @return  array
 */
function schema_wp_get_currencies() {
	
	$currencies = array(
		'AUD' => __( 'Australian Dollars', 'schema-premium' ),
		'BDT' => __( 'Bangladeshi Taka', 'schema-premium' ),
		'BRL' => __( 'Brazilian Real', 'schema-premium' ),
		'BGN' => __( 'Bulgarian Lev', 'schema-premium' ),
		'CAD' => __( 'Canadian Dollars', 'schema-premium' ),
		'CLP' => __( 'Chilean Peso', 'schema-premium' ),
		'CNY' => __( 'Chinese Yuan', 'schema-premium' ),
		'COP' => __( 'Colombian Peso', 'schema-premium' ),
		'CZK' => __( 'Czech Koruna', 'schema-premium' ),
		'DKK' => __( 'Danish Krone', 'schema-premium' ),
		'DOP' => __( 'Dominican Peso', 'schema-premium' ),
		'EUR' => __( 'Euros', 'schema-premium' ),
		'HKD' => __( 'Hong Kong Dollar', 'schema-premium' ),
		'HRK' => __( 'Croatia kuna', 'schema-premium' ),
		'HUF' => __( 'Hungarian Forint', 'schema-premium' ),
		'ISK' => __( 'Icelandic krona', 'schema-premium' ),
		'IDR' => __( 'Indonesia Rupiah', 'schema-premium' ),
		'INR' => __( 'Indian Rupee', 'schema-premium' ),
		'NPR' => __( 'Nepali Rupee', 'schema-premium' ),
		'ILS' => __( 'Israeli Shekel', 'schema-premium' ),
		'JPY' => __( 'Japanese Yen', 'schema-premium' ),
		'KIP' => __( 'Lao Kip', 'schema-premium' ),
		'KRW' => __( 'South Korean Won', 'schema-premium' ),
		'MYR' => __( 'Malaysian Ringgits', 'schema-premium' ),
		'MXN' => __( 'Mexican Peso', 'schema-premium' ),
		'NGN' => __( 'Nigerian Naira', 'schema-premium' ),
		'NOK' => __( 'Norwegian Krone', 'schema-premium' ),
		'NZD' => __( 'New Zealand Dollar', 'schema-premium' ),
		'PYG' => __( 'Paraguayan Guaraní', 'schema-premium' ),
		'PHP' => __( 'Philippine Pesos', 'schema-premium' ),
		'PLN' => __( 'Polish Zloty', 'schema-premium' ),
		'GBP' => __( 'Pounds Sterling', 'schema-premium' ),
		'RON' => __( 'Romanian Leu', 'schema-premium' ),
		'RUB' => __( 'Russian Ruble', 'schema-premium' ),
		'SGD' => __( 'Singapore Dollar', 'schema-premium' ),
		'ZAR' => __( 'South African rand', 'schema-premium' ),
		'SEK' => __( 'Swedish Krona', 'schema-premium' ),
		'CHF' => __( 'Swiss Franc', 'schema-premium' ),
		'TWD' => __( 'Taiwan New Dollars', 'schema-premium' ),
		'THB' => __( 'Thai Baht', 'schema-premium' ),
		'TRY' => __( 'Turkish Lira', 'schema-premium' ),
		'USD' => __( 'US Dollars', 'schema-premium' ),
		'VND' => __( 'Vietnamese Dong', 'schema-premium' ),
		'EGP' => __( 'Egyptian Pound', 'schema-premium' ),
	);

	return apply_filters( 'schema_wp_currencies', $currencies );
}

/**
 * Retrieves symbol of the given currency.
 *
 * @since 1.0.0
 *
 * @param string $currency Currency code.
 *
 * @return string $currency_symbol Currency symbol.
 */
function schema_wp_get_currency_symbol( $currency ) {
	switch ( $currency ) {
		case 'BDT':
			$currency_symbol = '&#2547;&nbsp;';
			break;
		case 'BRL' :
			$currency_symbol = '&#82;&#36;';
			break;
		case 'BGN' :
			$currency_symbol = '&#1083;&#1074;.';
			break;
		case 'AUD' :
		case 'CAD' :
		case 'CLP' :
		case 'COP' :
		case 'MXN' :
		case 'NZD' :
		case 'HKD' :
		case 'SGD' :
		case 'USD' :
			$currency_symbol = '&#36;';
			break;
		case 'EUR' :
			$currency_symbol = '&euro;';
			break;
		case 'CNY' :
		case 'RMB' :
		case 'JPY' :
			$currency_symbol = '&yen;';
			break;
		case 'RUB' :
			$currency_symbol = '&#1088;&#1091;&#1073;.';
			break;
		case 'KRW' :
			$currency_symbol = '&#8361;';
			break;
		case 'PYG' :
			$currency_symbol = '&#8370;';
			break;
		case 'TRY' :
			$currency_symbol = '&#8378;';
			break;
		case 'NOK' :
			$currency_symbol = '&#107;&#114;';
			break;
		case 'ZAR' :
			$currency_symbol = '&#82;';
			break;
		case 'CZK' :
			$currency_symbol = '&#75;&#269;';
			break;
		case 'MYR' :
			$currency_symbol = '&#82;&#77;';
			break;
		case 'DKK' :
			$currency_symbol = 'kr.';
			break;
		case 'HUF' :
			$currency_symbol = '&#70;&#116;';
			break;
		case 'IDR' :
			$currency_symbol = 'Rp';
			break;
		case 'INR' :
			$currency_symbol = '&#8377;';
			break;
		case 'NPR' :
			$currency_symbol = 'Rs.';
			break;
		case 'ISK' :
			$currency_symbol = 'Kr.';
			break;
		case 'ILS' :
			$currency_symbol = '&#8362;';
			break;
		case 'PHP' :
			$currency_symbol = '&#8369;';
			break;
		case 'PLN' :
			$currency_symbol = '&#122;&#322;';
			break;
		case 'SEK' :
			$currency_symbol = '&#107;&#114;';
			break;
		case 'CHF' :
			$currency_symbol = '&#67;&#72;&#70;';
			break;
		case 'TWD' :
			$currency_symbol = '&#78;&#84;&#36;';
			break;
		case 'THB' :
			$currency_symbol = '&#3647;';
			break;
		case 'GBP' :
			$currency_symbol = '&pound;';
			break;
		case 'RON' :
			$currency_symbol = 'lei';
			break;
		case 'VND' :
			$currency_symbol = '&#8363;';
			break;
		case 'NGN' :
			$currency_symbol = '&#8358;';
			break;
		case 'HRK' :
			$currency_symbol = 'Kn';
			break;
		case 'EGP' :
			$currency_symbol = 'EGP';
			break;
		case 'DOP' :
			$currency_symbol = 'RD&#36;';
			break;
		case 'KIP' :
			$currency_symbol = '&#8365;';
			break;
		default    :
			$currency_symbol = $currency;
			break;
	}

	return apply_filters( 'schema_wp_currency_symbol', $currency_symbol, $currency );
}

/**
 * Get archive link
 *
 * @param string $post_type for custom post type
 * @since 1.0.0
 * @return string
 */
function schema_premium_get_archive_link( $post_type ) {
	
	global $wp_post_types;
	
	$archive_link 	= false;
	$slug 			= '';
	
	if ( ! isset($post_type) || ! isset($wp_post_types) || empty($wp_post_types) )
		return false;

	// debug
	//echo'<pre>';print_r($wp_post_types);echo'</pre>';exit;

	if ( isset($wp_post_types[$post_type]) ) {
		
		$wp_post_type = $wp_post_types[$post_type];
		
		if ($wp_post_type->publicly_queryable)
			if ( $wp_post_type->has_archive && $wp_post_type->has_archive !== true )
				$slug = $wp_post_type->has_archive;
			else if (isset($wp_post_type->rewrite['slug']))
				$slug = $wp_post_type->rewrite['slug'];
			else
				$slug = $post_type;
			$archive_link = get_option( 'siteurl' ) . "/{$slug}/";
	}

	return apply_filters( 'schema_wp_archive_link', $archive_link, $post_type );
}

/**
 * Get blog posts page URL.
 *
 * @source https://gist.github.com/kellenmace/9ef19dd86580cb7e63720b396c8c2721
 * @since 1.0.0
 * @return string The blog posts page URL.
 */
function schema_wp_get_blog_posts_page_url() {
	// If front page is set to display a static page, get the URL of the posts page.
	if ( 'page' === get_option( 'show_on_front' ) ) {
		return get_permalink( get_option( 'page_for_posts' ) );
	}
	// The front page IS the posts page. Get its URL.
	return get_home_url();
}

/**
 * Check if is Blog page
 *
 * @since 1.0.0
 * @return true or false
 */
function schema_wp_is_blog() {
	
	// Return true if is Blog (post list page)
	if ( ! is_front_page() && is_home() || is_home() ) {
		return true;
	}
	
	return false;
}

/**
 * Truncate a string of content to 110 characters, respecting full words.
 *
 * @since 1.0.1
 * @return string
 */
function schema_premium_get_truncate_to_word( $string, $limit = 110, $end = ' ...') {
	
	$limit 	= apply_filters( 'schema_premium_truncate_title_to_word_limit', $limit );
	
	if ( strlen($string) > $limit ) {
		$limit 	= $limit - strlen($end); // Take into account $end string into the limit
		$string = substr($string, 0, $limit);
		$string = substr($string, 0, strrpos($string, ' ')) . $end;
	}
	
	return $string;
}

/**
 * Get category slug by category id
 *
 * @since 1.0.3
 * @return array 
 */
function schema_premium_get_cat_slug_by_id( $cat_id ) {
	
	$cat_id 	= (int) $cat_id;
	$category 	= get_category($cat_id);
	
	if ( ! empty($category) )
		return $category->slug;
}

/**
 * Checks if the current post type has an archive.
 *
 * Context: The has_archive value can be a string or a boolean. In most case it will be a boolean,
 * but it can be defined as a string. When it is a string the archive_slug will be overwritten to
 * define another endpoint.
 *
 * @since 1.0.6
 *
 * @param WP_Post_Type $post_type The post type object.
 * @return bool True whether the post type has an archive.
 */
function schema_premium_post_type_has_archive( $post_type ) {
	return ( ! empty( $post_type->has_archive ) );
}

/**
 * Get class selectors for the cssSelector property
 *
 * @since 1.1.2
 * @return array 
 */
function schema_premium_get_property_cssSelector( $schema_type ) {
			
	global $post;
	
	$output = array();
	
	$count = get_post_meta( get_the_ID(), 'schema_properties_'. $schema_type . '_cssSelector', true );
	
	if ( isset( $count ) && $count >= 0 ) {
	
		for( $i=0; $i < $count; $i++ ) {
			
			$step_no = $i + 1;
			
			$name = get_post_meta( get_the_ID(), 'schema_properties_'. $schema_type . '_cssSelector_' . $i . '_cssSelector_name', true );
			
			$output[] = array(
						'@type' 				=> 'WebPageElement',
						'isAccessibleForFree' 	=> 'False',
						'cssSelector' 			=> strip_tags($name)
					);	
		}
	}
	
	return $output;
}

/**
 * Get fixed value of class selectors for the cssSelector property
 *
 * @since 1.1.4.3
 * @return array 
 */
function schema_premium_get_property_cssSelector_fixed( $properties_cssSelector ) {
	
	$output = array(
		'@type' 				=> 'WebPageElement',
		'isAccessibleForFree' 	=> 'False',
		'cssSelector' 			=> strip_tags($properties_cssSelector['cssSelector_name'])
	);	
	
	return $output;
}
		

if ( ! function_exists('schema_premium_rating_star') ) :
/**
 * Output a HTML element with a star rating for a given rating.
 *
 * Outputs a HTML element with the star rating exposed on a 0..5 scale in
 * half star increments (ie. 1, 1.5, 2 stars). Optionally, if specified, the
 * number of ratings may also be displayed by passing the $number parameter.
 *
 * @since 1.0.6
 *
 * @param array $args {
 *     Optional. Array of star ratings arguments.
 *
 *     @type int    $rating The rating to display, expressed in either a 0.5 rating increment,
 *                          or percentage. Default 0.
 *     @type string $type   Format that the $rating is in. Valid values are 'rating' (default),
 *                          or, 'percent'. Default 'rating'.
 *     @type int    $number The number of ratings that makes up this rating. Default 0.
 *     @type bool   $echo   Whether to echo the generated markup. False to return the markup instead
 *                          of echoing it. Default true.
 * }
 */
function schema_premium_rating_star( $args = array() ) {
	
	global $post;
	
	$defaults = array(
		'id'	 => $post->ID,
		'type'   => 'rating',
		'rating' => 0,
		'number' => 0,
		'scale'	 => 0,
		'text'   => true,
		'echo'   => true,
		'class'	 => ''
	);
	
	$r = wp_parse_args( $args, $defaults );

	// Non-english decimal places when the $rating is coming from a string
	$rating = str_replace( ',', '.', $r['rating'] );

	$scale = ( $r['scale'] && $r['scale'] != false ) ? $r['scale'] : 5; // default

	$class = ( $r['class'] && $r['class'] != '' ) ? $r['class'] : ''; // default
	
	// Convert Percentage to star rating, 0..5 in .5 increments
	if ( 'percent' == $r['type'] ) {
		$rating = round( $rating / 10, 0 ) / 2;
	}

	// Calculate the number of each type of star needed
	$full_stars = floor( $rating );
	$half_stars = ceil( $rating - $full_stars );
	$empty_stars = max( ($scale - $full_stars - $half_stars) , 0);
	
	if ( $r['number'] ) {
		/* translators: 1: The rating, 2: The number of ratings */
		$format = _n( '%1$s rating based on %2$s rating', '%1$s rating based on %2$s ratings', $r['number'] );
		$title = sprintf( $format, number_format_i18n( $rating, 1 ), number_format_i18n( $r['number'] ) );
	} else {
		/* translators: 1: The rating/scale */
		$title = sprintf( __( '%s<span class="schema-rating-scale">/'.$scale .'</span>' ), number_format_i18n( $rating, 1 ) );
	}

	$output = '<span class="star-rating ' . $class . '">';
	$output .= str_repeat( '<span class="star star-full"></span>', $full_stars );
	$output .= str_repeat( '<span class="star star-half"></span>', $half_stars );
	$output .= str_repeat( '<span class="star star-empty"></span>', $empty_stars );
	
	if ( $r['text'] ) {
		$output .= '<span class="schema-screen-reader-text">' . $title . '</span>';
	}
	
	$output .= '</span>';
	
	if ( $rating > $scale ) {
		$output = '<span class="schema-rating-notice">';
		$output .= '<span class="dashicons dashicons-warning"></span> ' . __('Rating can not be larger than Scale!', 'schema-premium');
		$output .= '</span>';
	}
	
	if ( $r['echo'] ) {
		echo $output;
	}

	return $output;
}
endif;

add_action( 'acf/init', 'schema_wp_acf_front_rating_stars' );
/**
 * Meta Box
 *
 * @since 1.0.x
 */
function schema_wp_acf_front_rating_stars() {

	if( function_exists('acf_add_local_field_group') ):

		// ACF Field: Star Rating
		//
		//
		acf_add_local_field(array(
		'key' => 'schema_front_star_rating',
		'name' => 'schema_front_star_rating',
		'type' => 'star_rating',
		'wrapper' => array (
				'width' => '50',
			),
		'max_stars' => 5,
		'return_type' => 'num',
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
		'default_value' => '',
		'required' => 0,
		'multiple' => 0,
		'other_choice' => 0,
		'save_other_choice' => 0,
		'layout' => 'horizontal'
	) );
		
	endif;
}

/**
 * Check if url is external
 *
 * @since 1.1.2.4
 * @return string, or false when url is external 
 */
function schema_premium_isexternal( $url ) {
	$components = parse_url($url);
	$domain = str_ireplace('www.', '', parse_url( get_site_url(), PHP_URL_HOST));
	if ( empty($components['host']) ) return false;  // we will treat url like '/relative.php' as relative
	if ( strcasecmp($components['host'], $domain) === 0 ) return false; // url host looks exactly like the local host
	return strrpos(strtolower($components['host']), '.'.$domain) !== strlen($components['host']) - strlen('.'.$domain); // check if the url host is a subdomain
}

/**
 * Get patern for shortcodes
 * 
 * @source https://stackoverflow.com/questions/32523265/extract-shortcode-parameters-in-content-wordpress/32525101#32525101
 * @param string $text
 * @since 1.1.2.8
 * @return string 
 */
function schema_premium_get_pattern( $text ) {
    $pattern = get_shortcode_regex();
    preg_match_all( "/$pattern/s", $text, $c );
    return $c;
}

/**
 * Parse attributes
 * 
 * @param string $content
 * @since 1.1.2.8
 * @return array 
 */
function schema_premium_parse_atts( $content ) {
    $content = preg_match_all( '/([^ ]*)=(\'([^\']*)\'|\"([^\"]*)\"|([^ ]*))/', trim( $content ), $c );
    list( $dummy, $keys, $values ) = array_values( $c );
    $c = array();
    foreach ( $keys as $key => $value ) {
        $value = trim( $values[ $key ], "\"'" );
        $type = is_numeric( $value ) ? 'int' : 'string';
        $type = in_array( strtolower( $value ), array( 'true', 'false' ) ) ? 'bool' : $type;
        switch ( $type ) {
            case 'int': $value = (int) $value; break;
            case 'bool': $value = strtolower( $value ) == 'true'; break;
        }
        $c[ $keys[ $key ] ] = $value;
    }
    return $c;
}

/**
 * Get shortcodes 
 * 
 * @since 1.1.2.8
 * @return array 
 */
function schema_premium_get_shortcodes( &$output, $text, $child = false ) {

    $patts = schema_premium_get_pattern( $text );
    $t = array_filter( schema_premium_get_pattern( $text ) );
    if ( ! empty( $t ) ) {
        list( $d, $d, $parents, $atts, $d, $contents ) = $patts;
        $out2 = array();
        $n = 0;
        foreach( $parents as $k=>$parent ) {
            ++$n;
            $name = $child ? 'child' . $n : $n;
            $t = array_filter( schema_premium_get_pattern( $contents[ $k ] ) );
            $t_s = schema_premium_get_shortcodes( $out2, $contents[ $k ], true );
            $output[ $name ] = array( 'name' => $parents[ $k ] );
            $output[ $name ]['atts'] = schema_premium_parse_atts( $atts[ $k ] );
            $output[ $name ]['original_content'] = $contents[ $k ];
            $output[ $name ]['content'] = ! empty( $t ) && ! empty( $t_s ) ? $t_s : $contents[ $k ];
        }
    }
    return array_values( $output );
}
