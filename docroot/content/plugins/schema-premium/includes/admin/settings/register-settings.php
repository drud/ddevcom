<?php
/**
 * Register Settings
 *
 * @package     Schema
 * @subpackage  Admin/Settings
 * @copyright   Copyright (c) 2018, Hesham Zebida
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Get an option
 *
 * Looks to see if the specified setting exists, returns default if not
 *
 * @since 1.0
 * @global $schema_wp_options Array of all the Schema Options
 * @return mixed
 */
function schema_wp_get_option( $key = '', $default = false ) {
	global $schema_wp_options;
	$value = ! empty( $schema_wp_options[ $key ] ) ? $schema_wp_options[ $key ] : $default;
	$value = apply_filters( 'schema_wp_get_option', $value, $key, $default );
	return apply_filters( 'schema_wp_get_option_' . $key, $value, $key, $default );
}

/**
 * Update an option
 *
 * Updates an edd setting value in both the db and the global variable.
 * Warning: Passing in an empty, false or null string value will remove
 *          the key from the schema_wp_options array.
 *
 * @since 1.0
 * @param string $key The Key to update
 * @param string|bool|int $value The value to set the key to
 * @global $schema_wp_options Array of all the Schema Options
 * @return boolean True if updated, false if not.
 */
function schema_wp_update_option( $key = '', $value = false ) {

	// If no key, exit
	if ( empty( $key ) ){
		return false;
	}

	if ( empty( $value ) ) {
		$remove_option = schema_wp_delete_option( $key );
		return $remove_option;
	}

	// First let's grab the current settings
	$options = get_option( 'schema_wp_settings' );

	// Let's let devs alter that value coming in
	$value = apply_filters( 'schema_wp_update_option', $value, $key );

	// Next let's try to update the value
	$options[ $key ] = $value;
	$did_update = update_option( 'schema_wp_settings', $options );

	// If it updated, let's update the global variable
	if ( $did_update ){
		global $schema_wp_options;
		$schema_wp_options[ $key ] = $value;
	}

	return $did_update;
}

/**
 * Remove an option
 *
 * Removes an edd setting value in both the db and the global variable.
 *
 * @since 1.0
 * @param string $key The Key to delete
 * @global $schema_wp_options Array of all the Schema Options
 * @return boolean True if removed, false if not.
 */
function schema_wp_delete_option( $key = '' ) {

	// If no key, exit
	if ( empty( $key ) ){
		return false;
	}

	// First let's grab the current settings
	$options = get_option( 'schema_wp_settings' );

	// Next let's try to update the value
	if( isset( $options[ $key ] ) ) {

		unset( $options[ $key ] );

	}

	$did_update = update_option( 'schema_wp_settings', $options );

	// If it updated, let's update the global variable
	if ( $did_update ){
		global $schema_wp_options;
		$schema_wp_options = $options;
	}

	return $did_update;
}

/**
 * Get Settings
 *
 * Retrieves all plugin settings
 *
 * @since 1.0
 * @return array Schema settings
 */
function schema_wp_get_settings() {

	$settings = get_option( 'schema_wp_settings' );
	
	// debug
	//echo'<pre>';print_r($settings);echo'</pre>';exit;
	
	if( empty( $settings ) ) {

		// Update old settings with new single option

		$general_settings = is_array( get_option( 'schema_wp_settings_general' ) )    ? get_option( 'schema_wp_settings_general' )    : array();
		$knowledge_graph_settings = is_array( get_option( 'schema_wp_settings_knowledge_graph' ) )    ? get_option( 'schema_wp_settings_knowledge_graph' )    : array();
		$search_results_settings = is_array( get_option( 'schema_wp_settings_search_results' ) )    ? get_option( 'schema_wp_settings_search_results' )    : array();
		$ext_settings     = is_array( get_option( 'schema_wp_settings_extensions' ) ) ? get_option( 'schema_wp_settings_extensions' ) : array();
		$license_settings = is_array( get_option( 'schema_wp_settings_licenses' ) )   ? get_option( 'schema_wp_settings_licenses' )   : array();
		$advanced_settings    = is_array( get_option( 'schema_wp_settings_advanced' ) )       ? get_option( 'schema_wp_settings_advanced' )	: array();

		$settings = array_merge( $general_settings, $knowledge_graph_settings, $search_results_settings, $ext_settings, $license_settings, $advanced_settings );

		update_option( 'schema_wp_settings', $settings );

	}
	return apply_filters( 'schema_wp_get_settings', $settings );
}

add_action( 'admin_init', 'schema_wp_register_settings' );
/**
 * Add all settings sections and fields
 *
 * @since 1.0
 * @return void
*/
function schema_wp_register_settings() {

	if ( false == get_option( 'schema_wp_settings' ) ) {
		add_option( 'schema_wp_settings' );
	}

	foreach ( schema_wp_get_registered_settings() as $tab => $sections ) {
		foreach ( $sections as $section => $settings) {

			// Check for backwards compatibility
			$section_tabs = schema_wp_get_settings_tab_sections( $tab );
			if ( ! is_array( $section_tabs ) || ! array_key_exists( $section, $section_tabs ) ) {
				$section = 'main';
				$settings = $sections;
			}

			add_settings_section(
				'schema_wp_settings_' . $tab . '_' . $section,
				__return_null(),
				'__return_false',
				'schema_wp_settings_' . $tab . '_' . $section
			);

			foreach ( $settings as $option ) {
				// For backwards compatibility
				if ( empty( $option['id'] ) ) {
					continue;
				}

				$name = isset( $option['name'] ) ? $option['name'] : '';

				add_settings_field(
					'schema_wp_settings[' . $option['id'] . ']',
					$name . apply_filters( 'schema_wp_after_setting_name', '', $option ),
					function_exists( 'schema_wp_' . $option['type'] . '_callback' ) ? 'schema_wp_' . $option['type'] . '_callback' : 'schema_wp_missing_callback',
					'schema_wp_settings_' . $tab . '_' . $section,
					'schema_wp_settings_' . $tab . '_' . $section,
					array(
						'section'       => $section,
						'id'            => isset( $option['id'] )            ? $option['id']            : null,
						'class'         => isset( $option['class'] )         ? $option['class']         : null,
						'class_field'   => isset( $option['class_field'] )   ? $option['class_field']   : null,
						'desc'          => ! empty( $option['desc'] )        ? $option['desc']          : '',
						'name'          => isset( $option['name'] )          ? $option['name']          : null,
						'size'          => isset( $option['size'] )          ? $option['size']          : null,
						'options'       => isset( $option['options'] )       ? $option['options']       : '',
						'std'           => isset( $option['std'] )           ? $option['std']           : '',
						'min'           => isset( $option['min'] )           ? $option['min']           : null,
						'max'           => isset( $option['max'] )           ? $option['max']           : null,
						'step'          => isset( $option['step'] )          ? $option['step']          : null,
						'chosen'        => isset( $option['chosen'] )        ? $option['chosen']        : null,
						'placeholder'   => isset( $option['placeholder'] )   ? $option['placeholder']   : null,
						'allow_blank'   => isset( $option['allow_blank'] )   ? $option['allow_blank']   : true,
						'readonly'      => isset( $option['readonly'] )      ? $option['readonly']      : false,
						'faux'          => isset( $option['faux'] )          ? $option['faux']          : false,
						'tooltip_title' => isset( $option['tooltip_title'] ) ? $option['tooltip_title'] : false,
						'tooltip_desc'  => isset( $option['tooltip_desc'] )  ? $option['tooltip_desc']  : false,
						'post_type'		=> isset( $option['post_type'] )  	 ? $option['post_type']  	: false,
					)
				);
			}
		}

	}

	// Creates our settings in the options table
	register_setting( 'schema_wp_settings', 'schema_wp_settings', 'schema_wp_settings_sanitize' );

}

