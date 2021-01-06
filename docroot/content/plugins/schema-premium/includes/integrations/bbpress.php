<?php
/**
 * bbPress plugin integration
 *
 *
 * plugin url: https://wordpress.org/plugins/bbpress/
 * @since 1.1.2
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'schema_output_DiscussionForumPosting', 'schema_premium_bbp_extend_schema_output' );
/**
 * Extend Discussion Forum Posting markup for bbPress
 *
 * @since 1.1.2
 * @return array
 */
function schema_premium_bbp_extend_schema_output( $schema ) {
	
	$enabled = schema_wp_get_option( 'bbpress_enabled' );
	
	if ( $enabled == 'enabled' ) {
		return $schema;
	}

	// Chedk if bbPress plugin is enabled 
	//
	if ( ! class_exists( 'bbPress' ) )
		return $schema; 

	// Chedk if schema.org type is DiscussionForumPosting 
	//
	if ( $schema['@type'] !== 'DiscussionForumPosting' )
		return $schema;
	
	// interactionStatistic
	//
	$reply_count = bbp_get_topic_reply_count();
		
	if ( $reply_count > 0 ) {
		$schema['interactionStatistic'] = array (
				'@type'					=> 'InteractionCounter',
				'interactionType'		=> 'https://schema.org/ReplyAction', // https://schema.org/CommentAction
				'userInteractionCount'	=> $reply_count
		);
		
		// comment
		//
		$replies = schema_premium_bbp_get_replies_markup();

		if ( ! empty($replies) )
			$schema['comment'] = $replies;
	}
	
	// comment
	//
	$replies = schema_premium_bbp_get_replies_markup();

	if ( ! empty($replies) )
		$schema['comment']= $replies;
	
	return $schema;
}

/**
 * Get bbPress replies markup
 *
 * @since 1.1.2.8
 * @return array
 */
function schema_premium_bbp_get_replies_markup() {

	// Defaults
    $default_reply_search   = bbp_sanitize_search_request( 'rs' );
    $default_post_parent    = ( bbp_is_single_topic() ) ? bbp_get_topic_id() : 'any';
    $default_post_type      = ( bbp_is_single_topic() && bbp_show_lead_topic() ) ? bbp_get_reply_post_type() : array( bbp_get_topic_post_type(), bbp_get_reply_post_type() );
    $default_thread_replies = (bool) ( bbp_is_single_topic() && bbp_thread_replies() );
	$replies 				= array();

    // The args. 
    $args = array(
        'post_type'              => $default_post_type,         // Only replies
        'post_parent'            => $default_post_parent,       // Of this topic
        'posts_per_page'         => bbp_get_replies_per_page(), // This many
        'paged'                  => bbp_get_paged(),            // On this page
        'orderby'                => 'date',                     // Sorted by date
        'order'                  => 'ASC',                      // Oldest to newest
        'hierarchical'           => $default_thread_replies,    // Hierarchical replies
        'ignore_sticky_posts'    => true,                       // Stickies not supported
        'update_post_term_cache' => false,                      // No terms to cache

        // Conditionally prime the cache for all related posts
        'update_post_family_cache' => true
    );

    // Query replies
	//
	$the_query = new WP_Query($args);
	
    if( $the_query->have_posts() ) {

        $replies = array();
        
        while($the_query->have_posts()): $the_query->the_post();

			$reply_id = get_the_ID();

			$post_array 	= get_post( $reply_id );
			$post_author 	= get_userdata( $post_array->post_author) ;
		
            $output = array(
                '@type'         => 'Comment',
                '@id'           => bbp_get_reply_permalink( $reply_id ),
				'url'           => bbp_get_reply_permalink( $reply_id ),
				//'headline'		=> bbp_get_reply_title($reply_id),
                'dateCreated'   => get_the_date('c', true),
                'text'          => get_the_content(), //bbp_get_reply_content()
            );

			// author
			//
			if ( ! bbp_is_reply_anonymous( $reply_id ) ) {
				// get author array
				$output['author'] = schema_wp_get_author_array( $reply_id );
			} else {
				$output['author'] = array(
                    '@type'	=>'Person',
                    'name'	=> bbp_get_reply_author_display_name( $reply_id ),
				);
				if ( '' != bbp_get_reply_author_url( $reply_id ) ) {
					$output['author']['url'] = bbp_get_reply_author_url( $reply_id );
				}
			}

            $replies[] = $output;
                
        endwhile;
	} 
	
    // Restore original post data
    wp_reset_postdata();
	
	return $replies;
}

add_action( 'admin_init', 'schema_premium_bbpress_register_settings', 1 );
/*
* Register settings 
*
* @since 1.1.2.8
*/
function schema_premium_bbpress_register_settings() {
	
	add_filter( 'schema_wp_settings_integrations', 'schema_premium_bbpress_settings', 30 );
}

/*
* Settings 
*
* @since 1.1.2.8
*/
function schema_premium_bbpress_settings( $settings ) {

	$info = ' <span style="color:#8a8a8a;margin-top:3px;" class="dashicons dashicons-admin-plugins"></span>';

	if ( class_exists( 'bbPress' ) ) {
		$info = ' <span style="color:#48b142;margin-top:3px;" class="dashicons dashicons-admin-plugins"></span>';
	}

	$settings['main']['bbpress_enabled'] = array(
		'id' => 'bbpress_enabled',
		'name' => __( 'bbPress', 'schema-premium' ),
		'desc' => $info,
		'type' => 'select',
		'options' => array(
			'enabled'	=> __( 'Enabled', 'schema-premium'),
			'disabled'	=> __( 'Disabled', 'schema-premium')
		),
		'std' => 'enabled',
		'tooltip_title' => __('When enabled', 'schema-premium'),
		'tooltip_desc' => __('Schema plugin will use comments as replies for DiscussionForumPosting markup', 'schema-premium'),
	);
	
	return $settings;
}
