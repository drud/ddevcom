<?php
/**
 * @package Schema Premium - Class Schema Author Archive
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
	
if ( ! class_exists('Schema_WP_Author_Archive') ) :
	/**
	 * Schema Author Archive
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Author_Archive {
		
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
			$enabled = apply_filters( 'schema_wp_output_author_archive_enabled', true );
				if ( ! $enabled )
					return;
	
			if ( is_author() && schema_wp_get_option( 'author_archive_enable' ) ) {
				// Add action to hook to this function
				do_action( 'schema_wp_action_author_archive' );
				
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
			
			// Get current author data
			if( get_query_var('author_name') ) :
    			$curauth = get_user_by( 'slug', get_query_var('author_name') );
			else :
    			$curauth = get_userdata( get_query_var('author') );
			endif;
	
			// debug
			//echo'<pre>';print_r($curauth);echo'</pre>';exit;
			//var_dump( $GLOBALS['wp_query'] );
			
			$blogPost 	= array();
			$schema 	= array();
		
			if ( ! empty($curauth) ) {
				
				// Author url
				$url_enable = schema_wp_get_option( 'author_url_enable' );
				$url 		= ( $url_enable == true ) ? esc_url( get_author_posts_url( $curauth->ID ) ) : '';
	
				// put all together
				$schema = array
				(
					'@context' 			=> 'http://schema.org/',
					'@type' 			=> array('Person', 'ProfilePage'),
					'name' 				=> $curauth->display_name,
					'description' 		=> $curauth->description,
					'url' 				=> $url,
					//'@id' 				=> get_author_posts_url($curauth->ID),
				);
				
				// sameAs - if user website url provided in profile
				if ( isset($curauth->user_url) && $curauth->user_url != '' ) $schema['sameAs'] = esc_url( $curauth->user_url );
				
				if ( schema_wp_validate_gravatar( $curauth->user_email ) ) {
					// Default = 96px, since it is a squre image, width = height
					$image_size	= apply_filters( 'schema_wp_get_author_array_img_size', 96); 
					$image_url	= get_avatar_url( $curauth->user_email, $image_size );
					
					$schema['image'] = array
					(
						'@type'		=> 'ImageObject',
						'url' 		=> $image_url,
						'height' 	=> $image_size, 
						'width' 	=> $image_size
					);
				}
			}
			
			return apply_filters( 'schema_author_archive_output', $schema );
		}
	}
	
	new Schema_WP_Author_Archive();
	
endif;
