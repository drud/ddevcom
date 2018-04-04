<?php
if(!class_exists('Prism_WP_Settings_Page') and class_exists('Codefleet_Settings_Sub_Page')):
	/**
	* Class for plugin settings extending our base class
	*/
	class Prism_WP_Settings_Page extends Codefleet_Settings_Sub_Page {
		
		protected $view; // Holds the instance of view
		
		/**
		* Initialize 
		*/
		public function __construct( $view ) {
			parent::__construct();
			// Dependency injections
			$this->view = $view;
			
			add_filter( 'plugin_action_links', array( $this, 'settings_link' ), 10, 2 );
		}
		
		/**
		* Add a "Settings" link to the plugins page 
		*/
		function settings_link( $links, $file ) {

			if ( 'prism-wp/prism-wp.php' == $file )
				$links[] = '<a href="' . admin_url( 'options-general.php?page=prism-wp-settings' ) . '">' . __( 'Settings', 'prism-wp' ) . '</a>';
	
			return $links;
		}
	
		/**
		* Render settings page. This function should echo the HTML form of the settings page.
		*/
		public function render_settings_page($post){
			$this->view->set_view_file( PRISM_WP_PATH . 'views/settings-page.php' );
            
			$settings_data = $this->get_settings_data();
			
            $vars = array();
            $vars['page_title'] = $this->page_title;
            $vars['screen_icon'] = get_screen_icon('options-general'); ;
            
			$vars['settings_fields'] = $this->settings_fields( $this->option_group );
			$vars['option_name'] = $this->option_name;
			
			$vars['settings_data'] = $settings_data;
			
			$vars['debug'] = (PRISM_WP_DEBUG) ? prism_wp_debug( $vars['settings_data'] ) : '';
            
            $this->view->set_vars( $vars );
            $this->view->render();
		}
		
		/**
		* Validate data from HTML form
		*/
		public function validate_options( $input ) {
			$input = wp_parse_args($input, $this->get_settings_data());

			if( isset($_POST['reset']) ){
				$input = $this->get_default_settings_data();
				add_settings_error( $this->menu_slug, 'restore_defaults', __( 'Default options restored.', 'cycloneslider'), 'updated fade' );
			} else {
				
			}
			return $input;
		}
		
		/**
		* Apply default values
		*/
		public function get_default_settings_data() {
			$defaults = array();
			
			$defaults['theme'] = 'default';
			
			$defaults['language_bash'] = 1;
			$defaults['language_c'] = 1;
			$defaults['language_coffeescript'] = 1;
			$defaults['language_cpp'] = 1;
			$defaults['language_csharp'] = 1;
			$defaults['language_css'] = 1;
			$defaults['language_css_extras'] = 1;
			$defaults['language_gherkin'] = 1;
			$defaults['language_groovy'] = 1;
			$defaults['language_http'] = 1;
			$defaults['language_java'] = 1;
			$defaults['language_javascript'] = 1;
			$defaults['language_markup'] = 1;
			$defaults['language_php'] = 1;
			$defaults['language_php_extras'] = 1;
			$defaults['language_python'] = 1;
			$defaults['language_ruby'] = 1;
			$defaults['language_scss'] = 1;
			$defaults['language_sql'] = 1;
			
			$defaults['line_highlight'] = 0;
			$defaults['line_numbers'] = 0;
			$defaults['show_invisibles'] = 0;
			$defaults['autolinker'] = 0;
			$defaults['wpd'] = 0;
			$defaults['file_highlight'] = 0;
			
			
			$defaults['load_scripts_in'] = 'footer';
			$defaults['script_priority'] = 100;
			return $defaults;
		}
		
		
	} // end class
	
endif;