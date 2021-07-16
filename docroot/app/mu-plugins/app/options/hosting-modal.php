<?php

namespace App\Options\HostingModal;

add_action('init', function(){
  if (function_exists('acf_add_options_sub_page')) {
    acf_add_options_sub_page([
      'page_title'   => 'Hosting Modal Settings',
      'menu_title'  => 'Hosting Modal',
      'parent_slug'  => 'theme-general-settings',
    ]);
  }
});
