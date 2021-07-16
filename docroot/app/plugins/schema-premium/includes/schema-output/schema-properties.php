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
    // @since 1.2
    if ( ! isset($schema_type_now) ) return;
    
    //echo '<pre>'; print_r($is_enabled); echo '</pre>';
    
    $schema = array();
    
    foreach ( $is_enabled as $schema_ID => $enabled ) :
        
        //
        // @since 1.1.2
        // Modified @since 1.2
        // TODO look at removing this check, or maybe keep it after adding itemReviewed
        //
        if ( $schema_type_now == $enabled['schema_type'] 
            || $schema_type_now == $enabled['schema_subtype'] 
            || isset($enabled['itemReviewed']) 
        ) {
            
            // Get final schema type
            $schema_type = $enabled['schema_type'];
            
            // Check if type is Review, set type to itemReviewed
            // @since 1.2
            //
            /*
            if ( $schema_type_now == 'Review' ) {
                $schema_type = $enabled['itemReviewed'];
                echo "<pre>";print_r($schema_ID);echo "</pre>";
            }
            */ 
        
            $enabled_on = $enabled['enabled_on'];

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
                    //
                    // Main field
                    //
                    $property_field = get_post_meta( $schema_ID, '_properties_' . $properity, true );
                    $output         = schema_wp_check_property_field( $post, $schema_ID, $schema_type, $property_field, $properity, $enabled_on, false );
                    
                    if ( isset($output) && $output != '' ) {
                       
                        // Check if property value is set to new custom field
                        // @since 1.2   
                        //
                        if ( $property_field == 'new_custom_field' ) {
                           
                            // Swtich between image types 
                            // to get the correct output
                            //
                            switch ( $properity ) {
                                
                                case 'image':
                                
                                    // Check if image is set to new custom field
                                    // @since 1.0.1
                                    //
                                    if ( $property_field == 'new_custom_field' )
                                        $schema[$properity] = schema_premium_get_property_image_new_custom_field( $output ); 
                                    break;
    
                                case 'logo':
                                    
                                    // Check if image is set to new custom field
                                    //
                                    if ( $property_field == 'new_custom_field' ) 
                                        $schema[$properity] = schema_wp_get_image_url_by_attachment_id( $output ); 
                                    break; 
                                
                                default:
                                    $schema[$properity] = $output;
                                    break;

                            } // end of switch

                        } else {

                            // get output value
                            //
                            if ( ! isset($schema[$properity])) {
                                $schema[$properity] = $output;
                            }
                                
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
    //echo "<pre>";print_r($schema);echo "</pre>";
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
        
        case 'full_content':
            // Full post content + HTML tags
            $output = schema_wp_get_description( $post->ID, 'full', false );
            break;

        case 'post_content':
            $output = schema_wp_get_description( $post->ID, 'full', true );
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
            $output = get_post_meta( $schema_ID, $sub . '_fixed_text_field_' . $properity, true );
            break;
        
        case 'featured_image':
            $output = schema_wp_get_media( $post->ID );
            break;

        case 'fixed_image_field':
            $fixed_image_id = get_post_meta( $schema_ID, $sub . '_fixed_image_field_' . $properity, true );
            if ( $properity == 'logo') {
                $output = schema_wp_get_image_url_by_attachment_id( $fixed_image_id );
            } else {
                // Get image object
                $output = schema_premium_get_property_image_new_custom_field( $fixed_image_id );
            }
            break;
            
        case 'existing_custom_field':
            $existing_custom_field_key  = get_post_meta( $schema_ID, $sub . '_existing_custom_field_' . $properity, true );
            if ( isset($existing_custom_field_key) &&  $existing_custom_field_key != '' ) {
                $output  = get_post_meta( $post->ID, $existing_custom_field_key, true );
            } else {
                $output = '';
            }
            
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
