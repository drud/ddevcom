<?php
/**
 * @package Schema Premium - Class Schema Post Type Archive
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
	
if ( ! class_exists('Schema_WP_Post_Type_Archive') ) :
	/**
	 * Schema Post Type Archive
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Post_Type_Archive {
		
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
			
			if ( is_post_type_archive() ) {
				
				// add action to hook to this function
				do_action('schema_wp_action_post_type_archive');
		
				$setting = schema_wp_get_option( 'post_type_archive_enable' );
				
				if ( ! isset($setting) || $setting == '' ) {
					return;
				}
				
				$markup = new Schema_WP_Output();
				$markup->json_output( $this->get_markup() );
			}
		}
		
		/**
		* Get ListItem markup
		*
		* @since 1.0.0
		* @return array
		*/
		public function get_markup() {
			
			global $post, $wp_query;
	
			// debug
			//echo'<pre>';print_r($wp_query->posts);echo'</pre>';exit;
			//var_dump( $GLOBALS['wp_query'] );
			
			if ( empty($wp_query->posts) ) return;
			
			$blogPost 	= array();
			$schema 	= array();
			$post_type	= $wp_query->query_vars['post_type'];
			$url		= schema_premium_get_archive_link( $post_type ) ? schema_premium_get_archive_link( $post_type ) : get_home_url();
			
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
									$list_item['url'] = $url.'#'.$schema_post->post_name;
									// @since 1.0.3
									$list_item['@id'] = $url.'#'.$schema_post->post_name;
					
									$blogPost[] = array(
										'@type'		=> 'ListItem',
										'position'	=> $i,
										'item' 		=> apply_filters( 'schema_output_post_type_archive_single_ListItem', $list_item, $schema_post->ID )
									);
								} // end if
							} // end if match
					
						endforeach;
						
						$i++;
					} // end if ! empty($schema_location_target)
				} // end foreach
			}
				
			$obj = get_post_type_object( $post_type );
				
			if ( ! empty($blogPost)) {
				// put all together
				$schema = array
				(
					'@context' 			=> 'http://schema.org/',
					'@type' 			=> array('ItemList', 'CreativeWork'),
					'name' 				=> isset($obj->label) ? $obj->label : '',
					'description' 		=> isset($obj->description) ? $obj->description : '',
					'url' 				=> $url,
					'itemListOrder' 	=> 'http://schema.org/ItemListOrderAscending',
					'numberOfItems' 	=> count($blogPost),
					'itemListElement' 	=> $blogPost,
				);
			}
			
			return apply_filters( 'schema_post_type_archive_output', $schema );
		}
	}
	
	new Schema_WP_Post_Type_Archive();
	
endif;
