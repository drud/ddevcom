<?php

/**
 * Returns an array with the positions where the social networks
 * can be placed
 *
 * @return array
 *
 */
function dpsp_get_network_locations( $for = 'all', $only_slugs = true ) {

	$locations_share = [
		'sidebar'    => __( 'Floating Sidebar', 'social-pug' ),
		'content'    => __( 'Content', 'social-pug' ),
		'sticky_bar' => __( 'Sticky Bar', 'social-pug' ),
		'pop_up'     => __( 'Pop-Up', 'social-pug' ),
	];

	$locations_follow = [
		'follow_widget' => __( 'Follow Widget', 'social-pug' ),
	];

	switch ( $for ) {
		case 'share':
			$locations = $locations_share;
			break;
		case 'follow':
			$locations = $locations_follow;
			break;
		case 'all':
			$locations = array_merge( $locations_share, $locations_follow );
			break;

	}

	$locations = apply_filters( 'dpsp_get_network_locations', $locations, $for );

	if ( $only_slugs ) {
		$locations = array_keys( $locations );
	}

	return $locations;

}


/**
 * Returns the name of a location
 *
 * @param string $location_slug
 *
 * @return string
 *
 */
function dpsp_get_network_location_name( $location_slug ) {

	$locations = dpsp_get_network_locations( 'all', false );

	if ( isset( $locations[ $location_slug ] ) ) {
		return $locations[ $location_slug ];
	} else {
		return '';
	}

}

/*
 * Checks to see if the location is active or not
 *
 */
function dpsp_is_location_active( $location_slug ) {

	$settings = dpsp_get_location_settings( $location_slug );

	if ( isset( $settings['active'] ) ) {
		return true;
	} else {
		return false;
	}

}


/**
 * Determines whether the location should be displayed or not
 *
 * @param string $location_slug
 *
 * @return bool
 *
 */
function dpsp_is_location_displayable( $location_slug ) {

	$return = true;

	// Get saved settings for the location
	$settings = dpsp_get_location_settings( $location_slug );

	if ( empty( $settings ) ) {
		$return = false;
	}

	if ( ! isset( $settings['post_type_display'] ) || ( isset( $settings['post_type_display'] ) && ! is_singular( $settings['post_type_display'] ) ) ) {
		$return = false;
	}

	return apply_filters( 'dpsp_is_location_displayable', $return, $location_slug, $settings );

}


/**
 * Get settings for a particular location
 * This is a developer friendly function
 *
 * @param string $location
 *
 * @return mixed null | array
 *
 */
function dpsp_get_location_settings( $location = '' ) {

	// Return null if no location is provided
	if ( empty( $location ) ) {
		return null;
	}

	$location_settings = Mediavine\Grow\Settings::get_setting( 'dpsp_location_' . $location, [] );

	return apply_filters( 'dpsp_get_location_settings', $location_settings, $location );

}


/**
 * Function that returns all networks
 *
 * @param string $for - buttons for share(ing) or follow(ing)
 *
 * @return array
 *
 */
function dpsp_get_networks( $for = 'share' ) {

	$networks = [];

	$networks_share = [
		'facebook'  => 'Facebook',
		'twitter'   => 'Twitter',
		'pinterest' => 'Pinterest',
		'linkedin'  => 'LinkedIn',
	];
	$networks_share = apply_filters( 'dpsp_share_networks', $networks_share );
	$networks_share = array_merge( $networks_share, [
		'email'     => 'Email',
		'print'     => 'Print',
	]);

	$networks_follow = [
		'facebook'   => 'Facebook',
		'twitter'    => 'Twitter',
		'pinterest'  => 'Pinterest',
		'linkedin'   => 'LinkedIn',
	];
	$networks_follow = apply_filters( 'dpsp_follow_networks', $networks_follow );

	switch ( $for ) {
		case 'share':
			$networks = $networks_share;
			break;

		case 'follow':
			$networks = $networks_follow;
			break;

		case 'all':
			$networks = array_merge( $networks_share, $networks_follow );
			break;

		default:
			break;
	}

	/**
	 * Filter the networks before returning them
	 *
	 * @param array $networks
	 * @param string $for
	 *
	 */
	return apply_filters( 'dpsp_get_networks', $networks, $for );

}


