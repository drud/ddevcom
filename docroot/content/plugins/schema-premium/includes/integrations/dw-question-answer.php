<?php
/**
 * DW Question Answer plugin
 *
 *
 * plugin url: https://wordpress.org/plugins/dw-question-answer/
 * @since 1.1.2.8
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'schema_output_QAPage', 'schema_premium_dwqa_markup_output' );
/**
 * Extend QAPage markup based on DW Question Answer plugin
 *
 * @since 1.1.2.8
 * @param array $schema markup
 * @return array
 */
function schema_premium_dwqa_markup_output( $schema ){
	
	if ( ! class_exists( 'DW_Question_Answer' ) ) 
		return $schema;

	$enabled = schema_wp_get_option( 'dwqa_enabled' );
	
	if ( $enabled == 'enabled' ) {
		return $schema;
	}

	if ( ! function_exists('dwqa_get_post_parent_id') ) 
		return $schema;

	$question_id = dwqa_get_post_parent_id();

	// answerCount
	//
	$answerCount = dwqa_question_answers_count( get_the_ID() );
	if ( $answerCount > 0 ) {
		$schema['mainEntity']['answerCount'] = dwqa_question_answers_count( get_the_ID() );
	}

	$output_array = array();
	
	$args = array(
		'post_type' 				=> 'dwqa-answer',
		'post_status' 				=> 'publish',
		'post_parent' 				=> $question_id,
		'no_found_rows' 			=> true,
		'update_post_meta_cache'	=> false,
		'update_post_term_cache' 	=> false,
		'fields' 					=> 'ids'
	);

	$publish_answer = new WP_Query( $args );

	if( $publish_answer->have_posts() ) {
		
		while( $publish_answer->have_posts() ) : $publish_answer->the_post();

			$post_array =  get_post( get_the_ID() );

			// mainEntity : acceptedAnswer
			//
			if ( dwqa_is_the_best_answer() ) {

				$acceptedAnswer = array (
					'@type'			=> 'Answer',
					'headline'		=> 	$post_array->post_title,
					'text'			=>  $post_array->post_content,
					'dateCreated'	=>  $post_array->post_date,
					'url'			=>  $post_array->guid,
					'text'			=>  $post_array->post_content,
				);
				
				//
				// upvoteCount
				//
				$upvoteCount = dwqa_vote_count( get_the_ID() );
				if ( isset($upvoteCount) ) {
					$acceptedAnswer['upvoteCount'] = $upvoteCount;
				}

				// get author array
				//
				if ( dwqa_is_anonymous( get_the_ID() ) ) {
					$anonymous_name = get_post_meta( get_the_ID(), '_dwqa_anonymous_name', true );
					$display_name = ($anonymous_name != '') ? $anonymous_name : __( 'Anonymous', 'schema-premium' );
					$author = array (
						'@type'	=> 'Person',
						'name'	=>  $anonymous_name,
					);
				} else {
					$acceptedAnswer['author'] = schema_wp_get_author_array( get_the_ID() );
				}
				
				// add to schema markup
				$schema['mainEntity']['acceptedAnswer'] = $acceptedAnswer;

				// Continue to next answer
				//
				continue;
			}

			$answer_array = array (
				'@type'			=> 'Answer',
				'headline'		=> 	$post_array->post_title,
				'text'			=>  $post_array->post_content,
				'dateCreated'	=>  $post_array->post_date,
				'url'			=>  $post_array->guid,
				'text'			=>  $post_array->post_content,
			);

			// get author array
			//
			if ( dwqa_is_anonymous( get_the_ID() ) ) {
				$anonymous_name = get_post_meta( get_the_ID(), '_dwqa_anonymous_name', true );
				$display_name = ($anonymous_name != '') ? $anonymous_name : __( 'Anonymous', 'schema-premium' );
				$answer_array['author'] = array (
					'@type'	=> 'Person',
					'name'	=>  $anonymous_name,
				);
			} else {
				$answer_array['author'] = schema_wp_get_author_array( get_the_ID() );
			}
			
			// upvoteCount
			//
			$upvoteCount = dwqa_vote_count();
			if ( isset($upvoteCount) ) {
				$answer_array['upvoteCount'] = $upvoteCount;
			}
			
			$output_array[] = $answer_array; 
			 
		endwhile;
	}
	
	// Restore original post data
    wp_reset_postdata();
	
	$schema['mainEntity']['suggestedAnswer'] = $output_array;
		
	return $schema;
}

add_action( 'admin_init', 'schema_premium_dwqa_register_settings', 1 );
/*
* Register settings 
*
* @since 1.1.2.8
*/
function schema_premium_dwqa_register_settings() {
	
	add_filter( 'schema_wp_settings_integrations', 'schema_premium_dwqa_settings', 30 );
}

/*
* Settings 
*
* @since 1.1.2.8
*/
function schema_premium_dwqa_settings( $settings ) {

	$info = ' <span style="color:#8a8a8a;margin-top:3px;" class="dashicons dashicons-admin-plugins"></span>';

	if ( class_exists( 'DW_Question_Answer' ) ) {
		$info = ' <span style="color:#48b142;margin-top:3px;" class="dashicons dashicons-admin-plugins"></span>';
	}

	$settings['main']['dwqa_enabled'] = array(
		'id' => 'dwqa_enabled',
		'name' => __( 'DW Question Answer', 'schema-premium' ),
		'desc' => $info,
		'type' => 'select',
		'options' => array(
			'enabled'	=> __( 'Enabled', 'schema-premium'),
			'disabled'	=> __( 'Disabled', 'schema-premium')
		),
		'std' => 'enabled',
		'tooltip_title' => __('When enabled', 'schema-premium'),
		'tooltip_desc' => __('Schema plugin will add answers in markup.', 'schema-premium'),
	);
	
	return $settings;
}