<?php
/**
 * Location rule to for Schema
 *
 * @package     Schema
 * @subpackage  Schema Post Meta ACF
 * @copyright   Copyright (c) 2018, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/location/rule_types', 'schema_wp_types_acf_add_special_rule_type' );
/**
 * Add rule type
 *
 * @since 1.0.0
 *
 * return array
 */
function schema_wp_types_acf_add_special_rule_type( $choices ) {
	if (!isset($choices['Special'])) {
		$choices['Extra'] = array();
	}
	if (!isset($choices['Extra']['is_schema'])) {
		$choices['Extra']['is_schema'] = 'Schema';
	}
	if (!isset($choices['Extra']['is_opennings'])) {
		$choices['Extra']['is_opennings'] = 'OpeningHoursSpecification';
	}
	return $choices;
}

add_filter( 'acf/location/rule_values/is_schema', 'schema_wp_types_acf_location_rules_values_special_is_schema' );
/**
 * Add rule value
 *
 * @since 1.0.0
 *
 * return array
 */
function schema_wp_types_acf_location_rules_values_special_is_schema( $choices ) {
	$choices['true'] = 'true';
	$choices['false'] = 'false';
	return $choices;
}

add_filter( 'acf/location/rule_match/is_schema', 'schema_wp_types_acf_location_rules_match_is_schema', 10, 3 );
/**
 * Add rule match
 *
 * @since 1.0.0
 *
 * return array
 */
function schema_wp_types_acf_location_rules_match_is_schema( $match, $rule, $options ) {
	
	global $post, $pagenow;
	
	if ( ! isset($post->ID) )
		return $match;

	if ($rule['param'] != 'is_schema') {
		return $match;
	}
	
	$post_type 		= schema_wp_get_current_post_type();
	$schema_enabled = schema_wp_get_enabled_location_targets();
					
	if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' ) {
        
		if ( !empty($schema_enabled) ) {     
           
		   // Get array value with unknown key name, which is schema post ID
		   $schema_enabled = reset($schema_enabled);
		   
		   if ($rule['operator'] == '==') {
				// Get match of location target
				//
				$schema_location_target = schema_premium_get_location_target_match($post->ID);
				
				if ( ! empty($schema_location_target) ) :
					foreach ( $schema_location_target as $locations => $location ) :
						if ($location['match']) {
							$match = true;
							break;
						}
					endforeach;
				endif;
				
			} elseif ( $rule['operator'] == '!=' ) {
				$match = false;
			}
			if ( $rule['value'] != 'true' ) {
				$match = !$match;
			} 
			
        } //end of if !empty array
		
    } //end of post new
	
	return $match;
}

add_filter( 'acf/location/rule_values/is_opennings', 'schema_wp_types_acf_location_rules_values_special_is_opennings' );
/**
 * Add rule value
 *
 * @since 1.0.0
 *
  * @return array
 */
function schema_wp_types_acf_location_rules_values_special_is_opennings( $choices ) {
	$choices['true'] = 'true';
	$choices['false'] = 'false';
	return $choices;
}

add_filter( 'acf/location/rule_match/is_opennings', 'schema_wp_types_acf_location_rules_match_is_opennings', 10, 3 );
/**
 * Add rule match
 *
 * @since 1.0.0
 *
 * @return array
 */
function schema_wp_types_acf_location_rules_match_is_opennings( $match, $rule, $options ) {
	
	global $post, $pagenow;
	
	if ( ! isset($post->ID) )
		return $match;
		
	if ($rule['param'] != 'is_opennings') {
		return $match;
	}
	
	$is_opennings_enable = schema_premium_meta_is_opennings();
	if ( empty($is_opennings_enable) ) {
		return;
	}
	
	$post_type 		= schema_wp_get_current_post_type();
	$schema_enabled = schema_wp_get_enabled_location_targets();
			
	if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' ) {
        
		if ( ! empty($schema_enabled) ) {     
           
		   // Get array value with unknown key name, which is schema post ID
		   $schema_enabled = reset($schema_enabled);
		   
		   if ($rule['operator'] == '==') {
				// Get match of location target
				$schema_location_target = schema_premium_get_location_target_match( $post->ID );
				
				if ( ! empty($schema_location_target) ) :
					foreach ( $schema_location_target as $locations => $location ) :
						if ($location['match'] && in_array( $location['schema_type'], $is_opennings_enable ) ) {
							$match = true;
							break;
						}
					endforeach;
				endif;
				
			} elseif ($rule['operator'] == '!=') {
				$match = false;
			}
			if ($rule['value'] != 'true') {
				$match = !$match;
			} 
			
        } //end of if !empty array
		
    } //end of post new
	
	return $match;
}

