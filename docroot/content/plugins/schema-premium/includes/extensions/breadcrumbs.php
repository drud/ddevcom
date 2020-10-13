<?php
/**
 * Class Schema WP Breadcrumb.
 *
 * @package  JSON_LD_Breadcrumbs
 *
 * Credits: https://wordpress.org/plugins/json-ld-breadcrumbs/
 */

// Exit if the file is called directy by URL.
defined( 'ABSPATH' ) or exit;


if ( ! class_exists( 'SCHEMA_WP_Breadcrumbs' ) ) {

	/**
	 * Class JSON LD Breadcrumb.
	 *
	 * @since  1.0.0
	 */
	class SCHEMA_WP_Breadcrumbs {

		/**
		 * Instance of JSON_LD_Breadcrumbs
		 *
		 * @since  v1.0.0
		 * @var Object JSON_LD_Breadcrumbs
		 */
		private static $_instance = null;

		/**
		 * Crumb position. Increases everytime a new crumb is added.
		 *
		 * @since  1.0.0
		 * @var integer
		 */
		private $crumb_position = 0;

		/**
		 * Crunbs Array
		 *
		 * @since  1.0.0
		 * @var array
		 */
		private $crumbs = array();

		/**
		 * Initiate the class JSON_LD_Breadcrumbs
		 *
		 * @since  1.0.0
		 * @return (Object) Instance of JSON_LD_Breadcrumbs
		 */
		public static function instance() {
			if ( ! isset( self::$_instance ) ) {
				self::$_instance = new self;
			}

			return self::$_instance;
		}

		/**
		 * Constructor.
		 *
		 * @since  1.0.0
		 */
		private function __construct() {
			
			$breadcrumbs_enable = schema_wp_get_option( 'breadcrumbs_enable' );
	
			if ( $breadcrumbs_enable ) {
				
				// if Breadcrumbs is enabled within the plugin settings
				
				$this->post           = ( isset( $GLOBALS['post'] ) ? $GLOBALS['post'] : null );
				$this->show_on_front  = get_option( 'show_on_front' );
				$this->page_for_posts = get_option( 'page_for_posts' );
				
				add_action( 'schema_output_before', array( $this, 'set_crumbs' ) , 10 );
			}
		}

		/**
		 * Initialize the Schema for the breadcrumbs markup.
		 *
		 * @since  1.0.0
		 *
		 * @param  (Array) $breadcrumb Breadcrumbs array.
		 *
		 * @return (Array) $breadcrumb Breadcrumbs array.
		 */
		private function initialize_breadcrumb_schema( $breadcrumb ) {
			if ( schema_wp_is_blog() ) {
				$url = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : get_home_url();	
			} else {
				$url = get_permalink();
			}
			$breadcrumb['@context'] = 'http://schema.org';
			$breadcrumb['@type']    = 'BreadcrumbList';
			$breadcrumb['@id']  	= $url . '#breadcrumb';
			$breadcrumb['url']  	= $url;
			//$breadcrumb['name'] 	= 'Breadcrumb'; // Maybe not needed!

			return $breadcrumb;
		}

		/**
		 * Adds homepage to the breadcrumb.
		 *
		 * @since  1.0.0
		 */
		private function maybe_add_home_crumb() {
			// TODO: (Done) Add option in the admin panel to enable or disable home page in breadcrumb.
			// TODO: (Done) Add option in the admin panel to choose the text for home page.
			$breadcrumbs_home_enabled 	= schema_wp_get_option( 'breadcrumbs_home_enable' );
	
			if ( $breadcrumbs_home_enabled ) {
				
				$home_text = schema_wp_get_option( 'breadcrumbs_home_text' ) ? schema_wp_get_option( 'breadcrumbs_home_text' ) : __('Home', 'schema-premium');
				
				$this->add_crumb(
					$home_text, // Default is Home
					get_site_url()
				);
			}
		}

		/**
		 * Conditionally adds blog page to the breadcrumb.
		 *
		 * @since  1.0.0
		 */
		private function maybe_add_blog_crumb() {
			if ( ( 'page' === $this->show_on_front && 'post' === get_post_type() ) && ( ! is_home() && ! is_search() ) ) {
				if ( $this->page_for_posts ) {
					$this->add_crumb( wp_filter_nohtml_kses( get_the_title( $this->page_for_posts ) ), get_permalink( $this->page_for_posts ) );
				}
			}
		}

		/**
		 * Add crumb to the breadcrumbs array.
		 *
		 * @since  1.0.0
		 *
		 * @param String $name Name of the Breadcrumb element.
		 * @param string $url URL of the Breadcrumb element.
		 * @param string $image Image URL of the Breadcrumb element.
		 */
		private function add_crumb( $name, $url = '', $image = '' ) {
			$this->crumb_position = $this->crumb_position + 1;

			if ( '' == $image ) {
				$this->crumbs[] = array(
					'@type'    => 'ListItem',
					'position' => $this->crumb_position,
					'item'     => array(
						'@type' => 'WebPage',
						'@id'  	=> $url,
						'url'  	=> $url,
						'name' 	=> $name,
					),
				);
			} else {
				$this->crumbs[] = array(
					'@type'    => 'ListItem',
					'position' => $this->crumb_position,
					'item'     => array(
						'@type' => 'WebPage',
						'@id'   => $url,
						'url'  	=> $url,
						'name'  => $name,
						'image' => $image,
					),
				);
			}
		}

		/**
		 * Post type archive title.
		 *
		 * @since  1.0.0
		 *
		 * @param  string $pt The name of a registered post type.
		 *
		 * @return String     Title of the post type.
		 */
		private function post_type_archive_title( $pt ) {
			$archive_title = '';

			$post_type_obj = get_post_type_object( $pt );
			if ( is_object( $post_type_obj ) ) {
				if ( isset( $post_type_obj->label ) && '' !== $post_type_obj->label ) {
					$archive_title = $post_type_obj->label;
				} elseif ( isset( $post_type_obj->labels->menu_name ) && '' !== $post_type_obj->labels->menu_name ) {
					$archive_title = $post_type_obj->labels->menu_name;
				} else {
					$archive_title = $post_type_obj->name;
				}
			}

			return $archive_title;
		}

		/**
		 * Conditionally adds the post type archive to the breadcrumb.
		 *
		 * @since  1.0.0
		 */
		private function maybe_add_pt_archive_crumb_for_post() {
			if ( 'post' === $this->post->post_type ) {
				return;
			}
			if ( isset( $this->post->post_type ) && get_post_type_archive_link( $this->post->post_type ) ) {
				$this->add_crumb( $this->post_type_archive_title( $this->post->post_type ), get_post_type_archive_link( $this->post->post_type ) );
			}
		}

		/**
		 * Conditionally adds taxanomy titles to the breadcrumb.
		 *
		 * @since  1.0.0
		 */
		private function maybe_add_taxonomy_crumbs_for_post() {
			
			$schema_option = schema_wp_get_option( 'breadcrumbs_taxonomy' );
			
			// Debug
			//echo'<pre>';print_r($schema_option);echo'</pre>';
			
			if ( isset($schema_option[$this->post->post_type]) ) {
				$main_tax = $schema_option[$this->post->post_type];
        		if ( isset( $this->post->ID ) ) {
            		$terms = get_the_terms( $this->post, $main_tax );
 
            		if ( is_array( $terms ) && $terms !== array() ) {

                		$primary_term = new WPSEO_Primary_Term( $main_tax, $this->post->ID );
                		if ( $primary_term->get_primary_term() ) {
                    		$breadcrumb_term = get_term( $primary_term->get_primary_term(), $main_tax );
                		} else {
                    		$breadcrumb_term = $this->find_deepest_term( $terms );
                		}
 
                		if ( is_taxonomy_hierarchical( $main_tax ) && $breadcrumb_term->parent !== 0 ) {
                    		$parent_terms = $this->get_term_parents( $breadcrumb_term );
                    		foreach ( $parent_terms as $parent_term ) {
                        		$this->add_term_crumb( $parent_term );
                    		}
                		}

						$this->add_term_crumb( $breadcrumb_term );
            		}
        		}
    		}
		}

		/**
		 * Adds post ancestor to the breadcrumb.
		 *
		 * @since  1.0.0
		 */
		private function add_post_ancestor_crumbs() {
			$ancestors = $this->get_post_ancestors();
			if ( is_array( $ancestors ) && array() !== $ancestors ) {
				foreach ( $ancestors as $ancestor ) {
					$this->add_crumb( wp_filter_nohtml_kses( get_the_title( $ancestor ) ), get_permalink( $ancestor ) );
				}
			}
		}

		/**
		 * Finds the post ancestors.
		 *
		 * @since  1.0.0
		 * @return Array Ancestors for the current page.
		 */
		private function get_post_ancestors() {
			$ancestors = array();

			if ( isset( $this->post->ancestors ) ) {
				if ( is_array( $this->post->ancestors ) ) {
					$ancestors = array_values( $this->post->ancestors );
				} else {
					$ancestors = array( $this->post->ancestors );
				}
			} elseif ( isset( $this->post->post_parent ) ) {
				$ancestors = array( $this->post->post_parent );
			}

			// Reverse the order so it's oldest to newest.
			$ancestors = array_reverse( $ancestors );

			return $ancestors;
		}
		
		/**
		 * Add a term based crumb to the crumbs property.
		 *
		 * @param object $term Term data object.
		 */
		private function add_term_crumb( $term ) {
			$this->add_crumb[] = array(
				'term' => $term,
			);
		}
	
		/**
		 * Add Taxanomies to breadcrumb.
		 *
		 * @since  1.0.0
		 */
		private function add_crumbs_for_taxonomy() {
			$term = $GLOBALS['wp_query']->get_queried_object();
			$this->add_crumb( $term->name, get_term_link( $term ) );
		}

		/**
		 * Add month to the breadcrumb.
		 *
		 * @since  1.0.0
		 */
		private function add_month_crumb() {
			$this->add_crumb(
				'Archives for ' . esc_html( single_month_title( ' ', false ) ),
				get_month_link( get_query_var( 'y' ), get_query_var( 'monthnum' ) )
			);
		}

		/**
		 * Add Month and year to breadcrumb for date archive.
		 *
		 * @since  1.0.0
		 */
		private function add_linked_month_year_crumb() {
			$this->add_crumb(
				$GLOBALS['wp_locale']->get_month( get_query_var( 'monthnum' ) ) . ' ' . get_query_var( 'year' ),
				get_month_link( get_query_var( 'year' ), get_query_var( 'monthnum' ) )
			);
		}

		/**
		 * Add date to the breadcrumb.
		 *
		 * @since  1.0.0
		 */
		private function add_date_crumb() {
			$this->add_crumb(
				'Archives for ' . esc_html( single_month_title( ' ', false ) ),
				get_day_link( get_query_var( 'year' ), get_query_var( 'monthnum' ), get_query_var( 'day' ) )
			);
		}

		/**
		 * Add year to the breadcrumb.
		 *
		 * @since  1.0.0
		 */
		private function add_year_crumb() {
			$this->add_crumb(
				'Archives for ' . esc_html( get_query_var( 'year' ) ),
				get_year_link( get_query_var( 'year' ) )
			);
		}

		/**
		 * Conditionally add individual crumbs to the breadcrumb.
		 *
		 * @since  1.0.0
		 */
		private function add_breadcrumb_crumbs() {
			global $wp_query;

			$this->maybe_add_home_crumb();
			$this->maybe_add_blog_crumb();

			if ( ( 'page' === $this->show_on_front && is_front_page() ) || ( 'posts' === $this->show_on_front && is_home() ) ) {
				// Do nothing.
			} elseif ( 'page' == $this->show_on_front && is_home() ) {
				$this->add_crumb( wp_filter_nohtml_kses( get_the_title( $this->page_for_posts ) ), get_permalink( $this->page_for_posts ) );
			} elseif ( is_singular() ) {
				$this->maybe_add_pt_archive_crumb_for_post();

				if ( isset( $this->post->post_parent ) && 0 == $this->post->post_parent ) {
					$this->maybe_add_taxonomy_crumbs_for_post();
				} else {
					$this->add_post_ancestor_crumbs();
				}

				if ( isset( $this->post->ID ) ) {
					$this->add_crumb( wp_filter_nohtml_kses( get_the_title( $this->post->ID ) ), get_permalink( $this->post->ID ), get_the_post_thumbnail_url( $this->post->ID, 'full' ) );
				}
			} else {
				if ( is_post_type_archive() ) {
					$post_type = $wp_query->get( 'post_type' );

					if ( $post_type && is_string( $post_type ) ) {
						$this->add_crumb( $this->post_type_archive_title( $post_type ), get_post_type_archive_link( $post_type ) );
					}
				} elseif ( is_tax() || is_tag() || is_category() ) {
					$this->add_crumbs_for_taxonomy();
				} elseif ( is_date() ) {
					if ( is_day() ) {
						$this->add_linked_month_year_crumb();
						$this->add_date_crumb();
					} elseif ( is_month() ) {
						$this->add_month_crumb();
					} elseif ( is_year() ) {
						$this->add_year_crumb();
					}
				} elseif ( is_author() ) {
					$user = $wp_query->get_queried_object();
					$this->add_crumb(
						'Archives for ' . $user->display_name,
						get_author_posts_url( $user->ID, $user->nicename ),
						get_avatar_url( $user->ID ) 
					);
				} elseif ( is_search() ) {
					$this->add_crumb(
						'Search results for ' . esc_html( get_search_query() ),
						get_search_link( get_query_var( 's' ) )
					);
				} elseif ( is_404() ) {
					$this->add_crumb(
						'Error 404: Page not found',
						null
					);
				}// End if().
			}// End if().

			return apply_filters( 'schema_json_ld_breadcrumb_itemlist_array', $this->crumbs );
		}

		/**
		 * Initialize the breadcrumbs.
		 *
		 * @since  1.0.0
		 */
		public function set_crumbs() {
			
			// Allow disbable/enable breadcrumbs output
			$breadcrumb_enabled = apply_filters( 'schema_wp_breadcrumb_enabled', true );
			// check if enabled
			if ( ! $breadcrumb_enabled )
				return;
			
			$breadcrumb = array();
			$breadcrumb = $this->initialize_breadcrumb_schema( $breadcrumb );

			$breadcrumb['itemListElement'] = $this->add_breadcrumb_crumbs();
			
			$markup = new Schema_WP_Output();
			$markup->json_output( $breadcrumb );
				
		}
		
		/**
		 * Get the breadcrumbs.
		 *
		 * @since  1.0.0
		 */
		public function get_crumbs() {
			
			// Allow disbable/enable breadcrumbs output
			$breadcrumb_enabled = apply_filters( 'schema_wp_breadcrumb_enabled', true );
			// check if enabled
			if ( ! $breadcrumb_enabled )
				return;
			
			$breadcrumb = array();
			$breadcrumb = $this->initialize_breadcrumb_schema( $breadcrumb );

			$breadcrumb['itemListElement'] = $this->add_breadcrumb_crumbs();
			
			return $breadcrumb;	
		}
		
	}

}// End if().

add_action( 'wp', 'SCHEMA_WP_Breadcrumbs::instance' );
