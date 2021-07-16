<?php

namespace App\Options\Header;

add_action('init', function(){
  if (function_exists('acf_add_options_sub_page')) {
    acf_add_options_sub_page([
      'page_title'   => 'Theme Header Settings',
      'menu_title'  => 'Header',
      'parent_slug'  => 'theme-general-settings',
    ]);
  }
});
