<?php
/**
 * Testing on local server
 *
 * @since 1.2
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Check if on local server
 *
 * @since 1.2
 * @return bool 
 */
function schea_premium_is_local_server() {
	
	if ( $_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1' ) {
		return true;
	}

	return false;
}

add_filter( 'schema_output_Product', 'schema_premium_test_output_on_local_server', 99 );
/**
 * Enable testing on local server
 *
 * @since 1.2
 * @return array 
 */
function schema_premium_test_output_on_local_server( $schema ) {

	if ( empty($schema) )
		return array();

	if ( ! schea_premium_is_local_server() ) {
		return $schema;
	}

	$enabled = schema_wp_get_option( 'local_server_enabled' );

	if ( $enabled != 'enabled' )
		return $schema;

	$local_domain 	= schema_wp_get_option( 'local_server_http_host_domain' );
	$test_domain 	= schema_wp_get_option( 'local_server_http_host_domain_test' );

	foreach ( $schema as $key => $val ) {
		
		switch ( $key ) {
			
			case 'url':
			case 'logo':
				
				$schema[$key] = str_replace( $local_domain, $test_domain, $val);
			break;
			
			case 'image':
				
				if ( is_array($schema[$key])) {
					if ( isset($schema[$key]['url']) ) {
						$schema[$key]['url'] = isset($val['url']) ? str_replace( $local_domain, $test_domain, $val['url']) : '';
					} else {
						$new_image_arr = array();
						foreach($schema[$key] as $url_key => $url ) {
							$new_image_url = str_replace( $local_domain, $test_domain, $url);
							array_push( $new_image_arr, $new_image_url);
						}
						$schema[$key] = $new_image_arr;
					}
				}
			break;

			case 'author':
				
				if (isset($schema[$key]['url'])) {
					$schema[$key]['url'] = isset($val['url']) ? str_replace( $local_domain, $test_domain, $val['url']) : '';
				}
			break;
			
			case 'offers':
				
				if (isset($schema[$key]['url'])) {
					$schema[$key]['url'] = isset($val['url']) ? str_replace( $local_domain, $test_domain, $val['url']) : '';
				}
			break;

			case 'itemReviewed':
				
				$schema[$key]['url'] = isset($val['url']) ? str_replace( $local_domain, $test_domain, $val['url']) : '';
				
				foreach (  $schema['itemReviewed'] as $item_key => $item_val ) {
					switch ( $item_key ) {
						case 'image':
						case 'offers':
							$schema[$key][$item_key]['url'] = str_replace( $local_domain, $test_domain, $item_val['url']);
							break;
					}
				}
			break;
			
			// Add support for Local Business Extension
			// @since 1.2.1
			//
			case 'department':
				
				if ( is_array($schema[$key]) ) {
					foreach ( $schema[$key] as $department_key => $department_val ) {
						if ( is_array($department_val) ) {
							foreach ( $department_val as $item_key => $item_val ) {
								switch ( $item_key ) {
								case 'image':
								case 'logo':
									$schema[$key][$department_key][$item_key] = str_replace( $local_domain, $test_domain, $item_val);
									break;
								}
							}
						}
					}
				}
			break;
			
		}
		
	}

	//echo '<pre>'; print_r($schema); echo '</pre>';

	return $schema;
}

add_action( 'admin_init', 'schema_premium_test_on_local_server_register_settings', 1 );
/*
* Register settings 
*
* @since 1.2
*/
function schema_premium_test_on_local_server_register_settings() {
	
	if ( ! schea_premium_is_local_server() ) {
		return;
	}

	add_filter( 'schema_wp_settings_advanced', 'schema_premium_on_local_server_settings', 10 );
}

/*
* Settings 
*
* @since 1.2
*/
function schema_premium_on_local_server_settings( $settings ) {

	
	$info = ' <span style="color:#8a8a8a;margin-top:3px;" class="dashicons dashicons-laptop"></span>';

	if ( schea_premium_is_local_server() ) {
		$info = ' <span style="color:#48b142;margin-top:3px;" class="dashicons dashicons-laptop"></span> Local Server on!';
	}
	
	$settings['main']['local_server_enabled'] = array(
		'id' => 'local_server_enabled',
		'name' => __( 'Fix URLs on Local Server?', 'schema-premium' ),
		'desc' => $info,
		'type' => 'select',
		'options' => array(
			'enabled'	=> __( 'Enabled', 'schema-premium'),
			'disabled'	=> __( 'Disabled', 'schema-premium')
		),
		'std' => 'disabled',
		'tooltip_title' => __('When enabled', 'schema-premium'),
		'tooltip_desc' => __('Schema Premium will override your local server url, this will fix errors and validate when you test your markup.', 'schema-premium'),
	);

	$settings['main']['local_server_http_host_domain'] = array(
		'id' => 'local_server_http_host_domain',
		'name' => __( 'HTTP HOST', 'schema-premium' ),
		'desc' => '',
		'type' => 'text',
		'std' => '',
		'placeholder' => $_SERVER['HTTP_HOST'], //$_SERVER['SERVER_NAME'],
		'tooltip_title' => __('HTTP HOST', 'schema-premium'),
		'tooltip_desc' => __('URL which presents you test site. ( make sure you include http:// or https:// to the url without a trailing slash)', 'schema-premium' )
	);

	$settings['main']['local_server_http_host_domain_test'] = array(
		'id' => 'local_server_http_host_domain_test',
		'name' => __( 'Fake Domain', 'schema-premium' ),
		'desc' => '',
		'type' => 'text',
		'std' => 'https://test.com',
		'placeholder' => 'https://test.com',
		'tooltip_title' => __('Test Domain', 'schema-premium'),
		'tooltip_desc' => __('Used to replace your HTTP HOST.', 'schema-premium' )
	);
	
	return $settings;
}
