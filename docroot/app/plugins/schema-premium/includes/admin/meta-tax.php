<?php
/**
 * Schema Tax Meta
 *
 * @package     Schema
 * @subpackage  Schema Tax Meta
 * @copyright   Copyright (c) 2018, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'schema_premium_acf_taxonomy_field_sameAs' );
/**
 * Meta Box
 *
 * @since 1.1.2.3
 */
function schema_premium_acf_taxonomy_field_sameAs() {

if( function_exists('acf_add_local_field_group') ):

  acf_add_local_field_group(array(
    'key' => 'group_taxonomy_sameAs',
    'title' => __('Schema', 'schema-premium'),
    'fields' => array(
      array(
        'key' => 'field_taxonomy_sameAs',
        'label' => __('sameAs', 'schema-premium'),
        'name' => 'schema_sameAs',
        'type' => 'repeater',
        'instructions' => __('URL of a reference Web page that unambiguously indicates the item\'s identity. E.g. the URL of the item\'s Wikipedia page, Freebase page, or official website.', 'schema-premium'),
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'collapsed' => '',
        'min' => 0,
        'max' => 0,
        'layout' => 'table',
        'button_label' => __('Add URL', 'schema-premium'),
        'sub_fields' => array(
          array(
            'key' => 'field_sameAs',
            'label' => __('URL', 'schema-premium'),
            'name' => 'url',
            'type' => 'url',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
          ),
        ),
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'taxonomy',
          'operator' => '==',
          'value' => 'all',
        ),
        array(
          'param' => 'taxonomy',
          'operator' => '!=',
          'value' => 'post_format',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
  ));
  
  endif;
}