/**
 * Retrieve the array of plugin settings
 *
 * @since 1.0
 * @return array
*/
function schema_wp_get_registered_settings() {

	/**
	 * 'Whitelisted' Schema settings, filters are provided for each settings
	 * section to allow extensions and other plugins to add their own settings
	 */
	$schema_wp_settings = array(
		/** General Settings */
		'general' => apply_filters( 'schema_wp_settings_general',
			array(
				'main' => array(
					'site_type' => array(
						'id' => 'site_type',
						'name' => __( 'Site Type', 'schema-premium' ),
						'desc' => '',
						'type' => 'select',
						'options' => array(
							'' 						=> __('Select Site Type', 'schema-premium'),
							'blog'					=> __('Blog or Personal', 'schema-premium'),
							'online_shop' 			=> __('Online Shop', 'schema-premium'),
							'news_chanel' 			=> __('News and Magazine', 'schema-premium'),
							'offline_business' 		=> __('Small Offline Business', 'schema-premium'),
							'corporation' 			=> __('Corporation', 'schema-premium'),
							'portfolio' 			=> __('Portfolio', 'schema-premium'),
							'photography'			=> __('Photography', 'schema-premium'),
							'music'					=> __('Music', 'schema-premium'),
							'niche_affiliate'		=> __('Niche Affiliate / Reviews', 'schema-premium'),
							'business_directory' 	=> __('Online Business Directory', 'schema-premium'),
							'job_board'				=> __('Online Job Board', 'schema-premium'),
							'knowledgebase'			=> __('Knowledgebase / Wiki', 'schema-premium'),
							'question_answer'		=> __('Question & Answer', 'schema-premium'),
							'school'				=> __('School or College', 'schema-premium'),
							'else' 					=> __('Something else', 'schema-premium')
						),
						'std' => ''
					),
					'publisher_logo' => array(
						'id' => 'publisher_logo',
						'name' => __( 'Publisher Logo', 'schema-premium' ),
						'desc' => __( 'Publisher Logo should have a wide aspect ratio, not a square icon, it should be no wider than 600px, and no taller than 60px.', 'schema-premium' ) . ' <a href="https://developers.google.com/search/docs/data-types/articles#logo-guidelines" target="_blank">'.__('Logo guidelines', 'schema-premium').'</a>',
						'type' => 'image_upload',
						'std' => ''
					)
				)
			)
		),

		/** Knowledge Graph Settings */
		'knowledge_graph' => apply_filters('schema_wp_settings_knowledge_graph',
			array(
				'organization' => array( // section
					// Social Profiles
					'person_or_organization_settings' => array(
						'id' => 'social_profiles_settings',
						'name' => '<strong>' . __( 'Person or Organization', 'schema-premium' ) . '</strong>',
						'desc' => __( 'This information will be used in Google\'s Knowledge Graph Card, the big block of information you see on the right side of the search results.', 'schema-premium' ),
						'type' => 'header'
					),
					'organization_or_person' => array(
						'id' => 'organization_or_person',
						'class_field' => 'organization_or_person_radio',
						'name' => __( 'This Website Represent', 'schema-premium' ),
						'desc' => '',
						'type' => 'radio',
						'options' => array(
							//'' 				=> __('Select Type', 'schema-premium'),
							'organization'	=> 'Organization',
							'person' 		=> 'Person'
						),
						'std' => ''
					),
					'name' => array(
						'id' => 'name',
						'class_field' => 'input_name',
						'class' => 'tr_field_name',
						'name' => __( 'Name', 'schema-premium' ),
						'desc' => __( '', 'schema-premium' ),
						'type' => 'text',
						'placeholder' => get_bloginfo( 'name' ),
						'std' => ''
					),
					'url' => array(
						'id' => 'url',
						'class' => 'tr_field_url',
						'name' => __( 'Website URL', 'schema-premium' ),
						'desc' => __( '', 'schema-premium' ),
						'type' => 'text',
						'placeholder' => 'https://',
						'std' => ''
					),
					'logo' => array(
						'id' => 'logo',
						'class' => 'tr_field_logo',
						'name' => __( 'Logo', 'schema-premium' ),
						'desc' => __('Specify the image of your organization\'s logo to be used in Google Search results and in the Knowledge Graph.<br />Learn more about', 'schema-premium') . ' <a href="https://developers.google.com/search/docs/data-types/logo" target="_blank">'.__('Logo guidelines', 'schema-premium').'</a>',
						'type' => 'image_upload',
						'std' => ''
					)
				),
				
				/** Social Profiles Settings */
				'social_profiles' => array( // section
				
					// Social Profiles
					'social_profiles_settings' => array(
						'id' => 'social_profiles_settings',
						'name' => '<strong>' . __( 'Social Profiles', 'schema-premium' ) . '</strong>',
						'desc' => __( 'Provide your social profile information to a Google Knowledge panel.', 'schema-premium' ),
						'type' => 'header'
					),
					'facebook' => array(
						'id' => 'facebook',
						'name' => __( 'Facebook', 'schema-premium' ),
						'desc' => '',
						'type' => 'text',
						'placeholder' => 'https://',
						'std' => ''
					),
					'twitter' => array(
						'id' => 'twitter',
						'name' => __( 'Twitter', 'schema-premium' ),
						'desc' => '',
						'type' => 'text',
						'placeholder' => 'https://',
						'std' => ''
					),
					'instagram' => array(
						'id' => 'instagram',
						'name' => __( 'Instagram', 'schema-premium' ),
						'desc' => '',
						'type' => 'text',
						'placeholder' => 'https://',
						'std' => ''
					),
					'youtube' => array(
						'id' => 'youtube',
						'name' => __( 'YouTube', 'schema-premium' ),
						'desc' => '',
						'type' => 'text',
						'placeholder' => 'https://',
						'std' => ''
					),
					'linkedin' => array(
						'id' => 'linkedin',
						'name' => __( 'LinkedIn', 'schema-premium' ),
						'desc' => '',
						'type' => 'text',
						'placeholder' => 'https://',
						'std' => ''
					),
					'myspace' => array(
						'name' => __( 'Myspace', 'schema-premium' ),
						'desc' => '',
						'type' => 'text',
						'placeholder' => 'https://',
						'std' => ''
					),
					'pinterest' => array(
						'id' => 'pinterest',
						'name' => __( 'Pinterest', 'schema-premium' ),
						'desc' => '',
						'type' => 'text',
						'placeholder' => 'https://',
						'std' => ''
					),
					'soundcloud' => array(
						'id' => 'soundcloud',
						'name' => __( 'SoundCloud', 'schema-premium' ),
						'desc' => '',
						'type' => 'text',
						'placeholder' => 'https://',
						'std' => ''
					),
					'tumblr' => array(
						'id' => 'tumblr',
						'name' => __( 'Tumblr', 'schema-premium' ),
						'desc' => '',
						'type' => 'text',
						'placeholder' => 'https://',
						'std' => ''
					)
				),
				/** Corporate Contacts Settings */
				'corporate_contacts' => array( // section
				
					'corporate_contacts_contact_type' => array(
						'id' => 'corporate_contacts_contact_type',
						'name' => __( 'Contact Type', 'schema-premium' ),
						'desc' => '',
						'type' => 'select',
						'options' => schema_wp_get_corporate_contacts_types()
					),
					
					'corporate_contacts_telephone' => array(
						'id' => 'corporate_contacts_telephone',
						'name' => __( 'Telephone', 'schema-premium' ),
						'desc' => '<br>' . __('Recommended. An internationalized version of the phone number, starting with the "+" symbol and country code (+1 in the US and Canada).', 'schema-premium'),
						'type' => 'text',
						'std' => ''
					),
					
					'corporate_contacts_url' => array(
						'id' => 'corporate_contacts_url',
						'name' => __( 'URL', 'schema-premium' ),
						'desc' => '<br>' . __('Recommended. The URL of contact page.', 'schema-premium'),
						'type' => 'text',
						'placeholder' => 'https://',
						'std' => ''
					)
				), 
				
				/** Search Results Settings */
				'search_results' => array( // section
					
					// Sitelinks
					'sitelinks_search_box' => array(
						'id' => 'sitelinks_search_box',
						'name' => __( 'Enable Sitelinks Search Box?', 'schema-premium' ),
						'desc' => __( 'Tell Google to show a Sitelinks search box.', 'schema-premium' ),
						'type' => 'checkbox'
					),
					
					// Site name
					'site_name_enable' => array(
						'id' => 'site_name_enable',
						'class_field' => 'site_name_enable_checkbox',
						'name' => __( 'Enable Site Name?', 'schema-premium' ),
						'desc' => __( 'Tell Google to show your site name in search results.', 'schema-premium' ),
						'type' => 'checkbox'
					),
					'site_name' => array(
						'id' => 'site_name',
						'class' => 'tr_field_site_name',
						'name' => __( 'Site Name', 'schema-premium' ),
						'desc' => '',
						'type' => 'text',
						'std' => get_bloginfo ('name'),
					),
					'site_alternate_name' => array(
						'id' => 'site_alternate_name',
						'class' => 'tr_field_site_alternate_name',
						'name' => __( 'Site Alternate Name', 'schema-premium' ),
						'desc' => '',
						'type' => 'text',
						'std' => ''
					)
				), 
			)
		),
		
		/** Schemas Settings */
		'schemas' => apply_filters( 'schema_wp_settings_schemas',
			array(
				'general' => array(
					'wpheader' => array(
						'id' => 'wpheader_enable',
						'name' => __( 'WPHeader', 'schema-premium' ),
						'desc' => __( 'enable?', 'schema-premium' ),
						'type' => 'checkbox'
					),
					'wpfooter' => array(
						'id' => 'wpfooter_enable',
						'name' => __( 'WPFooter', 'schema-premium' ),
						'desc' => __( 'enable?', 'schema-premium' ),
						'type' => 'checkbox'
					),
					'comments' => array(
						'id' => 'comments_enable',
						'name' => __( 'Comments', 'schema-premium' ),
						'desc' => __( 'enable?', 'schema-premium' ),
						'type' => 'checkbox'
					),
					'default_image' => array(
						'id' => 'default_image',
						'class' => 'tr_field_logo',
						'name' => __( 'Default image', 'schema-premium' ),
						'desc' => __('Specify a default image to be a fallback for missing Featured Images. (should be at least 1200 pixels wide)', 'schema-premium'),
						'type' => 'image_upload',
						'std' => ''
					)
				),
				'author' => array(
					'author_archive' => array(
						'id' => 'author_archive_enable',
						'name' => __( 'Author Archives', 'schema-premium' ),
						'desc' => __( 'enable?', 'schema-premium' ),
						'type' => 'checkbox'
					),
					'author_url' => array(
						'id' => 'author_url_enable',
						'name' => __( 'Author URL', 'schema-premium' ),
						'desc' => __( 'enable?', 'schema-premium' ),
						'type' => 'checkbox',
						'tooltip_title' => __('Keep disabled', 'schema-premium'),
						'tooltip_desc' => __('if you don\'t want to expose author profile url.', 'schema-premium' )
					),
					'gravatar_image' => array(
						'id' => 'gravatar_image_enable',
						'name' => __( 'Gravatar ImageObject', 'schema-premium' ),
						'desc' => __( 'enable?', 'schema-premium' ),
						'type' => 'checkbox',
						'tooltip_title' => __('When enabled', 'schema-premium' ),
						'tooltip_desc' => __('User gravatar.com image will be used in author markup.', 'schema-premium' ),
					)
				),
				'breadcrumbs' => array(
					'breadcrumbs' => array(
						'id' => 'breadcrumbs_enable',
						'name' => __( 'Breadcrumbs', 'schema-premium' ),
						'desc' => __( 'enable?', 'schema-premium' ),
						'type' => 'checkbox'
					),
					'breadcrumbs_home_enable' => array(
						'id' => 'breadcrumbs_home_enable',
						'name' => __( 'Show Homepage', 'schema-premium' ),
						'desc' => __( 'enable?', 'schema-premium' ),
						'type' => 'checkbox'
					),
					'breadcrumbs_home_text' => array(
						'id' => 'breadcrumbs_home_text',
						'name' => __( 'Homepage Text', 'schema-premium' ),
						'desc' => '',
						'type' => 'text',
						'std' => __( 'Home', 'schema-premium' ),
						'tooltip_title' => __('Change', 'schema-premium'),
						'tooltip_desc' => __('Text for the Homepage. Default is Home', 'schema-premium' )
					),
					/*
					'breadcrumbs_taxonomy' => array(
						'id' => 'breadcrumbs_taxonomy',
						'name' => __( 'Taxonomy', 'schema-premium' ),
						'desc' => '',
						'type' => 'taxonomy_select',
						'tooltip_title' => __('Taxonomy', 'schema-premium'),
						'tooltip_desc' => __('to show in breadcrumbs for content types.', 'schema-premium' )
					),
					'breadcrumbs_content_type_archive' => array(
						'id' => 'breadcrumbs_content_type_archive',
						'name' => __( 'Content Type Archive', 'schema-premium' ),
						'desc' => '',
						'type' => 'content_type_archive_select',
						'tooltip_title' => __('Content Type Archive', 'schema-premium'),
						'tooltip_desc' => __('to show in breadcrumbs for taxonomies.', 'schema-premium' )
					),
					*/
				),
				'blog' => array(
					'blog_markup' => array(
						'id' => 'blog_markup',
						'name' => __( 'Blog Markup', 'schema-premium' ),
						'desc' => __( '', 'schema-premium' ),
						'type' => 'select',
						'options' => array(
							''			=> __('Select Markup Type', 'schema-premium'),
							'Blog'		=> __( 'Blog', 'schema-premium'),
							'ItemList'	=> __( 'ItemList', 'schema-premium')
						),
						'std' => 'Blog',
					),
					'category' => array(
						'id' => 'category_enable',
						'name' => __( 'Categories', 'schema-premium' ),
						'desc' => __( 'enable?', 'schema-premium' ),
						'type' => 'checkbox'
					),
					'tag' => array(
						'id' => 'tag_enable',
						'name' => __( 'Tags', 'schema-premium' ),
						'desc' => __( 'enable?', 'schema-premium' ),
						'type' => 'checkbox'
					),
				),
				'post_types' => array(
					'post_type_archive' => array(
						'id' => 'post_type_archive_enable',
						'name' => __( 'Post Type Archives', 'schema-premium' ),
						'desc' => __( 'enable?', 'schema-premium' ),
						'type' => 'checkbox'
					),
					'taxonomy' => array(
						'id' => 'taxonomy_enable',
						'name' => __( 'Taxonomies', 'schema-premium' ),
						'desc' => __( 'enable?', 'schema-premium' ),
						'type' => 'checkbox'
					),
				),
				'special_pages' => array(
					'about_page' => array(
						'id' => 'about_page',
						'name' => __( 'About Page', 'schema-premium' ),
						'desc' => __( '', 'schema-premium' ),
						'type' => 'post_select',
						'post_type' => 'page',
						'tooltip_title' => __('Select About Page', 'schema-premium'),
						'tooltip_desc' => __('Add schema.org markup for AboutPage automatically on the selected page.', 'schema-premium')
					),
					'contact_page' => array(
						'id' => 'contact_page',
						'name' => __( 'Contact Page', 'schema-premium' ),
						'desc' => __( '', 'schema-premium' ),
						'type' => 'post_select',
						'post_type' => 'page',
						'tooltip_title' => __('Select Contact Page', 'schema-premium'),
						'tooltip_desc' => __('Add schema.org markup for ContactPaage automatically on the selected page.', 'schema-premium')
					),
					'checkout_page' => array(
						'id' => 'checkout_page',
						'name' => __( 'Checkout Page', 'schema-premium' ),
						'desc' => __( '', 'schema-premium' ),
						'type' => 'post_select',
						'post_type' => 'page',
						'tooltip_title' => __('Select Checkout Page', 'schema-premium'),
						'tooltip_desc' => __('Add schema.org markup for CheckoutPage automatically on the selected page.', 'schema-premium')
					)
				),
				'embeds' => array(
					'video' => array(
						'id' => 'video_object_enable',
						'name' => __( 'VideoObject', 'schema-premium' ),
						'desc' => __( 'enable?', 'schema-premium' ),
						'type' => 'checkbox',
						'tooltip_title' => __('When enabled', 'schema-premium'),
						'tooltip_desc' => __('Schema plugin will fetch video data automatically from embedded video. (configure it under Schema > Types)', 'schema-premium'),
					),
					'video_meta' => array(
						'id' => 'video_object_meta_enable',
						'name' => __( 'VideoObject meta', 'schema-premium' ),
						'desc' => __( 'enable?', 'schema-premium' ),
						'type' => 'checkbox',
						'tooltip_title' => __('When enabled', 'schema-premium'),
						'tooltip_desc' => __('Schema plugin will show new post meta feilds to allow you insert video details in page editor.', 'schema-premium'),
					),
					'audio' => array(
						'id' => 'audio_object_enable',
						'name' => __( 'AudioObject', 'schema-premium' ),
						'desc' => __( 'enable?', 'schema-premium' ),
						'type' => 'checkbox',
						'tooltip_title' => __('When enabled', 'schema-premium'),
						'tooltip_desc' => __('Schema plugin will fetch audio data automatically from embedded audio. (configure it under Schema > Types)', 'schema-premium'),
					),
					'youtube_api_key' => array(
						'id' => 'youtube_api_key',
						'name' => __( 'YouTube API Key', 'schema-premium' ),
						'desc' => '<br><br>' . __('Obtain a YouTube API Key from your  <a href="https://console.developers.google.com/project" target="_blank"> Google Developer console</a>.', 'schema-premium'),
						'type' => 'text',
						'std' => '',
						'tooltip_title' => __('When used', 'schema-premium'),
						'tooltip_desc' => __('Schema plugin will use YoouTube API to fetch video data automatically.', 'schema-premium'),
					)
				)
			)
		),
		
		/** Integrations Settings */
		'integrations' => apply_filters('schema_wp_settings_integrations',
			array()
		),
		/** Extension Settings */
		'extensions' => apply_filters('schema_wp_settings_extensions',
			array()
		),
		/** Licenses Settings */
		'licenses' => apply_filters('schema_wp_settings_licenses',
			array()
		),
		/** Advanced Settings */
		'advanced' => apply_filters('schema_wp_settings_advanced',
			array(
				'main' => array(
					'uninstall_on_delete' => array(
						'id'   => 'uninstall_on_delete',
						'name' => __( 'Delete Data on Uninstall?', 'schema-premium' ),
						'desc' => __( 'Check this box if you would like Schema to completely remove all of its data when uninstalling via Plugins > Delete.', 'schema-premium' ),
						'type' => 'checkbox'
					),
					'schema_output_location' => array(
						'id' => 'schema_output_location',
						'name' => __( 'Schema Markup Output', 'schema-premium' ),
						'desc' => '',
						'type' => 'select',
						'options' => array(
							'head'		=> __( 'Head', 'schema-premium'),
							'footer'	=> __( 'Footer', 'schema-premium')
						),
						'std' => 'head',
						'tooltip_title' => __('Schema markup script output', 'schema-premium'),
						'tooltip_desc' => __('Choose where to output the schema.org json-ld markup.', 'schema-premium'),
					),
					'json_ld_output_format' => array(
						'id' => 'json_ld_output_format',
						'name' => __( 'JSON-LD Output Format', 'schema-premium' ),
						'desc' => '',
						'type' => 'select',
						'options' => array(
							'minified'		=> __( 'Minified', 'schema-premium'),
							'pretty_print'	=> __( 'Pretty Print', 'schema-premium')
						),
						'std' => 'minified',
						'tooltip_title' => __('Schema markup script output', 'schema-premium'),
						'tooltip_desc' => __('Choose the output format of the schema.org json-ld markup.', 'schema-premium'),
					),
					'schema_test_link' => array(
						'id' => 'schema_test_link',
						'name' => __( 'Enable Test Schema Link in Admin Top Toolbar?', 'schema-premium' ),
						'desc' => '',
						'type' => 'select',
						'options' => array(
							'yes'	=> __( 'Yes', 'schema-premium'),
							'no'	=> __( 'No', 'schema-premium')
						),
						'std' => 'yes',
						'tooltip_title' => __('When enabled', 'schema-premium'),
						'tooltip_desc' => __('Schema plugin will show a Test link in admin toolbar. Clicking on that link will take you directly to Google Rich Snippets Testing Tool.', 'schema-premium'),
					),
					'properties_tabs' => array(
						'id' => 'properties_tabs_enable',
						'name' => __( 'Enable Properties Tabs?', 'schema-premium' ),
						'desc' => '',
						'type' => 'select',
						 'options' => array(
							'yes'	=> __( 'Yes', 'schema-premium'),
							'no'	=> __( 'No', 'schema-premium')
						),
						'std' => 'yes',
						'tooltip_title' => __('When enabled', 'schema-premium'),
						'tooltip_desc' => __('Properties will show under tabs.', 'schema-premium'),
					),
					'properties_instructions' => array(
						'id' => 'properties_instructions_enable',
						'name' => __( 'Enable Properties Instructions?', 'schema-premium' ),
						'desc' => '',
						'type' => 'select',
						 'options' => array(
							'yes'	=> __( 'Yes', 'schema-premium'),
							'no'	=> __( 'No', 'schema-premium')
						),
						'std' => 'yes',
						'tooltip_title' => __('When enabled', 'schema-premium'),
						'tooltip_desc' => __('Instructions will show under each property post meta field.', 'schema-premium'),
					)
				)
			)
		)
	);
		
	return apply_filters( 'schema_wp_registered_settings', $schema_wp_settings );
}

