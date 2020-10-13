<?php
/**
 * ACF Extensions register: Currency Select
 *
 * @package     Schema
 * @subpackage  Schema ACF Extensions
 * @copyright   Copyright (c) 2018, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// check if class already exists
if( !class_exists('schema_acf_field_currency_select') ) :

class schema_acf_field_currency_select extends acf_field
{
/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	6/16/2018
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function __construct( $settings ) {
		
		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/
		
		$this->name = 'currency_select';
		
		
		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/
		
		$this->label = __('Currency Select', 'schema-premium');
		
		
		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/
		
		$this->category = 'choice';
		
		
		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*  var message = acf._e('FIELD_NAME', 'error');
		*/
		
		$this->l10n = array(
			'error'	=> __('Error! Please enter a higher value', 'schema-premium'),
		);
		
		
		/*
		*  settings (array) Store plugin settings (url, path, version) as a reference for later use with assets
		*/
		
		$this->settings = $settings;
		
		
		// do not delete!
    	parent::__construct();
    	
	}
	
	
	 /*
    *  render_field_settings()
    *
    *  Create extra settings for your field. These are visible when editing a field
    *
    *  @type    action
    *  @since   3.6
    *  @date    23/01/13
    *
    *  @param   $field (array) the $field being edited
    *  @return  n/a
    */
    public function render_field_settings($field)
    {

        /*
        *  acf_render_field_setting
        *
        *  This function will create a setting for your field.
        *  Simply pass the $field parameter and an array of field settings.
        *  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
        *
        *  More than one setting can be added by copy/paste the above code.
        *  Please note that you must also have a matching $defaults value for the field name (font_size)
        */

        // default_value
        acf_render_field_setting($field, array(
            'label' => __('Default Value', 'acf'),
            'instructions' => __('Enter each default value on a new line', 'acf'),
            'type' => 'textarea',
            'name' => 'default_value'
        ));

        // allow_null
        acf_render_field_setting($field, array(
            'label' => __('Allow Null?', 'acf'),
            'instructions' => '',
            'type' => 'radio',
            'name' => 'allow_null',
            'choices' => array(
                1 => __('Yes', 'acf'),
                0 => __('No', 'acf')
            ),
            'layout' => 'horizontal'
        ));

        // multiple
        acf_render_field_setting($field, array(
            'label'         => __('Select multiple values?','acf'),
            'instructions'  => '',
            'type'          => 'radio',
            'name'          => 'multiple',
            'choices'       => array(
                1               => __("Yes",'acf'),
                0               => __("No",'acf'),
            ),
            'layout'    =>  'horizontal',
        ));

    }
	
	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field (array) the $field being rendered
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	
	function render_field( $field ) {
		
		
		/*
		*  Review the data of $field.
		*  This will show what data is available
		*/
		
		// for debug
		//echo '<pre>';print_r( $field );echo '</pre>';
		
		// convert value to array
        $field['value'] = acf_get_array($field['value'], false);

        // add empty value (allows '' to be selected)
        if (empty($field['value'])) {
            $field['value'][''] = '';
        }

        // placeholder
        if (empty($field['placeholder'])) {
            $field['placeholder'] = __("Select",'acf');
        }

        // vars
        $atts = array(
            'id'                => $field['id'],
            'class'             => $field['class'],
            'name'              => $field['name'],
            'data-multiple'     => $field['multiple'],
            'data-placeholder'  => $field['placeholder'],
            'data-allow_null'   => $field['allow_null']
        );

        // multiple
        if ($field['multiple']) {
            $atts['multiple'] = 'multiple';
            $atts['size'] = 5;
            $atts['name'] .= '[]';
        }

        // special atts
        foreach (array( 'readonly', 'disabled' ) as $k) {
            if (!empty($field[ $k ])) {
                $atts[ $k ] = $k;
            }
        }

        // vars
        $els = array();
        // $choices = array();

        $currencies = $this->currencies_options();
        
		foreach ($currencies as $pt) {
            $els[] = array(
                'type' => 'option',
                'value' => $pt['value'],
                'label' => $pt['label'],
                'selected' => in_array($pt['value'], $field['value'])
            );
        }

        // null
        if ($field['allow_null']) {
            array_unshift($els, array(
                'type' => 'option',
                'value' => '',
                'label' => '- ' . $field['placeholder'] . ' -'
            ));
        }

        // html
        echo '<select ' . acf_esc_attr($atts) . '>';

        // construct html
        if (!empty($els)) {
            foreach ($els as $el) {
                // extract type
                $type = acf_extract_var($el, 'type');
                if ($type == 'option') {
                    // get label
                    $label = acf_extract_var($el, 'label');
                    // validate selected
                    if (acf_extract_var($el, 'selected')) {
                        $el['selected'] = 'selected';
                    }

                    // echo
                    echo '<option ' . acf_esc_attr($el) . '>' . $label . '</option>';
                } else {
                    // echo
                    echo '<' . $type . ' ' . acf_esc_attr($el) . '>';
                }

            }

        }

        echo '</select>';
	}
	
	 /**
     * Outputs Post Types in HTML option tags
     *
     * @return array Array of post type names and labels
     */
    private function currencies_options() {
		
		$currencies = schema_wp_get_currencies();
        $currencies = apply_filters( 'schema_acf_field_currency_select/get_currencies', $currencies );
		$output 	= array();

        foreach ($currencies as $currency_name => $currency_label ) {
            $output[] = array(
                'value' => $currency_name,
                'label' => $currency_label
            );
        }
        return apply_filters( 'schema_acf_field_currency_select_choices', $output );
    }
	
}

// create field
new schema_acf_field_currency_select( $this->settings );

// class_exists check
endif;
