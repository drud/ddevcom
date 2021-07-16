<?php
/**
 * Admin Functions
 *
 * @package     Schema
 * @subpackage  Admin Functions/Formatting
 * @copyright   Copyright (c) 2018, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Get all custom fields
 *
 *
 * @since  1.0.0
 * @return array of post meta keys
 */
function schema_premium_get_all_custom_fields() {
	
	global $wpdb;
	
	// Use transient
	// @since 1.1.1
	//
	$cache_key = 'schema_premium_meta_keys';
	
	if ( ! $meta_keys = get_transient( $cache_key ) ) :
	    
		$post_types = schema_premium_get_admin_post_types();
		
		/*$query = "
			SELECT DISTINCT($wpdb->postmeta.meta_key) 
			FROM $wpdb->posts 
			LEFT JOIN $wpdb->postmeta 
			ON $wpdb->posts.ID = $wpdb->postmeta.post_id 
			WHERE $wpdb->postmeta.meta_key != '' 
			AND $wpdb->postmeta.meta_key NOT RegExp '(^[_0-9].+$)' 
			AND $wpdb->postmeta.meta_key NOT RegExp '(^[0-9]+$)' 
		";*/
		
		$query = "
			SELECT DISTINCT($wpdb->postmeta.meta_key) 
			FROM $wpdb->posts 
			LEFT JOIN $wpdb->postmeta 
			ON $wpdb->posts.ID = $wpdb->postmeta.post_id 
			WHERE $wpdb->posts.post_type != 'schema'
			AND $wpdb->postmeta.meta_key != ''
			AND $wpdb->postmeta.meta_key NOT RegExp 'schema_'
			AND $wpdb->postmeta.meta_key NOT RegExp '(^[0-9]+$)' 
		";

		$meta_keys_query = $wpdb->get_results($query, ARRAY_A);
		
		// debug
		//echo count($meta_keys_query); 
		//echo '<pre>'; print_r($meta_keys_query); echo '</pre>'; exit;
		
		foreach ( $meta_keys_query as $key => $value) {
			
			if ($value['meta_key'][0] != '_') { // exclude where added by plugin
			   $meta_keys[$value['meta_key']] = isset($meta_keys[$value['meta_key']]) ? $value['meta_key'] : $value['meta_key'];
			} else {
				$meta_keys[$value['meta_key']] = isset($meta_keys[$value['meta_key']]) ? str_replace('_', ' ', $value['meta_key']) : $value['meta_key']; 
			}
				  
			//$new_meta_keys[$value['meta_key']] = $value['meta_key']; 
		}
				
		// Debug
		//echo count($meta_keys).'<br><br><br>';
		//echo '<pre>'; print_r($new_meta_keys); echo '</pre>';exit; 
		
		set_transient( $cache_key, $meta_keys, 60 ); // 60 seconds, enough for page to load faster
	
	endif;
	
	return $meta_keys;
}

/**
 * Get post types for use in admin pages 
 *
 *
 * @since  1.0.1
 * @return array of post types
 */
function schema_premium_get_admin_post_types() {
	
	$args = array(
	   'public'   => true,
	   '_builtin' => false
	);
	
	$post_types = get_post_types( $args , 'names', 'or' );
	
	unset($post_types['attachment']);
	
	// Use this filter to remove un-used/un-wanted post types
	// @sinnce 1.1.1
	//
	$post_types = apply_filters( 'schema_premium_admin_post_types_extras', $post_types);
	
	// debug
	//echo'<pre>';print_r($post_types);echo'</pre>';exit;
	
	$post_types	= array_keys($post_types);
	$post_types = apply_filters( 'schema_premium_admin_post_types', $post_types);
	
	return $post_types;
}

/**
 * Sanitizes a string key for Schema Settings
 *
 * Keys are used as internal identifiers. Alphanumeric characters, dashes, underscores, stops, colons and slashes are allowed
 *
 * @since  1.0.0
 * @param  string $key String key
 * @return string Sanitized key
 */
function schema_premium_sanitize_key( $key ) {
	$raw_key = $key;
	$key = preg_replace( '/[^a-zA-Z0-9_\-\.\:\/]/', '', $key );

	/**
	 * Filter a sanitized key string.
	 *
	 * @since 2.5.8
	 * @param string $key     Sanitized key.
	 * @param string $raw_key The key prior to sanitization.
	 */
	return apply_filters( 'schema_premium_sanitize_key', $key, $raw_key );
}

/**
 * Convert an object to an associative array.
 *
 * Can handle multidimensional arrays
 *
 * @since 1.0.0
 *
 * @param unknown $data
 * @return array
 */
function schema_wp_object_to_array( $data ) {
	if ( is_array( $data ) || is_object( $data ) ) {
		$result = array();
		foreach ( $data as $key => $value ) {
			$result[ $key ] = schema_wp_object_to_array( $value );
		}
		return $result;
	}
	return $data;
}

/**
 * Flatten an array
 * 
 * @since 1.4.7
 * @return flat array
 */
function schema_wp_array_flatten($array) {

	$return = array();
	foreach ($array as $key => $value) {
	if (is_array($value)){ $return = array_merge($return, array_flatten($value));}
		else {$return[$key] = $value;}
	}
	
	return $return;
}

