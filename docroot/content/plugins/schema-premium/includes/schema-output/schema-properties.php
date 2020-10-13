<?php
/**
 * @package Schema Premium - Schema Properties output functions
 * @category Core
 * @author Hesham Zebida
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
	
/**
 * Get properties markup output
 *
 * @since 1.0.0
 * @return array
 */
function schema_wp_get_properties_markup_output( $post_id, $properties, $schema_type_now = null ) {
    
    //global $schema_properties;

    if ( empty($properties) ) return;
    
    if ( isset($post_id) ) {
                $post = get_post( $post_id );
    } else {
        global $post;
    }
    
    $is_enabled = schema_wp_get_enabled_location_targets( $post->ID );
    
    if ( empty($is_enabled) ) return;
    
    //echo '<pre>'; print_r($is_enabled); echo '</pre>';
    
    $schema = array();
    
    foreach ( $is_enabled as $schema_ID => $enabled ) :
        
        //
        // @since 1.1.2
        //
        if ( isset($schema_type_now) && $schema_type_now == $enabled['schema_type'] || $schema_type_now == $enabled['schema_subtype'] ) {
            
            // Get final schema type
            $schema_type            = $enabled['schema_type'];
            $schema_default         = schema_wp_get_default_schemas( $schema_type );
            $schema_type_properties = $properties;
            $enabled_on             = $enabled['enabled_on'];
            
            foreach ( $properties as $properity => $details ) :
            
                if ( isset($details['sub_fields']) && ! empty($details['sub_fields']) ) {
                    // Sub field
                    foreach( $details['sub_fields'] as $sub_field_properity => $sub_field_details) :
                        $property_field = get_post_meta( $schema_ID, '__properties_' . $sub_field_properity, true );
        
                        $output = schema_wp_check_property_field( $post, $schema_ID, $schema_type, $property_field, $sub_field_properity, $enabled_on, true );
                        if ( isset($output) && $output != '' ) {
                            $schema[$properity][$sub_field_properity] = $output;
                        }
                    endforeach;
                    
                } else {
                    // Main field
                    $property_field = get_post_meta( $schema_ID, '_properties_' . $properity, true );
                    $output = schema_wp_check_property_field( $post, $schema_ID, $schema_type, $property_field, $properity, $enabled_on, false );
                    if ( isset($output) && $output != '' ) {
                        // Check if image is set to new custom field
                        // @since 1.0.1
                        if ( $properity == 'image' && $property_field == 'new_custom_field' ) {
                            $schema[$properity] = schema_premium_get_property_image_new_custom_field( $output ); 
                        } else {
                            $schema[$properity] = $output;
                        }
                    }
                }
                
            endforeach;

        } // end of check $post_type_now
        
        //return $schema;
        //echo $schema_ID .'<br>';
        //echo "<pre>";print_r($schema);echo "</pre>";
        //$schema_properties[$schema_ID] = $schema;
    
    endforeach;
    
    // Debug
    //echo "<pre>";print_r($schema_x);echo "</pre>";
    //exit;

    return $schema;
}

/**
 * Check property field
 *
 * @since 1.0.0
 * @return string or array
 */
function schema_wp_check_property_field ( $post, $schema_ID, $schema_type, $property_field, $properity, $enabled_on, $sub_field = false ) {
    
    $output = null;
    
    if ( $sub_field ) {
        $sub = '_';
    } else {
        $sub = '';
    }
    
    switch( $property_field ){
                
        // Site Meta
        //
        case 'site_title':
            
            $output = get_bloginfo( 'name' );
            break;
        
        case 'site_description':
            $output = get_bloginfo( 'description' );
            break;
        
        case 'site_url':
            $output = get_bloginfo( 'url' );
            break;
        
        // Post Meta
        //
        case 'post_title':
            $output = schema_wp_get_the_title( $post->ID );
            break;
        
        case 'post_content':
            $output = schema_wp_get_description( $post->ID );
            break;
        
        case 'post_excerpt':
            setup_postdata( $post );
            $output = ( isset($post->ID)) ? get_the_excerpt( $post->ID ) : array();
            break;
        
        case 'post_permalink':
            $output = get_permalink( $post->ID );
            break;
            
        case 'author_name':
            //$output = get_the_author_meta( 'display_name' );
            break;
            
        case 'post_date':
            $output = get_the_date( 'c', $post->ID );
            break;
            
        case 'post_modified':
            $output = get_post_modified_time( 'c', false, $post->ID, false );
            break;
        
        // Custom Fields
        //
        case 'new_custom_field':
            $output = get_post_meta( $post->ID, 'schema_properties_' . $schema_type . '_' . $properity, true );
            break;
        
        case 'fixed_text_field':
            // @since 1.1.2.4
            /*
            if (    isset($enabled_on['post_id'])   && is_array($enabled_on['post_id']) && !empty($enabled_on['post_id']) && in_array( $post->ID, $enabled_on['post_id']) 
                ||  isset($enabled_on['post'])      && is_array($enabled_on['post'])    && !empty($enabled_on['post']) && in_array( $post->ID, $enabled_on['post'])
                ||  isset($enabled_on['page'])      && is_array($enabled_on['page'])    && !empty($enabled_on['page']) && in_array( $post->ID, $enabled_on['page'])     
                ) {
                $output = get_post_meta( $schema_ID, $sub . '_fixed_text_field_' . $properity, true );
            }*/
            $output = get_post_meta( $schema_ID, $sub . '_fixed_text_field_' . $properity, true );
            //$output = $sub.'xxxxx';
            break;
        
        case 'featured_image':
            $output = schema_wp_get_media( $post->ID );
            break;

        case 'fixed_image_field':
            $fixed_image_id = get_post_meta( $schema_ID, $sub . '_fixed_image_field_' . $properity, true );
            $output = schema_premium_get_property_image_new_custom_field( $fixed_image_id );
            break;
            
        case 'existing_custom_field':
            $existing_custom_field_key  = get_post_meta( $schema_ID, $sub . '_existing_custom_field_' . $properity, true );
            $output                     = get_post_meta( $post->ID, $existing_custom_field_key, true );
            break;
        
        case 'fixed_review_field':
            $output = get_post_meta( $schema_ID, $sub . '_fixed_review_field_' . $properity, true );
            break;
        
        case 'fixed_ratingValue_field':
            $output = get_post_meta( $schema_ID, $sub . '_fixed_ratingValue_field_' . $properity, true );
            break;
        
        case 'fixed_priceRange_field':
            $output = get_post_meta( $schema_ID, $sub . '_fixed_priceRange_field_' . $properity, true );
            break;
        
        // Accept User Rating Field
        // @siince 1.0.2
        //
        case 'accept_user_rating':
            $output = 'accept_user_rating';
            break;
        
        // Accept User Reviews Field
        // @siince 1.1.2
        //
        case 'accept_user_reviews':
            $output = 'accept_user_reviews';
            break;
    }
    
    return $output;
}
