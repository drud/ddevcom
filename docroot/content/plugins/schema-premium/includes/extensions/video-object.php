<?php
/**
 *  VideoObject extention
 *
 *  Adds schema VideoObject to oEmbed
 *
 *  @since 1.0.0
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'acf/init', 'schema_premium_acf_meta_video_object' );
/**
 * VideoObject - ACF Meta Box
 *
 * @since 1.0.0
 */
function schema_premium_acf_meta_video_object() {
		
	$video_object_setting_enable = schema_wp_get_option( 'video_object_enable' );

	if ( $video_object_setting_enable != true )
		return;
		
	if( function_exists('acf_add_local_field_group') ):
		
		// Get setting for display instructions
		$properties_instructions_enable = schema_wp_get_option( 'properties_instructions_enable' );
			
		// ACF Group: VideoObject
		//
		//
		acf_add_local_field_group(array (
			'key' => 'group_schema_VideoObject',
			'title' => __('Video Object', 'schema-premium'),
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
				
		// ACF Field: VideoObject
		// 
		//
		acf_add_local_field(array(
			'key' 		=> 'feild_schema_VideoObject',
			'label' 	=> __('Video Markups', 'schema-premium'),
			'name' 		=> 'schema_VideoObject',
			'type' 		=> 'radio',
			'parent' 	=> 'group_schema_VideoObject',
			'choices' => array(
				'none'		=> __('None', 'schema-premium'),
				'single'	=> __('Single video', 'schema-premium'),
				'multiple'	=> __('Multiple videos', 'schema-premium'),
			),
			'default_value' => '',
			'placeholder' => 'https://',
			'instructions'	=> $properties_instructions_enable == 'yes' ? __('Add Structured Data for embedded videos when using <a href="https://codex.wordpress.org/Embeds" target="_blank">oEmbed</a> method.', 'schema-premium') : '', 
			'layout' => 'horizontal',
		));
		
		// ACF Field: Info Message
		// 
		//
		if ($properties_instructions_enable == 'yes' ) {
			acf_add_local_field(array(
				'key' => 'field_schema_VideoObject_info',
				'name' => 'schema_VideoObject_info',
				'label' => '<span></span>',
				'instructions'	=> '', 
				'message'	=>  __('Note: You can enable markups to multiple videos on the same page. However, this may slow down your site, make sure your site is hosted on a reliable web host and cache your site pages by a good caching plugin. (Recommended setting: Single Video)', 'schema-premium'), 
				'type' => 'message',
				'parent' => 'group_schema_VideoObject',
				'wrapper' => array (
					'width' => '50',
				)
			));
		}
		
	endif;
}

add_filter( 'schema_single_item_output', 'schema_premium_video_object_output' );
//add_filter( 'schema_output', 'schema_wp_video_object_output' );
//add_filter( 'schema_output_blog_post', 'schema_wp_video_object_output' );
//add_filter( 'schema_output_blog_single_ListItem', 'schema_wp_video_object_output' );
/**
 * Video object output, filter the schema_single_item_output
 *
 * @param array $schema
 * @since 1.0.0
 * @return array $schema 
 */
function schema_premium_video_object_output( $schema ) {
	
	// Debug - start of script
	//$time_start = microtime(true); 
	
	if ( empty($schema) ) return;
	
	$video_object_setting_enable = schema_wp_get_option( 'video_object_enable' );
	
	if ( $video_object_setting_enable != true )
		return $schema;
			
	global $wp_query, $post, $wp_embed;
	
	// Maybe this is not needed!
	// Or maybe it's needed to make sure video markup included only on main query (Not Sure!)
	if ( ! $wp_query->is_main_query() ) return $schema;
	
	$locations_match = schema_premium_get_location_target_match( $post->ID );
	
    if ( ! is_array($locations_match) ) return $schema;
    
	// Make sure WP_oEmbed class is loaded
	if ( ! class_exists('WP_oEmbed') ) {
    	require_once( ABSPATH . WPINC . '/class-oembed.php' );
	}
	
	foreach ( $locations_match as $schema_id => $location ) {
		
		if ( $location['match'] ) {
			$video_object_type = get_post_meta( $schema_id, 'schema_VideoObject', true );
			// Check and add video markup only on enabled schema.org types
			if ( isset($video_object_type) && $location['schema_type'] == $schema['@type'] ) {
				switch ( $video_object_type ) {
					case 'single' :
						$video_markup = schema_premium_get_video_object_markup_single( $post->ID );
						break;
					case 'multiple' :
						$video_markup = schema_premium_get_video_object_markup_multiple( $post->ID );
						break;
				}
			}
			
			if ( ! empty($video_markup) ) {
				$schema['video'] = $video_markup;
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
 * Get single video object markup 
 *
 * @param string $post_id
 * @since 1.0.0
 * @return array 
 */
function schema_premium_get_video_object_markup_single( $post_id ) {
	
	// Get content
	$post_object 	= get_post( $post_id );
	$content 		= $post_object->post_content;
	$video_markup 	= array();
	// Exctract urls from content
	$matches = wp_extract_urls( $content );
		
	if ( empty($matches) ) return;
	
	// Find and get the first video
	foreach ( $matches as $key => $url ) {
		$domain = str_ireplace('www.', '', parse_url($url, PHP_URL_HOST));
		$supported_domains	= array ( 'ted.com', 'vimeo.com', 'dailymotion.com', 'videopress.com', 'vine.com', 'youtube.com' );
		if ( in_array( $domain, $supported_domains) ) {
			break;
		}
	}
	
	$autoembed = new WP_oEmbed();
	$url = trim($url); // remove white spaces if any
	$provider = $autoembed->discover( $url );
	if (filter_var($provider, FILTER_VALIDATE_URL) != FALSE) {
		$data = $autoembed->fetch( $provider, $url );
		if ( !empty($data) ) {
			$data->url = $url; // Add video url to our array
			$video_markup = schema_premium_get_video_object_array( $data );
		}
	}
	
	return $video_markup;
}

/**
 * Get multiple video object markups
 *
 * @param string $post_id
 * @since 1.0.0
 * @return array 
 */
function schema_premium_get_video_object_markup_multiple( $post_id ) {
	
	// Get content
	$post_object = get_post( $post_id );
	$content = $post_object->post_content;
		
	// Get them all
	//$reg = preg_match_all( $regex, $content, $matches );
	// Or we can use this
	$matches = wp_extract_urls( $content );
		
	if ( empty($matches) ) return;
	
	$video_markup = array();
		
	//$matches = schema_wp_get_string_urls($content);
	$autoembed = new WP_oEmbed();
	$video_markup = array();
	foreach ( $matches as $key => $url ) {
		$url = trim($url); // remove white spaces if any
		$provider = $autoembed->discover( $url );
		if (filter_var($provider, FILTER_VALIDATE_URL) != FALSE) {
			$data = $autoembed->fetch( $provider, $url );
			if ( !empty($data) ) {
				// Add video url to our array
				$data->url = $url; 
				// Get video object array
				$video_object_array = schema_premium_get_video_object_array( $data );
				if ($video_object_array) {
					$video_markup[] = $video_object_array;
				}
			}
		}
	}
	
	return $video_markup;
}

/**
 * Get video object array 
 *
 * @param array $data
 * @since 1.0.0
 * @return array 
 */
function schema_premium_get_video_object_array( $data ) {
	
	global $post;
	
	//echo'<pre>'; print_r( $data ); echo'</pre>'; //exit;
	
	$video_id		= '';		
	$name			= '';
	$description	= '';
	$thumbnail_url	= '';
	$upload_date	= '';		
	$duration 		= '';
	
	$youtube_id  	= '';
				
	$host 				= isset($data->provider_name) ? $data->provider_name : '';
	$supported_hosts	= array ( 'TED', 'Vimeo', 'Dailymotion', 'VideoPress', 'Vine', 'YouTube' );
	
	
	if ( ! in_array( $host, $supported_hosts) ) return false;
	
	//echo'<pre>';print_r($data);echo'</pre>'; // exit;
	
	// Get values from post meta
	$meta_name			= get_post_meta( $post->ID, '_schema_video_object_name', true );
	$meta_description	= get_post_meta( $post->ID, '_schema_video_object_description', true );
	$meta_upload_date	= get_post_meta( $post->ID, '_schema_video_object_upload_date', true );
	$meta_duration		= get_post_meta( $post->ID, '_schema_video_object_duration', true );
	
	if ( $host == 'YouTube' ) { // If host is YouTube
		// Call our YouTube class
		$youtube = new Schema_Premium_YouTube();
		// Get video ID
		parse_str( parse_url( $data->url, PHP_URL_QUERY ), $youtube_id );
		// Get video data; 
		$data = isset($youtube_id['v']) ? $youtube->get_video_info($youtube_id['v']) : array();
		
		if ( !empty($data) ) {
			// Override values if found via parsing the data
			$video_id		= isset($data['video_id']) ? $data['video_id'] : '';
			$name			= isset($data['title']) ? $data['title'] : $meta_name;
			$description	= isset($data['description']) ? $data['description'] : $meta_description;
			$upload_date	= isset($data['publishedAt']) ? $data['publishedAt'] : $meta_upload_date;
			$duration		= isset($data['duration']) ? $data['duration'] : $meta_duration;
		
			// Prepare an array of thumbnails
			if ( ! empty($data['thumbnail']) ) {
				$thumbnails_array = $data['thumbnail'];
				$thumbnail_url = array();
				foreach ($thumbnails_array as $thumb => $thumb_url ) {
					$thumbnail_url[] = $thumb_url;
				}
			}
		}
		
	} else { // For other hosts 
		
		// Override values if found via parsing the data
		$video_id		= isset($data->video_id) ? $data->video_id : '';
		$name			= isset($data->title) ? $data->title : $meta_name;
		$description	= isset($data->description) ? $data->description : $meta_description;
		$upload_date	= isset($data->upload_date) ? $data->upload_date : $meta_upload_date;
		$duration		= isset($data->duration) ? schema_wp_get_time_second_to_iso8601_duration( $data->duration ) : $meta_duration;
		$thumbnail_url	= isset($data->thumbnail_url) ? $data->thumbnail_url : '';
	}
	
	if ( '' != $name && '' != $description ) { 

		return array( 
			'@type'			=> 'VideoObject',
			"name"			=> $name,
			"description"	=> $description,
			"thumbnailUrl"	=> $thumbnail_url,
			'uploadDate'	=> $upload_date,
			"duration"		=> $duration
		);
	}
	
	//echo'<pre>';print_r($video_schema);echo'</pre>'; // exit;
					
	return array();
}

/**
 * YouTube Class
 *
 * @since 1.0.0
 */
if ( ! class_exists('Schema_Premium_YouTube') ) :

class Schema_Premium_YouTube {
    
   	static $api_base = 'https://www.googleapis.com/youtube/v3/videos';
   	static $thumbnail_base = 'https://i.ytimg.com/vi/';
		
	/**
 	* Constructor
 	*
 	* @since 1.0.0
 	*/
	public function __construct () {
	}
	
    // $vid - video id in youtube
    // returns - video info
   	public static function get_video_info( $vid ) {
		
		$api_key = self::get_api_key();

		// Get duration
		$params = array(
           	'part' 	=> 'contentDetails',
           	'id' 	=> $vid,
           	'key' 	=> $api_key,
        );

       	$api_url = Schema_Premium_YouTube::$api_base . '?' . http_build_query($params);
       	$result = json_decode(@file_get_contents($api_url), true);
		
		// @sinnce 1.0.4
		if( $result === FALSE ) {
			// handle error here...
			return null; 
		}
		
       	if(empty($result['items'][0]['contentDetails']))
           	return null;
       	$vinfo = $result['items'][0]['contentDetails'];

       	$interval = new DateInterval($vinfo['duration']);
       	$vinfo['duration_sec'] = $interval->h * 3600 + $interval->i * 60 + $interval->s;

       	$vinfo['thumbnail']['default']       = self::$thumbnail_base . $vid . '/default.jpg';
       	$vinfo['thumbnail']['mqDefault']     = self::$thumbnail_base . $vid . '/mqdefault.jpg';
   		$vinfo['thumbnail']['hqDefault']     = self::$thumbnail_base . $vid . '/hqdefault.jpg';
       	$vinfo['thumbnail']['sdDefault']     = self::$thumbnail_base . $vid . '/sddefault.jpg';
       	$vinfo['thumbnail']['maxresDefault'] = self::$thumbnail_base . $vid . '/maxresdefault.jpg';
			
		// Get other detailss
		$params = array(
           	'part' 	=> 'snippet',
           	'id' 	=> $vid,
          	'key' 	=> $api_key,
       	);

       	$api_url = Schema_Premium_YouTube::$api_base . '?' . http_build_query($params);
       	$result = json_decode(@file_get_contents($api_url), true);

       	if(empty($result['items'][0]['snippet']))
           	return null;
       	$vinfo_2 = $result['items'][0]['snippet'];

       	return array_merge($vinfo, $vinfo_2);
   	}
		
   	// Returns - YouTube API Key
   	private static function get_api_key() {
			
		// Get duration
		$api_key = schema_wp_get_option( 'youtube_api_key' );
        
		return $api_key;
    }
}

endif;
