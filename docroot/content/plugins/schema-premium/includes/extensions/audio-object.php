<?php
/**
 *  AudioObject extention
 *
 *  Adds schema AudioObject to oEmbed
 *
 *  @since 1.0.0
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'acf/init', 'schema_premium_acf_meta_audio_object' );
/**
 * AudioObject - ACF Meta Box
 *
 * @since 1.0.0
 */
function schema_premium_acf_meta_audio_object() {
		
	$audio_object_setting_enable = schema_wp_get_option( 'audio_object_enable' );

	if ( $audio_object_setting_enable != true )
		return;
		
	if( function_exists('acf_add_local_field_group') ):
		
		// Get setting for display instructions
		$properties_instructions_enable = schema_wp_get_option( 'properties_instructions_enable' );
			
		// ACF Group: VideoObject
		//
		//
		acf_add_local_field_group(array (
			'key' => 'group_schema_AudioObject',
			'title' => __('Audio Object', 'schema-premium'),
			'location' => array (
				array (
					array (	 // custom location
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'schema'
					),
				),
			),
			'menu_order' => 40,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'left',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => 1,
			'description' => '',
		));
				
		// ACF Field: AudioObject
		// 
		//
		acf_add_local_field(array(
			'key' 		=> 'feild_schema_AudioObject',
			'label' 	=> __('Audio Markups', 'schema-premium'),
			'name' 		=> 'schema_AudioObject',
			'type' 		=> 'radio',
			'parent' 	=> 'group_schema_AudioObject',
			'choices' => array(
				'none'		=> __('None', 'schema-premium'),
				'single'	=> __('Single audio', 'schema-premium'),
				'multiple'	=> __('Multiple audios', 'schema-premium'),
			),
			'default_value' => '',
			'placeholder' => 'https://',
			'instructions'	=> $properties_instructions_enable == 'yes' ? __('Add Structured Data for embedded audio when using <a href="https://codex.wordpress.org/Embeds" target="_blank">oEmbed</a> method.', 'schema-premium') : '', 
			'layout' => 'horizontal',
		));
		
		// ACF Field: Info Message
		// 
		//
		if ($properties_instructions_enable == 'yes' ) {
			acf_add_local_field(array(
				'key' => 'field_schema_AudioObject_info',
				'name' => 'schema_AudioObject_info',
				'label' => '<span></span>',
				'instructions'	=> '', 
				'message'	=>  __('Note: You can enable markups to multiple audios on the same page. However, this may slow down your site, make sure your site is hosted on a reliable web host and cache your site pages by a good caching plugin. (Recommended setting: Single Audio)', 'schema-premium'), 
				'type' => 'message',
				'parent' => 'group_schema_AudioObject',
				'wrapper' => array (
					'width' => '50',
				)
			));
		}
		
	endif;
}

add_filter( 'schema_single_item_output', 'schema_premium_audio_object_output' );
//add_filter( 'schema_output', 'schema_premium_audio_object_output' );
//add_filter( 'schema_output_blog_post', 'schema_premium_audio_object_output' );
//add_filter( 'schema_output_blog_single_ListItem', 'schema_premium_audio_object_output' );
/**
 * Audio object output, filter the schema_single_item_output
 *
 * @param array $schema
 * @since 1.0.0
 * @return array $schema 
 */
function schema_premium_audio_object_output( $schema ) {
	
	// Debug - start of script
	//$time_start = microtime(true); 
	
	if ( empty($schema) ) return;
	
	$audio_object_setting_enable = schema_wp_get_option( 'audio_object_enable' );
	
	if ( $audio_object_setting_enable != true )
		return $schema;
			
	global $wp_query, $post, $wp_embed;
	
	// Maybe this is not needed!
	// Or maybe it's needed, to make sure audio markup included only on main query (Not Sure!)
	if ( ! $wp_query->is_main_query() ) return $schema;
	
	$locations_match = schema_premium_get_location_target_match( $post->ID );
	
	if ( ! is_array($locations_match) || empty($locations_match) ) return $schema;

	// Make sure WP_oEmbed class is loaded
	if ( ! class_exists('WP_oEmbed') ) {
    	require_once( ABSPATH . WPINC . '/class-oembed.php' );
	}
	
	foreach ( $locations_match as $schema_id => $location ) {
		
		if ( $location['match'] ) {
			$audio_object_type = get_post_meta( $schema_id, 'schema_AudioObject', true );
			// Check and add audio markup only on enabled schema.org types
			if ( isset($audio_object_type) && $location['schema_type'] == $schema['@type'] ) {
				switch ( $audio_object_type ) {
					case 'single' :
						$audio_markup = schema_premium_get_audio_object_markup_single( $post->ID );
						break;
					case 'multiple' :
						$audio_markup = schema_premium_get_audio_object_markup_multiple( $post->ID );
						break;
				}
			}
			
			if ( ! empty($audio_markup)) {
				$schema['audio'] = $audio_markup;
			}
		}
	}
	
	// Debug
	/*if (current_user_can( 'manage_options' )) {
			echo'<pre>'; print_r( $schema ); echo'</pre>';
			exit;
			echo 'Execution time in seconds: ' . (microtime(true) - $time_start) . '<br>';
	}
	*/
	
	// finally!
	return $schema;
}