/*
 * Function that returns the name of a social network given its slug
 *
 */
function dpsp_get_network_name( $slug ) {

	$nerworks = dpsp_get_networks( 'all' );

	if ( isset( $nerworks[ $slug ] ) ) {
		return $nerworks[ $slug ];
	} else {
		return '';
	}
}


/**
 * Returns all networks that are set in every location panel
 *
 * @return array;
 *
 */
function dpsp_get_active_networks( $for = 'share' ) {

	$locations = dpsp_get_network_locations( $for );
	$networks  = [];

	foreach ( $locations as $location ) {

		$location_settings = dpsp_get_location_settings( $location );

		if ( isset( $location_settings['networks'] ) && ! empty( $location_settings['networks'] ) ) {
			foreach ( $location_settings['networks'] as $network_slug => $network ) {

				if ( ! in_array( $network_slug, $networks ) ) {
					$networks[] = $network_slug;
				}
			}
		}
	}

	return apply_filters( 'dpsp_get_active_networks', $networks, $for );

}


/**
 * Return an array of registered post types slugs and names
 *
 * @return array
 *
 */
function dpsp_get_post_types() {

	// Get default and custom post types
	$default_post_types = [ 'post', 'page' ];
	$custom_post_types  = get_post_types(
		[
			'public'   => true,
			'_builtin' => false,
		]
	);
	$post_types         = array_merge( $default_post_types, $custom_post_types );

	// The array we wish to return
	$return_post_types = [];

	foreach ( $post_types as $post_type ) {
		$post_type_object = get_post_type_object( $post_type );

		$return_post_types[ $post_type ] = $post_type_object->labels->singular_name;
	}

	return apply_filters( 'dpsp_get_post_types', $return_post_types );

}


/**
 * Returns the post types that are active for all locations
 *
 */
function dpsp_get_active_post_types() {

	$locations  = dpsp_get_network_locations();
	$post_types = [];

	foreach ( $locations as $location ) {

		$location_settings = Mediavine\Grow\Settings::get_setting( 'dpsp_location_' . $location, [] );

		if ( isset( $location_settings['active'] ) && ! empty( $location_settings['post_type_display'] ) ) {
			$post_types = array_merge( $post_types, $location_settings['post_type_display'] );
		}
	}

	$post_types = array_unique( $post_types );

	return $post_types;

}


/**
 * Returns the saved option, but replaces the saved social network
 * data with simple data to display in the back-end
 *
 * @param string $option_name
 *
 * @return array $settings
 */
function dpsp_get_back_end_display_option( $option_name ) {
	$settings = Mediavine\Grow\Settings::get_setting( $option_name );
	$networks = dpsp_get_networks( 'all' );

	$settings_networks_count = ( ! empty( $settings['networks'] ) ? count( $settings['networks'] ) : 0 );

	if ( $settings_networks_count > 2 ) {

		$current_network = 0;
		foreach ( $settings['networks'] as $network_slug => $network ) {

			if ( $current_network > 2 ) {
				unset( $settings['networks'][ $network_slug ] );
			} else {
				$settings['networks'][ $network_slug ] = [ 'label' => $networks[ $network_slug ] ];
			}

			$current_network ++;
		}
	} else {
		$settings['networks'] = [
			'facebook'  => [ 'label' => 'Facebook' ],
			'twitter'   => [ 'label' => 'Twitter' ],
			'pinterest' => [ 'label' => 'Pinterest' ],
		];
	}

	//Unset certain options
	unset( $settings['display']['show_count'] );

	return $settings;

}


/**
 * Returns the share link for a social network given the network slug
 *
 * @param string $network_slug
 * @param string $post_url
 * @param string $post_title
 * @param string $post_description
 * @param string $post_image
 *
 * @return string
 *
 */