/**
 * Check Schema enabled entries, used by Locations targeting
 *
 * @since 1.0.0
 * @return array of schema data
 */
function schema_premium_get_location_target_match( $post_id = null ) {
	
	if ( isset($post_id) ) {
		$post = get_post($post_id);
	} else {
		global $post;
	}
	
	$match 				= false;
	$schema_location 	= array();

	$location_targets	= schema_wp_get_enabled_location_targets();
	
	// Debug
	//echo '<pre>'; print_r($location_targets); echo '</pre>'; 
	
	if ( ! is_array($location_targets) || empty($location_targets) ) 
		return false;
	
	foreach( $location_targets as $locations => $location ) : 
		
		// Get an array of category slugs
		// @since 1.0.3
		//
		$categories = array();
		//
		// Check if post_category is selected for both enabled and excluded entries
		// @since 1.2
		//
		if ( isset($location['enabled_on']['post_category']) || isset($location['excluded_on']['post_category']) ) {
			if ( ! empty($post->post_category) ) {
				foreach ( $post->post_category as $key => $cat_id ) {
					$categories[] = schema_premium_get_cat_slug_by_id( $cat_id );
				}
				//echo '<pre>'; print_r($categories); echo '</pre>';
			}
		}

		if ( isset($location['enabled_on']['all_singulars']) && $location['enabled_on']['all_singulars'] === true ) {
				$match = true;
		} else {
			if ( isset($location['enabled_on']) && is_array($location['enabled_on']) ) {
				foreach ( $location['enabled_on'] as $enabled ) :
					if ( 	is_object($post) && in_array( $post->post_type, $enabled) 	||
							is_object($post) && in_array( $post->post_format, $enabled) ||
							is_object($post) && in_array( $post->post_status, $enabled) ||
							! empty(array_intersect($categories, $enabled)) ||
							is_object($post) && in_array( $post->ID, $enabled) )
							{
								$match = true;
					}
				endforeach;
			}
		}
	
		if ( isset($location['excluded_on']['all_singulars']) && $location['excluded_on']['all_singulars'] === true ) {
				$match = false;
		} else {
			
			if ( isset($location['excluded_on']) && is_array($location['excluded_on']) ) {
				foreach ( $location['excluded_on'] as $excluded ) :
					if ( 	is_object($post) && in_array( $post->post_type, $excluded)	 ||
							is_object($post) && in_array( $post->post_format, $excluded) ||
							is_object($post) && in_array( $post->post_status, $excluded) ||
							! empty(array_intersect($categories, $excluded)) ||
							is_object($post) && in_array( $post->ID, $excluded) )
							{
								$match = false;
					}
				endforeach;
			}
		}
		
		if ( isset($location['schema_type']) ) {
			
			$schema_location[$locations] = array
			(
				'schema_type' 		=> $location['schema_type'],
				'schema_subtype'	=> isset($location['schema_subtype']) ? $location['schema_subtype'] : '',
				'match'				=> $match,
			);
		}
		
		// Reset match
		//
		$match = false;
	
	endforeach;
	
	// Debug
	//
	//if ( ! is_admin() ) {  echo '<pre>'; print_r($schema_location); echo '</pre>';  }
	
	return apply_filters( 'schema_location_rules', $schema_location );					
}

/**
 * Check Schema enabled entries, used by Locations targeting
 * Make sure a specific proprty is set to a specific value
 *
 * @since 1.1.2
 * @return bool
 */
