<?php
/**
 * ACF Blocks Functions
 *
 * @package     Schema
 * @subpackage  Schema - ACF
 * @copyright   Copyright (c) 2019, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.6
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'block_categories', 'schema_premium_acf_block_categories', 10, 2 );
/**
 * Add Schema in block categories
 *
 * @since 1.0.6
 *
 * return void
 */
function schema_premium_acf_block_categories( $categories, $post ) {
    
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'schema-blocks',
                'title' => __('Schema', 'schema-wp'),
                //'icon'  => 'wordpress',
            ),
        )
    );
}