function dpsp_get_network_share_link( $network_slug = '', $post_url = null, $post_title = null, $post_description = null, $post_image = null ) {

	if ( empty( $network_slug ) ) {
		return '';
	}

	if ( is_null( $post_url ) ) {
		$post_obj = dpsp_get_current_post();
		$post_url = dpsp_get_post_url( $post_obj->ID );
	}

	if ( is_null( $post_title ) ) {
		$post_obj   = dpsp_get_current_post();
		$post_title = dpsp_get_post_title( $post_obj->ID );
	}

	if ( is_null( $post_description ) ) {
		$post_obj         = dpsp_get_current_post();
		$post_description = dpsp_get_post_description( $post_obj->ID );
	}

	// Late filtering
	$post_url         = rawurlencode( apply_filters( 'dpsp_get_network_share_link_post_url', $post_url, $network_slug ) );
	$post_title       = rawurlencode( apply_filters( 'dpsp_get_network_share_link_post_title', $post_title, $network_slug ) );
	$post_description = rawurlencode( apply_filters( 'dpsp_get_network_share_link_post_description', $post_description, $network_slug ) );
	$post_image       = apply_filters( 'dpsp_get_network_share_link_post_image', $post_image, $network_slug );

	switch ( $network_slug ) {

		case 'facebook':
			$share_link = sprintf( 'https://www.facebook.com/sharer/sharer.php?u=%1$s&t=%2$s', $post_url, $post_title );
			break;

		case 'twitter':
			$settings = Mediavine\Grow\Settings::get_setting( 'dpsp_settings', [] );

			$via = ( ! empty( $settings['twitter_username'] ) && ! empty( $settings['tweets_have_username'] ) ) ? '&via=' . $settings['twitter_username'] : '';

			$share_link = sprintf( 'https://twitter.com/intent/tweet?text=%2$s&url=%1$s%3$s', $post_url, $post_title, $via );
			break;

		case 'pinterest':
			$settings = Mediavine\Grow\Settings::get_setting( 'dpsp_pinterest_share_images_setting', [] );

			$share_behavior = ( ! empty( $settings['share_image_pinterest_button_share_behavior'] ) ? $settings['share_image_pinterest_button_share_behavior'] : 'all_images' );

			if ( ! is_null( $post_image ) && 'post_image' == $share_behavior ) {
				$share_link = sprintf( 'https://pinterest.com/pin/create/button/?url=%1$s&media=%2$s&description=%3$s', $post_url, $post_image, $post_title );
			} else {
				$share_link = '#';
			}
			break;

		case 'linkedin':
			$share_link = sprintf( 'https://www.linkedin.com/shareArticle?url=%1$s&title=%2$s&summary=%3$s&mini=true', $post_url, $post_title, $post_description );
			break;

		case 'email':
			$share_link = sprintf( 'mailto:?subject=%1$s&amp;body=%2$s', $post_title, $post_url );
			break;

		case 'print':
			$share_link = '#';
			break;

		default:
			if ( function_exists('dpsp_get_pro_network_share_link' ) ) {
				$share_link = dpsp_get_pro_network_share_link( $network_slug, $post_url, $post_title, $post_image );
			} else {
				$share_link = '';
			}
			break;
	}

	return apply_filters( 'dpsp_get_network_share_link', $share_link, $network_slug );

}


/**
 * Returns the network follow link
 *
 * @param string $network_slug
 *
 * @return string
 *
 */