/**
 * Settings Sanitization
 *
 * Adds a settings error (for the updated message)
 * At some point this will validate input
 *
 * @since 1.0.0
 *
 * @param array $input The value inputted in the field
 * @global $schema_wp_options Array of all the Schema Options
 *
 * @return string $input Sanitizied value
 */
function schema_wp_settings_sanitize( $input = array() ) {
	global $schema_wp_options;

	$doing_section = false;
	if ( ! empty( $_POST['_wp_http_referer'] ) ) {
		$doing_section = true;
	}

	$setting_types = schema_wp_get_registered_settings_types();
	$input         = $input ? $input : array();

	if ( $doing_section ) {

		parse_str( $_POST['_wp_http_referer'], $referrer ); // Pull out the tab and section
		$tab      = isset( $referrer['tab'] ) ? $referrer['tab'] : 'general';
		$section  = isset( $referrer['section'] ) ? $referrer['section'] : 'main';

		// Run a general sanitization for the tab for special fields (like taxes)
		$input = apply_filters( 'schema_wp_settings_' . $tab . '_sanitize', $input );

		// Run a general sanitization for the section so custom tabs with sub-sections can save special data
		$input = apply_filters( 'schema_wp_settings_' . $tab . '-' . $section . '_sanitize', $input );

	}

	// Merge our new settings with the existing
	$output = array_merge( $schema_wp_options, $input );

	foreach ( $setting_types as $key => $type ) {

		if ( empty( $type ) ) {
			continue;
		}

		// Some setting types are not actually settings, just keep moving along here
		$non_setting_types = apply_filters( 'schema_wp_non_setting_types', array(
			'header', 'descriptive_text', 'hook',
		) );

		if ( in_array( $type, $non_setting_types ) ) {
			continue;
		}

		if ( array_key_exists( $key, $output ) ) {
			$output[ $key ] = apply_filters( 'schema_wp_settings_sanitize_' . $type, $output[ $key ], $key );
			$output[ $key ] = apply_filters( 'schema_wp_settings_sanitize', $output[ $key ], $key );
		}

		if ( $doing_section ) {
			switch( $type ) {
				case 'checkbox':
					if ( array_key_exists( $key, $input ) && $output[ $key ] === '-1' ) {
						unset( $output[ $key ] );
					}
					break;
				default:
					if ( array_key_exists( $key, $input ) && empty( $input[ $key ] ) ) {
						unset( $output[ $key ] );
					}
					break;
			}
		} else {
			if ( empty( $input[ $key ] ) ) {
				unset( $output[ $key ] );
			}
		}

	}

	if ( $doing_section ) {
		add_settings_error( 'schema-wp-notices', '', __( 'Settings updated.', 'schema-premium' ), 'updated' );
	}

	return $output;
}

