<?php
/**
 *  Deprecated Functions
 * 
 * This file is made to keep older non-used functions as a refrence. 
 *
 *
 *  @since 1.0.0
 *  @return void
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Get an array of enabled post types
 *
 * @since 1.5.9.6
 * @return array of enabled post types, schema type
 */
function schema_wp_cpt_get_enabled_post_types() {
	
	$cpt_enabled = array();
	
	$args = array(
					'post_type'			=> 'schema',
					'post_status'		=> 'publish',
					'posts_per_page'	=> -1
				);
				
	$schemas_query = new WP_Query( $args );
	
	$schemas = $schemas_query->get_posts();
	
	// If there is no schema types set, return and empty array
	if ( empty($schemas) ) return array();
	
	foreach( $schemas as $schema ) : 
		
		$schema_post_types = get_post_meta( $schema->ID, '_schema_post_types'	, true );
		
		// Build our array
		$cpt_enabled[] = (is_array($schema_post_types)) ? reset($schema_post_types) : array();
		
	endforeach;
	
	wp_reset_postdata();
	
	// debug
	//echo '<pre>'; print_r($cpt_enabled); echo '</pre>'; exit;
	//echo reset($cpt_enabled[0]);
	return apply_filters('schema_wp_cpt_enabled_post_types', $cpt_enabled);
}

////////////////
//////////////////////////////////


/**
 * Check if post type is enabled
 *
 * @since 1.6.9.8
 *
 * @param int $post_type The post type.
 * @return string post ID, or false
 */
function schema_wp_is_post_type_enabled( $post_type = null ) {
	
	if ( ! isset($post_type) ) $post_type = get_post_type();
	if ( ! isset($post_type) ) 
		return false;
	
	$enabled 			= false;
	$enabled_post_types	= schema_wp_cpt_get_enabled_post_types();
	
	if ( in_array( $post_type, $enabled_post_types, false ) )  $enabled = true;
	
	return apply_filters( 'schema_wp_is_post_type_enabled', $enabled );
}

/**
 * Get schema ref for a post
 *
 * @since 1.6.9.5
 *
 * @param int $post_id The post ID.
 * @return string post ID, or false
 */
function schema_wp_get_ref( $post_id = null ) {
	
	if ( ! isset($post_id) ) $post_id = isset($_GET['post']) ? $_GET['post'] : null;
	
	if ( ! isset($post_id) ) return false;
	
	$schema_ref = get_post_meta( $post_id, '_schema_ref', true );
	
	If ( ! isset($schema_ref) ) $schema_ref = false;
	
	return apply_filters( 'schema_wp_ref', $schema_ref );
}

/**
 * Get schema type for a post
 *
 * @since 1.6.9.5
 *
 * @param int $post_id The post ID.
 * @return string schema type, or false 
 */
function schema_wp_get_type( $post_id = null ) {
	
	if ( ! isset($post_id) ) $post_id = isset($_GET['post']) ? $_GET['post'] : null;
	
	if ( ! isset($post_id) ) return false;
	
	
	$schema_ref = schema_wp_get_ref( $post_id );
	
	$schema_type = false;
	
	if ( $schema_ref ) {
		
		$schema_type = get_post_meta( $schema_ref, '_schema_type', true );
	}
	
	return apply_filters( 'schema_wp_type', $schema_type );
}

/**
 * Get schema json-ld for a post
 *
 * @since 1.6.9.5
 *
 * @param int $post_id The post ID.
 * @return string post ID, or false
 */
function schema_wp_get_jsonld( $post_id = null ) {
	
	global $post;
	
	if ( ! isset($post_id) ) $post_id = $post->ID;
	
	if ( ! isset($post_id ) ) return false;
	
	$schema_json = get_post_meta( $post_id, '_schema_json', true);
	
	If ( ! isset($schema_json )) $schema_json = false;
	
	return apply_filters( 'schema_wp_json', $schema_json );
}