function dpsp_get_network_follow_link( $network_slug ) {

	$settings = Mediavine\Grow\Settings::get_setting( 'dpsp_settings', [] );

	// We need a network username or url
	if ( empty( $settings[ $network_slug . '_username' ] ) ) {
		return;
	}

	$network_handle = $settings[ $network_slug . '_username' ];

	// Default follow link is full link
	$follow_link = $network_handle;

	// If it is a network username
	if ( strpos( $network_handle, 'http' ) === false ) {

		switch ( $network_slug ) {

			case 'facebook':
				$follow_link = sprintf( 'https://www.facebook.com/%1$s', $network_handle );
				break;

			case 'twitter':
				$follow_link = sprintf( 'https://twitter.com/%1$s', $network_handle );
				break;

			case 'pinterest':
				$follow_link = sprintf( 'https://pinterest.com/%1$s', $network_handle );
				break;

			case 'linkedin':
				$follow_link = sprintf( 'https://www.linkedin.com/in/%1$s', $network_handle );
				break;

			default:
				if ( function_exists( 'dpsp_get_pro_network_follow_link' ) ) {
					$follow_link = dpsp_get_pro_network_follow_link( $network_slug, $network_handle );
				} else {
					$follow_link = '';
				}
				break;
		}
	}

	return apply_filters( 'dpsp_get_network_follow_link', $follow_link, $network_slug );
}


/**
 * Return Facebook, Pinterest and Pinterest networks if no active networks are present
 * on first ever activation of the plugin in order for the first ever cron job to pull
 * the share counts for these three social networks.
 *
 * Without this, the cron job will be executed later and at first no share counts will be
 * available for the last posts.
 *
 * @param array $networks
 * @param string $for
 *
 * @return array
 *
 */
function dpsp_first_activation_active_networks( $networks = [], $for = 'share' ) {

	if ( ! empty( $networks ) ) {
		return $networks;
	}

	if ( 'share' != $for ) {
		return $networks;
	}

	$first_activation = Mediavine\Grow\Settings::get_setting( 'dpsp_first_activation', '' );

	if ( ! empty( $first_activation ) ) {
		return $networks;
	}

	$networks = [ 'facebook', 'pinterest', 'pinterest' ];

	return $networks;

}



/**
 * Function that adds the initial options and settings
 *
 */
function dpsp_default_settings() {

	/*
	 * Add general settings
	 */
	$dpsp_settings = Mediavine\Grow\Settings::get_setting( 'dpsp_settings', [] );

	// Click to Tweet
	if ( ! isset( $dpsp_settings['shortening_service'] ) ) {
		$dpsp_settings['shortening_service'] = 'bitly';
	}

	if ( ! isset( $dpsp_settings['ctt_style'] ) ) {
		$dpsp_settings['ctt_style'] = 1;
	}

	if ( ! isset( $dpsp_settings['ctt_link_text'] ) ) {
		$dpsp_settings['ctt_link_text'] = 'Click to Tweet';
	}

	// Google Analytics UTM tracking
	if ( ! isset( $dpsp_settings['utm_source'] ) ) {
		$dpsp_settings['utm_source'] = '{{network_name}}';
	}

	if ( ! isset( $dpsp_settings['utm_medium'] ) ) {
		$dpsp_settings['utm_medium'] = 'social';
	}

	if ( ! isset( $dpsp_settings['utm_campaign'] ) ) {
		$dpsp_settings['utm_campaign'] = 'grow-social-pro';
	}

	// Update settings
	update_option( 'dpsp_settings', $dpsp_settings );

	/*
	 * Add default settings for each share buttons location
	 */
	$locations = dpsp_get_network_locations();

	foreach ( $locations as $location ) {

		$location_settings = Mediavine\Grow\Settings::get_setting( 'dpsp_location_' . $location, [] );

		if ( ! empty( $location_settings ) ) {
			continue;
		}

		// General settings for all locations
		$location_settings = [
			'networks'          => [],
			'button_style'      => 1,
			'display'           => [
				'shape' => 'rectangular',
				'size'  => 'medium',
			],
			'post_type_display' => [
				'post',
			],
		];

		// Individual settings per location
		switch ( $location ) {

			case 'sidebar':
				$location_settings['display']['position']       = 'left';
				$location_settings['display']['icon_animation'] = 'yes';
				break;

			case 'content':
				$location_settings['display']['position']       = 'top';
				$location_settings['display']['column_count']   = 'auto';
				$location_settings['display']['icon_animation'] = 'yes';
				$location_settings['display']['show_labels']    = 'yes';
				break;

			case 'sticky_bar':
				$location_settings['display']['screen_size']      = '720';
				$location_settings['display']['column_count']     = '3';
				$location_settings['display']['icon_animation']   = 'yes';
				$location_settings['display']['show_on_device']   = 'mobile';
				$location_settings['display']['position_desktop'] = 'bottom';
				$location_settings['display']['position_mobile']  = 'bottom';
				break;

			case 'pop_up':
				$location_settings['display']['icon_animation'] = 'yes';
				$location_settings['display']['show_labels']    = 'yes';
				$location_settings['display']['title']          = __( 'Sharing is Caring', 'social-pug' );
				$location_settings['display']['message']        = __( 'Help spread the word. You\'re awesome for doing it!', 'social-pug' );
				break;

			case 'follow_widget':
				$location_settings['display']['show_labels'] = 'yes';
				$location_settings['display']['show_mobile'] = 'yes';
				break;

		}

		// Update option with values
		update_option( 'dpsp_location_' . $location, $location_settings );

	}

}


