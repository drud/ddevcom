<?php

namespace App\Options\Footer;

add_action('init', function(){
  acf_add_options_sub_page([
    'page_title'   => 'Theme Footer Settings',
    'menu_title'  => 'Footer',
    'parent_slug'  => 'theme-general-settings',
  ]);
});