/**
 * Flattens the set of registered settings and their type so we can easily sanitize all the settings
 * in a much cleaner set of logic in schema_wp_settings_sanitize
 *
 * @since  1.0.0
 * @return array Key is the setting ID, value is the type of setting it is registered as
 */
function schema_wp_get_registered_settings_types() {
	$settings      = schema_wp_get_registered_settings();
	$setting_types = array();
	
	// debug
	//echo'<pre>';print_r($settings);echo'</pre>';exit;
	
	foreach ( $settings as $tab ) {

		foreach ( $tab as $section_or_setting ) {

			// See if we have a setting registered at the tab level for backwards compatibility
			if ( is_array( $section_or_setting ) && array_key_exists( 'type', $section_or_setting ) ) {
				$setting_types[ $section_or_setting['id'] ] = $section_or_setting['type'];
				continue;
			}

			foreach ( $section_or_setting as $section => $section_settings ) {
				if(isset($section_settings['id'])) $setting_types[ $section_settings['id'] ] = $section_settings['type'];
			}
		}

	}

	return $setting_types;
}

add_filter( 'schema_wp_settings_sanitize_text', 'schema_wp_sanitize_text_field' );
/**
 * Sanitize text fields
 *
 * @since 1.0.0
 * @param array $input The field value
 * @return string $input Sanitizied value
 */
function schema_wp_sanitize_text_field( $input ) {
	$tags = array(
		'p' => array(
			'class' => array(),
			'id'    => array(),
		),
		'span' => array(
			'class' => array(),
			'id'    => array(),
		),
		'a' => array(
			'href' => array(),
			'title' => array(),
			'class' => array(),
			'title' => array(),
			'id'    => array(),
		),
		'strong' => array(),
		'em' => array(),
		'br' => array(),
		'img' => array(
			'src'   => array(),
			'title' => array(),
			'alt'   => array(),
			'id'    => array(),
		),
		'div' => array(
			'class' => array(),
			'id'    => array(),
		),
		'ul' => array(
			'class' => array(),
			'id'    => array(),
		),
		'li' => array(
			'class' => array(),
			'id'    => array(),
		)
	);

	$allowed_tags = apply_filters( 'schema_wp_allowed_html_tags', $tags );

	return trim( wp_kses( $input, $allowed_tags ) );
}

/**
 * Sanitize HTML Class Names
 *
 * @since 1.1.1
 * @param  string|array $class HTML Class Name(s)
 * @return string $class
 */
function schema_premium_sanitize_html_class( $class = '' ) {

	if ( is_string( $class ) ) {
		$class = sanitize_html_class( $class );
	} else if ( is_array( $class ) ) {
		$class = array_values( array_map( 'sanitize_html_class', $class ) );
		$class = implode( ' ', array_unique( $class ) );
	}

	return $class;

}

/**
 * Retrieve settings tabs
 *
 * @since 1.0.0
 * @return array $tabs
 */
function schema_wp_get_settings_tabs() {

	$settings = schema_wp_get_registered_settings();

	$tabs						= array();
	$tabs['general']			= __( 'General',			'schema-premium' );
	$tabs['knowledge_graph']	= __( 'Knowledge Graph',	'schema-premium' );
	$tabs['schemas']			= __( 'Schemas',			'schema-premium' );
	
	if( ! empty( $settings['integrations'] ) ) {
		$tabs['integrations'] = __( 'Integrations', 'schema-premium' );
	}
	if( ! empty( $settings['extensions'] ) ) {
		$tabs['extensions'] = __( 'Extensions', 'schema-premium' );
	}
	if( ! empty( $settings['licenses'] ) ) {
		$tabs['licenses'] = __( 'Licenses', 'schema-premium' );
	}

	$tabs['advanced']      = __( 'Advanced', 'schema-premium' );
	
	//if( schema_wp()->settings->get( 'debug_mode', false ) ) {	
	//	$tabs['schema_wp_debug']     = __( 'Debug Assistant', 'schema-premium' );
	//}
	
	return apply_filters( 'schema_wp_settings_tabs', $tabs );
}

/**
 * Retrieve settings tabs
 *
 * @since 1.0.0
 * @return array $section
 */