/**
 * Connects to DevPups to return the status of the serial key
 *
 */
function dpsp_get_serial_key_status( $serial = '' ) {
	// @TODO Determine if this function is still needed and delete if not
	// Get serial from settings if the serial is not passed
	if ( empty( $serial ) ) {
		$dpsp_settings = Mediavine\Grow\Settings::get_setting( 'dpsp_settings' );
		$serial        = ( isset( $dpsp_settings['product_serial'] ) ? $dpsp_settings['product_serial'] : '' );
	}

	if ( empty( $serial ) ) {
		return null;
	}

	// Make request
	$request = wp_remote_get(
		add_query_arg(
			[
				'serial' => $serial,
				'action' => 'check_serial',
			],
			'http://updates.devpups.com'
		),
		[ 'timeout' => 30 ]
	);

	if ( is_wp_error( $request ) ) {
		$request = wp_remote_get(
			add_query_arg(
				[
					'serial' => $serial,
					'action' => 'check_serial',
				],
				'http://updates.devpups.com'
			),
			[
				'timeout'   => 30,
				'sslverify' => false,
			]
		);
	}

	if ( ! is_wp_error( $request ) && isset( $request['response']['code'] ) && $request['response']['code'] == 200 ) {
		$serial_status = trim( $request['body'] );

		return $serial_status;
	}

	return null;

}


/**
 * Determines whether to display the buttons for a location by checking if
 * the post has overwrite display option selected
 *
 */
function dpsp_post_location_overwrite_option( $return, $location_slug, $settings ) {

	$post_obj = dpsp_get_current_post();

	if ( ! $post_obj ) {
		return $return;
	}

	// Pull share options meta data
	$share_options = dpsp_maybe_unserialize( get_post_meta( $post_obj->ID, 'dpsp_share_options', true ) );

	if ( ! empty( $share_options['locations_overwrite'] ) && is_array( $share_options['locations_overwrite'] ) && in_array( $location_slug, $share_options['locations_overwrite'] ) ) {
		return false;
	}

	if ( ! empty( $share_options['locations_overwrite_show'] ) && is_array( $share_options['locations_overwrite_show'] ) && in_array( $location_slug, $share_options['locations_overwrite_show'] ) ) {
		return true;
	}

	return $return;

}

/*
 * Darkens a given color
 *
 */
function dpsp_darken_color( $rgb, $darker ) {

	$hash = ( strpos( $rgb, '#' ) !== false ) ? '#' : '';
	$rgb  = ( strlen( $rgb ) == 7 ) ? str_replace( '#', '', $rgb ) : ( ( strlen( $rgb ) == 6 ) ? $rgb : false );
	if ( strlen( $rgb ) != 6 ) {
		return $hash . '000000';
	}
	$darker = ( $darker > 1 ) ? $darker : 1;

	list( $R16, $G16, $B16 ) = str_split( $rgb, 2 );

	$R = sprintf( '%02X', floor( hexdec( $R16 ) / $darker ) );
	$G = sprintf( '%02X', floor( hexdec( $G16 ) / $darker ) );
	$B = sprintf( '%02X', floor( hexdec( $B16 ) / $darker ) );

	return $hash . $R . $G . $B;
}