/**
* Retrieve a post given its title.
*
* @link http://wordpress.stackexchange.com/questions/11292/how-do-i-get-a-post-page-or-cpt-id-from-a-title-or-slug/11296#11296
*
* @since 1.0.0
*
* @uses $wpdb
*
* @param string $post_title Page title
* @param string $post_type post type ('post','page','any custom type')
* @param string $output Optional. Output type. OBJECT, ARRAY_N, or ARRAY_A.
* @return mixed
*/
function schema_wp_get_post_by_title($page_title, $post_type = 'post' , $output = OBJECT) {
    global $wpdb;
        $post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type= %s", $page_title, $post_type));
        if ( $post )
            return get_post($post, $output);

    return null;
}

/**
 * Recursive array search
 *
 * #link http://php.net/manual/en/function.array-search.php
 *
 * @since 1.0.0
 * @return Returns the key for needle if it is found in the array, FALSE otherwise. 
 */
function schema_wp_recursive_array_search( $needle, $haystack ) {
    foreach($haystack as $key=>$value) {
        $current_key=$key;
        if($needle===$value OR (is_array($value) && schema_wp_recursive_array_search($needle,$value) !== false)) {
            return $current_key;
        }
    }
    return false;
}

/**
 * Recursive array search by Key => value
 *
 * #link https://stackoverflow.com/questions/1019076/how-to-search-by-key-value-in-a-multidimensional-array-in-php
 *
 * @since 1.1.1
 * @return Returns array 
 */
function schema_premium_recursive_array_search( $array, $key, $value) {
    
	$results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, schema_premium_recursive_array_search($subarray, $key, $value));
        }
    }

    return $results;
}

/**
 * Get corporate contacts types
 *
 * @since 1.0.0
 * @return array $corporate_contacts_types A list of the available types
 */
function schema_wp_get_corporate_contacts_types() {

	$corporate_contacts_types = array(
		'customer_support'		=> __( 'Customer Support', 'schema-premium' ),
		'technical_support'		=> __( 'Technical Support', 'schema-premium' ),
		'billing_support'		=> __( 'Billing Support', 'schema-premium' ),
		'bill_payment'			=> __( 'Bill Payment', 'schema-premium' ),
		'sales'					=> __( 'Sales', 'schema-premium' ),
		'reservations'			=> __( 'Reservations', 'schema-premium' ),
		'credit_card_support'	=> __( 'Credit Card Support', 'schema-premium' ),
		'emergency'				=> __( 'Emergency', 'schema-premium' ),
		'baggage_tracking'		=> __( 'Baggage Tracking', 'schema-premium' ),
		'roadside_assistance'	=> __( 'Roadside Assistance', 'schema-premium' ),
		'package_tracking'		=> __( 'Package Tracking', 'schema-premium' ),
	);

	return apply_filters( 'schema_wp_corporate_contacts_types', $corporate_contacts_types );
}

/**
 * Get post types
 *
 * @since 1.0.0
 * @return array $post_types of all registered post types 
 */
function schema_wp_get_post_types() {

	$post_types = array();
	$builtin = array();
	
	$builtin['post'] = array(
		'name' 	=> 'post',
		'label' => 'Post'
	);
	
	$builtin['page'] = array(
		'name' 	=> 'page',
		'label' => 'Page'
	);
	
	// all CPTs.
	$cpts_obj = get_post_types( array(
		'public'   => true,
		'_builtin' => false
		) , 
	'objects'); // return post types 'objects'
	
	if ( ! empty($cpts_obj) ) {
		// prepare array
		foreach ( $cpts_obj as $cpt => $info ) {
			$cpts[$cpt] = array(
				'name' 	=> $cpt,
				'label' => $info->label
			);
		}
		
		// merge Builtin types and 'important' CPTs to resulting array to use as argument.
		$post_types = array_merge( $builtin, $cpts );
	} else {
		
		$post_types = $builtin;
	}
	
	// debug
	//echo'<pre>';print_r($post_types);echo'</pre>';

	return apply_filters( 'schema_wp_post_types', $post_types );
}

/**
 * Get the current post type in the WordPress Admin
 *
 * @url https://gist.github.com/DomenicF/3ebcf7d53ce3182854716c4d8f1ab2e2
 * @since 1.0.0
 * @return array $post_types of all registered post types 
 */
function schema_wp_get_current_post_type() {
	global $post, $typenow, $current_screen, $pagenow;
	//we have a post so we can just get the post type from that
	if ( $post && $post->post_type ) {
   		return $post->post_type;
	}
	//check the global $typenow - set in admin.php
	elseif ( $typenow ) {
		return $typenow;
	}
	//check the global $current_screen object - set in sceen.php
	elseif ( $current_screen && $current_screen->post_type ) {
		return $current_screen->post_type;
	}
	//check the post_type querystring
	elseif ( isset( $_REQUEST['post_type'] ) ) {
		return sanitize_key( $_REQUEST['post_type'] );
	}
	//lastly check if post ID is in query string
	elseif ( isset( $_REQUEST['post'] ) ) {
		return get_post_type( $_REQUEST['post'] );
	}
	
	//we do not know the post type!
	return null;
}

/**
 * is_edit_page 
 * function to check if the current page is a post edit page
 * 
 * @author Ohad Raz <admin@bainternet.info>
 * 
 * @since 1.0.6
 * @param  string  $new_edit what page to check for accepts new - new post page ,edit - edit post page, null for either
 * @return boolean
 */
function sp_is_edit_page($new_edit = null){
    global $pagenow;
    //make sure we are on the backend
    if (!is_admin()) return false;


    if($new_edit == "edit")
        return in_array( $pagenow, array( 'post.php',  ) );
    elseif($new_edit == "new") //check for new post page
        return in_array( $pagenow, array( 'post-new.php' ) );
    else //check for either new or edit
        return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
}