function schema_wp_get_settings_tab_sections( $tab = false ) {

	$tabs     = false;
	$sections = schema_wp_get_registered_settings_sections();

	if( $tab && ! empty( $sections[ $tab ] ) ) {
		$tabs = $sections[ $tab ];
	} else if ( $tab ) {
		$tabs = false;
	}

	return $tabs;
}

/**
 * Get the settings sections for each tab
 * Uses a static to avoid running the filters on every request to this function
 *
 * @since 1.0
 * @return array Array of tabs and sections
 */
function schema_wp_get_registered_settings_sections() {

	static $sections = false;

	if ( false !== $sections ) {
		return $sections;
	}

	$sections = array(
		'general'    => apply_filters( 'schema_wp_settings_sections_general', array(
			'main'		=> '',
		) ),
		'schemas'    => apply_filters( 'schema_wp_settings_sections_schemas', array(
			'general'		=> __( 'General', 'schema-premium' ),
			'author'		=> __( 'Author', 'schema-premium' ),
			'breadcrumbs'	=> __( 'Breadcrumbs', 'schema-premium' ),
			'blog'			=> __( 'Blog', 'schema-premium' ),
			'post_types'	=> __( 'Post Types', 'schema-premium' ),
			'special_pages' => __( 'Special Pages', 'schema-premium' ),
			'embeds' 		=> __( 'Embeds', 'schema-premium' ),
		) ),
		'knowledge_graph'	=> apply_filters( 'schema_wp_settings_sections_knowledge_graph', array(
			'organization'			=> __( 'Organization Info', 'schema-premium' ),
			'search_results'		=> __( 'Search Results', 'schema-premium' ),
			'social_profiles'		=> __( 'Social Profiles', 'schema-premium' ),
			'corporate_contacts'	=> __( 'Corporate Contacts', 'schema-premium' ),
		) ),
		'integrations' => apply_filters( 'schema_wp_settings_sections_integrations', array(
			'main'		=> __( 'Main', 'schema-premium' ),
		) ),
		'extensions' => apply_filters( 'schema_wp_settings_sections_extensions', array(
			'main'		=> __( 'Main', 'schema-premium' ),
		) ),
		'licenses'	=> apply_filters( 'schema_wp_settings_sections_licenses', array() ),
		'advanced'	=> apply_filters( 'schema_wp_settings_sections_advanced', array(
			'main'		=> '',
		) ),
	);

	$sections = apply_filters( 'schema_wp_settings_sections', $sections );

	return $sections;
}

/**
 * Retrieve a list of all published pages
 *
 * On large sites this can be expensive, so only load if on the settings page or $force is set to true
 *
 * @since 1.0
 * @param bool $force Force the pages to be loaded even if not on settings
 * @return array $pages_options An array of the pages
 */
function schema_wp_get_pages( $force = false ) {

	$pages_options = array( '' => '' ); // Blank option

	if( ( ! isset( $_GET['page'] ) || 'schema' != $_GET['page'] ) && ! $force ) {
		return $pages_options;
	}

	$pages = get_pages();
	if ( $pages ) {
		foreach ( $pages as $page ) {
			$pages_options[ $page->ID ] = $page->post_title;
		}
	}

	return $pages_options;
}

/**
 * Header Callback
 *
 * Renders the header.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 * @return void
 */
function schema_wp_header_callback( $args ) {
	echo $args['desc'];
	echo apply_filters( 'schema_wp_after_setting_output', '', $args );
}

/**
 * Checkbox Callback
 *
 * Renders checkboxes.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 *
 * @return void
 */
function schema_wp_checkbox_callback( $args ) {
	$schema_wp_option = schema_wp_get_option( $args['id'] );

	if ( isset( $args['faux'] ) && true === $args['faux'] ) {
		$name = '';
	} else {
		$name = 'name="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']"';
	}
	
	if ( isset( $args['class_field'] ) ) {
		$class_field = 'class="' . schema_premium_sanitize_key( $args['class_field'] ) . '"';
	} else {
		$class_field = '';
	}
	
	$checked  = ! empty( $schema_wp_option ) ? checked( 1, $schema_wp_option, false ) : '';
	$html     = '<input type="hidden"' . $name . ' value="-1" />';
	$html    .= '<input ' . $class_field . 'type="checkbox" id="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']"' . $name . ' value="1" ' . $checked . '/>';
	$html    .= '<label for="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']"> '  . wp_kses_post( $args['desc'] ) . '</label>';

	echo apply_filters( 'schema_wp_after_setting_output', $html, $args );
}

/**
 * Multicheck Callback
 *
 * Renders multiple checkboxes.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 *
 * @return void
 */
function schema_wp_multicheck_callback( $args ) {
	$schema_wp_option = schema_wp_get_option( $args['id'] );

	$class = schema_premium_sanitize_html_class( $args['class_field'] );
	
	$html = '';
	if ( ! empty( $args['options'] ) ) {
		$html .= '<input type="hidden" name="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']" value="-1" />';
		foreach( $args['options'] as $key => $option ):
			if( isset( $schema_wp_option[ $key ] ) ) { $enabled = $option; } else { $enabled = 0; }
			$html .= '<input name="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . '][' . schema_premium_sanitize_key( $key ) . ']" id="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . '][' . schema_premium_sanitize_key( $key ) . ']" class="' . $class . '" type="checkbox" value="' . esc_attr( $option ) . '" ' . checked($option, $enabled, false) . '/>&nbsp;';
			$html .= '<label for="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . '][' . schema_premium_sanitize_key( $key ) . ']">' . wp_kses_post( $option ) . '</label><br/>';
		endforeach;
		$html .= '<p class="description">' . $args['desc'] . '</p>';
	}

	echo apply_filters( 'schema_wp_after_setting_output', $html, $args );
}

/**
 * Radio Callback
 *
 * Renders radio boxes.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 *
 * @return void
 */
function schema_wp_radio_callback( $args ) {
	$schema_wp_options = schema_wp_get_option( $args['id'] );

	$html = '<fieldset class="">';
	
	if ( isset( $args['class_field'] ) ) {
		$class_field = 'class="' . schema_premium_sanitize_key( $args['class_field'] ) . '"';
	} else {
		$class_field = '';
	}
	
	foreach ( $args['options'] as $key => $option ) :
		$checked = false;

		if ( $schema_wp_options && $schema_wp_options == $key )
			$checked = true;
		elseif( isset( $args['std'] ) && $args['std'] == $key && ! $schema_wp_options )
			$checked = true;

		$html .= '<input ' . $class_field .' name="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']" id="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . '][' . schema_premium_sanitize_key( $key ) . ']" type="radio" value="' . schema_premium_sanitize_key( $key ) . '" ' . checked(true, $checked, false) . '/>&nbsp;';
		$html .= '<label for="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . '][' . schema_premium_sanitize_key( $key ) . ']">' . esc_html( $option ) . '</label><br/>';
	endforeach;
	
	$html .= '</fieldset>';
	
	$html .= '<p class="description">' . apply_filters( 'schema_wp_after_setting_output', wp_kses_post( $args['desc'] ), $args ) . '</p>';

	echo $html;
}

/**
 * Text Callback
 *
 * Renders text fields.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 *
 * @return void
 */
function schema_wp_text_callback( $args ) {
	$schema_wp_option = schema_wp_get_option( $args['id'] );

	if ( $schema_wp_option ) {
		$value = $schema_wp_option;
	} else {
		$value = isset( $args['std'] ) ? $args['std'] : '';
	}

	if ( isset( $args['faux'] ) && true === $args['faux'] ) {
		$args['readonly'] = true;
		$value = isset( $args['std'] ) ? $args['std'] : '';
		$name  = '';
	} else {
		$name = 'name="schema_wp_settings[' . esc_attr( $args['id'] ) . ']"';
	}
	
	if ( isset( $args['class_field'] ) ) {
		$class_field = schema_premium_sanitize_key( $args['class_field'] ) . ' ';
	} else {
		$class_field = '';
	}

	$readonly = $args['readonly'] === true ? ' readonly="readonly"' : '';
	$size     = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
	$html     = '<input type="text" class="' . $class_field . sanitize_html_class( $size ) . '-text" id="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']" ' . $name . ' value="' . esc_attr( stripslashes( $value ) ) . '" placeholder="' . $args['placeholder'] . '" ' . $readonly . '/>';
	$html    .= '<label for="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']"> '  . wp_kses_post( $args['desc'] ) . '</label>';

	echo apply_filters( 'schema_wp_after_setting_output', $html, $args );
}

/**
 * Number Callback
 *
 * Renders number fields.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 *
 * @return void
 */
