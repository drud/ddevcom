<?php
/**
 * ACF Extensions register: Address
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
if( !class_exists('schema_acf_field_address') ) :

class schema_acf_field_address extends acf_field
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
		
		$this->name = 'schema_address';
		
		
		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/
		
		$this->label = __('Address', 'schema-premium');
		
		
		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/
		
		$this->category = 'content';
		
		
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
		?>
        
         <?php //echo'<pre>'; var_dump ($field['value']); echo'</pre>'; ?>
         <?php //echo'<pre>'; print_r ($field); echo'</pre>'; ?>
         <?php //echo'<pre>'; print_r ($field['value']); echo'</pre>'; ?>
         
		<table >
      <!--
      <tr>
        <th scope="col">Year</th>
        <th scope="col">Text</th>
      </tr>
      -->
      <tr>
        <td>
        <?php 
			echo '<label for="' . $field['name'] . '[streetAddress]">' . __('Street address', 'schema-premium') . '</label>';
			echo '<input type="text" id="' . $field['id'] . '" class="' . $field['class'] . '" name="' . $field['name'] . '[streetAddress]" value="'.$field['value']['streetAddress'].'" />';
		?>  
        </td>
        <td>
        <?php 
			echo '<label for="' . $field['name'] . '[streetAddress]">' . __('Street address 2', 'schema-premium') . '</label>';
        	echo '<input type="text" id="' . $field['id'] . '" class="' . $field['class'] . '" name="' . $field['name'] . '[streetAddress_2]" value="'.$field['value']['streetAddress_2'].'" />';
		?>
        </td>
        <td>
        <?php 
			echo '<label for="' . $field['name'] . '[streetAddress]">' . __('Street address 3', 'schema-premium') . '</label>';
			echo '<input type="text" id="' . $field['id'] . '" class="' . $field['class'] . '" name="' . $field['name'] . '[streetAddress_3]" value="'.$field['value']['streetAddress_3'].'" />';
		?>
        </td>
      </tr>
      
      <tr>
       
        <td>
        <?php 
			echo '<label for="' . $field['name'] . '[streetAddress]">' . __('Street address', 'schema-premium') . '</label>';
			echo '<input type="text" id="' . $field['id'] . '" class="' . $field['class'] . '" name="' . $field['name'] . '[streetAddress]" value="'.$field['value']['streetAddress'].'" />';
		?>  
        </td>
        <td>
        <?php 
			echo '<label for="' . $field['name'] . '[streetAddress_2]">' . __('Street address 2', 'schema-premium') . '</label>';
        	echo '<input type="text" id="' . $field['id'] . '" class="' . $field['class'] . '" name="' . $field['name'] . '[streetAddress_2]" value="'.$field['value']['streetAddress_2'].'" />';
		?>
        </td>
        <td>
        <?php 
			echo '<label for="' . $field['name'] . '[streetAddress_3]">' . __('Street address 3', 'schema-premium') . '</label>';
			echo '<input type="text" id="' . $field['id'] . '" class="' . $field['class'] . '" name="' . $field['name'] . '[streetAddress_3]" value="'.$field['value']['streetAddress_3'].'" />';
		?>
        </td>
        <td>
        <?php 
			echo '<label for="' . $field['name'] . '[streetAddress_4]">' . __('Street address 4', 'schema-premium') . '</label>';
			echo '<input type="text" id="' . $field['id'] . '" class="' . $field['class'] . '" name="' . $field['name'] . '[streetAddress_4]" value="'.$field['value']['streetAddress_3'].'" />';
		?>
        </td>
      </tr>
      
    </table>
	<?php
	}
}

// create field
new schema_acf_field_address( $this->settings );

// class_exists check
endif;
