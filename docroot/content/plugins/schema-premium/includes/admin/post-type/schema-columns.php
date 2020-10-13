<?php
/**
 * @package Schema - Schema Post Type Columns 
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('Schema_WP_CPT_columns') ) return;

$post_columns = new Schema_WP_CPT_columns('schema'); // if you want to replace and reorder columns then pass a second parameter as true

//add native column
$post_columns->add_column('title',
  array(
		'label'    => __('Name', 'schema-premium'),
		'type'     => 'native',
		'sortable' => true
	)
);
//custom field column
$post_columns->add_column('schema_type',
  array(
		'label'    => __('Schema Type', 'schema-premium'),
		'type'     => 'post_meta',
		'meta_key' => '_schema_type', //meta_key
		'orderby' => 'meta_value', //meta_value,meta_value_num
		'sortable' => true,
		'prefix' => "",
		'suffix' => "",
		'std' => '<span class="dashicons dashicons-warning" style="color:#ed6a6c"></span> ' . __('Not set!', 'schema-premium'), // default value in case post meta not found
	)
);
//custom field column
$post_columns->add_column('schema_sub_type',
  array(
		'label'    => __('Specific Type', 'schema-premium'),
		'type'     => 'post_meta',
		'meta_key' => 'schema_subtype', //meta_key
		'orderby' => 'meta_value', //meta_value,meta_value_num
		'sortable' => true,
		'prefix' => "",
		'suffix' => "",
		'std' => __('-'), // default value in case post meta not found
	)
);
$post_columns->add_column('target_location_enabled_on',
  array(
		'label'    => __('Enabled on', 'schema-premium'),
		'type'     => 'target_location_enabled_on',
		'sortable' => false,
		'prefix' => "",
		'suffix' => "",
		'std' => __('-'), // default value in case post meta not found
	)
);
$post_columns->add_column('target_location_excluded_on',
  array(
		'label'    => __('Excluded on', 'schema-premium'),
		'type'     => 'target_location_excluded_on',
		'sortable' => false,
		'prefix' => "",
		'suffix' => "",
		'std' => __('-'), // default value in case post meta not found
	)
);
/*$post_columns->add_column('target_location',
  array(
		'label'    => __('Target Location', 'schema-premium'),
		'type'     => 'target_location',
		'sortable' => false,
		'prefix' => "",
		'suffix' => "",
		'std' => __('N/A'), // default value in case post meta not found
	)
);
*/
$post_columns->add_column('schema_cpt_post_count',
  array(
		'label'    => __('Details', 'schema-premium'),
		'type'     => 'post_meta',
		'meta_key' => '_schema_comment', //meta_key
		'sortable' => false,
		'prefix' => "",
		'suffix' => "",
		'std' => __('-'), // default value in case post meta not found
	)
);

//remove columns
$post_columns->remove_column('post_type');
$post_columns->remove_column('categories');
$post_columns->remove_column('date');

// remove columns appended by 
$post_columns->remove_column('gadwp_stats');
$post_columns->remove_column('mashsb_shares');
$post_columns->remove_column('ratings');

add_filter( 'post_row_actions', 'remove_row_actions', 10, 1 );
/**
 * Remove row actions: View.& Quick Edit links
 *
 * @since   1.0.0
 *
 * @param array $actions 
 *
 * @return array
 */
function remove_row_actions( $actions ) {
    if( get_post_type() === 'schema' ) {
        unset( $actions['view'] );
		unset( $actions['inline hide-if-no-js'] );
	}
		 
    return $actions;
}

/**
 * Get Target Locations Title
 *
 * @since 1.0.0
 *
 * @return array
 */
function schema_premium_get_target_locations_titles() {
	
	$titles = array ( 
		'all_singulars'		=> __('All Singulars', 'schema-premium'), 
		'post_type' 		=> __('Post Type', 'schema-premium'), 
		'post_format' 		=> __('Post Format', 'schema-premium'),
		'post_status' 		=> __('Post Status', 'schema-premium'),
		'post_category' 	=> __('Post Category', 'schema-premium'),
		//'post_taxonomy' 	=> __('Post Taxonomy', 'schema-premium'),
		'post' 				=> __('Specific Post', 'schema-premium'),
		//'page_template' 	=> __('Page Template', 'schema-premium'), 
		//'page_type' 		=> __('Page Type', 'schema-premium'),
		//'page_parent' 	=> __('Page Parent', 'schema-premium'), 
		'page' 				=> __('Specific Page', 'schema-premium'),
		'post_id' 			=> __('Post id', 'schema-premium'), 
	);
											
	return $titles;
}