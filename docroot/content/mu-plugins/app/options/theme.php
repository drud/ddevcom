<?php

namespace App\Options\Theme;

add_action('init', function(){
  acf_add_options_page([
    'page_title'   => 'Theme Settings',
    'menu_title'  => 'Theme Settings',
    'menu_slug'   => 'theme-general-settings',
    'capability'  => 'edit_posts',
    'redirect'    => true
  ]);
});