/**
 * Get single audio object markup 
 *
 * @param string $post_id
 * @since 1.0.0
 * @return array 
 */
function schema_premium_get_audio_object_markup_single( $post_id ) {
	
	// Get content
	$post_object 	= get_post( $post_id );
	$content 		= $post_object->post_content;
	$audio_markup 	= array();
	// Exctract urls from content
	$matches = wp_extract_urls( $content );
		
	if ( empty($matches) ) return;
	
	// Find and get the first audio
	foreach ( $matches as $key => $url ) {
		$domain = str_ireplace('www.', '', parse_url($url, PHP_URL_HOST));
		$supported_domains	= array ( 'soundcloud.com', 'mixcloud.com', 'spotify.com' );
		if ( in_array( $domain, $supported_domains) ) {
			break;
		}
	}
		
	$autoembed = new WP_oEmbed();
	$url = trim($url); // remove white spaces if any
	$provider = $autoembed->discover( $url );
	if (filter_var($provider, FILTER_VALIDATE_URL) != FALSE) {
		$data = $autoembed->fetch( $provider, $url );
		if (!empty($data) ) {
			$data->url = $url; // Add audio url to our array
			$audio_markup = schema_premium_get_audio_object_array( $data );
		}
	}
	
	return $audio_markup;
}

/**
 * Get multiple audio object markups
 *
 * @param string $post_id
 * @since 1.0.0
 * @return array 
 */
function schema_premium_get_audio_object_markup_multiple( $post_id ) {
	
	// Get content
	$post_object = get_post( $post_id );
	$content = $post_object->post_content;
		
	// Get them all
	//$reg = preg_match_all( $regex, $content, $matches );
	// Or we can use this
	$matches = wp_extract_urls( $content );
			
	if ( empty($matches) ) return;
	
	$audio_markup = array();
		
	//$matches = schema_wp_get_string_urls($content);
	$autoembed = new WP_oEmbed();
	$audio_markup = array();
	foreach ( $matches as $key => $url ) {
		$url = trim($url); // remove white spaces if any
		$provider = $autoembed->discover( $url );
		if (filter_var($provider, FILTER_VALIDATE_URL) != FALSE) {
			$data = $autoembed->fetch( $provider, $url );
			if (!empty($data) ) {
				$data->url = $url; // Add audio url to our array
				$audio_markup[] = schema_premium_get_audio_object_array( $data );
			}
		}
	}
	
	return $audio_markup;
}

/**
 * Get audio object array 
 *
 * @param array $data
 * @since 1.0.0
 * @return array 
 */
function schema_premium_get_audio_object_array( $data ) {
	
	global $post;
	
	//echo'<pre>'; print_r( $data ); echo'</pre>'; //exit;
	
	$audio_id		= '';		
	$name			= '';
	$description	= '';
	$image			= '';
	$thumbnail_url	= '';
	$upload_date	= '';		
	$duration 		= '';
			
	$host 				= isset($data->provider_name) ? $data->provider_name : '';
	$supported_hosts	= array ( 'SoundCloud', 'Mixcloud', 'Spotify' ); // Spotify not tested!
	
	if ( ! in_array( $host, $supported_hosts) ) return;
	
	// Get values from post meta
	$meta_name			= get_post_meta( $post->ID, '_schema_audio_object_name', true );
	$meta_description	= get_post_meta( $post->ID, '_schema_audio_object_description', true );
	$meta_upload_date	= get_post_meta( $post->ID, '_schema_audio_object_upload_date', true );
	$meta_duration		= get_post_meta( $post->ID, '_schema_audio_object_duration', true );
	
	// Override values if found via parsing the data
	$audio_id		= isset($data->audio_id) ? $data->audio_id : '';
	$name			= isset($data->title) ? $data->title : $meta_name;
	$description	= isset($data->description) ? $data->description : $meta_description;
	$image			= isset($data->image) ? $data->image : '';
	$thumbnail_url	= isset($data->thumbnail_url) ? $data->thumbnail_url : '';
	$upload_date	= isset($data->upload_date) ? $data->upload_date : $meta_upload_date;
	$duration		= isset($data->duration) ? schema_wp_get_time_second_to_iso8601_duration( $data->duration ) : $meta_duration;
	
	$audio_schema = array( 
						'@type'			=> 'AudioObject',
						"name"			=> $name,
						"description"	=> $description,
						"image"			=> $image,
						"thumbnailUrl"	=> $thumbnail_url,
						'uploadDate'	=> $upload_date,
						"duration"		=> $duration
					);
	
	//echo'<pre>'; print_r( $audio_schema ); echo'</pre>'; //exit;
					
	return $audio_schema;
}