/**
 * Removes the script tags from the values of an array recursivelly
 *
 * @param array $array
 *
 * @return array
 *
 */
function dpsp_array_strip_script_tags( $array = [] ) {

	if ( empty( $array ) || ! is_array( $array ) ) {
		return [];
	}

	foreach ( $array as $key => $value ) {

		if ( is_array( $value ) ) {
			$array[ $key ] = dpsp_array_strip_script_tags( $value );
		} else {
			$array[ $key ] = preg_replace( '@<(script)[^>]*?>.*?</\\1>@si', '', $value );
		}
	}

	return $array;

}


/**
 * Wrapper to WP's "attachment_url_to_postid" function, which also handles URLs for image sizes
 *
 * @param string $url
 *
 * @return int
 *
 */
function dpsp_attachment_url_to_postid( $url ) {

	/**
	 * Try to get post ID with given URL
	 *
	 */
	$post_id = attachment_url_to_postid( $url );

	/**
	 * Try to get post ID with URL image sizes stripped down
	 *
	 */
	if ( empty( $post_id ) ) {

		$dir  = wp_upload_dir();
		$path = $url;

		if ( 0 === strpos( $path, $dir['baseurl'] . '/' ) ) {
			$path = substr( $path, strlen( $dir['baseurl'] . '/' ) );
		}

		if ( preg_match( '/^(.*)(\-\d*x\d*)(\.\w{1,})/i', $path, $matches ) ) {
			$url     = $dir['baseurl'] . '/' . $matches[1] . $matches[3];
			$post_id = attachment_url_to_postid( $url );
		}
	}

	/**
	 * Try to get post ID with scaled image URL
	 *
	 */
	if ( empty( $post_id ) ) {

		$extension_pos = strrpos( $url, '.' );

		$url     = substr( $url, 0, $extension_pos ) . '-scaled' . substr( $url, $extension_pos );
		$post_id = attachment_url_to_postid( $url );

	}

	return absint( $post_id );

}


/**
 * Returns the SVG data for the provided icon slug
 *
 * @param string $icon_slug
 *
 * @return array
 *
 */
