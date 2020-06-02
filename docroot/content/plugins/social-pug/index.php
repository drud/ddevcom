<?php
/**
 * Plugin Name: Grow by Mediavine
 * Plugin URI: https://marketplace.mediavine.com/grow-social-pro/
 * Description: Add beautiful social sharing buttons to your posts, pages and custom post types.
 * Version: 1.7.0
 * Author: Mediavine
 * Author URI: https://marketplace.mediavine.com/
 * Text Domain: social-pug
 * Domain Path: /translations/
 * License: GPL2
 *
 * == Copyright ==
 * Copyright 2016 Mediavine (www.mediavine.com)
 *	
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */


Class Social_Pug {


	/*
	 * The Constructor
	 *
	 */
	public function __construct() {

		// Defining constants
		define('DPSP_VERSION', '1.7.0');
		define('DPSP_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . dirname( plugin_basename(__FILE__) ) );
		define('DPSP_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
		define('DPSP_TRANSLATION_DIR', DPSP_PLUGIN_DIR . '/translations' );
		define('DPSP_TRANSLATION_TEXTDOMAIN', 'social-pug' );

		// Hooks
		add_action( 'init', array( $this, 'init_translation' ) );
		add_action( 'admin_menu', array( $this, 'add_main_menu_page' ), 10 );
		add_action( 'admin_menu', array( $this, 'remove_main_menu_page' ), 11 );
		add_action( 'admin_enqueue_scripts', array( $this, 'init_admin_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'init_front_end_scripts' ) );
		add_action( 'admin_init', array( $this, 'update_database' ) );

		add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ) );
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( $this, 'add_plugin_action_links' ) );

		$this->load_resources_front_end();
		
		add_action( 'init', array( $this, 'load_resources_admin' ) );

	}


	/*
	 * Loads the translations files if they exist
	 *
	 */
	public function init_translation() {

		load_plugin_textdomain( 'social-pug', false, DPSP_TRANSLATION_DIR );

	}


	/*
	 * Add the main menu page
	 *
	 */
	public function add_main_menu_page() {
		add_menu_page( __('Grow', 'social-pug'), __('Grow', 'social-pug'), 'manage_options', 'dpsp-social-pug', '','data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDI0LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCAyMCAyMCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjAgMjA7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPHN0eWxlIHR5cGU9InRleHQvY3NzIj4KCS5zdDB7ZmlsbDojMjMxRjIwO30KPC9zdHlsZT4KPGc+Cgk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMC4wOSw3LjE1Yy0wLjAzLDAuMTktMC42Niw0Ljc0LDEuODksNy4yOWMxLjcsMS43MSw0LjMsMi4wMSw1Ljg5LDIuMDFjMC4zNywwLDAuNjgtMC4wMiwwLjkyLTAuMDMKCQljLTAuNDctMC4xNS0xLjM1LTAuNDYtMi4zLTAuOTlDNS43MSwxNSw1LjAyLDE0LjUsNC40NSwxMy45NmMtMC43Mi0wLjY5LTEuMjYtMS40NS0xLjYtMi4yN0MyLjQ5LDEwLjgxLDIuMzQsOS44MiwyLjQsOC43NQoJCWMwLjA0LTAuNzksMC4yLTEuNjMsMC40OC0yLjVjLTAuMi0wLjAxLTAuMzktMC4wMS0wLjU3LTAuMDFjLTAuNzksMC0xLjMzLDAuMDctMS4zOSwwLjA4bC0wLjcyLDAuMUwwLjA5LDcuMTV6Ii8+Cgk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNNC42OSwzLjQzTDQuMzIsNC4wNUM0LjI4LDQuMTIsMy44Nyw0LjgyLDMuNDksNS44NGMwLjg3LDAuMDgsMS42NywwLjI1LDIuNCwwLjQ5CgkJQzYuMjMsNS42NSw2LjY4LDQuOTYsNy4yNCw0LjNDNi4yNiwzLjg0LDUuNDgsMy42Myw1LjQsMy42MUw0LjY5LDMuNDN6Ii8+Cgk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMy4yNywxMS41MWMxLjEzLDIuNzUsNC4zNCw0LjA0LDUuNTQsNC40M2MtMC4xMi0wLjEtMC4yOC0wLjI0LTAuNDYtMC40Yy0wLjEzLTAuMTItMC4yOC0wLjI3LTAuNDMtMC40MgoJCWMtMC4yNy0wLjI3LTAuNTYtMC41OS0wLjg1LTAuOTZjLTAuNTYtMC43LTEuMDEtMS40Mi0xLjMzLTIuMTRjLTAuNC0wLjkxLTAuNjEtMS44Mi0wLjYtMi43MWMwLTAuNywwLjEzLTEuNDIsMC4zOS0yLjEzCgkJYzAuMDMtMC4wNywwLjA1LTAuMTQsMC4wOC0wLjIxQzUuNjQsNi44OSw1LjY3LDYuODIsNS43LDYuNzVDNS4wNSw2LjU0LDQuNCw2LjQxLDMuNzksNi4zM0MzLjcyLDYuMzIsMy42NCw2LjMxLDMuNTcsNi4zMQoJCUMzLjQ5LDYuMywzLjQyLDYuMjksMy4zNCw2LjI4QzMuMzIsNi4zNiwzLjMsNi40MywzLjI3LDYuNUMzLjI1LDYuNTcsMy4yMyw2LjY1LDMuMjEsNi43MkMyLjgxLDguMTMsMi42MSw5Ljg5LDMuMjcsMTEuNTF6Ii8+Cgk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMTAuNTksMi44MmwtMC41OC0wLjQ0TDkuNDIsMi44MkM5LjM2LDIuODcsOC43MiwzLjM1LDcuOTgsNC4xNUM4Ljc0LDQuNTYsOS40Miw1LjAyLDEwLDUuNTMKCQljMC41OC0wLjUxLDEuMjYtMC45NiwyLjAzLTEuMzZDMTEuMjksMy4zNiwxMC42NSwyLjg3LDEwLjU5LDIuODJ6Ii8+Cgk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNNi41Myw2LjU5QzYuNiw2LjYyLDYuNjcsNi42NSw2Ljc0LDYuNjhDNy4zMiw2Ljk2LDcuODQsNy4zLDguMjksNy43MWMwLjI2LTAuNTQsMC42MS0xLjA2LDEuMDUtMS41NAoJCUM5LjM5LDYuMTEsOS40NSw2LjA1LDkuNSw2QzkuNTUsNS45NCw5LjYsNS44OSw5LjY2LDUuODRDOS4xNSw1LjM5LDguNiw1LjAyLDguMDcsNC43MkM4LDQuNjgsNy45Myw0LjY1LDcuODcsNC42MQoJCUM3LjgsNC41Nyw3LjczLDQuNTQsNy42Niw0LjVjLTAuMDUsMC4wNi0wLjEsMC4xMi0wLjE1LDAuMTdDNy40Nyw0Ljc0LDcuNDIsNC44LDcuMzgsNC44NkM3LDUuMzQsNi42Miw1Ljg5LDYuMzIsNi41CgkJQzYuMzksNi41Myw2LjQ2LDYuNTUsNi41Myw2LjU5eiIvPgoJPHBhdGggY2xhc3M9InN0MCIgZD0iTTYuMDQsNy4xMkM2LjAxLDcuMTksNS45OSw3LjI2LDUuOTYsNy4zM2MwLDAsMCwwLDAsMEM1Ljc0LDcuOTUsNS42LDguNjIsNS42LDkuMzEKCQljLTAuMDEsMi45NiwyLjQ0LDUuMzYsMy40MSw2LjJjLTAuMDctMC4xNS0wLjE3LTAuMzMtMC4yNy0wLjU1Yy0wLjA4LTAuMTctMC4xNi0wLjM1LTAuMjQtMC41NmMtMC4xMi0wLjMxLTAuMjUtMC42Ni0wLjM2LTEuMDQKCQljLTAuMjUtMC44MS0wLjQtMS42MS0wLjQ0LTIuMzZjLTAuMDUtMC44NSwwLjAzLTEuNjQsMC4yNC0yLjM3YzAuMDItMC4wOCwwLjA1LTAuMTcsMC4wOC0wLjI1YzAsMCwwLTAuMDEsMC0wLjAxCgkJQzguMDQsOC4zLDguMDcsOC4yMiw4LjEsOC4xNWMtMC40Ny0wLjQ1LTEtMC43OS0xLjU2LTEuMDZjMCwwLDAsMCwwLDBDNi40Nyw3LjA2LDYuNDEsNy4wMyw2LjM0LDdjMCwwLDAsMCwwLDAKCQlDNi4yNyw2Ljk3LDYuMiw2Ljk0LDYuMTMsNi45MUM2LjEsNi45OCw2LjA3LDcuMDUsNi4wNCw3LjEyQzYuMDQsNy4xMiw2LjA0LDcuMTIsNi4wNCw3LjEyeiIvPgoJPHBhdGggY2xhc3M9InN0MCIgZD0iTTE1LjMxLDMuNDVMMTQuNiwzLjYzYy0wLjA4LDAuMDItMC44NSwwLjIyLTEuODQsMC42OGMwLjU1LDAuNjYsMC45OSwxLjMzLDEuMzMsMi4wMQoJCWMwLjE3LTAuMDYsMC4zNC0wLjExLDAuNTEtMC4xNmMwLjU5LTAuMTYsMS4yMi0wLjI3LDEuODgtMC4zM2MtMC4zNy0xLjAxLTAuNzYtMS42OS0wLjgtMS43NkwxNS4zMSwzLjQ1eiIvPgoJPHBhdGggY2xhc3M9InN0MCIgZD0iTTEzLjQ1LDYuNTdjMC4wNy0wLjAzLDAuMTQtMC4wNiwwLjIxLTAuMDljLTAuMy0wLjYtMC42Ni0xLjE0LTEuMDMtMS42MWMtMC4wNS0wLjA2LTAuMDktMC4xMi0wLjE0LTAuMTgKCQljLTAuMDUtMC4wNi0wLjEtMC4xMi0wLjE1LTAuMThjLTAuMDcsMC4wMy0wLjEzLDAuMDctMC4yLDAuMTFjLTAuMDcsMC4wNC0wLjEzLDAuMDctMC4yLDAuMTFjLTAuNTMsMC4zLTEuMDksMC42Ny0xLjYxLDEuMTEKCQljMC4wNSwwLjA1LDAuMTEsMC4xMSwwLjE2LDAuMTZjMC4wNSwwLjA2LDAuMSwwLjExLDAuMTUsMC4xN2MwLjQyLDAuNDcsMC43NywwLjk4LDEuMDMsMS41MWMwLjQ1LTAuNCwwLjk4LTAuNzQsMS41Ny0xLjAyCgkJQzEzLjMxLDYuNjMsMTMuMzgsNi42LDEzLjQ1LDYuNTd6Ii8+Cgk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMTAuMzEsNi40OEMxMC4zMSw2LjQ4LDEwLjMxLDYuNDgsMTAuMzEsNi40OGMtMC4wNS0wLjA2LTAuMS0wLjExLTAuMTYtMC4xN2MwLDAsMCwwLDAsMAoJCUMxMC4xLDYuMjUsMTAuMDUsNi4yLDkuOTksNi4xNUM5Ljk0LDYuMiw5Ljg5LDYuMjUsOS44Myw2LjMxYzAsMCwwLDAsMCwwYy0wLjA1LDAuMDUtMC4xLDAuMTEtMC4xNiwwLjE3YzAsMCwwLDAsMCwwCgkJQzkuMjYsNi45Myw4LjksNy40NSw4LjY0LDguMDRDOC42Myw4LjA2LDguNjIsOC4wOCw4LjYxLDguMDljMC4wNywwLjAzLDAuMTMsMC4wNywwLjE4LDAuMTNsMCwwYzAsMCwwLDAsMCwwCgkJYzAsMCwwLjAxLDAuMDEsMC4wMSwwLjAxYzAuMDYsMC4wNiwwLjExLDAuMTMsMC4xNiwwLjJjMC40LDAuNTEsMC43MywxLjA5LDAuOTksMS43NWMwLjI3LTAuNjcsMC42MS0xLjI3LDEuMDMtMS43OQoJCWMwLjA1LTAuMDcsMC4xMS0wLjEzLDAuMTctMC4yYzAuMDYtMC4wNiwwLjExLTAuMTIsMC4xNy0wLjE4QzExLjA2LDcuNDMsMTAuNzEsNi45MiwxMC4zMSw2LjQ4eiIvPgoJPHBhdGggY2xhc3M9InN0MCIgZD0iTTguNzMsOC44N0M4LjcsOC44Miw4LjY2LDguNzgsOC42Miw4LjczQzguNjEsOC43Miw4LjYsOC43LDguNiw4LjY5QzguNTUsOC42Myw4LjUsOC41OCw4LjQ1LDguNTIKCQlDOC40Myw4LjU5LDguNCw4LjY2LDguMzgsOC43M2MwLDAuMDEtMC4wMSwwLjAzLTAuMDEsMC4wNEM4LjM1LDguODQsOC4zNCw4LjksOC4zMiw4Ljk2QzguMzEsOC45OSw4LjMxLDkuMDIsOC4zLDkuMDUKCQljLTAuNTcsMi40NCwwLjQ5LDUsMS4wMiw2LjA3Yy0wLjAxLTAuMTctMC4wMy0wLjM4LTAuMDMtMC42MWMtMC4wMS0wLjE5LTAuMDEtMC4zOSwwLTAuNjFjMC4wMS0wLjM0LDAuMDItMC43MiwwLjA3LTEuMTIKCQljMC4wNC0wLjM0LDAuMDgtMC42NywwLjE1LTAuOThjMC4wMy0wLjE3LDAuMDctMC4zNCwwLjExLTAuNTFjMC4wNC0wLjE0LDAuMDctMC4yOCwwLjExLTAuNDJjLTAuMjEtMC42Ni0wLjUxLTEuMzItMC45My0xLjkxCgkJQzguNzcsOC45Myw4Ljc1LDguOSw4LjczLDguODd6Ii8+Cgk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMTcuMDksNi4yNmMtMC4wNywwLTAuMTUsMC4wMS0wLjIzLDAuMDFjLTAuMDgsMC0wLjE1LDAuMDEtMC4yMywwLjAyYy0wLjcyLDAuMDYtMS41NCwwLjE5LTIuMzUsMC40NgoJCWMtMC4wNywwLjAyLTAuMTQsMC4wNS0wLjIyLDAuMDdjLTAuMDcsMC4wMy0wLjE0LDAuMDUtMC4yMSwwLjA4Yy0wLjA3LDAuMDMtMC4xNCwwLjA2LTAuMjEsMC4wOWMtMC4wNywwLjAzLTAuMTQsMC4wNi0wLjIxLDAuMDkKCQljLTAuNTYsMC4yNi0xLjEsMC42LTEuNTcsMS4wNGMtMC4wNSwwLjA1LTAuMTEsMC4xLTAuMTYsMC4xNWMtMC4wMSwwLjAxLTAuMDEsMC4wMS0wLjAyLDAuMDJjLTAuMDYsMC4wNi0wLjEyLDAuMTItMC4xOCwwLjE5CgkJYy0wLjA2LDAuMDctMC4xMSwwLjEzLTAuMTcsMC4yYy0wLjA1LDAuMDYtMC4xLDAuMTMtMC4xNSwwLjE5Yy0wLjQ2LDAuNjItMC43NywxLjMtMC45OSwyYy0wLjA0LDAuMTQtMC4wOCwwLjI4LTAuMTIsMC40MgoJCWMtMC4wMywwLjEyLTAuMDYsMC4yMy0wLjA4LDAuMzVjLTAuMDEsMC4wNS0wLjAyLDAuMTEtMC4wMywwLjE2Yy0wLjAxLDAuMDMtMC4wMSwwLjA1LTAuMDIsMC4wOGMtMC4wMywwLjEzLTAuMDUsMC4yNi0wLjA3LDAuNAoJCWMtMC4wMSwwLjA4LTAuMDIsMC4xNi0wLjAzLDAuMjRDOS43LDEzLjUzLDkuNzMsMTQuNDQsOS43NywxNWMwLjAyLDAuMzIsMC4wNSwwLjUzLDAuMDYsMC41OGMwLDAsMCwwLDAsMGMwLDAsMCwwLDAsMC4wMQoJCWwwLjAyLDAuMTdsMC4wMiwwLjE0bDAuMDEsMC4xbDAuMDMsMC4xOGwwLjAxLDAuMDRsMCwwLjAybDAsMC4wMmwwLjAxLDAuMDVsMC4xMiwwLjAybDAuMSwwLjAxbDAuMDEsMGwwLjAyLDBsMC4wMSwwbDAuMTgsMC4wMwoJCWwwLjAxLDBsMC4wMSwwbDAuMDIsMGwwLDBsMC4yNCwwLjAzYzAuMDYsMC4wMSwwLjU5LDAuMDgsMS4zNiwwLjA4YzEuNTksMCw0LjIzLTAuMyw1Ljk0LTIuMDNjMi41NS0yLjU3LDEuOS03LjEzLDEuODgtNy4zMgoJCWwtMC4xMS0wLjcybC0wLjczLTAuMWMtMC4wNi0wLjAxLTAuNTktMC4wOC0xLjM2LTAuMDhDMTcuNDcsNi4yNCwxNy4yOSw2LjI1LDE3LjA5LDYuMjZ6IE0xNi41NywxMy4xCgkJYy0xLjIyLDEuMjQtMy4yNywxLjQ1LTQuNTQsMS40NWMtMC4xMiwwLTAuMjQsMC0wLjM0LTAuMDFjLTAuMDYtMS4zNiwwLjE0LTMuNjIsMS40LTQuODljMS4yMi0xLjI0LDMuMjctMS40NSw0LjU0LTEuNDUKCQljMC4xMiwwLDAuMjMsMCwwLjM0LDAuMDFDMTguMDIsOS40MSwxNy45MSwxMS43NCwxNi41NywxMy4xeiIvPgo8L2c+Cjwvc3ZnPgo=' );
	}


	/*
	 * Remove the main menu page as we will rely only on submenu pages
	 *
	 */
	public function remove_main_menu_page() {

		remove_submenu_page( 'dpsp-social-pug', 'dpsp-social-pug' );

	}


	/*
	 * Enqueue scripts and styles for the admin dashboard
	 *
	 */
	public function init_admin_scripts( $hook ) {

		// TODO: Replace this with .env check.
		$VERSION = '1.0.0';

		if( strpos( $hook, 'dpsp' ) !== false ) {
			wp_register_script( 'select2-js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js', array( 'jquery' ) );
			wp_enqueue_script( 'select2-js' );

			wp_register_style( 'select2-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css' );
			wp_enqueue_style( 'select2-css' );

			wp_register_script( 'dpsp-touch-punch-js' , plugin_dir_url( __FILE__ ) . "assets/dist/jquery.ui.touch-punch.min.$VERSION.js", array('jquery-ui-sortable', 'jquery' ) );
			wp_enqueue_script( 'dpsp-touch-punch-js' );
		}

		wp_register_style( 'dpsp-dashboard-style', plugin_dir_url( __FILE__ ) . "assets/dist/style-dashboard.$VERSION.css", array(), DPSP_VERSION );
		wp_enqueue_style( 'dpsp-dashboard-style' );

		wp_register_script( 'dpsp-dashboard-js' , plugin_dir_url( __FILE__ ) . "assets/dist/dashboard.$VERSION.js", array( 'jquery' ), DPSP_VERSION );
		wp_enqueue_script( 'dpsp-dashboard-js' );

		wp_register_style( 'dpsp-frontend-style', plugin_dir_url( __FILE__ ) . "assets/dist/style-frontend.$VERSION.css", array(), DPSP_VERSION );
		wp_enqueue_style( 'dpsp-frontend-style' );

		/**
		 * Enqueue additional admin scripts
		 *
		 */
		do_action( 'dpsp_enqueue_admin_scripts' );

	}


	/*
	 * Enqueue scripts for the front-end
	 *
	 */
	public function init_front_end_scripts() {

		// TODO: Replace this with Mediavine Development Plugin stuff.
		$IS_DEVELOPMENT = false;

		// TODO: Replace this with .env check.
		$VERSION = "1.0.0";

		$settings = get_option('dpsp_settings');

		if ( $IS_DEVELOPMENT ) {

			if( isset($settings['optimize_javascript']) && $settings['optimize_javascript'] ) {
				wp_register_style( 'mv-grow-frontend-style', plugin_dir_url( __FILE__ ) . "assets/dist/dev-entry.css" );
				wp_enqueue_style( 'mv-grow-frontend-style' );

				wp_register_script( 'mv-grow-frontend-bundled-js', plugin_dir_url( __FILE__ ) . 'assets/dist/dev-entry.js', array(), null, true );
				wp_enqueue_script( 'mv-grow-frontend-bundled-js' );
			} else {
				wp_register_style( 'mv-grow-frontend-style', plugin_dir_url( __FILE__ ) . "assets/dist/dev-entry-jquery.css" );
				wp_enqueue_style( 'mv-grow-frontend-style' );
	
				wp_register_script( 'mv-grow-frontend-bundled-js', plugin_dir_url( __FILE__ ) . 'assets/dist/dev-entry-jquery.js', array('jquery'), null, true );
				wp_enqueue_script( 'mv-grow-frontend-bundled-js' );
			}
		} else {
			if( isset($settings['optimize_javascript']) && $settings['optimize_javascript'] ) {
				wp_register_style( 'mv-grow-frontend-style', plugin_dir_url( __FILE__ ) . "assets/dist/style-frontend.$VERSION.css" );
				wp_enqueue_style( 'mv-grow-frontend-style' );

				wp_register_script( 'mv-grow-frontend-js', plugin_dir_url( __FILE__ ) . "assets/dist/front-end.$VERSION.js", array(),  null, true);
				wp_enqueue_script( 'mv-grow-frontend-js' );
			} else {
				wp_register_style( 'mv-grow-frontend-style', plugin_dir_url( __FILE__ ) . "assets/dist/style-frontend-jquery.$VERSION.css" );
				wp_enqueue_style( 'mv-grow-frontend-style' );

				wp_register_script( 'mv-grow-frontend-js', plugin_dir_url( __FILE__ ) . "assets/dist/front-end-jquery.$VERSION.js", array('jquery'),  null, true );
				wp_enqueue_script( 'mv-grow-frontend-js' );
			}
		}


	}


	/*
	 * Fallback for setting defaults when updating the plugin,
	 * as register_activation_hook does not fire for automatic updates
	 *
	 */
	public function update_database() {

		$dpsp_db_version = get_option( 'dpsp_version', '' );

		if( $dpsp_db_version != DPSP_VERSION ) {

			// Update default settings
			dpsp_default_settings();
			update_option( 'dpsp_version', DPSP_VERSION );

			// Add first time activation
			if( get_option( 'dpsp_first_activation', '' ) == '' )
				update_option( 'dpsp_first_activation', time() );
			else
				update_option( 'dpsp_welcome_screen_got_it', 1 );

			/**
			 * Do extra database updates on plugin update
			 *
			 * @param string $dpsp_db_version - the previous version of the plugin
			 * @param string DPSP_VERSION     - the new (current) version of the plugin
			 *
			 */
			do_action( 'dpsp_update_database', $dpsp_db_version, DPSP_VERSION );

		}

	}


	/*
	 * Replace admin footer text with a rate plugin message
	 *
	 */
	public function admin_footer_text( $text ) {

		if( isset( $_GET['page'] ) && strpos( $_GET['page'], 'dpsp' ) !== false ) {
			return sprintf( __( 'If you enjoy using <strong>Grow by Mediavine</strong>, please <a href="%s" target="_blank">leave us a ★★★★★ rating</a>. Big thank you for this!', 'social-pug' ), 'https://wordpress.org/support/view/plugin-reviews/social-pug?rate=5#postform' );
		}

		return $text;

	}


	/*
	 * Add extra action links in the plugins page
	 *
	 */
	public function add_plugin_action_links( $links ) {

		$links[] = '<a href="' . esc_url( get_admin_url( null, 'admin.php?page=dpsp-toolkit' ) ) . '">' . __( 'Settings', 'social-pug' ) . '</a>';

		return $links;

	}


	/*
	 * Include plugin files for the front-end
	 *
	 */
	public function load_resources_front_end() {

		// Database version update file
		if( file_exists( DPSP_PLUGIN_DIR . '/inc/functions-version-update.php' ) )
			include_once( DPSP_PLUGIN_DIR . '/inc/functions-version-update.php' );

		// Functions
		if( file_exists( DPSP_PLUGIN_DIR . '/inc/functions.php' ) )
			include_once( DPSP_PLUGIN_DIR . '/inc/functions.php' );

		// Share counts functions
		if( file_exists( DPSP_PLUGIN_DIR . '/inc/functions-share-counts.php' ) )
			include_once( DPSP_PLUGIN_DIR . '/inc/functions-share-counts.php' );

		// Cron jobs
		if( file_exists( DPSP_PLUGIN_DIR . '/inc/functions-cron.php' ) )
			include_once( DPSP_PLUGIN_DIR . '/inc/functions-cron.php' );

		// Frontend rendering
		if( file_exists( DPSP_PLUGIN_DIR . '/inc/functions-frontend.php' ) )
			include_once( DPSP_PLUGIN_DIR . '/inc/functions-frontend.php' );

	}


	/*
	 * Include plugin files for the admin area
	 *
	 */
	public function load_resources_admin() {

		// Admin functions and pages
		if( file_exists( DPSP_PLUGIN_DIR . '/inc/functions-admin.php' ) )
			include_once( DPSP_PLUGIN_DIR . '/inc/functions-admin.php' );

		if( file_exists( DPSP_PLUGIN_DIR . '/inc/admin/submenu-page-toolkit.php' ) )
			include_once( DPSP_PLUGIN_DIR . '/inc/admin/submenu-page-toolkit.php' );

		// Network locations admin pages
		$network_locations = dpsp_get_network_locations();

		foreach( $network_locations as $location_slug ) {
			if( dpsp_is_location_active( $location_slug ) ) {
				if( file_exists( DPSP_PLUGIN_DIR . '/inc/admin/submenu-page-' . str_replace( '_','-', $location_slug ) . '.php' ) )
					include_once( DPSP_PLUGIN_DIR . '/inc/admin/submenu-page-' . str_replace( '_','-', $location_slug ) . '.php' );
			}
		}

		if( file_exists( DPSP_PLUGIN_DIR . '/inc/admin/submenu-page-settings.php' ) )
			include_once( DPSP_PLUGIN_DIR . '/inc/admin/submenu-page-settings.php' );

		if( file_exists( DPSP_PLUGIN_DIR . '/inc/admin/submenu-page-extensions.php' ) )
			include_once( DPSP_PLUGIN_DIR . '/inc/admin/submenu-page-extensions.php' );

		// Feedback form
		if( file_exists( DPSP_PLUGIN_DIR . '/inc/admin/feedback-form/functions.php' ) )
			include_once( DPSP_PLUGIN_DIR . '/inc/admin/feedback-form/functions.php' );

		if( file_exists( DPSP_PLUGIN_DIR . '/inc/admin/feedback-form/functions-ajax.php' ) )
			include_once( DPSP_PLUGIN_DIR . '/inc/admin/feedback-form/functions-ajax.php' );

		// Admin extras
		if( file_exists( DPSP_PLUGIN_DIR . '/inc/admin/admin-metaboxes.php' ) )
			include_once( DPSP_PLUGIN_DIR . '/inc/admin/admin-metaboxes.php' );

	}

}

// Let's get the party started
new Social_Pug;



/*
 * Activation hooks
 *
 */
register_activation_hook( __FILE__, 'dpsp_default_settings' );
register_activation_hook( __FILE__, 'dpsp_set_cron_jobs' );


/*
 * Deactivation hooks
 *
 */
register_deactivation_hook( __FILE__, 'dpsp_stop_cron_jobs' );