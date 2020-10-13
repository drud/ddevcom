<?php
/**
 * ACF Extensions register: Countries Select
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
if( !class_exists('schema_acf_field_countries_select') ) :

class schema_acf_field_countries_select extends acf_field
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
		
		$this->name = 'countries_select';
		
		
		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/
		
		$this->label = __('Countries Select', 'schema-premium');
		
		
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

        $currencies = $this->countries_options();
        
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
    private function countries_options() {
		
		$countries 	= $this->get_countries();
        $countries 	= apply_filters( 'schema_acf_field_countries_select/get_countries', $countries );
		$output		= array();

        foreach ($countries as $country_name => $country_label ) {
            $output[] = array(
                'value' => $country_name,
                'label' => $country_label
            );
        }
        return apply_filters( 'schema_acf_field_countries_select_choices', $output );
    }
	
	 /**
     * Get Countries
     *
     * @return array Array of countries names and labels
     */
    private function get_countries() {
		
		$countries = array
		(
		  "AF" => "Afghanistan",
		  "AL" => "Albania",
		  "DZ" => "Algeria",
		  "AS" => "American Samoa",
		  "AD" => "Andorra",
		  "AO" => "Angola",
		  "AI" => "Anguilla",
		  "AQ" => "Antarctica",
		  "AG" => "Antigua and Barbuda",
		  "AR" => "Argentina",
		  "AM" => "Armenia",
		  "AW" => "Aruba",
		  "AU" => "Australia",
		  "AT" => "Austria",
		  "AZ" => "Azerbaijan",
		  "BS" => "Bahamas",
		  "BH" => "Bahrain",
		  "BD" => "Bangladesh",
		  "BB" => "Barbados",
		  "BY" => "Belarus",
		  "BE" => "Belgium",
		  "BZ" => "Belize",
		  "BJ" => "Benin",
		  "BM" => "Bermuda",
		  "BT" => "Bhutan",
		  "BO" => "Bolivia",
		  "BA" => "Bosnia and Herzegovina",
		  "BW" => "Botswana",
		  "BV" => "Bouvet Island",
		  "BR" => "Brazil",
		  "BQ" => "British Antarctic Territory",
		  "IO" => "British Indian Ocean Territory",
		  "VG" => "British Virgin Islands",
		  "BN" => "Brunei",
		  "BG" => "Bulgaria",
		  "BF" => "Burkina Faso",
		  "BI" => "Burundi",
		  "KH" => "Cambodia",
		  "CM" => "Cameroon",
		  "CA" => "Canada",
		  "CT" => "Canton and Enderbury Islands",
		  "CV" => "Cape Verde",
		  "KY" => "Cayman Islands",
		  "CF" => "Central African Republic",
		  "TD" => "Chad",
		  "CL" => "Chile",
		  "CN" => "China",
		  "CX" => "Christmas Island",
		  "CC" => "Cocos [Keeling] Islands",
		  "CO" => "Colombia",
		  "KM" => "Comoros",
		  "CG" => "Congo - Brazzaville",
		  "CD" => "Congo - Kinshasa",
		  "CK" => "Cook Islands",
		  "CR" => "Costa Rica",
		  "HR" => "Croatia",
		  "CU" => "Cuba",
		  "CY" => "Cyprus",
		  "CZ" => "Czech Republic",
		  "CI" => "Côte d’Ivoire",
		  "DK" => "Denmark",
		  "DJ" => "Djibouti",
		  "DM" => "Dominica",
		  "DO" => "Dominican Republic",
		  "NQ" => "Dronning Maud Land",
		  "DD" => "East Germany",
		  "EC" => "Ecuador",
		  "EG" => "Egypt",
		  "SV" => "El Salvador",
		  "GQ" => "Equatorial Guinea",
		  "ER" => "Eritrea",
		  "EE" => "Estonia",
		  "ET" => "Ethiopia",
		  "FK" => "Falkland Islands",
		  "FO" => "Faroe Islands",
		  "FJ" => "Fiji",
		  "FI" => "Finland",
		  "FR" => "France",
		  "GF" => "French Guiana",
		  "PF" => "French Polynesia",
		  "TF" => "French Southern Territories",
		  "FQ" => "French Southern and Antarctic Territories",
		  "GA" => "Gabon",
		  "GM" => "Gambia",
		  "GE" => "Georgia",
		  "DE" => "Germany",
		  "GH" => "Ghana",
		  "GI" => "Gibraltar",
		  "GR" => "Greece",
		  "GL" => "Greenland",
		  "GD" => "Grenada",
		  "GP" => "Guadeloupe",
		  "GU" => "Guam",
		  "GT" => "Guatemala",
		  "GG" => "Guernsey",
		  "GN" => "Guinea",
		  "GW" => "Guinea-Bissau",
		  "GY" => "Guyana",
		  "HT" => "Haiti",
		  "HM" => "Heard Island and McDonald Islands",
		  "HN" => "Honduras",
		  "HK" => "Hong Kong SAR China",
		  "HU" => "Hungary",
		  "IS" => "Iceland",
		  "IN" => "India",
		  "ID" => "Indonesia",
		  "IR" => "Iran",
		  "IQ" => "Iraq",
		  "IE" => "Ireland",
		  "IM" => "Isle of Man",
		  "IL" => "Israel",
		  "IT" => "Italy",
		  "JM" => "Jamaica",
		  "JP" => "Japan",
		  "JE" => "Jersey",
		  "JT" => "Johnston Island",
		  "JO" => "Jordan",
		  "KZ" => "Kazakhstan",
		  "KE" => "Kenya",
		  "KI" => "Kiribati",
		  "KW" => "Kuwait",
		  "KG" => "Kyrgyzstan",
		  "LA" => "Laos",
		  "LV" => "Latvia",
		  "LB" => "Lebanon",
		  "LS" => "Lesotho",
		  "LR" => "Liberia",
		  "LY" => "Libya",
		  "LI" => "Liechtenstein",
		  "LT" => "Lithuania",
		  "LU" => "Luxembourg",
		  "MO" => "Macau SAR China",
		  "MK" => "Macedonia",
		  "MG" => "Madagascar",
		  "MW" => "Malawi",
		  "MY" => "Malaysia",
		  "MV" => "Maldives",
		  "ML" => "Mali",
		  "MT" => "Malta",
		  "MH" => "Marshall Islands",
		  "MQ" => "Martinique",
		  "MR" => "Mauritania",
		  "MU" => "Mauritius",
		  "YT" => "Mayotte",
		  "FX" => "Metropolitan France",
		  "MX" => "Mexico",
		  "FM" => "Micronesia",
		  "MI" => "Midway Islands",
		  "MD" => "Moldova",
		  "MC" => "Monaco",
		  "MN" => "Mongolia",
		  "ME" => "Montenegro",
		  "MS" => "Montserrat",
		  "MA" => "Morocco",
		  "MZ" => "Mozambique",
		  "MM" => "Myanmar [Burma]",
		  "NA" => "Namibia",
		  "NR" => "Nauru",
		  "NP" => "Nepal",
		  "NL" => "Netherlands",
		  "AN" => "Netherlands Antilles",
		  "NT" => "Neutral Zone",
		  "NC" => "New Caledonia",
		  "NZ" => "New Zealand",
		  "NI" => "Nicaragua",
		  "NE" => "Niger",
		  "NG" => "Nigeria",
		  "NU" => "Niue",
		  "NF" => "Norfolk Island",
		  "KP" => "North Korea",
		  "VD" => "North Vietnam",
		  "MP" => "Northern Mariana Islands",
		  "NO" => "Norway",
		  "OM" => "Oman",
		  "PC" => "Pacific Islands Trust Territory",
		  "PK" => "Pakistan",
		  "PW" => "Palau",
		  "PS" => "Palestinian Territories",
		  "PA" => "Panama",
		  "PZ" => "Panama Canal Zone",
		  "PG" => "Papua New Guinea",
		  "PY" => "Paraguay",
		  "YD" => "People's Democratic Republic of Yemen",
		  "PE" => "Peru",
		  "PH" => "Philippines",
		  "PN" => "Pitcairn Islands",
		  "PL" => "Poland",
		  "PT" => "Portugal",
		  "PR" => "Puerto Rico",
		  "QA" => "Qatar",
		  "RO" => "Romania",
		  "RU" => "Russia",
		  "RW" => "Rwanda",
		  "RE" => "Réunion",
		  "BL" => "Saint Barthélemy",
		  "SH" => "Saint Helena",
		  "KN" => "Saint Kitts and Nevis",
		  "LC" => "Saint Lucia",
		  "MF" => "Saint Martin",
		  "PM" => "Saint Pierre and Miquelon",
		  "VC" => "Saint Vincent and the Grenadines",
		  "WS" => "Samoa",
		  "SM" => "San Marino",
		  "SA" => "Saudi Arabia",
		  "SN" => "Senegal",
		  "RS" => "Serbia",
		  "CS" => "Serbia and Montenegro",
		  "SC" => "Seychelles",
		  "SL" => "Sierra Leone",
		  "SG" => "Singapore",
		  "SK" => "Slovakia",
		  "SI" => "Slovenia",
		  "SB" => "Solomon Islands",
		  "SO" => "Somalia",
		  "ZA" => "South Africa",
		  "GS" => "South Georgia and the South Sandwich Islands",
		  "KR" => "South Korea",
		  "ES" => "Spain",
		  "LK" => "Sri Lanka",
		  "SD" => "Sudan",
		  "SR" => "Suriname",
		  "SJ" => "Svalbard and Jan Mayen",
		  "SZ" => "Swaziland",
		  "SE" => "Sweden",
		  "CH" => "Switzerland",
		  "SY" => "Syria",
		  "ST" => "São Tomé and Príncipe",
		  "TW" => "Taiwan",
		  "TJ" => "Tajikistan",
		  "TZ" => "Tanzania",
		  "TH" => "Thailand",
		  "TL" => "Timor-Leste",
		  "TG" => "Togo",
		  "TK" => "Tokelau",
		  "TO" => "Tonga",
		  "TT" => "Trinidad and Tobago",
		  "TN" => "Tunisia",
		  "TR" => "Turkey",
		  "TM" => "Turkmenistan",
		  "TC" => "Turks and Caicos Islands",
		  "TV" => "Tuvalu",
		  "UM" => "U.S. Minor Outlying Islands",
		  "PU" => "U.S. Miscellaneous Pacific Islands",
		  "VI" => "U.S. Virgin Islands",
		  "UG" => "Uganda",
		  "UA" => "Ukraine",
		  "SU" => "Union of Soviet Socialist Republics",
		  "AE" => "United Arab Emirates",
		  "GB" => "United Kingdom",
		  "US" => "United States",
		  "ZZ" => "Unknown or Invalid Region",
		  "UY" => "Uruguay",
		  "UZ" => "Uzbekistan",
		  "VU" => "Vanuatu",
		  "VA" => "Vatican City",
		  "VE" => "Venezuela",
		  "VN" => "Vietnam",
		  "WK" => "Wake Island",
		  "WF" => "Wallis and Futuna",
		  "EH" => "Western Sahara",
		  "YE" => "Yemen",
		  "ZM" => "Zambia",
		  "ZW" => "Zimbabwe",
		  "AX" => "Åland Islands"
		);
						
					
		return $countries;
    }
}

// create field
new schema_acf_field_countries_select( $this->settings );

// class_exists check
endif;
