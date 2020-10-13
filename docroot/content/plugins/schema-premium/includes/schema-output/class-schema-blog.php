<?php
/**
 * @package Schema Premium - Class Schema Blog
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
	
if ( ! class_exists('Schema_WP_Blog') ) :
	/**
	 * Schema Blog
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Blog {
		
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
			
			add_action( 'schema_markup_output', array( $this, 'get_blog_markup_output' ) );
		}
		
		/**
		* Get blog markup output
		*
		* @since 1.0.0
		* @return array
		*/
		public function get_blog_markup_output() {
			
			if ( schema_wp_is_blog() ) {
				
				$setting = schema_wp_get_option( 'blog_markup' );
				
				if ( ! isset($setting) || $setting == '' ) {
					return;
				}
				
				// Switch between Blog markup output types
				switch ($setting) {
					case 'Blog' :
						$markup = new Schema_WP_Output();
						$markup->json_output( $this->get_blog_markup() );
						break;
				
					case 'ItemList' :
						$markup = new Schema_WP_Output();
						$markup->json_output( $this->get_list_markup() );
						break;
				}
			}
		}
		
		/**
		* Get blog markup
		*
		* @since 1.0.0
		* @return array
		*/
		public function get_blog_markup() {
			
			global $wp_query;
	 
			// debug
			//echo'<pre>';print_r($wp_query);echo'</pre>';exit;
			//var_dump( $GLOBALS['wp_query'] );
	
			if ( empty($wp_query->posts) ) return;
	
			$blogPosts 	= array();
			$schema 	= array();
			
			foreach ($wp_query->posts as $schema_post) {
				
				//$schema_location_target = schema_premium_get_location_target_match( $schema_post->ID );
						
				//if ( $schema_location_target['match'] == 'true' ) {
							
				// create it
				$blogPosts[] = apply_filters( 'schema_output_Blog_Post', array
				(
					'@type' => 'BlogPosting',
					'headline' => schema_wp_get_the_title($schema_post->ID),
					'description' => schema_wp_get_description($schema_post->ID),
					'url' => get_the_permalink($schema_post->ID),
					//'sameAs' => schema_wp_get_sameAs($schema_post->ID),
					'datePublished' => get_the_date('c', $schema_post->ID),
					'dateModified' => get_the_modified_date('c', $schema_post->ID),
					'mainEntityOfPage' => get_the_permalink($schema_post->ID),
					'author' => schema_wp_get_author_array(),
					'publisher' => schema_wp_get_publisher_array(),
					'image' => schema_wp_get_media($schema_post->ID),
					'keywords' => schema_wp_get_post_tags($schema_post->ID),
					'commentCount' => get_comments_number($schema_post->ID),
					'comment' => schema_wp_get_comments($schema_post->ID),
				));
				//}
			}
			
			// put all together
			$schema = array
        	(
				'@context' => 'http://schema.org/',
				'@type' => 'Blog',
				'headline' => get_option( 'page_for_posts' ) ? wp_filter_nohtml_kses( get_the_title( get_option( 'page_for_posts' ) ) ) : get_bloginfo( 'name' ),
				'description' => get_bloginfo( 'description' ),
				'url' => get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : get_home_url(),
				//'publisher' => schema_wp_get_publisher_array(),
				'blogPost' => $blogPosts, // or use blogPosts ?
        	);
			
			//endif;
			
			return apply_filters( 'schema_output_Blog', $schema );
		}
		
		/**
		* Get ListItem markup
		*
		* @since 1.0.0
		* @return array
		*/
		public function get_list_markup() {
			
			global $wp_query;
	
			// debug
			//echo'<pre>';print_r($wp_query);echo'</pre>';exit;
			//var_dump( $GLOBALS['wp_query'] );
			
			if ( empty($wp_query->posts) ) return;
			
			$listPosts 	= array();
			$schema 	= array();
			
			// get markup data for each post in the query
			if ( ! empty($wp_query->posts) ) {
				   
				$i = 1;
					
				foreach ($wp_query->posts as $schema_post) {
					
					$schema_location_target = schema_premium_get_location_target_match( $schema_post->ID );
					
					if ( ! empty($schema_location_target) ) {
					
						foreach ( $schema_location_target as $schema_post_ID => $details ) :
						
							if ( $details['match'] == true ) {
							
								// Get final schema type
								$schema_type = ( isset($details['schema_subtype']) 
										&& $details['schema_subtype'] != ''
										&& $details['schema_subtype'] != 'General' ) ? $details['schema_subtype'] : $details['schema_type'];
							
								if (isset($schema_type) &&  $schema_type != '' ) {
															
									// Get schema markup
									$schema_markup = new Schema_WP_Output();
									$list_item = $schema_markup->get_schema( $schema_post->ID, $schema_type );
									
									// Override urls, fix for: All values provided for url must point to the same page.
									$list_item['url'] = get_home_url() . '#' . $schema_post->post_name;
					
									$listPosts[] = array(
										'@type'		=> 'ListItem',
										'position'	=> $i,
										'item' 		=> apply_filters( 'schema_output_blog_single_ListItem', $list_item )
									);
								} // end if
							} // end if match
					
						endforeach;
						
						$i++;
					} // end if ! empty($schema_location_target)
				} // end foreach
			}
				
			//wp_reset_postdata();
				
			if ( is_array($listPosts) && ! empty($listPosts) ) {
				// put all together
				$schema = array
				(
					'@context' 			=> 'http://schema.org/',
					'@type' 			=> array('ItemList', 'CreativeWork'),
					'name' 				=> get_bloginfo( 'name' ),
					'description' 		=> get_bloginfo( 'description' ),
					'url' 				=> get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : get_home_url(),
					'itemListOrder' 	=> 'http://schema.org/ItemListOrderAscending',
					'numberOfItems' 	=> count($listPosts),
					'itemListElement' 	=> $listPosts,
				);
			}
			
			return apply_filters( 'schema_output_Blog_ListItem', $schema );
		}
	}
	
	new Schema_WP_Blog();
	
endif;
