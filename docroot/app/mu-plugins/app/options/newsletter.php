<?php

namespace App\Options\Newsletter;

add_action('init', function(){
  if (function_exists('acf_add_options_sub_page')) {
    acf_add_options_sub_page([
      'page_title'   => 'Newsletter Settings',
      'menu_title'  => 'Newsletter',
      'parent_slug'  => 'theme-general-settings',
    ]);
  }
});
