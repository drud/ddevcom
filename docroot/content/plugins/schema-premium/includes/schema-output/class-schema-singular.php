<?php
/**
 * @package Schema Premium - Class Schema Singular
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
	
if ( ! class_exists('Schema_WP_Singular') ) :
	/**
	 * Schema Singulars
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Singular {
		
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
			
			// Check if disabled
			// @since 1.1.2.8
			//
			if ( schema_premium_is_disabled() )
				return;

			// Filter this and return false to disable the function
			$enabled = apply_filters( 'schema_wp_output_singular_enabled', true );
				if ( ! $enabled )
					return;
				
			if ( is_singular() ) {
				
				// Add action to hook to this function
				do_action( 'schema_wp_action_singular' );
				
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
			
			global $post, $schema_markup_singular;
			
			// var
			$blogPost = array();
			
			// Get match of location target
			$schema_location_target = schema_premium_get_location_target_match( $post->ID );
			
			if ( !empty($schema_location_target) ) :
				
				foreach ( $schema_location_target as $locations => $location ) :
					// Run only on enabled location targets
					if ( $location['match'] ) {

						// Get final schema type
						$schema_type = ( isset($location['schema_subtype']) 
									&& $location['schema_subtype'] != ''
									&& $location['schema_subtype'] != 'General' ) ? $location['schema_subtype'] : $location['schema_type'];
			
						if ( isset($schema_type) && '' != $schema_type ) {
							// Get schema markup
							$schema_markup 	= new Schema_WP_Output();
							$item 			= $schema_markup->get_schema( $post->ID, $schema_type );
							// Make $item filterable 
							$item 			= apply_filters( 'schema_single_item_output', $item );
							$blogPost[]		= $item; // add/join markups if there is more than one schema.org type enabled on a single entry
						} // end if
					
					} // end if enabled location targets
				endforeach;
			
			endif;
			
			$schema_markup_singular = apply_filters( 'schema_singular_output', $blogPost );
			
			return $schema_markup_singular;
		}
	}
	
	new Schema_WP_Singular();
	
endif;
