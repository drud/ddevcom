<?php
/**
 *  VideoObject Details extention
 *
 *  Adds schema VideoObject 
 *
 *  @since 1.0.9
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_filter('schema_single_item_output', 'schema_premium_video_object_details_markup_output');
//add_filter( 'schema_output', 'schema_premium_video_object_details_markup_output' );
//add_filter( 'schema_output_blog_post', 'schema_premium_video_object_details_markup_output' );
//add_filter( 'schema_output_blog_single_ListItem', 'schema_premium_video_object_details_markup_output' );
/**
 * Output Markup
 *
 * @since 1.0.9
 */
function schema_premium_video_object_details_markup_output( $schema ) {
	
	if ( empty($schema) ) return;
	
	$enabled = schema_wp_get_option( 'video_object_meta_enable' );
	
	if ( $enabled != true )
		return $schema;
	
	$video_object_details = schema_premium_get_video_object_details();
	
	if ( is_array($video_object_details) && ! empty($video_object_details) ) {
		
		if ( empty($schema['video']) ) {
			$schema['video'] = $video_object_details;
		} else {
			// Reconstruct our array
			$old_val = $schema['video'];
			$schema['video'] = array();
			$schema['video'][] = $old_val;
			foreach ($video_object_details as $details) {
				$schema['video'][] = $details;
			}
		}
	}
	
	//echo'<pre>'; print_r( $schema ); echo'</pre>'; //exit;
	
	return $schema;
}

/**
 * Get VideoObject details 
 *
 * @since 1.0.9
 *
 * return array
 */
function schema_premium_get_video_object_details() {
	
	$video_object = array();
	
	if ( ! function_exists('have_rows') )
		return;

	// check if the repeater field has rows of data
	if( have_rows('field_schema_VideoObject_details_repeater', get_the_ID() ) ):
		
		// loop through the rows of data
    	while ( have_rows('field_schema_VideoObject_details_repeater', get_the_ID() ) ) : the_row();

        	// get sub fields values
			$name 				= get_sub_field('feild_schema_VideoObject_details_name');
			$description 		= get_sub_field('feild_schema_VideoObject_details_description');
			$transcript 		= get_sub_field('feild_schema_VideoObject_details_transcript');
			$thumbnailUrl 		= get_sub_field('feild_schema_VideoObject_details_thumbnailUrl');
			$uploadDate 		= get_sub_field('feild_schema_VideoObject_details_uploadDate');
			$contentUrl 		= get_sub_field('feild_schema_VideoObject_details_contentUrl');
			$embedUrl 			= get_sub_field('feild_schema_VideoObject_details_embedUrl');
			
			$publication 		= array();
			$isLiveBroadcast 	= get_sub_field('feild_schema_VideoObject_details_isLiveBroadcast');
			$startDate 			= get_sub_field('feild_schema_VideoObject_details_startDate');
			$endDate 			= get_sub_field('feild_schema_VideoObject_details_endDate');
			
			// Put all together
			//
        	$video_markup = array
			(
				'@type'			=> 'VideoObject',
				'name' 			=> $name,
				'description' 	=> $description,
				'transcript' 	=> $transcript,
				'thumbnailUrl' 	=> isset($thumbnailUrl['url']) ? $thumbnailUrl['url'] : '',
				'uploadDate' 	=> $uploadDate,
				'contentUrl' 	=> $contentUrl,
				'embedUrl' 		=> $embedUrl
			);
			
			// is Live Broadcast
			//
			// @since 1.1.2.6
			if ( isset($isLiveBroadcast) && $isLiveBroadcast ) {
				$publication = array(
					'@type'				=> 'BroadcastEvent',
					'name'				=> $name,
					'description'		=> $description,
					'isLiveBroadcast'	=> isset($isLiveBroadcast) ? true : false,
					'videoFormat'		=> 'HD',
					'startDate'			=> $startDate,
					'endDate'			=> $endDate,
				);
			}
			// Add $publication
			//
			if ( ! empty($publication) )
				$video_markup['publication'] = $publication;
			
			// Add video to ouor video objects array
			//
			$video_object[] = $video_markup;

    	endwhile;

	else :

    	// no rows found

	endif;
	
	return $video_object;
}

