<?php
/**
 * @package Schema Premium - Class Schema About Page
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
	
if ( ! class_exists('Schema_WP_SpecialPage_AboutPage') ) :
	/**
	 * Schema About Page
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_SpecialPage_AboutPage {
		
		/** @var string Currenct Type */
    	protected $type = 'AboutPage';
		
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
			
			// Remove other markup added by other types
			add_action( 'schema_singular_output', array( $this, 'output_no_markup' ) );
			
			// Add AboutPage markup
			add_action( 'schema_markup_output', array( $this, 'output_markup' ) );
			
		}
		
		/**
		* Remove markup added by other types
		*
		* @since 1.0.0
		* @return array
		*/
		public function output_no_markup( $schema ) {
			
			global $post;
			
			$page_id = schema_wp_get_option( 'about_page' );
			
			if ( isset($page_id) && $page_id == $post->ID ) {
				return array();
			}
			
			return $schema;
		}
		
		/**
		* Get markup output
		*
		* @since 1.0.0
		* @return array
		*/
		public function output_markup() {
			
			// Filter this and return false to disable the function
			$enabled = apply_filters( 'schema_wp_output_AboutPage_enabled', true );
				if ( ! $enabled )
					return;
				
			if ( is_singular() ) {
				
				// Add action to hook to this function
				do_action( 'schema_wp_action_AboutPage' );
				
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
			
			global $post;
			
			$page_id = schema_wp_get_option( 'about_page' );
			
			// var
			$schema = array();
			
			if ( isset($page_id) && $page_id == $post->ID ) {
				// Get schema markup
				$schema_markup 	= new Schema_WP_Output();
				$schema			= $schema_markup->get_schema( $post->ID, $this->type );
			}
			
			return apply_filters( 'schema_singular_output_AboutPage', $schema );
		}
		
		/**
		* Properties
		*
		* @since 1.0.0
		* @return array
		*/
		public function properties() {
		}
		
		/**
		* Schema output
		*
		* @since 1.0.0
		* @return array
		*/
		public function schema_output( $post_id = null ) {
			
			if ( isset($post_id) ) {
				$post = get_post( $post_id );
			} else {
				global $post;
			}
			
			$schema			= array();
			
			// Putting all together
			//
			$schema['@context'] 			=  'http://schema.org';
			$schema['@type'] 				=  $this->type;
		
			$schema['mainEntityOfPage'] 	= array
			(
				'@type' => 'WebPage',
				'@id' => get_permalink( $post->ID )
			);
	
			$schema['url'] 					= get_permalink( $post->ID );
	
			// Truncate headline 
			$headline						= schema_wp_get_the_title( $post->ID );
			$schema['headline']				= apply_filters( 'schema_wp_filter_headline', $headline );
			
			$schema['alternativeHeadline']	= get_post_meta( $post->ID, 'schema_properties_Article_alternativeHeadline', true );
			
			$schema['description']			= schema_wp_get_description( $post->ID );
	
			$schema['datePublished']		= get_the_date( 'c', $post->ID );
			$schema['dateModified']			= get_post_modified_time( 'c', false, $post->ID, false );
	
			$schema['articleSection']		= schema_wp_get_post_category( $post->ID );
			$schema['keywords']				= schema_wp_get_post_tags( $post->ID );
	
			$schema['image'] 				= schema_wp_get_media( $post->ID );
	
			$schema['publisher']			= schema_wp_get_publisher_array();
			
			return apply_filters( 'schema_output_AboutPage', $schema );
		}
	}
	
	new Schema_WP_SpecialPage_AboutPage();
	
endif;
