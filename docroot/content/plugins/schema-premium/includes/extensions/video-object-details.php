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
				'uploadDate' 	=> $uploadDate
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
		$properties_instructions_enable = schema_wp_get_option( 'properties_instructions_enable' );
		
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
			'instructions' => $properties_instructions_enable == 'yes' ? __('Mark up your video content manually with structured data to make Google Search an entry point for discovering and watching videos. Use this feature if your videos are not supported by Schema Premium plugin.', 'schema-premium') : '',
			'layout' 	   => 'block',
			'button_label' => __('Add Video Details', 'schema-premium')
		) );
		
		// Sub Repeater
		// 
		// Video details: Name
		acf_add_local_field(array(
			'key' 		=> 'feild_schema_VideoObject_details_name',
			'label' 	=> 'Name',
			'name' 		=> 'schema_VideoObject_details_name',
			'type' 		=> 'text',
			'parent' 	=> 'field_schema_VideoObject_details_repeater',
			'default_value' => '',
			'placeholder' => ''
		));
		
		// Sub Repeater
		// 
		// Video details: Description
		acf_add_local_field(array(
			'key' 		=> 'feild_schema_VideoObject_details_description',
			'label' 	=> 'Description',
			'name' 		=> 'schema_VideoObject_details_description',
			'type' 		=> 'textarea',
			'parent' 	=> 'field_schema_VideoObject_details_repeater',
			'rows' 		=> '3',
			'default_value' => '',
			'placeholder' => ''
		));

		// Sub Repeater
		// 
		// Video details: Transcript
		acf_add_local_field(array(
			'key' 		=> 'feild_schema_VideoObject_details_transcript',
			'label' 	=> 'Transcript',
			'name' 		=> 'schema_VideoObject_details_transcript',
			'type' 		=> 'textarea',
			'parent' 	=> 'field_schema_VideoObject_details_repeater',
			'rows' 		=> '3',
			'default_value' => '',
			'placeholder' => ''
		));
		
		// Sub Repeater
		// 
		// Video details: thumbnailUrl
		acf_add_local_field(array(
			'key' 		=> 'feild_schema_VideoObject_details_thumbnailUrl',
			'label' 	=> 'Thumbnail',
			'name' 		=> 'schema_VideoObject_details_thumbnailUrl',
			'type' 		=> 'image',
			'parent' 	=> 'field_schema_VideoObject_details_repeater',
			'default_value' => ''
		));
		
		// Sub Repeater
		// 
		// Video details: uploadDate
		acf_add_local_field(array(
			'key' 		=> 'feild_schema_VideoObject_details_uploadDate',
			'label' 	=> 'Upload Date',
			'name' 		=> 'schema_VideoObject_details_uploadDate',
			'type' 		=> 'date_time_picker',
			'parent' 	=> 'field_schema_VideoObject_details_repeater',
			'return_format' => 'Y-m-d H:i:s',
			'default_value' => ''
		));

		// Sub Repeater
		// 
		// Video details: isLiveBroadcast
		acf_add_local_field(array(
			'key' 		=> 'feild_schema_VideoObject_details_isLiveBroadcast',
			'label' 	=> 'Is Live Broadcast?',
			'name' 		=> 'schema_VideoObject_details_isLiveBroadcast',
			'type' 		=> 'true_false',
			'parent' 	=> 'field_schema_VideoObject_details_repeater',
			'return_format' => 'Y-m-d H:i:s',
			'default_value' => 0,
			'instructions' 	=> __('Set to true if the video is, has been, or will be streamed live.', 'schema-premium'),
			'ui' => 1,
			'ui_on_text' => __('Yes', 'schema-premium'),
			'ui_off_text' => __('No', 'schema-premium'),
		));

		// Sub Repeater
		// 
		// Video details: startDate
		acf_add_local_field(array(
			'key' 		=> 'feild_schema_VideoObject_details_startDate',
			'label' 	=> 'Start Date',
			'name' 		=> 'schema_VideoObject_details_startDate',
			'type' 		=> 'date_time_picker',
			'parent' 	=> 'field_schema_VideoObject_details_repeater',
			'return_format' => 'Y-m-d H:i:s',
			'default_value' => '',
			'instructions' 	=> __('Time and date of when the livestream starts or is expected to start.', 'schema-premium'),
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
		acf_add_local_field(array(
			'key' 		=> 'feild_schema_VideoObject_details_endDate',
			'label' 	=> 'End Date',
			'name' 		=> 'schema_VideoObject_details_endDate',
			'type' 		=> 'date_time_picker',
			'parent' 	=> 'field_schema_VideoObject_details_repeater',
			'return_format' => 'Y-m-d H:i:s',
			'default_value' => '',
			'instructions' 	=> __('Time and date of when the livestream ends or is expected to end.', 'schema-premium'),
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
