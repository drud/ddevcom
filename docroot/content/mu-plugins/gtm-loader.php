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
namespace Riot\GTM;

if (! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

 /**
  * Bootstrap the class
  */
 class GTM
 {

   /**
    * GTM Account ID
    *
    * @var string
    */
   public $container_id = 'GTM-XXXX';


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
      // render no script
      add_action('wp_footer', [$this, 'renderNoScript'], 100);
   }

   /**
    * Set the use container ID
    *
    * @return return null
    */
   public function setContainerId()
   {

     //  allow overriding via GTM_CONTAINER_ID
     if (defined('GTM_CONTAINER_ID')) {
         $this->container_id = GTM_CONTAINER_ID;
     }

     //  load value from ACF
     elseif (function_exists('get_field')) {
         $gtm_container_id = get_field('field_581274da85921', 'option');
         if ($gtm_container_id) {
             $this->container_id = $gtm_container_id;
         }
     }
   }


   /**
    * Get the Container ID
    *
    * @return $container_id string
    */
   public function getContainerId()
   {
       return $this->container_id;
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
             'page_title' => 'GTM Settings',
             'menu_title' => 'GTM Settings',
             'menu_slug'  => 'gtm-settings',
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
             'key'    => 'group_581274c5bc77f',
             'title'  => 'General Settings',
             'fields' => [
                  [
                     'key'               => 'field_581274da85921',
                     'label'             => 'Account Key',
                     'name'              => 'gtm_container_key',
                     'type'              => 'text',
                     'instructions'      => 'GTM Container ID',
                     'required'          => 0,
                     'conditional_logic' => 0,
                     'wrapper'           => [
                         'width' => '',
                         'class' => '',
                         'id'    => '',
                     ],
                     'default_value' => '',
                     'placeholder'   => 'GTM-XXXX',
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
                         'value'    => 'gtm-settings',
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
     if ('GTM-XXXX' !== self::getContainerId()) {
       $html = sprintf("
       <!-- Google Tag Manager -->
       <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
       new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
       j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
       'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
       })(window,document,'script','dataLayer','%s');</script>
       <!-- End Google Tag Manager -->
       ", self::getContainerId());
       echo $html;
     }
   }


   /**
    * Rendering of the No script tag
    *
    * @return html
    */
   public function renderNoScript()
   {
     if ('GTM-XXXX' !== self::getContainerId()) {
       $html = sprintf('
       <!-- Google Tag Manager (noscript) -->
       <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=%s"
       height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
       <!-- End Google Tag Manager (noscript) -->
       ', self::getContainerId());
       echo $html;
     }
   }
 }

 new GTM();