function schema_wp_number_callback( $args ) {
	$schema_wp_option = schema_wp_get_option( $args['id'] );

	if ( $schema_wp_option ) {
		$value = $schema_wp_option;
	} else {
		$value = isset( $args['std'] ) ? $args['std'] : '';
	}

	if ( isset( $args['faux'] ) && true === $args['faux'] ) {
		$args['readonly'] = true;
		$value = isset( $args['std'] ) ? $args['std'] : '';
		$name  = '';
	} else {
		$name = 'name="schema_wp_settings[' . esc_attr( $args['id'] ) . ']"';
	}
	
	if ( isset( $args['class_field'] ) ) {
		$class_field = schema_premium_sanitize_key( $args['class_field'] ) . ' ';
	} else {
		$class_field = '';
	}
	
	$max  = isset( $args['max'] ) ? $args['max'] : 999999;
	$min  = isset( $args['min'] ) ? $args['min'] : 0;
	$step = isset( $args['step'] ) ? $args['step'] : 1;

	$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
	$html = '<input type="number" step="' . esc_attr( $step ) . '" max="' . esc_attr( $max ) . '" min="' . esc_attr( $min ) . '" class="' . $class_field . sanitize_html_class( $size ) . '-text" id="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']" ' . $name . ' value="' . esc_attr( stripslashes( $value ) ) . '"/>';
	$html .= '<label for="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']"> '  . wp_kses_post( $args['desc'] ) . '</label>';

	echo apply_filters( 'schema_wp_after_setting_output', $html, $args );
}

/**
 * Textarea Callback
 *
 * Renders textarea fields.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 *
 * @return void
 */
function schema_wp_textarea_callback( $args ) {
	$schema_wp_option = schema_wp_get_option( $args['id'] );

	if ( $schema_wp_option ) {
		$value = $schema_wp_option;
	} else {
		$value = isset( $args['std'] ) ? $args['std'] : '';
	}
	
	if ( isset( $args['class_field'] ) ) {
		$class_field = schema_premium_sanitize_key( $args['class_field'] ) . ' ';
	} else {
		$class_field = '';
	}
	
	$html = '<textarea class="' . $class_field . 'large-text" cols="50" rows="5" id="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']" name="schema_wp_settings[' . esc_attr( $args['id'] ) . ']">' . esc_textarea( stripslashes( $value ) ) . ' placeholder="' . $args['placeholder'] .'"</textarea>';
	$html .= '<label for="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']"> '  . wp_kses_post( $args['desc'] ) . '</label>';

	echo apply_filters( 'schema_wp_after_setting_output', $html, $args );
}

/**
 * Password Callback
 *
 * Renders password fields.
 *
 * @since 1.3
 * @param array $args Arguments passed by the setting
 *
 * @return void
 */
function schema_wp_password_callback( $args ) {
	$schema_wp_options = schema_wp_get_option( $args['id'] );

	if ( $schema_wp_options ) {
		$value = $schema_wp_options;
	} else {
		$value = isset( $args['std'] ) ? $args['std'] : '';
	}

	$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
	$html = '<input type="password" class="' . sanitize_html_class( $size ) . '-text" id="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']" name="schema_wp_settings[' . esc_attr( $args['id'] ) . ']" value="' . esc_attr( $value ) . '"/>';
	$html .= '<label for="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']"> ' . wp_kses_post( $args['desc'] ) . '</label>';

	echo apply_filters( 'schema_wp_after_setting_output', $html, $args );
}

/**
 * Missing Callback
 *
 * If a function is missing for settings callbacks alert the user.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 * @return void
 */
function schema_wp_missing_callback($args) {
	printf(
		__( 'The callback function used for the %s setting is missing.', 'schema-premium' ),
		'<strong>' . $args['id'] . '</strong>'
	);
}

/**
 * Select Callback
 *
 * Renders select fields.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 *
 * @return void
 */
function schema_wp_select_callback($args) {
	$schema_wp_option = schema_wp_get_option( $args['id'] );

	if ( $schema_wp_option ) {
		$value = $schema_wp_option;
	} else {
		$value = isset( $args['std'] ) ? $args['std'] : '';
	}

	if ( isset( $args['placeholder'] ) ) {
		$placeholder = $args['placeholder'];
	} else {
		$placeholder = '';
	}

	if ( isset( $args['chosen'] ) ) {
		$chosen = 'class="schema-wp-chosen"';
	} else {
		$chosen = '';
	}
	
	if ( isset( $args['class_field'] ) ) {
		$class_field = 'class="' . schema_premium_sanitize_key( $args['class_field'] ) . '"';
	} else {
		$class_field = '';
	}

	$html = '<select ' . $class_field .' id="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']" name="schema_wp_settings[' . esc_attr( $args['id'] ) . ']" ' . $chosen . 'data-placeholder="' . esc_html( $placeholder ) . '" />';

	foreach ( $args['options'] as $option => $name ) {
		$selected = selected( $option, $value, false );
		$html .= '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( $name ) . '</option>';
	}

	$html .= '</select>';
	$html .= '<label for="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']"> ' . wp_kses_post( $args['desc'] ) . '</label>';

	echo apply_filters( 'schema_wp_after_setting_output', $html, $args );
}

/**
 * Color select Callback
 *
 * Renders color select fields.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 *
 * @return void
 */
function schema_wp_color_select_callback( $args ) {
	$schema_wp_option = schema_wp_get_option( $args['id'] );

	if ( $schema_wp_option ) {
		$value = $schema_wp_option;
	} else {
		$value = isset( $args['std'] ) ? $args['std'] : '';
	}

	$html = '<select id="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']" name="schema_wp_settings[' . esc_attr( $args['id'] ) . ']"/>';

	foreach ( $args['options'] as $option => $color ) {
		$selected = selected( $option, $value, false );
		$html .= '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( $color['label'] ) . '</option>';
	}

	$html .= '</select>';
	$html .= '<label for="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']"> '  . wp_kses_post( $args['desc'] ) . '</label>';

	echo apply_filters( 'schema_wp_after_setting_output', $html, $args );
}

/**
 * Rich Editor Callback
 *
 * Renders rich editor fields.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 */
function schema_wp_rich_editor_callback( $args ) {
	$schema_wp_option = schema_wp_get_option( $args['id'] );

	if ( $schema_wp_option ) {
		$value = $schema_wp_option;

		if( empty( $args['allow_blank'] ) && empty( $value ) ) {
			$value = isset( $args['std'] ) ? $args['std'] : '';
		}
	} else {
		$value = isset( $args['std'] ) ? $args['std'] : '';
	}

	$rows = isset( $args['size'] ) ? $args['size'] : 20;


	ob_start();
	wp_editor( stripslashes( $value ), 'schema_wp_settings_' . esc_attr( $args['id'] ), array( 'textarea_name' => 'schema_wp_settings[' . esc_attr( $args['id'] ) . ']', 'textarea_rows' => absint( $rows ) ) );
	$html = ob_get_clean();

	$html .= '<br/><label for="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']"> ' . wp_kses_post( $args['desc'] ) . '</label>';

	echo apply_filters( 'schema_wp_after_setting_output', $html, $args );
}

/**
 * Upload Callback
 *
 * Renders upload fields.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 *
 * @return void
 */
function schema_wp_upload_callback( $args ) {
	$schema_wp_option = schema_wp_get_option( $args['id'] );
	
	if ( isset( $args['class_field'] ) ) {
		$class_field = schema_premium_sanitize_key( $args['class_field'] ) . ' ';
	} else {
		$class_field = '';
	}

	if ( $schema_wp_option ) {
		$value = $schema_wp_option;
	} else {
		$value = isset($args['std']) ? $args['std'] : '';
	}

	$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
	$html = '<input type="text" class="' . $class_field . sanitize_html_class( $size ) . '-text" id="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']" name="schema_wp_settings[' . esc_attr( $args['id'] ) . ']" value="' . esc_attr( stripslashes( $value ) ) . '"/>';
	$html .= '<span>&nbsp;<input type="button" class="schema_wp_settings_upload_button button-secondary" value="' . __( 'Upload File', 'schema-premium' ) . '"/></span>';
	$html .= '<label for="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']"> ' . wp_kses_post( $args['desc'] ) . '</label>';

	echo apply_filters( 'schema_wp_after_setting_output', $html, $args );
}

/**
 * Image Upload Callback
 *
 * Renders file upload fields.
 *
 * @since 1.0
 * @param array $args Arguements passed by the setting
 */
function schema_wp_image_upload_callback( $args ) {
	$schema_wp_option = schema_wp_get_option( $args['id'] );
	
	if ( isset( $args['class_field'] ) ) {
		$class_field = schema_premium_sanitize_key( $args['class_field'] ) . ' ';
	} else {
		$class_field = '';
	}

	if( $schema_wp_option )
		$value = $schema_wp_option;
	else
		$value = isset( $args['std'] ) ? $args['std'] : '';

	$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
	$html = '<input type="text" class="' . $class_field . sanitize_html_class( $size ) . '-text" id="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']" name="schema_wp_settings[' . esc_attr( $args['id'] ) . ']" value="' . esc_attr( stripslashes( $value ) ) . '"/>';
	//$html = '<input type="hidden" id="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']" name="schema_wp_settings[' . esc_attr( $args['id'] ) . ']" value="' . esc_attr( stripslashes( $value ) ) . '"/>';
	$html .= '<span>&nbsp;<input type="button" class="schema_wp_settings_upload_button button-secondary" value="' . __( 'Upload File', 'schema-premium' ) . '"/></span>';
	
	$html .= '<p>'  . wp_kses_post( $args['desc'] ) . '</p>';
		
	if ( ! empty( $value ) ) {
		$html .= '<div id="preview_image">';
		$html .= '<img src="'.esc_attr( stripslashes( $value ) ).'" />';
		$html .= '</div>';
	} else {
		$html .= '<div id="preview_image" style="display: none;"></div>';
	}
	
	echo apply_filters( 'schema_wp_after_setting_output', $html, $args );
}