/**
 * Get an array of enabled post types
 *
 * @since 1.4
 * @return array of enabled post types, schema type
 */
function schema_wp_cpt_get_enabled() {
	
	$cpt_enabled = array();
	
	$args = array(
					'post_type'			=> 'schema',
					'post_status'		=> 'publish',
					'posts_per_page'	=> -1
				);
				
	$schemas_query = new WP_Query( $args );
	
	$schemas = $schemas_query->get_posts();
	
	// If there is no schema types set, return and empty array
	if ( empty($schemas) ) return array();
	
	foreach( $schemas as $schema ) : 
		
		// Get post meta
		$schema_type			= get_post_meta( $schema->ID, '_schema_type'			, true );
		$schema_type_sub_pre	= get_post_meta( $schema->ID, '_schema_article_type'	, true );
		$schema_type_sub		= ( $schema_type_sub_pre == 'General' ) ? $schema_type : $schema_type_sub_pre;
		$schema_post_types 		= get_post_meta( $schema->ID, '_schema_post_types'	, true );
		$schema_categories 		= schema_wp_get_categories( $schema->ID );
		
		// Build our array
		$cpt_enabled[] = array (
									'id'			=>	$schema->ID,
									'type'			=>	$schema_type,
									'type_sub'		=>	$schema_type_sub,
									'post_type'		=>	$schema_post_types,
									'categories'	=>	$schema_categories
								);
		
	endforeach;
 	
	wp_reset_postdata();
	
	// debug
	//echo '<pre>'; print_r($cpt_enabled); echo '</pre>'; exit;
	
	return apply_filters('schema_wp_cpt_enabled', $cpt_enabled);
}

/**
 * Get schema ref by post type in admin page editor screen
 *
 * @since 1.6.9.3
 * @return array of enabled post types, schema type
 */
