<?php
/*
Plugin Name: GTM Loader
Plugin URI: https://github.com/newmediadenver/wp
Description: Loads the GTM code for the theme, adds an ACF Field to update the container ID.
Version: 0.1
Author: Riot Labs
Author URI: http://riotlabs.com/
*/

/**
 * Copyright (c) 2016 . All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * **********************************************************************
 */
namespace DDEV\Segment;

if (! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

 /**
  * Bootstrap the class
  */
 class Segment
 {

   /**
    * Segment Account ID
    *
    * @var string
    */
   public $source_id = '';


   /**
    * Init
    *
    * @return null
    */
   public function __construct()
   {
       add_action('init', [$this, 'init'], 1);
       // options
       add_action('plugins_loaded', [$this, 'options']);
       // option page
       add_action('plugins_loaded', [$this, 'optionsPage']);
   }


   /**
    * Init
    *
    * @return null
    */
   public function init()
   {
      // set container ID
      add_action('init', [$this, 'setContainerId']);
      // render main script
      add_action('wp_head', [$this, 'render']);
   }

   /**
    * Set the use container ID
    *
    * @return return null
    */
   public function setContainerId()
   {

     //  allow overriding via GTM_source_id
     if (defined('GTM_source_id')) {
         $this->source_id = GTM_source_id;
     }

     //  load value from ACF
     elseif (function_exists('get_field')) {
         $gtm_source_id = get_field('field_581274da85921', 'option');
         if ($gtm_source_id) {
             $this->source_id = $gtm_source_id;
         }
     }
   }


   /**
    * Get the Container ID
    *
    * @return $source_id string
    */
   public function getSourceID()
   {
       return $this->source_id;
   }

   /**
    * undocumented function summary
    *
    * @return null
    */
   public function optionsPage()
   {
       if (function_exists('acf_add_options_page')) {
           acf_add_options_sub_page([
             'page_title' => 'Segment Settings',
             'menu_title' => 'Segment Settings',
             'menu_slug'  => 'segment-settings',
             'capability' => 'edit_posts',
             'parent'     => 'options-general.php',
             'redirect'   => false,
         ]);
       }
   }


   /**
    * Options
    *
    * @return null
    */
   public function options()
   {
       if (function_exists('acf_add_local_field_group')):

         acf_add_local_field_group([
             'key'    => 'group_581274c5bc712',
             'title'  => 'Segment Settings',
             'fields' => [
                  [
                     'key'               => 'field_581274da85921',
                     'label'             => 'Segment Source Key',
                     'name'              => 'segment_source_key',
                     'type'              => 'text',
                     'instructions'      => 'Segment Source ID',
                     'required'          => 0,
                     'conditional_logic' => 0,
                     'wrapper'           => [
                         'width' => '',
                         'class' => '',
                         'id'    => '',
                     ],
                     'default_value' => '',
                     'placeholder'   => 'xxxxxxxxxx',
                     'prepend'       => '',
                     'append'        => '',
                     'maxlength'     => '',
                     'readonly'      => 0,
                     'disabled'      => 0,
                 ]
             ],
             'location' => [
                  [
                      [
                         'param'    => 'options_page',
                         'operator' => '==',
                         'value'    => 'segment-settings',
                     ],
                 ],
             ],
             'menu_order'            => 0,
             'position'              => 'normal',
             'style'                 => 'default',
             'label_placement'       => 'top',
             'instruction_placement' => 'label',
             'hide_on_screen'        => '',
             'active'                => 1,
             'description'           => '',
         ]);

       endif;
   }

   /**
    * Rendering of the tag
    *
    * @return html
    */
   public function render()
   {
     if ('' !== self::getSourceID()) {

            $html = sprintf(
                "<script>
                    !function(){var analytics=window.analytics=window.analytics||[];if(!analytics.initialize)if(analytics.invoked)window.console&&console.error&&console.error('Segment snippet included twice.');else{analytics.invoked=!0;analytics.methods=[\"trackSubmit\",\"trackClick\",\"trackLink\",\"trackForm\",\"pageview\",\"identify\",\"reset\",\"group\",\"track\",\"ready\",\"alias\",\"debug\",\"page\",\"once\",\"off\",\"on\",\"addSourceMiddleware\",\"addIntegrationMiddleware\",\"setAnonymousId\",\"addDestinationMiddleware\"];analytics.factory=function(e){return function(){var t=Array.prototype.slice.call(arguments);t.unshift(e);analytics.push(t);return analytics}};for(var e=0;e<analytics.methods.length;e++){var t=analytics.methods[e];analytics[t]=analytics.factory(t)}analytics.load=function(e,t){var n=document.createElement(\"script\");n.type=\"text/javascript\";n.async=!0;n.src=\"https://cdn.segment.com/analytics.js/v1/\"+e+\"/analytics.min.js\";var a=document.getElementsByTagName(\"script\")[0];a.parentNode.insertBefore(n,a);analytics._loadOptions=t};analytics.SNIPPET_VERSION=\"4.1.0\";
                    analytics.load(\"%s\");
                    analytics.page();
                    }}();
                </script>",
                self::getSourceID()
            );
            echo $html;
       
     }
   }
 }

 new Segment();