/**
 * Color picker Callback
 *
 * Renders color picker fields.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 *
 * @return void
 */
function schema_wp_color_callback( $args ) {
	$schema_wp_option = schema_wp_get_option( $args['id'] );

	if ( $schema_wp_option ) {
		$value = $schema_wp_option;
	} else {
		$value = isset( $args['std'] ) ? $args['std'] : '';
	}

	$default = isset( $args['std'] ) ? $args['std'] : '';

	$html = '<input type="text" class="schema-wp-color-picker" id="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']" name="schema_wp_settings[' . esc_attr( $args['id'] ) . ']" value="' . esc_attr( $value ) . '" data-default-color="' . esc_attr( $default ) . '" />';
	$html .= '<label for="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']"> '  . wp_kses_post( $args['desc'] ) . '</label>';

	echo apply_filters( 'schema_wp_after_setting_output', $html, $args );
}

/**
 * Date picker Callback
 *
 * Renders date picker fields.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 *
 * @return void
 */
function schema_wp_datepicker_callback( $args ) {
	$schema_wp_option = schema_wp_get_option( $args['id'] );

	if ( $schema_wp_option ) {
		$value = $schema_wp_option;
	} else {
		$value = isset( $args['std'] ) ? $args['std'] : '';
	}

	$default = isset( $args['std'] ) ? $args['std'] : '';

	$html = '<input type="text" class="schema_wp_datepicker" id="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']" name="schema_wp_settings[' . esc_attr( $args['id'] ) . ']" value="' . esc_attr( $value ) . '" data-default-datepicker="' . esc_attr( $default ) . '" />';
	$html .= '<label for="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']"> '  . wp_kses_post( $args['desc'] ) . '</label>';

	echo apply_filters( 'schema_wp_after_setting_output', $html, $args );
}	

/**
 * Descriptive text callback.
 *
 * Renders descriptive text onto the settings field.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 * @return void
 */
function schema_wp_descriptive_text_callback( $args ) {
	$html = wp_kses_post( $args['desc'] );

	echo apply_filters( 'schema_wp_after_setting_output', $html, $args );
}

/**
 * Post Select Callback
 *
 * Renders file upload fields.
 *
 * @since 1.0
 * @param array $args Arguements passed by the setting
 */
function schema_wp_post_select_callback( $args ) {
		
	$schema_wp_option = schema_wp_get_option( $args['id'] );

	if ( $schema_wp_option ) {
		$value = $schema_wp_option;
	} else {
		$value = isset( $args['std'] ) ? $args['std'] : '';
	}
		
	$html = '<select id="schema_wp_settings[' . $args['id'] . ']" name="schema_wp_settings[' . $args['id'] . ']"/>';
	$html .= '<option value=""> - '.__('Select One', 'schema-premium').' - </option>'; // Select One
	$posts = get_posts( array( 'post_type' => $args['post_type'], 'posts_per_page' => -1, 'orderby' => 'name', 'order' => 'ASC' ) );
	foreach ( $posts as $item ) :
	$selected = selected( $item->ID , $value, false );
		$html .= '<option value="' . $item->ID . '"' . $selected . '>' . $item->post_title . '</option>';
		$post_type_object = get_post_type_object( $args['post_type'] );
	endforeach;
	$html .= '</select>';
	$html .= '<p class="description">' . $args['desc'] . '</p>';
		
	echo $html;
}

/**
 * Taxonomy Select Callback
 *
 * Renders taxonomy select fields.
 *
 * @since 1.0.6
 * @param array $args Arguements passed by the setting
 */
function schema_wp_taxonomy_select_callback( $args ) {
	
	$schema_wp_option = schema_wp_get_option( $args['id'] );
	
	// Debug
	//echo'<pre>';print_r($schema_wp_option);echo'</pre>';
	
	if ( $schema_wp_option ) {
		$value = $schema_wp_option;
	} else {
		$value = isset( $args['std'] ) ? $args['std'] : '';
	}
	
	$html 		= '';
	$post_types = get_post_types( array( 'public' => true ), 'objects' );
	
	if ( is_array( $post_types ) && $post_types !== array() ) {
		//echo '<p><b>' . esc_html__( 'Taxonomy to show in breadcrumbs for content types', 'schema-premium' ) . '</b></p><br>';
		?>
		<table class="schema-review-rating-scale widefat">
			<thead>
				<tr>
					<?php
					$columns = array(
						'type' => __( 'Content type', 'schema-premium' ),
						'min'  => __( 'Taxonomy', 'schema-premium' )
					);
					foreach ( $columns as $key => $column ) {
						echo '<th class="' . esc_attr( $key ) . '">' . esc_html( $column ) . '</th>';
					}
					?>
				</tr>
			</thead>
            <tbody>
        <?php	           
		foreach ( $post_types as $pt ) {
			$taxonomies = get_object_taxonomies( $pt->name, 'objects' );
			if ( is_array( $taxonomies ) && $taxonomies !== array() ) {
				
				$html .= '<tr>';
				
				$html .= '<td>';
				$html .= $pt->labels->name . ' (<code>' . $pt->name . '</code>)';
				$html .= '</td>';
				
				$html .= '<td>';
				$html .= '<select name="schema_wp_settings[' . $args['id'] . '][' . $pt->name . ']" id="schema_wp_settings[' . $args['id'] . ']"/>';
				$html .= '<option value=""> - '.__('None', 'schema-premium').' - </option>'; // None
				foreach ( $taxonomies as $tax ) {
					if ( ! $tax->public ) {
						continue;
					}
					$selected = selected( $tax->name , $value[$pt->name], false );
					$html .= '<option value="' . $tax->name . '"' . $selected . '>' . $tax->labels->singular_name . '</option>';
					
				}
				$html .= '</select>';
				$html .= '</td>';
				$html .= '</tr>';
			}
			unset( $taxonomies );
		}
		unset( $pt );
		
		echo $html;
		
		echo'</tbody>
				</table>';
		
		echo '<p class="description">' . $args['desc'] . '</p>';
	}
}

/**
 * Content Type Archive Select Callback
 *
 * Renders content type archive select fields.
 *
 * @since 1.0.6
 * @param array $args Arguements passed by the setting
 */
function schema_wp_content_type_archive_select_callback( $args ) {
	
	$schema_wp_option = schema_wp_get_option( $args['id'] );
	
	// Debug
	//echo'<pre>';print_r($schema_wp_option);echo'</pre>';
	
	if ( $schema_wp_option ) {
		$value = $schema_wp_option;
	} else {
		$value = isset( $args['std'] ) ? $args['std'] : '';
	}
	
	$html 		= '';
	$post_types = get_post_types( array( 'public' => true ), 'objects' );

	$taxonomies = get_taxonomies(
		array(
			'public'   => true,
			'_builtin' => false,
		),
		'objects'
	);

	if ( is_array( $taxonomies ) && $taxonomies !== array() ) {
		//echo '<p><b>' . esc_html__( 'Content type archive to show in breadcrumbs for taxonomies', 'schema-premium' ) . '</b></p><br>';
		?>
		<table class="schema-review-rating-scale widefat">
			<thead>
				<tr>
					<?php
					$columns = array(
						'type' => __( 'Taxonomy', 'schema-premium' ),
						'min'  => __( 'Content type', 'schema-premium' )
					);
					foreach ( $columns as $key => $column ) {
						echo '<th class="' . esc_attr( $key ) . '">' . esc_html( $column ) . '</th>';
					}
					?>
				</tr>
			</thead>
            <tbody>
        <?php
		foreach ( $taxonomies as $tax ) {
			
			$html .= '<tr>';
			
			$html .= '<td>';
			$html .= $tax->labels->singular_name . ' (<code>' . $tax->name . '</code>)';
			$html .= '</td>';
			
			$html .= '<td>';
			$html .= '<select name="schema_wp_settings[' . $args['id'] . '][' . $tax->name . ']" id="schema_wp_settings[' . $args['id'] . ']"/>';
			$html .= '<option value=""> - '.__('None', 'schema-premium').' - </option>'; // None
			
			
			if ( get_option( 'show_on_front' ) === 'page' && get_option( 'page_for_posts' ) > 0 ) {
				$html .= '<option value="post">'.__('Blog', 'schema-premium').'</option>'; // None
			}
			
			if ( is_array( $post_types ) && $post_types !== array() ) {
				foreach ( $post_types as $pt ) {
					if ( schema_premium_post_type_has_archive( $pt ) ) {
						$selected = selected( $pt->name , $value[$tax->name], false );
						$html .= '<option value="' . $pt->name . '" ' . $selected . '>' . $pt->labels->name . '</option>';
					}
				}
				unset( $pt );
			}
			$html .= '</select>';
			$html .= '</td>';
			$html .= '</tr>';
					
			unset( $tax );
		}
	}
	
	echo $html;
	
	echo'</tbody>
		</table>';
		
	echo '<p class="description">' . $args['desc'] . '</p>';
}
	
/**
 * Registers the license field callback for Software Licensing
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 *
 * @return void
 */