function schema_wp_get_ref_by_post_type( $post_type = null ) {
	
	global $wpdb, $post;
	
	if ( ! isset($post_type) ) {
		// Get post type from current screen
		$current_screen = get_current_screen();
		$post_type = $current_screen->post_type;
	}
	
	$schema_posts = $wpdb->get_results ( "
    	SELECT * 
    	FROM  $wpdb->posts
        WHERE post_type = 'schema'
			AND post_status = 'publish'
	" );
	
	//echo '<pre>'; print_r($schema_posts); echo '</pre>';exit;
	if ( empty($schema_posts) ) return array();
	 
	foreach ( $schema_posts as $key => $post ) {
		$supported_types = get_post_meta( $post->ID, '_schema_post_types', true );
		if ( ! empty($supported_types) && in_array( $post_type, $supported_types, true ) ) {
			return $post->ID;
		}	
	}
}

/**
 * Get an array of schema enabed categories
 * 
 * @since 1.4.7
 * @return array of enabled categories, schema type
 */
function schema_wp_get_categories( $post_id ) {
	
	global $post;
	
	if ( ! isset($post_id) ) $post_id = $post->ID;
	
	$post_categories	= wp_get_post_categories( $post_id );
	$categories			= array();
     
	if ( empty($post_categories) ) return $categories;
		
	$cats = array();
		
	foreach( $post_categories as $c ){
    	$cat	= get_category( $c );
		$cats[]	= $cat->slug;
	}
	
	if ( empty($cats) ) return $categories;
	
	// Flat
	$categories = schema_wp_array_flatten($cats);
	
	return apply_filters( 'schema_wp_filter_categories', $categories );
}

/**
 * Get categories as a comma separated keywords
 *
 * @since 1.6.9.8
 * @return string
 */
function schema_wp_get_categories_as_keywords() {
	
	$categories = get_categories( array(
    	'orderby' => 'name',
    	'order'   => 'ASC'
	) );
	
	$cat = array();
	
	foreach ( $categories as $category ) {
    	$cat[] = $category->name;
	}
	
	// transform into a comma separated string
	$cat = implode(", ", $cat);
	
	return apply_filters( 'schema_wp_get_categories', $cat );
}

//add_action( 'save_post', 'schema_wp_clear_json_on_post_save', 10, 3 );
/**
 * Clear schema json on post save
 *
 * @param int $post_id The post ID.
 * @param post $post The post object.
 * @param bool $update Whether this is an existing post being updated or not.
 * @since 1.5.9.8
 */
function schema_wp_clear_json_on_post_save( $post_id, $post, $update ) {
	
	if( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
    || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) 
		return $post_id;
		
	$slug = 'schema';

    // If this is a 'schema' post, don't update it.
	if ( get_post_type( $post_id ) == $slug ) {
        return $post_id;
    }
	
	// If this is just a revision, don't save ref.
	if ( wp_is_post_revision( $post_id ) )
		 return $post_id;
		
    // - Delete the post's metadata.
	delete_post_meta( $post_id, '_schema_json' );
	delete_post_meta( $post_id, '_schema_json_timestamp' );
	
	// Debug
	//$msg = 'Is this un update? ';
  	//$msg .= $update ? 'Yes.' : 'No.';
  	//wp_die( $msg );
	
	 return $post_id;
}

//add_action( 'save_post', 'schema_save_categories', 10, 3 );
/**
 * Save categories when a Schema post is saved.
 *
 * @param int $post_id The post ID.
 * @param post $post The post object.
 * @param bool $update Whether this is an existing post being updated or not.
 * @since 1.4.7
 */
function schema_save_categories( $post_id, $post, $update ) {
	
	if( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
    || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) 
        return;
		
	$slug = 'schema';

    // If this isn't a 'schema' post, don't update it.
    if ( $slug != $post->post_type ) {
        return;
    }
	
	// If this is just a revision, don't save ref.
	if ( wp_is_post_revision( $post_id ) )
		return;
		
    // - Update the post's metadata.
	$post_categories = schema_wp_get_categories( $post_id );
	
	update_post_meta($post_id, '_schema_categories', $post_categories);
}

/**
 * Get First Post Date Function
 *
 * @since 1.6.9.8
 * @param  $format Type of date format to return, using PHP date standard, default Y-m-d
 * @return Date of first post
 */
function schema_wp_first_post_date( $format = 'Y-m-d' ) {
	// Setup get_posts arguments
	$ax_args = array(
		'numberposts' => -1,
		'post_status' => 'publish',
		'order' => 'ASC'
	);

	// Get all posts in order of first to last
	$ax_get_all = get_posts($ax_args);

	// Extract first post from array
	$ax_first_post = $ax_get_all[0];

	// Assign first post date to var
	$ax_first_post_date = $ax_first_post->post_date;

	// return date in required format
	$output = date($format, strtotime($ax_first_post_date));

	return $output;
}

//add_filter( 'schema_wp_filter_content', 'remove_visual_composer_shortcodes' );
/**
 * Remove VC shortcodes from content
 *
 * @since 1.5.9.3
 * @return string
 */
function remove_visual_composer_shortcodes( $content ) {
	
	global $post;
	
	$vc_enabled = get_post_meta($post->ID, '_wpb_vc_js_status', true);
	
	if ( isset($vc_enabled) && $vc_enabled == 'true') {
	
    	$content = preg_replace('/\[\/?vc_.*?\]/', '', $content);
	}
	
    return $content;
}


//add_filter( 'schema_wp_filter_content', 'schema_wp_remove_divi_shortcodes' );
/**
 * Remove Divi shortcodes from content
 *
 * @since 1.5.9
 * @return string
 */
function schema_wp_remove_divi_shortcodes( $content ) {
	
	$my_theme = wp_get_theme();
	
	if ( $my_theme == 'Divi') {
	
    	$content = preg_replace('/\[\/?et_pb.*?\]/', '', $content);
	}
	
    return $content;
}
