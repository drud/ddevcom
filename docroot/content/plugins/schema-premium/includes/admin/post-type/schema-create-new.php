<?php
/**
 * Create New Schema ACF Options Page Class
 *
 * @package     Schema
 * @subpackage  Functions
 * @copyright   Copyright (c) 2020, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists('schema_premium_acf_options_create_new_type') ) :

	class schema_premium_acf_options_create_new_type {
		
		/** @var array Contains the current options page */
		var $page;
		
		/** @var array Contains the current options page slug */
		protected $menu_slug = 'schema-create-new';

		/** @var array Contains options prefix */
		protected $prefix = 'schema_create_new_';

		/** @var array Contains the current options page title */
		protected $menu_title = 'Schema Create New';
		
		/*
		*  __construct
		*
		*  Initialize filters, action, variables and includes
		*
		*  @type	function
		*  @date	03/09/2020
		*  @since	1.0.0
		*
		*  @param	n/a
		*  @return	n/a
		*/
		
		function __construct() {
			
			// add menu items
			add_action( 'admin_menu', array($this, 'admin_menu'), 20 );
			add_action( 'admin_menu', array($this, 'admin_menu_remove'), 99 );
			
			add_action( 'admin_url', array($this, 'add_new_post_url'), 10, 3 );
			
			add_action( 'acf/init', array($this, 'add_options_page') );
			add_action( 'acf/init',  array($this, 'fields_schemas') );
			add_action( 'acf/init',  array($this, 'fields_location') );
			add_action( 'acf/init',  array($this, 'fields_ready') );

			add_action( 'acf/save_post', array($this, 'save_post'), 20 );
			add_action( 'acf/options_page/submitbox_before_major_actions',  array($this, 'steps') );

			add_action( 'acf/input/admin_footer', array($this, 'acf_disable_repeater_add_row') );

			add_action( 'admin_enqueue_scripts', array($this, 'load_styles') );
		}
		
		/*
		*  page_title
		*
		*  description
		*
		*  @type	function
		*  @date	10/09/2020
		*  @since	1.0.0
		*
		*  @param	
		*  @return string
		*/
		
		function page_title() {
			
			return __('Add New Schema', 'schema-premium');
		}


		/*
		*  admin_menu
		*
		*  description
		*
		*  @type	function
		*  @date	03/09/2020
		*  @since	1.0.0
		*
		*  @param	
		*  @return	
		*/
		
		function admin_menu() {
			
			add_submenu_page(
				'schema',
				__( 'Add New', 'schema-premium' ),
				__( 'Add New', 'schema-premium' ),
				'manage_schema_options',
				'admin.php?page=' . $this->menu_slug
			);
		}

		/*
		*  Remove admin menu
		*
		*  description
		*
		*  @type	function
		*  @date	03/09/2020
		*  @since	1.0.0
		*
		*  @param	
		*  @return	
		*/
		
		function admin_menu_remove() {
			
			remove_menu_page( $this->menu_slug );
		}

		/*
		* Get screens
		*
		*  description
		*
		*  @type	function
		*  @date	10/09/2020
		*  @since	1.0.0
		*
		*  @param	
		*  @return array	
		*/
		function get_screens() {

			$slug_toplevel 	= 'toplevel_page_' .  $this->menu_slug;
			$slug 			= $this->menu_slug . '_page_' . $this->menu_slug . '-';

			return array(
				$slug_toplevel		=> __('Select Schema', 		'schema-premium'),
				$slug . 'location'	=> __('Target Location', 	'schema-premium'),
				$slug . 'ready' 	=> __('Ready!', 			'schema-premium'),
			);
		}

		/*
		* Get sub pages
		*
		*  description
		*
		*  @type	function
		*  @date	10/09/2020
		*  @since	1.0.0
		*
		*  @param	
		*  @return array	
		*/
		function get_sub_pages() {

			$slug_toplevel 	= 'toplevel_page_' .  $this->menu_slug;
			$slug_prefix 	= $this->menu_slug . '_page_' . $this->menu_slug . '-';

			return array(
				
				'location' => array
					(
						'menu_title' 	=> __('Target Location', 'schema-premium'),
						'slug' 			=> $slug_prefix . 'location'
					),
				'ready' => array
					(
						'menu_title' 	=> __('Ready!', 'schema-premium'),
						'slug' 			=> $slug_prefix . 'ready'
					)
			);
		}

		/*
		* Check if it's an options page
		*
		*  description
		*
		*  @type	function
		*  @date	10/09/2020
		*  @since	1.0.0
		*
		*  @param	
		*  @return	
		*/
		function is_options_page() {

			$current_screen = get_current_screen();
			$screens 		= $this->get_screens();

			foreach ( $screens as $screen => $details ) {
				if ( $screen == $current_screen->id )
					return true;
			}

			return false;
		}

		/*
		*  acf/init : Add options page
		*
		*  description
		*
		*  @type	function
		*  @date	03/09/2020
		*  @since	1.0.0
		*
		*  @param	
		*  @return	
		*/
		
		function add_options_page() {
			
			// Check function exists
			//
			if ( function_exists('acf_add_options_page') ) {

				// Define menu slug
				//
				$menu_slug = $this->menu_slug . '-';

				// Add parent.
				//
				$parent = acf_add_options_page(array(
					'page_title'		=> $this->page_title(),
					'menu_title'		=> $this->menu_title,
					'menu_slug'			=> $this->menu_slug,
					'capability'		=> 'manage_options', // manage_schema_options || edit_posts 
					//'post_id' 			=> 'options',
					'redirect'			=> false,
					'icon_url'			=> 'dashicons-screenoptions',
					//'position'		=> 22,
					//'autoload' 			=> true,
					'update_button'		=> __('Start', 'schema-premium'),
					'updated_message' 	=> __('Schema has been updated', 'schema-premium'),
				));
				
				// Check function exists
				//
				if ( function_exists('acf_add_options_sub_page') ) {
					
					// Get sub pages
					//
					$sub_pages = $this->get_sub_pages();

					// Define update button
					//
					$update_button = __('Next', 'schema-premium');

					foreach ( $sub_pages as $slug => $details ) {

						// Define update button for last step
						//
						if ( $slug == 'ready' ) {
							$update_button = __('Create & Configure Properties', 'schema-premium');
						}

						// Add sub pages
						//
						$child = acf_add_options_sub_page(array(
							'page_title'  	=> $this->page_title() . ': ' . $details['menu_title'],
							'menu_title'  	=> $details['menu_title'],
							'parent_slug' 	=> $parent['menu_slug'],
							'menu_slug'   	=> $menu_slug . $slug,
							'update_button'	=> $update_button,
						));
					}
				} // end of check function exists acf_add_options_sub_page

			} // end of check function exists acf_add_options_page
			
		}

		/*
		*  Hook into options page after save.
		*
		*  description
		*
		*  @type	function
		*  @date	03/09/2020
		*  @since	1.0.0
		*
		*  @param	
		*  @return	
		*/
		
		function save_post( $post_id ) {
			
			if ( ! isset($post_id) || $post_id != 'options' || ! $this->is_options_page() )
				return;

			$current_screen = get_current_screen();

			if ( ! isset( $current_screen ) ) {
				return;
			}
			
			// Get newly saved values.
			//$values = get_fields( $post_id );
			//$schema_locations = get_field('schema_locations', 'option');

			// Debug
			//error_log( print_r( $current_screen, true ) );
			//error_log( print_r( $schema_locations, true ) );
			//exit;

			$page = $this->menu_slug . '-location';

			switch ( $current_screen->id ) {

				case $this->menu_slug . '_page_' . $this->menu_slug . '-location';
					$page = $this->menu_slug . '-ready';
					break;

				case $this->menu_slug . '_page_' . $this->menu_slug . '-ready';

					$values = get_fields( $post_id );

					$type = $values['schema_create_new_type'];
					
					// Create post object for schema.org type
					//
					$new_schema_type = array(
						'post_title'    => wp_strip_all_tags( $type ),
						'post_type'   	=> 'schema',
						'post_status'   => 'publish',
						'post_author'   => 1,
						'meta_input'   => array(
							'_schema_type' => $type,
						),
					);
					
					// Insert the post into the database
					//
					$new_post_id = wp_insert_post( $new_schema_type );
					
					if( ! is_wp_error( $new_post_id ) ) {
						
						// Post is valid
						//
						$schema_locations = get_field('schema_locations', 'option');

						// Save options
						//
						update_field( 'schema_locations', $schema_locations, $new_post_id ); 

						// Delete options, clean behind
						//
						delete_field( 'schema_create_new_type', 'option' );
						delete_field( 'schema_locations', 		'option' );

						// Delet location targets transient on Schema type creation
						//
						delete_transient('schema_location_targets_query');

						// Will redirect to schema type edit page
						// Jumping to properties post meta group
						//
						wp_redirect( 'post.php?post=' . $new_post_id . '&action=edit#acf-schema_properties_group' ); exit;

					} else {
						
						// There was an error in the post insertion, 
						//
						echo $new_post_id->get_error_message();

						// Log error
						//
						error_log( $new_post_id->get_error_message() );
					}

					break;
			}
			
			wp_redirect( 'admin.php?page=' . $page ); exit;
		}

		/*
		*  Steps.
		*
		*  description
		*
		*  @type	function
		*  @date	03/09/2020
		*  @since	1.0.0
		*
		*  @param	
		*  @return	
		*/
		
		function steps() {
			
			if ( ! $this->is_options_page() )
				return;	

			$current_screen = get_current_screen();
			$screens 		= $this->get_screens();

			// debug
			//echo'<pre>';print_r($current_screen);echo'</pre>';
			//echo'<pre>';print_r($screens);echo'</pre>';

			$steps = '<div class="container">';
			$steps .= '<ul class="progressbar">';
			
			foreach ( $screens as $screen => $details ) {
				$active = ($screen == $current_screen->id) ? 'active' : '';
				$steps .= '<li class="' . $active . '">' . $details . '</li>';
			}
			
			$steps .= '</ul>';
			$steps .= '</div>';

			echo $steps;
		}

		/*
		*  Get schemaorg types choices.
		*
		*  description
		*
		*  @type	function
		*  @date	08/10/2020
		*  @since	1.0.0
		*
		*  @param	
		*  @return	
		*/
		
		function get_types() {

			if ( ! function_exists('schema_premium_get_supported_schemas') ) 
				return array();
			
			$schema_types = schema_premium_get_supported_schemas();

			//echo'<pre>';print_r($schema_types);echo'</pre>';

			if ( is_array($schema_types) ) {
				
				foreach ( $schema_types as $schema => $label ) {
					
					switch( $schema ) {
						case 'Thing':
							$icon = '<span class="dashicons dashicons-archive"></span>';
							$icon = '<i class="fas fa-circle"></i>';
							break;
						
						case 'Organization':
							$icon = '<span class="dashicons dashicons-art"></span>';
							$icon = '<i class="fas fa-building"></i>';
							break;
							
						case 'CreativeWork':
							$icon = '<span class="dashicons dashicons-art"></span>';
							$icon = '<i class="fas fa-globe"></i>';
							break;

						case 'Article':
							$icon = '<span class="dashicons dashicons-text-page"></span>';
							$icon = '<i class="fas fa-newspaper"></i>';
							break;

						case 'BlogPosting':
							$icon = '<span class="dashicons dashicons-admin-post"></span>';
							$icon = '<i class="fas fa-rss"></i>';
							break;
						
						case 'Book':
							$icon = '<span class="dashicons dashicons-book"></span>';
							$icon = '<i class="fas fa-book"></i>';
							break;
						
						case 'Course':
							$icon = '<span class="dashicons dashicons-admin-page"></span>';
							$icon = '<i class="fas fa-book-reader"></i>';
							break;

						case 'Event':
							$icon = '<span class="dashicons dashicons-calendar-alt"></span>';
							$icon = '<i class="far fa-calendar-alt"></i>';
							break;

						case 'FAQPage':
							$icon = '<span class="dashicons dashicons-editor-help"></span>';
							$icon = '<i class="fas fa-question-circle"></i>';
							break;
						
						case 'HowTo':
							$icon = '<span class="dashicons dashicons-list-view"></span>';
							$icon = '<i class="fas fa-list-alt"></i>';
							break;
						
						case 'JobPosting':
							$icon = '<span class="dashicons dashicons-businessman"></span>';
							$icon = '<i class="fas fa-user-tie"></i>';
							break;

						case 'LocalBusiness':
							$icon = '<span class="dashicons dashicons-building"></span>';
							$icon = '<i class="fas fa-building"></i>';
							break;

						case 'Movie':
							$icon = '<span class="dashicons dashicons-format-video"></span>';
							$icon = '<i class="fas fa-film"></i>';
							break;
						
						case 'Person':
							$icon = '<span class="dashicons dashicons-admin-users"></span>';
							$icon = '<i class="fas fa-user-circle"></i>';
							break;
						
						case 'Place':
							$icon = '<span class="dashicons dashicons-admin-users"></span>';
							$icon = '<i class="fas fa-map-marker-alt"></i>';
							break;

						case 'Product':
							$icon = '<span class="dashicons dashicons-products"></span>';
							$icon = '<i class="fas fa-box"></i>';
							break;	

						case 'Recipe':
							$icon = '<span class="dashicons dashicons-carrot"></span>';
							$icon = '<i class="fas fa-pepper-hot"></i>';
							break;	

						case 'Review':
							$icon = '<span class="dashicons dashicons-star-half"></span>';
							$icon = '<i class="fas fa-star-half-alt"></i>';
							break;	

						case 'Service':
							$icon = '<span class="dashicons dashicons-admin-site"></span>';
							$icon = '<i class="fas fa-globe-americas"></i>';
							break;	
						
						case 'SoftwareApplication':
							$icon = '<span class="dashicons dashicons-editor-code"></span>';
							$icon = '<i class="fas fa-laptop-code"></i>';
							break;	
						
						case 'SpecialAnnouncement':
							$icon = '<span class="dashicons dashicons-controls-volumeon"></span>';
							$icon = '<i class="fas fa-bullhorn"></i>';
							break;

						case 'WebPage':
							$icon = '<span class="dashicons dashicons-media-default"></span>';
							$icon = '<i class="fas fa-file"></i>';
							break;

						default:
							$icon = '<span class="dashicons dashicons-admin-site"></span>';
							break;
					}

					$types[$schema] = $icon . ' ' . $label;
				}

				return $types;
			}
		}

		/*
		*  Fields : Welcome.
		*
		*  description
		*
		*  @type	function
		*  @date	10/09/2020
		*  @since	1.0.0
		*
		*  @param	
		*  @return	
		*/
		
		function fields_schemas() {
			
			if( function_exists('acf_add_local_field_group') ):

				// Add Group and fields
				//
				acf_add_local_field_group(array(
					'key' 		=> 'group_' . $this->prefix . 'welcome',
					'title' 	=> __('Create New Schema.org Type', 'schma-premium'),
					'location' 	=> array(
						array(
							array(
								'param' => 'options_page',
								'operator' => '==',
								'value' => $this->menu_slug,
							),
						),
					),
					'menu_order' 			=> 0,
					'position' 				=> 'normal',
					'style' 				=> 'seamless',
					'label_placement' 		=> 'top',
					'instruction_placement' => 'field'
				));

				if ( function_exists('schema_premium_get_supported_schemas') ) {
					
					// Schema Types
					//
					acf_add_local_field(array(
						'key' 		=> 'feild_' . $this->prefix . 'type',
						'label' 	=> __('Select Schema Type', 'schema-premium'),
						'name' 		=> $this->prefix . 'type',
						'type' 		=> 'radio',
						'parent' 	=> 'group_' . $this->prefix . 'welcome',
						'choices' 	=> $this->get_types(),
						'default_value'	=> 'easy',
						'return_format'	=> 'value',
						'layout'		=> 'horizontal',
						'instructions' 	=> '',
						'class' 		=> 'schema-create-new-type'
					));
				}
				
			endif;
		}

		/*
		*  Fields : Location.
		*
		*  description
		*
		*  @type	function
		*  @date	09/10/2020
		*  @since	1.0.0
		*
		*  @param	
		*  @return	
		*/
		
		function fields_location() {
			
			if ( function_exists('acf_add_local_field_group') ):
		
				// ACF Group: Locations
				//
				//
				acf_add_local_field_group(array (
					'key' => 'schema_locations_group',
					'title' => __('Locations', 'schema-premium'),
					'location' 	=> array(
						array(
							array(
								'param' => 'options_page',
								'operator' => '==',
								'value' => $this->menu_slug . '-location',
							),
						),
					),
					'menu_order' => 10,
					'position' => 'normal',
					'style' => 'default',
					'label_placement' => 'left',
					'instruction_placement' => 'label',
					'hide_on_screen' => '',
					'active' => 1,
					'description' => '',
				));
			
			endif;
		}

		/*
		*  Fields : Ready.
		*
		*  description
		*
		*  @type	function
		*  @date	09/10/2020
		*  @since	1.0.0
		*
		*  @param	
		*  @return	
		*/

		function fields_ready() {
			
			if( function_exists('acf_add_local_field_group') ):

				// Add Group and fields
				//
				acf_add_local_field_group(array(
					'key' 		=> 'group_' . $this->prefix . 'ready',
					'title' 	=> __('Ready!', 'schma-premium'),
					'location' 	=> array(
						array(
							array(
								'param' => 'options_page',
								'operator' => '==',
								'value' => $this->menu_slug . '-ready',
							),
						),
					),
					'menu_order' 			=> 0,
					'position' 				=> 'normal',
					'style' 				=> 'seamless',
					'label_placement' 		=> 'left',
					'instruction_placement' => 'field'
				));

				// Message
				//
				$msg =  '<p>' . __('Your new schema.org type is ready for creation!', 'schema-premium') . '</p>';
				$msg .=  '<p>' . __('Click on the create and configure properties button.', 'schema-premium') . '</p>';
				$msg .=  '<p><span class="dashicons dashicons-info-outline"></span> '. __('Lean more about', 'schema-premium') .' <a target="_blank" href="https://schema.press/docs-premium/properties/">' . __('how to configure properties', 'schema-premium') . '</a></p>';
			
				acf_add_local_field(array(
					'key' 		=> 'feild_' . $this->prefix . 'site_ready_next_step_msg',
					'name' 		=> $this->prefix . 'site_ready_next_step_msg',
					'label' 	=> __('Final Step...', 'schema-premium'),
					'type' 		=> 'message',
					'parent' 	=> 'group_' . $this->prefix . 'ready',
					'message' 	=> $msg
				));

				acf_add_local_field(array(
					'key' 		=> 'feild_' . $this->prefix . 'final_step',
					'label' 	=> '',
					'name' 		=> $this->prefix . 'final_step',
					'type' 		=> 'text',
					'parent' 	=> 'group_' . $this->prefix . 'ready',
					'default_value' => '',
					'placeholder' => '',
					'instructions' 	=>'',
					'readonly' => 1,
					'class'	=> 'schema-create-new-final-step'
				));

			endif;
		}
		
		/*
		*  ACF : Disable drag and drop for repeater
		*
		*  description
		*
		*  @type	function
		*  @date	09/10/2020
		*  @since	1.0.0
		*
		*  @param	
		*  @return	
		*/

		function acf_disable_repeater_add_row() {
			
			if ( ! $this->is_options_page() )
				return;	

			//if ( ! function_exists('get_current_screen') )
			//	return;
		
			//$screen = get_current_screen();
			/*
			 * Check if current screen is Schema post type
			 * Don't output script if it's not
			 */
			//if ( $screen->post_type != 'schema' )
				//return;
				
			?>
			<script type="text/javascript">
				(function($) {
					if (typeof acf !== 'undefined') {
						/*$.extend( acf.fields.repeater, {
							_mouseenter: function( e ){
								if( $( this.$tbody.closest('.acf-field-repeater') ).hasClass('disable-sorting') ){
									return;
								}
							}
						});*/
						$('.acf-row-handle a[data-event="add-row"]').remove();
						$('.acf-actions a').removeClass('button-primary')
					}
				})(jQuery);
			</script>
			<?php
		}

		/*
		*  Override "New Post" URL
		*
		*  description
		*
		*  @type	function
		*  @date	13/10/2020
		*  @since	1.0.0
		*
		*  @param	
		*  @return	
		*/

		function add_new_post_url( $url, $path, $blog_id ) {
			
			// Global object containing current admin page
			global $pagenow;
			
			if ( $pagenow == 'post.php' || $pagenow == 'edit.php' ) {
				
				if ( $path == "post-new.php?post_type=schema" ) {
					$url = 'admin.php?page=' . $this->menu_slug;
				}
			}
			return $url;
		}

		/*
		*  Load styles
		*
		*  description
		*
		*  @type	function
		*  @date	12/10/2020
		*  @since	1.0.0
		*
		*  @param	
		*  @return	
		*/

		function load_styles() {

			if ( ! $this->is_options_page() || ! defined( 'SCHEMAPREMIUM_PLUGIN_URL' ) )
				return;

			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			wp_enqueue_style( 'font-awesome', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css");

			wp_enqueue_style( 'schema-admin-options', SCHEMAPREMIUM_PLUGIN_URL . 'assets/css/admin-options' . $suffix . '.css', SCHEMAPREMIUM_VERSION );
		}
	}
	
	// initialize
	//
	new schema_premium_acf_options_create_new_type();
	
endif;

