<?php

namespace App\Options\Company;

add_action('init', function(){
  if (function_exists('acf_add_options_sub_page')) {
    acf_add_options_sub_page([
      'page_title'   => 'Company Settings',
      'menu_title'  => 'Company',
      'parent_slug'  => 'theme-general-settings',
    ]);
  }
});
