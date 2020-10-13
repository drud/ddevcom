<?php
/**
 * @package Schema Premium - Class Schema Terms
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
	
if ( ! class_exists('Schema_WP_Terms') ) :
	/**
	 * Schema Terms
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Terms {
		
		/**
	 	* Constructor
	 	*
	 	* @since 1.0.0
	 	*/
		public function __construct () {
		
			$this->init();
		}
	
		/**
		* Init
		*
		* @since 1.0.0
	 	*/
		public function init() {
			
			add_action( 'schema_markup_output', array( $this, 'output_markup' ) );
		}
		
		/**
		* Get markup output
		*
		* @since 1.0.0
		* @return array
		*/
		public function output_markup() {
			
			// Filter this and return false to disable the function
			$enabled = apply_filters( 'schema_wp_output_terms_enabled', true );
				if ( ! $enabled )
					return;
			
			$enabled = false;
				
			if ( is_category() && schema_wp_get_option( 'category_enable' ) ) {
				
				// Add action to hook to this function
				do_action( 'schema_wp_action_category' );
				$enabled = true;
			}
			
			if ( is_tag() && schema_wp_get_option( 'tag_enable' ) ) {
				
				// Add action to hook to this function
				do_action( 'schema_wp_action_tag' );
				$enabled = true;
			}
			
			if ( is_tax() && schema_wp_get_option( 'taxonomy_enable' ) ) {
				
				// Add action to hook to this function
				do_action( 'schema_wp_action_taxonomy' );
				$enabled = true;
			}
			
			if ( $enabled ) {
				
				// Add action to hook to this function
				do_action( 'schema_wp_action_terms' );
				
				$markup = new Schema_WP_Output();
				$markup->json_output( $this->get_markup() );
			}
		}
		
		/**
		* Get markup
		*
		* @since 1.0.0
		* @return array
		*/
		public function get_markup() {
			
			global $wp_query;
	
			// debug
			//echo'<pre>';print_r($wp_query->posts);echo'</pre>';exit;
			//var_dump( $GLOBALS['wp_query'] );
			
			if ( empty($wp_query->posts) ) return;
			
			$blogPost 	= array();
			$schema 	= array();
			$term 		= get_queried_object();
			$term_link	= get_term_link( $term->term_id );
			
			// get markup data for each post in the query
			if ( ! empty($wp_query->posts) ) {
				
				foreach ($wp_query->posts as $schema_post) {
					
					$schema_location_target = schema_premium_get_location_target_match( $schema_post->ID );
					
					if ( ! empty($schema_location_target) ) {
						
						// debug
						//echo'<pre>';print_r($schema_location_target);echo'</pre>';exit;
						
						foreach ( $schema_location_target as $schema_post_ID => $details ) :
						
							if ( $details['match'] == true ) {
							
								// Get final schema type
								$schema_type = ( isset($details['schema_subtype']) 
										&& $details['schema_subtype'] != ''
										&& $details['schema_subtype'] != 'General' ) ? $details['schema_subtype'] : $details['schema_type'];
							
								if ( isset($schema_type) &&  $schema_type != '' ) {
															
									// Get schema markup
									$schema_markup		= new Schema_WP_Output();
									$list_item			= $schema_markup->get_schema( $schema_post->ID, $schema_type );
									// Override urls, fix for: All values provided for url must point to the same page.
									$list_item['url'] 	= $term_link . '#' . $schema_post->post_name;
									// @since 1.0.3
									$list_item['@id'] 	= $term_link . '#' . $schema_post->post_name;
									$blogPost[]			= apply_filters( 'schema_output_terms_single', $list_item );
								} // end if
							} // end if match
					
						endforeach;
					} // end if ! empty($schema_location_target)
				} // end foreach
			}
			
			$schema = array
       		(
				'@context' 		=> 'http://schema.org/',
				'@type' 		=> "CollectionPage",
				'headline' 		=> strip_tags($term->name),
				'description' 	=> strip_tags($term->description),
				'url'		 	=> get_category_link( $term->term_id ),
				'sameAs' 		=> $this->get_sameAs($term),
				'hasPart' 		=> $blogPost
       		);
			//return $schema;
			return apply_filters( 'schema_terms_output', $schema );
		}

		/**
		* Get sameAs
		*
		* @since 1.1.2.3
		* @return array
		*/
		public function get_sameAs( $term ) {
			
			$output = array();
	
			$count = get_term_meta( $term->term_id, 'schema_sameAs', true );
			
			if ( isset( $count ) && $count >= 0 ) {
		 
				for( $i=0; $i < $count; $i++ ) {
					
					$step_no = $i + 1;
					
					$url 		= get_term_meta( $term->term_id, 'schema_sameAs_' . $i . '_url' , true );
					
					$output[] 	= esc_url($url);
				}
		
			}
	
			return $output;
		}

	}
	
	new Schema_WP_Terms();
	
endif;
