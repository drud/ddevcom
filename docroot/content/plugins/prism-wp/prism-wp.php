<?php
/*
Plugin Name: Prism WP
Plugin URI: http://www.codefleet.net/prism-wp/
Description: WordPress plugin for the prism js syntax highlighter. This is not a spying program!
Version: 1.0.0
Author: Nico Amarilla
Author URI: http://www.codefleet.net/
License:

  Copyright 2013 (kosinix@codefleet.net)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/
if(!defined('PRISM_WP_VERSION')){
    define('PRISM_WP_VERSION', '1.0.0' ); // Versioning for cache busting and update purposes
}
if(!defined('PRISM_WP_PATH')){
    define('PRISM_WP_PATH', realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR );
}
if(!defined('PRISM_WP_URL')){
    define('PRISM_WP_URL', plugin_dir_url(__FILE__) );
}
if(!defined('PRISM_WP_DEBUG')){
    define('PRISM_WP_DEBUG', false );
}

// Include common classes
require_once(PRISM_WP_PATH.'classes/codefleet/class-codefleet-view.php');
require_once(PRISM_WP_PATH.'classes/codefleet/class-codefleet-admin-page.php');
require_once(PRISM_WP_PATH.'classes/codefleet/class-codefleet-admin-sub-page.php');
require_once(PRISM_WP_PATH.'classes/codefleet/class-codefleet-settings-page.php');
require_once(PRISM_WP_PATH.'classes/codefleet/class-codefleet-settings-sub-page.php');

require_once(PRISM_WP_PATH.'classes/class-prism-wp-scripts.php');
require_once(PRISM_WP_PATH.'classes/class-prism-wp-settings-page.php');

$prism_wp_settings_page = new Prism_WP_Settings_Page( new Codefleet_View() );

// Wrap our intantiation code in a function to minimize conflict in global space
function prism_wp_instantiate ( $settings_page ) {
    // Store the plugin instance to a global object so that other plugins can use remove_action and remove_filter
    // Inject dependencies here
    $settings_page->set_option_group('prism_wp_option_group');
    $settings_page->set_option_name('prism_wp_option_name');
    $settings_page->set_parent_slug('options-general.php');
    $settings_page->set_menu_slug('prism-wp-settings');
    
    $scripts = new Prism_WP_Scripts( $settings_page->get_settings_data() );
}
prism_wp_instantiate( $prism_wp_settings_page ); // Call function immediately

// Load domain in this hook to work with WPML
add_action('plugins_loaded', 'prism_wp_plugins_loaded');
function prism_wp_plugins_loaded() {
    global $prism_wp_settings_page;
    
    $settings_page = $prism_wp_settings_page;
    
    load_plugin_textdomain( 'prism-wp', false, 'prism-wp/lang' );
    
    // These strings should be here for translation to work
    $settings_page->set_page_title( __('Prism WP Settings', 'prism-wp') );
    $settings_page->set_menu_title( __('Prism WP', 'prism-wp') );
    $settings_page->show();
    
}

function prism_wp_debug($out){
    return '<pre>'.print_r($out,1).'</pre>';
}