add_action( 'acf/init', 'schema_premium_acf_meta_video_object_details', 99 );
/**
 * VideoObject Details - ACF Meta Box
 *
 * @since 1.0.9
 */
function schema_premium_acf_meta_video_object_details() {
		
	$enabled = schema_wp_get_option( 'video_object_meta_enable' );
	
	if ( $enabled != true )
		return;
		
	if ( function_exists('acf_add_local_field_group') ):
		
		// Get setting for display instructions
		$instructions_on = schema_wp_get_option( 'properties_instructions_enable' );
		
		// ACF Field: Video Details
		// 
		//

		// Add tab
		//
		acf_add_local_field( array(
			'key' => 'field_schema_VideoObject_tab',
			'name' => 'schema_VideoObject_tab',
			'label' => __('Video Object Details', 'schema-premium'),
			'type' => 'tab',
			'parent' => 'group_schema_properties',
			'placement' => 'left',
			'endpoint'	=> 0,
		) );

		// Repeater
		// 
		// Video details repeater
		acf_add_local_field( array(
			'key'          => 'field_schema_VideoObject_details_repeater',
			'label'        => '',
			'name'         => 'schema_VideoObject_details_repeater',
			'type'         => 'repeater',
			'parent'       => 'group_schema_properties',
			'instructions' => $instructions_on == 'yes' ? __('Mark up your video content manually with structured data to make Google Search an entry point for discovering and watching videos. Use this feature if your videos are not supported by Schema Premium plugin.', 'schema-premium') : '',
			'layout' 	   => 'block',
			'button_label' => __('Add Video Details', 'schema-premium')
		) );
		
		// Sub Repeater
		// 
		// Video details: Name
		//
		acf_add_local_field(array(
			'key' 		=> 'feild_schema_VideoObject_details_name',
			'label' 	=> __('Name', 'schema-premium'),
			'name' 		=> 'schema_VideoObject_details_name',
			'type' 		=> 'text',
			'parent' 	=> 'field_schema_VideoObject_details_repeater',
			'default_value' => '',
			'placeholder' => '',
			'instructions' =>  $instructions_on == 'yes' ? __('The name of the video.', 'schema-premium') : '',
		));
		
		// Sub Repeater
		// 
		// Video details: Description
		//
		acf_add_local_field(array(
			'key' 		=> 'feild_schema_VideoObject_details_description',
			'label' 	=> __('Description', 'schema-premium'),
			'name' 		=> 'schema_VideoObject_details_description',
			'type' 		=> 'textarea',
			'parent' 	=> 'field_schema_VideoObject_details_repeater',
			'rows' 		=> '3',
			'default_value' => '',
			'placeholder' => '',
			'instructions' =>  $instructions_on == 'yes' ? __('A description of the video.', 'schema-premium') : '',
		));

		// Sub Repeater
		// 
		// Video details: Transcript
		//
		acf_add_local_field(array(
			'key' 		=> 'feild_schema_VideoObject_details_transcript',
			'label' 	=> __('Transcript', 'schema-premium'),
			'name' 		=> 'schema_VideoObject_details_transcript',
			'type' 		=> 'textarea',
			'parent' 	=> 'field_schema_VideoObject_details_repeater',
			'rows' 		=> '3',
			'default_value' => '',
			'placeholder' => '',
			'instructions' =>  $instructions_on == 'yes' ? __('If this video has audio, the transcript of the audio.', 'schema-premium') : '',
		));
		
		// Sub Repeater
		// 
		// Video details: thumbnailUrl
		//
		acf_add_local_field(array(
			'key' 		=> 'feild_schema_VideoObject_details_thumbnailUrl',
			'label' 	=> __('Thumbnail', 'schema-premium'),
			'name' 		=> 'schema_VideoObject_details_thumbnailUrl',
			'type' 		=> 'image',
			'parent' 	=> 'field_schema_VideoObject_details_repeater',
			'default_value' => '',
			'instructions' =>  $instructions_on == 'yes' ? __('Thumbnail image for the video.', 'schema-premium') : '',
		));
		
		// Sub Repeater
		// 
		// Video details: uploadDate
		//
		acf_add_local_field(array(
			'key' 		=> 'feild_schema_VideoObject_details_uploadDate',
			'label' 	=> __('Upload Date', 'schema-premium'),
			'name' 		=> 'schema_VideoObject_details_uploadDate',
			'type' 		=> 'date_time_picker',
			'parent' 	=> 'field_schema_VideoObject_details_repeater',
			'return_format' => 'Y-m-d H:i:s',
			'default_value' => '',
			'instructions' =>  $instructions_on == 'yes' ? __('Date when this video was uploaded to this site.', 'schema-premium') : '',
		));

		// Sub Repeater
		// 
		// Video details: contentUrl
		//
		acf_add_local_field(array(
			'key' 		=> 'feild_schema_VideoObject_details_contentUrl',
			'label' 	=> __('Content Url', 'schema-premium'),
			'name' 		=> 'schema_VideoObject_details_contentUrl',
			'type' 		=> 'url',
			'parent' 	=> 'field_schema_VideoObject_details_repeater',
			'default_value' => '',
			'placeholder' => 'https://',
			'instructions' =>  $instructions_on == 'yes' ? __('A URL pointing to the actual bytes of the video (for example, url of the video file).', 'schema-premium') : '',
		));
		
		// Sub Repeater
		// 
		// Video details: embedUrl
		//
		acf_add_local_field(array(
			'key' 		=> 'feild_schema_VideoObject_details_embedUrl',
			'label' 	=> __('Embed Url', 'schema-premium'),
			'name' 		=> 'schema_VideoObject_details_embedUrl',
			'type' 		=> 'url',
			'parent' 	=> 'field_schema_VideoObject_details_repeater',
			'default_value' => '',
			'placeholder' => 'https://',
			'instructions' =>  $instructions_on == 'yes' ? __('A URL pointing to a player for this specific video.', 'schema-premium') : '',
		));

		// Sub Repeater
		// 
		// Video details: isLiveBroadcast
		//
		acf_add_local_field(array(
			'key' 		=> 'feild_schema_VideoObject_details_isLiveBroadcast',
			'label' 	=> __('Is Live Broadcast?', 'schema-premium'),
			'name' 		=> 'schema_VideoObject_details_isLiveBroadcast',
			'type' 		=> 'true_false',
			'parent' 	=> 'field_schema_VideoObject_details_repeater',
			'return_format' => 'Y-m-d H:i:s',
			'default_value' => 0,
			'instructions' 	=> $instructions_on == 'yes' ? __('Set to true if the video is, has been, or will be streamed live.', 'schema-premium') : '',
			'ui' => 1,
			'ui_on_text' => __('Yes', 'schema-premium'),
			'ui_off_text' => __('No', 'schema-premium'),
		));

		// Sub Repeater
		// 
		// Video details: startDate
		//
		acf_add_local_field(array(
			'key' 		=> 'feild_schema_VideoObject_details_startDate',
			'label' 	=> __('Start Date', 'schema-premium'),
			'name' 		=> 'schema_VideoObject_details_startDate',
			'type' 		=> 'date_time_picker',
			'parent' 	=> 'field_schema_VideoObject_details_repeater',
			'return_format' => 'Y-m-d H:i:s',
			'default_value' => '',
			'instructions' 	=> $instructions_on == 'yes' ? __('Time and date of when the livestream starts or is expected to start.', 'schema-premium') : '',
			'conditional_logic' => array(
				array(
					array(
						'field' => 'feild_schema_VideoObject_details_isLiveBroadcast',
						'operator' => '==',
						'value' => 1,
					),
				),
			)
		));

		// Sub Repeater
		// 
		// Video details: endDate
		//
		acf_add_local_field(array(
			'key' 		=> 'feild_schema_VideoObject_details_endDate',
			'label' 	=> __('End Date', 'schema-premium'),
			'name' 		=> 'schema_VideoObject_details_endDate',
			'type' 		=> 'date_time_picker',
			'parent' 	=> 'field_schema_VideoObject_details_repeater',
			'return_format' => 'Y-m-d H:i:s',
			'default_value' => '',
			'instructions' 	=> $instructions_on == 'yes' ? __('Time and date of when the livestream ends or is expected to end.', 'schema-premium') : '',
			'conditional_logic' => array(
				array(
					array(
						'field' => 'feild_schema_VideoObject_details_isLiveBroadcast',
						'operator' => '==',
						'value' => 1,
					),
				),
			)
		));
		
	endif;
}