function dpsp_get_svg_icon_data( $icon_slug ) {

	$svg_icons = [
		'facebook'   => [
			'path'   => 'M17.12 0.224v4.704h-2.784q-1.536 0-2.080 0.64t-0.544 1.92v3.392h5.248l-0.704 5.28h-4.544v13.568h-5.472v-13.568h-4.544v-5.28h4.544v-3.904q0-3.328 1.856-5.152t4.96-1.824q2.624 0 4.064 0.224z',
			'width'  => 18,
			'height' => 32,
		],
		'twitter'    => [
			'path'   => 'M28.928 7.296q-1.184 1.728-2.88 2.976 0 0.256 0 0.736 0 2.336-0.672 4.64t-2.048 4.448-3.296 3.744-4.608 2.624-5.792 0.96q-4.832 0-8.832-2.592 0.608 0.064 1.376 0.064 4.032 0 7.168-2.464-1.888-0.032-3.36-1.152t-2.048-2.848q0.608 0.096 1.088 0.096 0.768 0 1.536-0.192-2.016-0.416-3.328-1.984t-1.312-3.68v-0.064q1.216 0.672 2.624 0.736-1.184-0.8-1.888-2.048t-0.704-2.752q0-1.568 0.8-2.912 2.176 2.656 5.248 4.256t6.656 1.76q-0.16-0.672-0.16-1.312 0-2.4 1.696-4.064t4.064-1.696q2.528 0 4.224 1.824 1.952-0.384 3.68-1.408-0.672 2.048-2.56 3.2 1.664-0.192 3.328-0.896z',
			'width'  => 30,
			'height' => 32,
		],
		'pinterest'  => [
			'path'   => 'M0 10.656q0-1.92 0.672-3.616t1.856-2.976 2.72-2.208 3.296-1.408 3.616-0.448q2.816 0 5.248 1.184t3.936 3.456 1.504 5.12q0 1.728-0.32 3.36t-1.088 3.168-1.792 2.656-2.56 1.856-3.392 0.672q-1.216 0-2.4-0.576t-1.728-1.568q-0.16 0.704-0.48 2.016t-0.448 1.696-0.352 1.28-0.48 1.248-0.544 1.12-0.832 1.408-1.12 1.536l-0.224 0.096-0.16-0.192q-0.288-2.816-0.288-3.36 0-1.632 0.384-3.68t1.184-5.152 0.928-3.616q-0.576-1.152-0.576-3.008 0-1.504 0.928-2.784t2.368-1.312q1.088 0 1.696 0.736t0.608 1.824q0 1.184-0.768 3.392t-0.8 3.36q0 1.12 0.8 1.856t1.952 0.736q0.992 0 1.824-0.448t1.408-1.216 0.992-1.696 0.672-1.952 0.352-1.984 0.128-1.792q0-3.072-1.952-4.8t-5.12-1.728q-3.552 0-5.952 2.304t-2.4 5.856q0 0.8 0.224 1.536t0.48 1.152 0.48 0.832 0.224 0.544q0 0.48-0.256 1.28t-0.672 0.8q-0.032 0-0.288-0.032-0.928-0.288-1.632-0.992t-1.088-1.696-0.576-1.92-0.192-1.92z',
			'width'  => 23,
			'height' => 32,
		],
		'linkedin'   => [
			'path'   => 'M6.24 11.168v17.696h-5.888v-17.696h5.888zM6.624 5.696q0 1.312-0.928 2.176t-2.4 0.864h-0.032q-1.472 0-2.368-0.864t-0.896-2.176 0.928-2.176 2.4-0.864 2.368 0.864 0.928 2.176zM27.424 18.72v10.144h-5.856v-9.472q0-1.888-0.736-2.944t-2.272-1.056q-1.12 0-1.856 0.608t-1.152 1.536q-0.192 0.544-0.192 1.44v9.888h-5.888q0.032-7.136 0.032-11.552t0-5.28l-0.032-0.864h5.888v2.56h-0.032q0.352-0.576 0.736-0.992t0.992-0.928 1.568-0.768 2.048-0.288q3.040 0 4.896 2.016t1.856 5.952z',
			'width'  => 27,
			'height' => 32,
		],
		'email'      => [
			'path'   => 'M18.56 17.408l8.256 8.544h-25.248l8.288-8.448 4.32 4.064zM2.016 6.048h24.32l-12.16 11.584zM20.128 15.936l8.224-7.744v16.256zM0 24.448v-16.256l8.288 7.776z',
			'width'  => 28,
			'height' => 32,
		],
		'print'      => [
			'path'   => 'M27.712 9.152c1.28 0 2.4 1.12 2.4 2.496v11.712c0 1.344-1.12 2.464-2.4 2.464h-2.432l1.088 4.896h-22.112l0.864-4.896h-2.624c-1.44 0-2.496-1.12-2.496-2.464v-11.712c0-1.376 1.056-2.496 2.496-2.496h3.072v-3.744h1.088v-4.128h16.864v4.128h1.088v3.744h3.104zM7.776 2.784v9.344h14.624v-9.344h-14.624zM4.16 15.232c0.96 0 1.76-0.768 1.76-1.728 0-0.896-0.8-1.696-1.76-1.696-0.928 0-1.728 0.8-1.728 1.696 0 0.96 0.8 1.728 1.728 1.728zM6.176 29.248h18.144l-1.504-7.744h-15.488zM14.24 25.632h-4.448v-1.12h4.448v1.12zM20.576 25.632h-4.448v-1.12h4.448v1.12z',
			'width'  => 30,
			'height' => 32,
		],
		'share'      => [
			'path'   => 'M20.8 20.8q1.984 0 3.392 1.376t1.408 3.424q0 1.984-1.408 3.392t-3.392 1.408-3.392-1.408-1.408-3.392q0-0.192 0.032-0.448t0.032-0.384l-8.32-4.992q-1.344 1.024-2.944 1.024-1.984 0-3.392-1.408t-1.408-3.392 1.408-3.392 3.392-1.408q1.728 0 2.944 0.96l8.32-4.992q0-0.128-0.032-0.384t-0.032-0.384q0-1.984 1.408-3.392t3.392-1.408 3.392 1.376 1.408 3.424q0 1.984-1.408 3.392t-3.392 1.408q-1.664 0-2.88-1.024l-8.384 4.992q0.064 0.256 0.064 0.832 0 0.512-0.064 0.768l8.384 4.992q1.152-0.96 2.88-0.96z',
			'width'  => 26,
			'height' => 32,
		],
		'cancel'     => [
			'path'   => 'M23.168 23.616q0 0.704-0.48 1.216l-2.432 2.432q-0.512 0.48-1.216 0.48t-1.216-0.48l-5.248-5.28-5.248 5.28q-0.512 0.48-1.216 0.48t-1.216-0.48l-2.432-2.432q-0.512-0.512-0.512-1.216t0.512-1.216l5.248-5.248-5.248-5.248q-0.512-0.512-0.512-1.216t0.512-1.216l2.432-2.432q0.512-0.512 1.216-0.512t1.216 0.512l5.248 5.248 5.248-5.248q0.512-0.512 1.216-0.512t1.216 0.512l2.432 2.432q0.48 0.48 0.48 1.216t-0.48 1.216l-5.248 5.248 5.248 5.248q0.48 0.48 0.48 1.216z',
			'width'  => 25,
			'height' => 32,
		],
	];

	if ( function_exists( 'dpsp_get_pro_svg_icon_data' ) ){
		$svg_icons = array_merge( $svg_icons, dpsp_get_pro_svg_icon_data());
	}

	return ( ! empty( $svg_icons[ $icon_slug ] ) ? $svg_icons[ $icon_slug ] : [] );

}


