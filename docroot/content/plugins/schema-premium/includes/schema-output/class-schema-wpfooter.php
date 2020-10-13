<?php
/**
 * @package Schema Premium - Class Schema WPFooter
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
	
if ( ! class_exists('Schema_WP_WPFooter') ) :
	/**
	 * Schema WPFooter
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_WPFooter {
		
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
			
			add_action( 'schema_output_after_after', array( $this, 'output_markup' ), 20 );
		}
		
		/**
		* Get markup output
		*
		* @since 1.0.0
		* @return array
		*/
		public function output_markup() {
			
			// Filter this and return false to disable the function
			$enabled = apply_filters( 'schema_wp_output_wpfooter_enabled', true );
				if ( ! $enabled )
					return;
				
			//if ( is_singular() && schema_wp_get_option( 'wpheader_enable' ) ) {
			if ( schema_wp_get_option( 'wpfooter_enable' ) ) {	
				// Add action to hook to this function
				do_action( 'schema_wp_action_wpfooter' );
				
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
	
			// get post type
			$post_type 		= get_post_type();
			
			// set defaults
			$headline  		= wp_filter_nohtml_kses( get_the_title() );
			$description 	= get_bloginfo( 'description' );
			$url			= get_bloginfo( 'url' );
			
			if ( is_404() ) {
				// 404
				$headline		= __( 'Page not found', 'schema-premium' );
				$description 	= __('It looks like nothing was found at this location!', 'schema-premium');
				$url			= '';
			} elseif ( is_front_page() && is_home() ) {
				// Default homepage
				$headline 		= get_bloginfo( 'name' );
				$description 	= get_bloginfo( 'description' );
				$url			= get_bloginfo( 'url' );
			} elseif ( is_front_page() ) {
				// static homepage
				$headline 		= get_bloginfo( 'name' );
				$description 	= get_bloginfo( 'description' );
				$url			= get_bloginfo( 'url' );
			} elseif ( is_home() ) {
				// blog page
				$headline 		= get_bloginfo( 'name' );
				$description 	= get_bloginfo( 'description' );
				$url			= schema_wp_get_blog_posts_page_url();
			} else {
				//everything else
				
				// get enabled post types
				$schema_enabled = schema_wp_cpt_get_enabled_post_types();
				
				if ( in_array( $post_type , $schema_enabled ) ) {
					if ( is_single() || is_singular() ) {
						// single and singular pages
						$headline 		= wp_filter_nohtml_kses( get_the_title() );
						$description 	= schema_wp_get_description();
						$url			= get_permalink();
					}
				}
				
			}
			
			if ( is_archive() ) {
				// archive pages
				$headline 		= get_the_archive_title();
				$description 	= get_the_archive_description();
				$url			= '';
			}
			
			if ( is_post_type_archive() ) {
				// post type archive pages
				$headline 		= post_type_archive_title( __(''), false );
				$obj 			= get_post_type_object($post_type);
				$description 	= isset($obj->description) ? $obj->description : '';
				$url			= schema_premium_get_archive_link($post_type) ? schema_premium_get_archive_link($post_type) : get_home_url();
			}
			
			if ( is_search() ) {
				// search
				$query			= get_search_query();
				$headline 		= sprintf( __( 'Search Results for &#8220;%s&#8221;' ), $query );
				$url			= get_search_link( $query );
				$description	= $wp_query->found_posts.' search results found for "'.$query.'".';
			}
			
			/*
			*	WPHeader
			*/
			$footer = array(
				'@context' 		=> 'http://schema.org/',
				'@type'			=> 'WPFooter',
				'url'			=> $url,
				'headline'		=> wp_strip_all_tags($headline),
				'description'	=> wp_trim_words( wp_strip_all_tags($description), 18, '...' ),
			);
	
			// Add copyrightYear to Footer singulars
			if (is_singular() ) {
				$footer['copyrightYear'] = 	get_the_date('Y');
			}
	
			return apply_filters( 'schema_wpfooter_output', $footer );
		}
	}
	
	new Schema_WP_WPFooter();
	
endif;