if ( ! function_exists( 'schema_wp_license_key_callback' ) ) {
	function schema_wp_license_key_callback( $args ) {
		$schema_wp_option = schema_wp_get_option( $args['id'] );

		$messages = array();
		$license  = get_option( $args['options']['is_valid_license_option'] );

		if ( $schema_wp_option ) {
			$value = $schema_wp_option;
		} else {
			$value = isset( $args['std'] ) ? $args['std'] : '';
		}

		if( ! empty( $license ) && is_object( $license ) ) {

			// activate_license 'invalid' on anything other than valid, so if there was an error capture it
			if ( false === $license->success ) {

				switch( $license->error ) {

					case 'expired' :

						$class = 'expired';
						$messages[] = sprintf(
							__( 'Your license key expired on %s. Please <a href="%s" target="_blank">renew your license key</a>.', 'schema-premium' ),
							date_i18n( get_option( 'date_format' ), strtotime( $license->expires, current_time( 'timestamp' ) ) ),
							'https://schema.press/checkout/?schema_wp_license_key=' . $value . '&utm_campaign=admin&utm_source=licenses&utm_medium=expired'
						);

						$license_status = 'license-' . $class . '-notice';

						break;

					case 'revoked' :

						$class = 'error';
						$messages[] = sprintf(
							__( 'Your license key has been disabled. Please <a href="%s" target="_blank">contact support</a> for more information.', 'schema-premium' ),
							'https://schema.press/submit-ticket/?utm_campaign=admin&utm_source=licenses&utm_medium=revoked'
						);

						$license_status = 'license-' . $class . '-notice';

						break;

					case 'missing' :

						$class = 'error';
						$messages[] = sprintf(
							__( 'Invalid license. Please <a href="%s" target="_blank">visit your account page</a> and verify it.', 'schema-premium' ),
							'https://schema.press/account/?utm_campaign=admin&utm_source=licenses&utm_medium=missing'
						);

						$license_status = 'license-' . $class . '-notice';

						break;

					case 'invalid' :
					case 'site_inactive' :

						$class = 'error';
						$messages[] = sprintf(
							__( 'Your %s is not active for this URL. Please <a href="%s" target="_blank">visit your account page</a> to manage your license key URLs.', 'schema-premium' ),
							$args['name'],
							'https://schema.press/account/?utm_campaign=admin&utm_source=licenses&utm_medium=invalid'
						);

						$license_status = 'license-' . $class . '-notice';

						break;

					case 'item_name_mismatch' :

						$class = 'error';
						$messages[] = sprintf( __( 'This appears to be an invalid license key for %s.', 'schema-premium' ), $args['name'] );

						$license_status = 'license-' . $class . '-notice';

						break;

					case 'no_activations_left':

						$class = 'error';
						$messages[] = sprintf( __( 'Your license key has reached its activation limit. <a href="%s">View possible upgrades</a> now.', 'schema-premium' ), 'https://schema.press/account/' );

						$license_status = 'license-' . $class . '-notice';

						break;
					
					case 'license_not_activable':

						$class = 'error';
						$messages[] = sprintf( __( 'Your license key is not activable. Get the specific valid license within your <a href="%s">account</a>.', 'schema-premium' ), 'https://schema.press/account/' );

						$license_status = 'license-' . $class . '-notice';

						break;

					default :

						$messages[] = print_r( $license, true );
						break;
				}

			} else {

				switch( $license->license ) {

					case 'valid' :
					default:

						$class = 'valid';

						$now        = current_time( 'timestamp' );
						$expiration = strtotime( $license->expires, current_time( 'timestamp' ) );

						if( 'lifetime' === $license->expires ) {

							$messages[] = __( 'License key never expires.', 'schema-premium' );

							$license_status = 'license-lifetime-notice';

						} elseif( $expiration > $now && $expiration - $now < ( DAY_IN_SECONDS * 30 ) ) {

							$messages[] = sprintf(
								__( 'Your license key expires soon! It expires on %s. <a href="%s" target="_blank">Renew your license key</a>.', 'schema-premium' ),
								date_i18n( get_option( 'date_format' ), strtotime( $license->expires, current_time( 'timestamp' ) ) ),
								'https://schema.press/checkout/?schema_wp_license_key=' . $value . '&utm_campaign=admin&utm_source=licenses&utm_medium=renew'
							);

							$license_status = 'license-expires-soon-notice';

						} else {

							$messages[] = sprintf(
								__( 'Your license key expires on %s.', 'schema-premium' ),
								date_i18n( get_option( 'date_format' ), strtotime( $license->expires, current_time( 'timestamp' ) ) )
							);

							$license_status = 'license-expiration-date-notice';

						}

						break;

				}

			}

		} else {
			$class = 'empty';

			$messages[] = sprintf(
				__( 'To receive updates, please enter your valid %s license key.', 'schema-premium' ),
				$args['name']
			);

			$license_status = null;
		}

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<input type="text" class="' . sanitize_html_class( $size ) . '-text" id="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']" name="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']" value="' . esc_attr( $value ) . '"/>';

		if ( ( is_object( $license ) && 'valid' == $license->license ) || 'valid' == $license ) {
			$html .= '<input type="submit" class="button-secondary" name="' . $args['id'] . '_deactivate" value="' . __( 'Deactivate License',  'schema-premium' ) . '"/>';
		}

		$html .= '<label for="schema_wp_settings[' . schema_premium_sanitize_key( $args['id'] ) . ']"> '  . wp_kses_post( $args['desc'] ) . '</label>';

		if ( ! empty( $messages ) ) {
			foreach( $messages as $message ) {

				$html .= '<div class="schema-wp-license-data schema-wp-license-' . $class . ' ' . $license_status . '">';
					$html .= '<p>' . $message . '</p>';
				$html .= '</div>';

			}
		}

		wp_nonce_field( schema_premium_sanitize_key( $args['id'] ) . '-nonce', schema_premium_sanitize_key( $args['id'] ) . '-nonce' );

		echo $html;
	}
}

/**
 * Hook Callback
 *
 * Adds a do_action() hook in place of the field
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 * @return void
 */
function schema_wp_hook_callback( $args ) {
	do_action( 'schema_wp_' . $args['id'], $args );
}

add_filter( 'schema_wp_after_setting_name', 'schema_wp_add_setting_tooltip', 10, 2 );
/**
 * Set manage_schema_options as the cap required to save Schema settings pages
 *
 * @since 1.0
 * @return string capability required
 */
function schema_wp_set_settings_cap() {
	return 'manage_schema_options';
}
add_filter( 'option_page_capability_schema_wp_settings', 'schema_wp_set_settings_cap' );

function schema_wp_add_setting_tooltip( $html, $args ) {

	if ( ! empty( $args['tooltip_title'] ) && ! empty( $args['tooltip_desc'] ) ) {
		$tooltip = '<span alt="f223" class="schema-wp-help-tip dashicons dashicons-editor-help" title="<strong>' . $args['tooltip_title'] . '</strong>: ' . $args['tooltip_desc'] . '"></span>';
		$html .= $tooltip;
	}

	return $html;
}

add_action( 'admin_print_footer_scripts', 'schema_wp_admin_footer_scripts' );
/**
 * Footer scripts
 *
 * @since 1.7
 *
 * @return void
 */
function schema_wp_admin_footer_scripts() { 

	if( ! schema_wp_is_admin_page() ) {
		return;
	}

?>
<script>                
	jQuery( document ).ready(function($) {
        	   
   	// Hide/Show Organization or Person fields 
	$('.tr_field_name').hide();
	$('.tr_field_logo').hide();
	
	var inputValue = $(".organization_or_person_radio:checked").attr("value");
	
	if ( inputValue == 'person' ) {
		$('.tr_field_logo').hide();
		$('.tr_field_name th').text('Person Name');
    	$('.tr_field_name').show();
	} 
	else {
		$('.tr_field_logo').show();
		$('.tr_field_name').show();
		$('.tr_field_name th').text('Organization Name');
	}
	
	$(".organization_or_person_radio").change(function(){
        var inputValue = $(this).attr("value");
        if ($(this).val() == 'person') {
			$('.tr_field_name th').text('Person Name');
    		$('.tr_field_name').show();
			$('.tr_field_logo').hide();
    	}
   		else {
   			$('.tr_field_name').show();
			$('.tr_field_logo').show();
			$('.tr_field_name th').text('Organziation Name');
   		}
	});
	
	// Hide/Show Site Name fields 
	$('.tr_field_site_name').hide();
	$('.tr_field_site_alternate_name').hide();
	
	var inputValue = $(".site_name_enable_checkbox:checked").attr("value");
	
	if ( inputValue == 1 ) {
		$('.tr_field_site_name').show();
		$('.tr_field_site_alternate_name').show();
	} 
	
	$(".site_name_enable_checkbox").change(function(){
        var $this = $(this);
         if ($this.is(':checked')) {
			$('.tr_field_site_name').show();
			$('.tr_field_site_alternate_name').show();
    	}
   		else {
   			$('.tr_field_site_name').hide();
			$('.tr_field_site_alternate_name').hide();
   		}
	});
	
});
</script>
<?php
}
