<?php
/**
 * @package Schema Premium - Extension : Defragment Graph Class
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_Graph') ) :
	/**
	 * Class
	 *
	 * @since 1.0.0
	 */
	class Schema_WP_Graph {
		
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
		
			add_filter( 'schema_singular_output', array( $this, 'graph' ) );
			add_filter( 'schema_output_Blog', array( $this, 'graph' ) );
			add_filter( 'schema_terms_output', array( $this, 'graph' ) );
			add_filter( 'schema_post_type_archive_output', array( $this, 'graph' ) );
			
		}
		
		/**
		* Graph
		*
		* @since 1.0.0
		* @return string
		*/
		public function graph( $schema ) {
			
			// Debug
			//echo'<pre>';print_r($schema);echo'</pre>';

			// Output only on specific locations
			//
			//if ( is_home() || is_front_page() || ! is_singular() )
			//	return $schema;

			// Build graph
			//
			$graph = array(
				'@context'	=> 'https://schema.org',
				'@graph'	=> array()
			);

			// Get breadcrumbs
			//
			$breadcrumbs = $this->breadcrumbs();

			// Single posts
			//
			if ( is_singular() && ! is_home() && ! is_front_page() ) {
				
				// Loop through schema types to implement defragmented output
				//
				if ( ! empty($schema) && is_array($schema) ) {
					
					$entities_count = count($schema);
					
					// Handle multiple schema types on same page
					//
					foreach ( $schema as $entity ) {
							
						$entity['mainEntityOfPage'] = $this->WebPage( $entity );
							
							if ( $entities_count == 1 ) {	
								// Add breadcrumbs
								//
								if ( ! empty($breadcrumbs) ) $entity['mainEntityOfPage']['breadcrumb'] = $breadcrumbs;
							}

							$graph['@graph'][] = $entity; 
					}
					
					if ( $entities_count >= 2 ) {
						// Add breadcrumbs
						//
						if ( ! empty($breadcrumbs) ) $graph['@graph'][] = $this->breadcrumbs();
					}
				}
			}

			// Home or Front Page
			//
			if ( is_home() || is_front_page() || is_archive() || is_post_type_archive() ) {

				if ( ! empty($schema) && is_array($schema) ) {
					
					$schema['mainEntityOfPage'] = $this->WebPage( $schema );

					if ( ! empty($breadcrumbs) ) $schema['mainEntityOfPage']['breadcrumb'] = $breadcrumbs;
							
					$graph['@graph'][] = $schema ;
					
				}
			}
			
			// Return final output
			//
			return apply_filters( 'schema_graph', $graph );
		}

		/**
		* WebPage
		*
		* @since 1.0.0
		* @return array
		*/
		public function WebPage( $schema ) {
			
			global $post;

			// Debug
			//echo'<pre>';print_r($schema);echo'</pre>';

			$name = isset($schema['name']) ?: $schema['headline'];

			// SiteLinks Search Box
			//
			$Website = schema_premium_get_sitelinks_search_box_markup();

			// Local Business
			//
			//$local_business_options = new schema_premium_local_business_options();
			//$local_business = $local_business_options->schema_markup();
			
			// Breadcrumbs
			//
			//$breadcrumb 	= SCHEMA_WP_Breadcrumbs_Defragment::instance();
			//$breadcrumbs 	= $breadcrumb->get_crumbs();
			
			// Primary Image Of Page
			//
			//$primaryImageOfPage = $schema['image'];
			$primaryImageOfPage = schema_wp_get_media( $post->ID );
			
			// WebPage markup
			//
			$WebPage = array(
				'@type' 				=> 'WebPage',
				'@id'					=> $schema['url'] . '#webpage',
				'url'					=> $schema['url'],
				'name'					=> $name,
				'datePublished'			=> isset($schema['datePublished']) ?: get_the_date( 'c', $post->ID ),
				'dateModified'			=> isset($schema['dateModified']) ?: get_post_modified_time( 'c', false, $post->ID, false ),
				'lastReviewed'			=> isset($schema['dateModified']) ?: get_post_modified_time( 'c', false, $post->ID, false ),
				'reviewedBy'			=> isset($schema['author']) ?: schema_wp_get_author_array( $post->ID ),
				'description'			=> $schema['description'],
				'inLanguage'			=> get_locale(), //'en-US',
				'isPartOf'				=> $Website,
				'primaryImageOfPage'	=> $primaryImageOfPage,
				//'breadcrumb'			=> $breadcrumbs,
				'potentialAction'		=> array(
					'@type'	 => 'ReadAction',
					'target' => array(
						'@type'			=> 'EntryPoint',
						'urlTemplate'	=> $schema['url']
					)
				)
			);

			return $WebPage;
		}

		/**
		* Graph
		*
		* @since 1.0.0
		* @return string
		*/
		public function breadcrumbs() {
			
			if ( class_exists('SCHEMA_WP_Breadcrumbs_Defragment') ) {

				$breadcrumbs = SCHEMA_WP_Breadcrumbs_Defragment::instance();
				$breadcrumb  = $breadcrumbs->get_crumbs();

				if ( ! empty($breadcrumb) ) {
					return $breadcrumb;
				}
			}
		}

	}

	$schema_graph = new Schema_WP_Graph();

endif;