function schema_premium_check_location_target_match( $post_id = null, $property = '', $value = '' ) {
	
	global $post;
	
	$post_id = isset($post->ID) ? $post->ID : null;
	
	if ( ! isset($post_id))
		return false;
		 
	$location_target_match = schema_premium_get_location_target_match( $post_id );
	
	if ( empty($location_target_match) ) 
		return false;
	
	foreach ( $location_target_match as $schema_ID => $target_match ) {
		
		if ( isset($target_match['match']) && $target_match['match'] == 1 ) {
			
			$property_val = get_post_meta( $schema_ID, '_properties_' . $property, true );
			
			if ( isset($property_val) && $property_val == $value ) {
				return true; 
			}
		}
	}
	
	return false;
}

/**
 * Check Schema enabled entries, used by Locations targeting
 *
 * @since 1.0.0
 * @return array of schema data
 */
function schema_wp_get_enabled_location_targets() {
	
	$cache_key = 'schema_location_targets_query';

	if ( ! $location_targets = get_transient( $cache_key ) ) {
		// It wasn't there, so regenerate the data and save the transient
		
		$args = array
		(
			'post_type'			=> 'schema',
			'post_status'		=> 'publish',
			'posts_per_page'	=> -1
		);
				
		$schemas_query		= new WP_Query( $args );
		$schemas 			= $schemas_query->get_posts();
		$location_targets 	= array();
	
		if ( empty($schemas) ) return array(); // return if empty
		
		// Check if function exists before calling it
		// @since 1.1.2.9
		//
		if ( ! function_exists('get_field') ) return array();

		foreach( $schemas as $schema ) : 
		
			$field_locations 	= get_field( 'field_schema_locations', $schema->ID );
			$field_exclution 	= get_field( 'field_schema_exclution', $schema->ID );
			$schema_type 		= get_post_meta( $schema->ID, '_schema_type', true );
			$schema_subtype 	= get_post_meta( $schema->ID, 'schema_subtype', true );
	
			$enabled_on_array	= array();
			$excluded_on_array	= array();

			// 
			// Schema Locations
			//
			if ( ! empty($field_locations) && is_array($field_locations) ) {
			
				foreach ($field_locations as $locations => $location) :
			
					$this_location = $location['locations_group_sub'];
				
					//if ( ! is_admin() ) {	
						//echo '<pre>'; print_r($this_location); echo '</pre>'; 
					//}
				
					switch( $this_location['schema_locations_select'] ) {
				
						case 'all_singulars':
							$enabled_on_array['all_singulars'] = true;
							break;
				
						case 'post_type':
							if ( isset($this_location['schema_post_type_location']) ) {
								$enabled_on_array['post_type'][] = $this_location['schema_post_type_location'];
							}
							break;
	
						case 'post_format':
							if ( isset($this_location['schema_post_formats_location']) ) {
								$enabled_on_array['post_format'][] = $this_location['schema_post_formats_location'];
							}
							break;
			
						case 'post_status':
							if ( isset($this_location['schema_post_statuses_select_location']) ) {
								$enabled_on_array['post_status'][] = $this_location['schema_post_statuses_select_location'];
							}
							break;
						
						case 'post_category':
							if ( isset($this_location['schema_categories_select_location']) ) {
								$enabled_on_array['post_category'][] = $this_location['schema_categories_select_location'];
							}
							break;
						
						case 'post_taxonomy':
							if ( isset($this_location['schema_taxonomy_select_location']) ) {
								$enabled_on_array['post_taxonomy'][] = $this_location['schema_taxonomy_select_location'];
							}
							break;
							
						case 'post':
							if ( '' != $this_location['schema_post_location'] ) {
								$enabled_on_array['post'][] = $this_location['schema_post_location'];
							}
							break;
					
						case 'page':
							if ( '' != $this_location['schema_page_location'] ) {
								$enabled_on_array['page'][] = $this_location['schema_page_location'];
							}
							break;
						
						case 'post_id':
							// Break the string into an array
							// in case more than one post id is defined
							// @since 1.1.2.4
							//
							$post_ids = isset($this_location['schema_post_id_location']) ? explode( ',', $this_location['schema_post_id_location']) : array();
							
							if ( !empty($post_ids) ) {
								foreach ( $post_ids as $the_enabled_post_id ) {
									$enabled_on_array['post_id'][] = $the_enabled_post_id;
								}
							}
							break;
					}
			
				endforeach;
			}
			
			// 
			// Schema Exclution
			//

			//echo'<pre>';print_r( $field_exclution ); echo'</pre>';

			if ( ! empty($field_exclution) ) {
				
				foreach ($field_exclution as $exclutions => $exclution) :
				
					$this_exclution = $exclution['exclusion_group_sub'];
					
					//if ( ! is_admin() ) {	
					//echo '<pre>'; print_r($this_exclution); echo '</pre>'; 
					//}
					
					switch( $this_exclution['schema_exclution_select'] ) {
					
						case 'all_singulars':
							$excluded_on_array['all_singulars'] = true;
							break;
					
						case 'post_type':
							if ( isset($this_exclution['schema_post_type_exclution']) ) {
								$excluded_on_array['post_type'][] = $this_exclution['schema_post_type_exclution'];
							}
							break;
		
						case 'post_format':
							if ( isset($this_exclution['schema_post_formats_exclution']) ) {
								$excluded_on_array['post_format'][] = $this_exclution['schema_post_formats_exclution'];
							}
							break;
				
						case 'post_status':
							if ( isset($this_exclution['schema_post_statuses_select_exclution']) ) {
								$excluded_on_array['post_status'][] = $this_exclution['schema_post_statuses_select_exclution'];
							}
							break;
						
						case 'post_category':
							if ( isset($this_exclution['schema_categories_select_exclution']) ) {
								$excluded_on_array['post_category'][] = $this_exclution['schema_categories_select_exclution'];
							}
							break;
							
						case 'post':
							if ( '' != $this_exclution['schema_post_exclution'] ) {
								$excluded_on_array['post'][] = $this_exclution['schema_post_exclution'];
							}
							break;
						
						case 'page':
							if ( '' != $this_exclution['schema_page_exclution'] ) {
								$excluded_on_array['page'][] = $this_exclution['schema_page_exclution'];
							}
							break;
						
						case 'post_id':
							// Break the string into an array
							// in case more than one post id is defined
							// @since 1.1.2.4
							//
							$post_ids = isset($this_exclution['schema_post_id_exclution']) ? explode( ',', $this_exclution['schema_post_id_exclution']) : array();
							//echo '<pre>'; print_r($post_ids); echo '</pre>';
							if ( !empty($post_ids) ) {
								foreach ( $post_ids as $the_excluded_post_id ) {
									$excluded_on_array['post_id'][] = $the_excluded_post_id;
								}
							}
							break;
					}
				
				endforeach;
			}
			
			// Check if -at least- there is one enabled type in our array, is not empty
			//
			if ( ! empty($enabled_on_array) ) {
				
				// Get data about this Type
				//
				$location_targets[$schema->ID] = array
				(
					'schema_type' 		=> $schema_type,
					'schema_subtype'	=> $schema_subtype,
					'enabled_on' 		=> $enabled_on_array,
					'excluded_on' 		=> $excluded_on_array
				);

				// Check if type is Review, add itemReviewed
				// @since 1.2
				//
				if ( $schema_type == 'Review') {
					$itemReviewed = get_post_meta( $schema->ID, '_properties_itemReviewed', true );
					$location_targets[$schema->ID]['itemReviewed'] = $itemReviewed;
				}
			}
			
		endforeach;
		
		wp_reset_postdata();
		//wp_reset_query();
		
		set_transient( $cache_key, $location_targets, 24 * HOUR_IN_SECONDS );
	}
	
	// Debug
	//
	//if ( ! is_admin() ) { echo '<pre>'; print_r($location_targets); echo '</pre>'; }
	
	return $location_targets;
}

add_action( 'save_post', 'schema_wp_delete_location_targets_transient_on_save', 10, 2 );
/**
 * Delet location targets transient on Schema type save
 *
 * @since 1.0.0
 * @return string, post id
 */
function schema_wp_delete_location_targets_transient_on_save( $post_id, $post ) {
		
	if ( ! isset( $GLOBALS['post']->ID ) )
		return NULL;
	
	if ( 'schema' != $post->post_type ) {
        return $post_id;
    }
		
	if( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
    || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) 
		return NULL;

	$cache_key = 'schema_location_targets_query';
	
	delete_transient( $cache_key );
		
	return $post_id;
}