/**
 * Outputs the <svg> element corresponding to the provided icon
 *
 * @param string $icon_slug
 *
 * @return string
 *
 */
function dpsp_get_svg_icon_output( $icon_slug ) {

	$icon_data = dpsp_get_svg_icon_data( $icon_slug );

	if ( empty( $icon_data ) ) {
		return false;
	}

	$output  = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="' . absint( $icon_data['width'] ) . '" height="' . absint( $icon_data['height'] ) . '" viewBox="0 0 ' . absint( $icon_data['width'] ) . ' ' . absint( $icon_data['height'] ) . '">';
	$output .= '<path d="' . esc_attr( $icon_data['path'] ) . '"></path>';
	$output .= '</svg>';

	return $output;

}


/**
 * Attempts to recursively unserialize the given value
 *
 * @param mixed $value
 *
 * @return mixed
 *
 */
function dpsp_maybe_unserialize( $value ) {

	$index = 1;
	$type  = gettype( $value );

	while ( 'string' == $type ) {

		if ( $index >= 5 ) {
			break;
		}

		$value = maybe_unserialize( $value );
		$type  = gettype( $value );

		$index ++;

	}

	return $value;

}

function dpsp_get_svg_data_for_networks( $networks ) {
	$output = [];
	foreach ( $networks as $slug => $label ) {
		$output[ $slug ] = dpsp_get_svg_icon_data( $slug );
	}

	return $output;
}

/**
 * Register hooks for functions.php
 */
function dpsp_register_functions() {
	add_filter( 'dpsp_get_active_networks', 'dpsp_first_activation_active_networks', 10, 2 );
	add_filter( 'dpsp_is_location_displayable', 'dpsp_post_location_overwrite_option', 10, 3 );
}
