<?php
/**
 * Generate post meta fields for ACF - Star Rating field
 *
 * @package     Schema
 * @subpackage  Schema Post Meta ACF
 * @copyright   Copyright (c) 2017, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// check if class already exists
if ( class_exists( 'acf_field' )  && ! class_exists( 'schema_wp_acf_field_star_rating' ) ) :

class schema_wp_acf_field_star_rating extends acf_field {
    
    /*
    *  __construct
    *
    *  This function will setup the field type data
    *
    *  @type    function
    *  @date    2017
    *  @since   1.0.0
    *
    *  @param   n/a
    *  @return  n/a
    */
    
    function initialize() {
		
		// vars
        $this->name = 'star_rating';
        $this->label = __("Star Rating",'acf');
        $this->category = 'choice';
        $this->defaults = array(
            'layout'            => 'horizontal',
            'choices'           => array(),
            'default_value'     => '',
            'other_choice'      => 0,
            'save_other_choice' => 0,
			'max_stars' 		=> 5,
            'return_type' 		=> 'num',
            'half_rating' 		=> true,
            'class'      		=> '',
        );
    }

	/*
	*  input_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add CSS + JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	1.0.0
	*  @date	27/11/2018
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function input_admin_enqueue_scripts() {
		
		$dir = plugin_dir_url( __FILE__ );
		
		//wp_enqueue_script( 'schema-acf-input-star_rating', SCHEMAPREMIUM_PLUGIN_URL . 'assets/js/star-rating-input.js' );
		wp_enqueue_style( 'font-awesome', "//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css");
		wp_enqueue_style( 'schema-acf-input-star_rating', SCHEMAPREMIUM_PLUGIN_URL . 'assets/css/star-rating-input.css' ); 
		
	}

    /*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
	*
	*  @type	filter
	*  @since	1.0.0
	*  @date	27/11/2018
	*
	*  @param	$value (mixed) the value which was loaded from the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*
	*  @return	$value (mixed) the modified value
	*/
	
	function format_value( $value, $post_id, $field ) {
		
		// bail early if no value
		if( empty($value) ) {
		
			return $value;
			
        }
        
        switch( $field['return_type'] ){
            
            case 'num': 
                return floatval( $value );
                break;
            
            case 'percentage':  
                return floatval( $value ) * 100 / $field['max_stars'];
                break;
        }

    }
    
    /*
	*  load_value()
	*
	*  This filter is applied to the $value after it is loaded from the db
	*
	*  @type	filter
	*  @since	5.2.9
	*  @date	23/01/13
	*
	*  @param	$value - the value found in the database
	*  @param	$post_id - the $post_id from which the value was loaded from
	*  @param	$field - the field array holding all the field options
	*
	*  @return	$value - the value to be saved in te database
	*/
	
	function load_value( $value, $post_id, $field ) {
		
		// must be single value
		if( is_array($value) ) {
			
			$value = array_pop($value);
			
		}
		
		switch( $field['return_type'] ){
            
            case 'num': 
                return floatval( $value );
                break;
            
            case 'percentage':  
                return floatval($value) * $field['max_stars'] / 100; 
                break;
        }
		// return
		return $value;
		
	}
	    
    /*
    *  render_field()
    *
    *  Create the HTML interface for your field
    *
    *  @param   $field (array) the $field being rendered
    *
    *  @type    action
    *  @since   1.0.0
    *  @date    27/11/2018
    *
    *  @param   $field (array) the $field being edited
    *  @return  n/a
    */
    
    function render_field( $field ) {
		
		// vars
        $i = 0;
        $checked = false;
        
        
        // class
        $field['class'] .= ' acf-radio-list';
        $field['class'] .= ($field['layout'] == 'horizontal') ? ' acf-hl' : ' acf-bl';

        // other choice
        if( $field['other_choice'] ) {
            
            // vars
            $input = array(
                'type'      => 'text',
                'name'      => $field['name'],
                'value'     => '',
                'disabled'  => 'disabled'
            );
            
            // select other choice if value is not a valid choice
            if( !isset($field['choices'][ $field['value'] ]) ) {
                
                unset($input['disabled']);
                $input['value'] = $field['value'];
                $field['value'] = 'other';
                
            }
            
            $field['choices']['other'] = '</label><input type="text" ' . acf_esc_attr($input) . ' /><label>';
        }
       
        // Round value to the nearest .5 (step)
        //
        $field['value'] = ( is_numeric($field['value']) ) ? round($field['value'] * 2) / 2 : 0;

		$e = '<div class="">';
		$e .= '<fieldset class="rating-group">';
			
	 	// require choices
        if( !empty($field['choices']) ) {
            
            // select first choice if value is not a valid choice
            if( !isset($field['choices'][ $field['value'] ]) ) {
                
				//$field['value'] = key($field['choices']);
                
            }
            	
            // foreach choices
            foreach( $field['choices'] as $value => $label ) {
                
                // increase counter
                $i++;
                
                $value = strval($value);
                $label = strval($label);

                // vars
                $atts = array(                                    
                    'id'    => $field['id'], 
                    'type'  => 'radio',
                    'name'  => $field['name'],
                    'value' => $value,
                );
                                
                $atts2 = array(
                    'id'   		 	=>'star_hide_text',
                    'for'   		=> $field['id'],
                    'title' 		=> $label .' star',
					'aria-label' 	=> $value .' star',
                );   
				    
                if( strval($value) === strval($field['value']) ) {
                    
                    $atts['checked'] = 'checked';
                    $checked = true;   
                }
				
                if( isset($field['disabled']) && acf_in_array($value, $field['disabled']) ) {
                
                    $atts['disabled'] = 'disabled';    
                }
               
			    // each input ID is generated with the $key, however, the first input must not use $key so that it matches the field's label for attribute
                if( $i > 0 ) {
                
                    $atts['id'] .= '-' . $value;
                    $atts2['for'] .= '-' . $value;
                }
              	
				if ( ctype_digit($label) ) {
					$e .= '<input ' . acf_esc_attr( $atts ) . ' /><label '. acf_esc_attr( $atts2 ).'></label>';
				
				} else {
                    if ( $field['half_rating'] )
					    $e .= '<input ' . acf_esc_attr( $atts ) . ' /><label class="half" '. acf_esc_attr( $atts2 ).'></label>';
				}
			}   
			
			$e .= '<input class="rating_no_star_input" type="radio" id="'.$field['id'].'" name="'.$field['name'].'" value="0" />
					<label class="rating_no_star" for="'.$field['id'].'" title="No star"></label>';                
        } else {
			// no choices provided
			echo __('Choices not available!', 'schema-premium');
		}
      
	  $e .= '</fieldset>'; 
      $e .= '</div>'; 
	  
	  echo $e;        
    }
    
    
    /*
    *  render_field_settings()
    *
    *  Create extra options for your field. This is rendered when editing a field.
    *  The value of $field['name'] can be used (like bellow) to save extra data to the $field
    *
    *  @type    action
    *  @since   1.0.0
    *  @date    27/11/2018
    *
    *  @param   $field  - an array holding all the field's data
    */
    
    function render_field_settings( $field ) {
        
        // encode choices (convert from array)
        $field['choices'] = acf_encode_choices($field['choices']);
        

        acf_render_field_setting( $field, array(
			'label'			=> __('Maximum Rating', 'schema-premium'),
			'instructions'	=> __('Maximum number of stars', 'schema-premium'),
			'type'			=> 'number',
			'name'			=> 'max_stars'
		));


		acf_render_field_setting( $field, array(
			'label'			=> __('Return Type', 'schema-premium'),
			'instructions'	=> __('What should be returned?', 'schema-premium'),
			'type'			=> 'select',
			'layout' 		=> 'horizontal',
			'choices' 		=> array(
                'num' 	       => __('Number', 'num'),
                'percentage'   => __('Percentage', 'percentage'),
				'2' 	       => __('List (unstyled)', 'list_u'),
                '3' 	       => __('List (fa-awesome)', 'list_fa')
			),
			'name' 			=> 'return_type'
		));
        
        
        // choices
        acf_render_field_setting( $field, array(
            'label'         => __('Choices','acf'),
            'instructions'  => __('Enter each choice on a new line.','acf') . '' . __('For more control, you may specify both a value and label like this:','acf'). '' . __('red : Red','acf'),
            'type'          => 'textarea',
            'name'          => 'choices',
        ));
        
        
        // other_choice
        acf_render_field_setting( $field, array(
            'label'         => __('Other','acf'),
            'instructions'  => '',
            'type'          => 'true_false',
            'name'          => 'other_choice',
            'message'       => __("Add 'other' choice to allow for custom values", 'acf')
        ));
        
        
        // save_other_choice
        acf_render_field_setting( $field, array(
            'label'         => __('Save Other','acf'),
            'instructions'  => '',
            'type'          => 'true_false',
            'name'          => 'save_other_choice',
            'message'       => __("Save 'other' values to the field's choices", 'acf')
        ));
        
        
        // default_value
        acf_render_field_setting( $field, array(
            'label'         => __('Default Value','acf'),
            'instructions'  => __('Appears when creating a new post','acf'),
            'type'          => 'text',
            'name'          => 'default_value',
        ));
        
        
        // layout
        acf_render_field_setting( $field, array(
            'label'         => __('Layout','acf'),
            'instructions'  => '',
            'type'          => 'radio',
            'name'          => 'layout',
            'layout'        => 'horizontal', 
            'choices'       => array(
                'vertical'      => __("Vertical",'acf'), 
                'horizontal'    => __("Horizontal",'acf')
            )
        ));
        
        
    }
    
    
    /*
    *  update_field()
    *
    *  This filter is applied to the $field before it is saved to the database
    *
    *  @type    filter
    *  @since   1.0.0
    *  @date    27/11/2018
    *
    *  @param   $field - the field array holding all the field options
    *  @param   $post_id - the field group ID (post_type = acf)
    *
    *  @return  $field - the modified field
    */

    function update_field( $field ) {
        
        // decode choices (convert to array)
        $field['choices'] = acf_decode_choices($field['choices']);
        
        // return
        return $field;
    }
    
    
    /*
    *  update_value()
    *
    *  This filter is applied to the $value before it is updated in the db
    *
    *  @type    filter
    *  @since   1.0.0
    *  @date    27/11/2018
    *  @todo    Fix bug where $field was found via json and has no ID
    *
    *  @param   $value - the value which will be saved in the database
    *  @param   $post_id - the $post_id of which the value will be saved
    *  @param   $field - the field array holding all the field options
    *
    *  @return  $value - the modified value
    */
    
    function update_value( $value, $post_id, $field ) {
        
        // save_other_choice
        if( $field['save_other_choice'] ) {
            
            
            // value isn't in choices yet
            if( !isset($field['choices'][ $value ]) ) {
                
                
                // update $field
                $field['choices'][ $value ] = $value;
                
                
                // save
                acf_update_field( $field );
                
            }
            
        }       
        
        switch( $field['return_type'] ){
            
            case 'num': // num
                return floatval( $value );
                break;
            
            case 'percentage': // percentage
                $rating = floatval( $value ) * 100 / $field['max_stars'];
                $rating = round($rating / 5) * 5; 
                return $rating;
                break;
            
                case 2:
				return $this->make_list( 
					$field['max_stars'], 
					$value,
					'<li class="%s">%d</li>', 
					array('empty', 'blank', 'half')
				);
			    break;
            
            case 3:
			
				wp_enqueue_style( 'schema-acf-input-star_rating', SCHEMAPREMIUM_PLUGIN_URL . 'assets/css/star-rating-input.css' ); 
				wp_enqueue_style( 'font-awesome', "//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css");
				//wp_enqueue_style( 'dashicons' );
				/*
				$html = '
					<div class="field_type-star_rating">
						%s
					</div>
				';
				
				if( ($value)){
					$args = array(
   						'rating' => $value,
   						'type' => 'rating',
   						'number' => 1234,
					);
					wp_star_rating( $args );
				}
	
				return sprintf(
					$html, 
					$this->make_list( 
						$field['max_stars'], 
						$value,
						'<li><i class="%s star-%d"></i></li>', 
						array('fa fa-star', 'fa fa-star-o', 'fa fa-star-half-o') 
					)
				);*/if( ($value)){
						$args = array(
   							'rating' => $value,
   							'type' => 'rating',
   							'number' => 1234,
						);
						wp_star_rating( $args );
					}
			    break;
		}

        // return
        return $value;
    }
	
	
	/*
	* make_list()
	*
	* Create a HTML list
	*
	* @return $html (string)
	*/
	
	function make_list($max_stars, $current_star, $li, $classes )
	{
		$is_half = $current_star != round($current_star);
		
		$html = '<ul class="star-rating">';
		
		for( $index = 1; $index < $max_stars + 1; $index++ ):
			$class = $classes[1];
			if ($index <= $current_star) {
				$class = $classes[0];				
			} else if ($is_half && $index <= $current_star + 1) {
				$class = $classes[2];				
			}

			$html .= sprintf($li, $class, $index);
		endfor;
				
		$html .= "</ul>";
		
		return $html;
		
	}

}

// create field
new schema_wp_acf_field_star_rating();

// class_exists check
endif;
