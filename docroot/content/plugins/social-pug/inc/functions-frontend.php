<?php

/**
 * Returns the social network buttons
 *
 * @param array $settings - the current section settings for the social networks
 * @param string $action - the action being taken
 * @param string $location - the location where the social networks will be displayed
 * @param array $data - data passed to class
 *
 * @return string
 */
function dpsp_get_output_network_buttons( $settings, $action = 'share', $location = '', $data = [] ) {
	$output = DPSP_Network_Buttons_Outputter::get_render( $settings, $action, $location, $data );

	return $output;

}


/**
 * Returns the HTML for the total share counts of the networks passed
 * If no networks are passed, the total count for all active networks will be outputed
 *
 * @param string $location - the location of the share buttons
 * @param array $networks - list with all networks we wish to output total for
 *
 * @return int
 */
function dpsp_get_output_total_share_count( $location = '', $networks = [] ) {

	$post_obj = dpsp_get_current_post();

	if ( ! $post_obj ) {
		return null;
	}

	$total_shares = dpsp_get_post_total_share_count( $post_obj->ID, $networks, $location );

	if ( is_null( $total_shares ) ) {
		return '';
	}

	// HTML output
	$output  = '<div class="dpsp-total-share-wrapper">';
	$output .= '<span class="dpsp-icon-total-share">' . dpsp_get_svg_icon_output( 'share' ) . '</span>';
	$output .= '<span class="dpsp-total-share-count">' . apply_filters( 'dpsp_get_output_total_share_count', $total_shares, $location ) . '</span>';
	$output .= '<span>' . apply_filters( 'dpsp_total_share_count_text', __( 'shares', 'social-pug' ) ) . '</span>';
	$output .= '</div>';

	return $output;
}


/**
 * Outputs custom inline CSS needed for certain functionality
 *
 */
function dpsp_output_inline_style() {

	// Styling default
	$output = '';

	/*
	 * Location: Mobile Sticky
	 */
	$dpsp_location_mobile = Mediavine\Grow\Settings::get_setting( 'dpsp_location_mobile' );

	if ( ! empty( $dpsp_location_mobile['active'] ) ) {
		$screen_size = (int) $dpsp_location_mobile['display']['screen_size'];

		$output .= '
				@media screen and ( min-width : ' . $screen_size . 'px ) {
					#dpsp-mobile-sticky.opened { display: none; }
				}
			';
	}

	/**
	 * Handle locations
	 */
	$locations = dpsp_get_network_locations();

	foreach ( $locations as $location ) {

		$location_settings = dpsp_get_location_settings( $location );

		// Jump to next one if location is not active
		if ( empty( $location_settings['active'] ) ) {
			continue;
		}

		/**
		 * Mobile display
		 */
		switch ( $location ) {

			case 'sidebar':
				$tool_html_selector = '#dpsp-floating-sidebar';
				break;

			case 'content':
				$tool_html_selector = '.dpsp-content-wrapper';
				break;

			case 'pop_up':
				$tool_html_selector = '#dpsp-pop';
				break;

			default:
				$tool_html_selector = '';
				break;

		}

		if ( ! empty( $tool_html_selector ) && empty( $location_settings['display']['show_mobile'] ) ) {

			$mobile_screen_width = ( ! empty( $location_settings['display']['screen_size'] ) ? (int) $location_settings['display']['screen_size'] : 720 );

			$output .= '
					@media screen and ( max-width : ' . $mobile_screen_width . 'px ) {
						' . $tool_html_selector . '.dpsp-hide-on-mobile { display: none !important; }
					}
				';

		}

		if ( ! empty( $tool_html_selector ) && empty( $location_settings['display']['show_mobile'] ) ) {

			$mobile_screen_width = ( ! empty( $location_settings['display']['screen_size'] ) ? (int) $location_settings['display']['screen_size'] : 720 );

			$output .= '
					@media screen and ( max-width : ' . $mobile_screen_width . 'px ) {
						.dpsp-share-text.dpsp-hide-on-mobile { display: none !important; }
					}
				';
		}
	}

	$output .= \Mediavine\Grow\Custom_Color::get_multiple_locations($locations);

	// Actually outputting the styling
	echo '<style type="text/css" data-source="Grow Social by Mediavine">' . esc_attr( apply_filters( 'dpsp_output_inline_style', $output ) ) . '</style>';

}

/**
 * Determine if a given Yoast Presenter class instance should be blocked from output
 * @param object $presenter Yoast presenter class instance
 *
 * @return bool
 */
function dpsp_yoast_present_should_block( $presenter ) {
	$base_namespace  = 'Yoast\WP\SEO\Presenters\\';
	$blocked_classes = [
		'Open_Graph\Locale_Presenter',
		'Open_Graph\Type_Presenter',
		'Open_Graph\Title_Presenter',
		'Open_Graph\Description_Presenter',
		'Open_Graph\Url_Presenter',
		'Open_Graph\Site_Name_Presenter',
		'Open_Graph\Article_Publisher_Presenter',
		'Open_Graph\Article_Author_Presenter',
		'Open_Graph\Article_Published_Time_Presenter',
		'Open_Graph\Article_Modified_Time_Presenter',
		'Open_Graph\Image_Presenter',
		'Open_Graph\FB_App_ID_Presenter',
		'Twitter\Card_Presenter',
		'Twitter\Title_Presenter',
		'Twitter\Description_Presenter',
		'Twitter\Image_Presenter',
		'Twitter\Creator_Presenter',
		'Twitter\Site_Presenter',
	];

	foreach ( $blocked_classes as $class ) {
		if ( class_exists( $base_namespace . $class ) && is_a( $presenter, $base_namespace . $class ) ) {
			return true;
		}
	}
	return false;
}

/**
 * Attemps to disable the outputting of know Open Graph and Twitter meta-tags
 * generated by other plugins. Plugins covered: Jetpack, Yoast SEO
 */
function dpsp_disable_known_meta_tags() {

	$settings = Mediavine\Grow\Settings::get_setting( 'dpsp_settings', [] );

	// Do nothing if the meta-tags option is disabled
	if ( ! empty( $settings['disable_meta_tags'] ) ) {
		return;
	}

	// Do nothing on singular pages
	if ( ! is_singular() ) {
		return;
	}

	// Check for current post
	$current_post = dpsp_get_current_post();

	if ( is_null( $current_post ) ) {
		return;
	}

	/**
	 * Disable Jackpack Open Graph tags
	 */
	add_filter( 'jetpack_enable_opengraph', '__return_false', 99 );
	add_filter( 'jetpack_enable_open_graph', '__return_false', 99 );

	/**
	 * Remove the Open Graph and Twitter tags added by Yoast
	 */
	if ( defined( 'WPSEO_VERSION' ) ) {

		global $wpseo_og;

		remove_action( 'wpseo_head', [ $wpseo_og, 'opengraph' ], 30 );
		remove_action( 'wpseo_head', [ 'WPSEO_Twitter', 'get_instance' ], 40 );
		add_filter(
			'wpseo_frontend_presenters',
			function ( $presenters ) {
				$pass = [];
				foreach ( $presenters as $presenter ) {
					if ( ! dpsp_yoast_present_should_block( $presenter ) ) {
						$pass[] = $presenter;
					}
				}
				return $pass;
			}
		);
	}

}

/**
 * Output the meta tags needed by the social networks
 */
function dpsp_output_meta_tags() {

	$settings = Mediavine\Grow\Settings::get_setting( 'dpsp_settings', [] );

	if ( ! empty( $settings['disable_meta_tags'] ) ) {
		return;
	}

	if ( ! is_singular() ) {
		return;
	}

	/**
	 * Get our own set of Open Graph tags
	 */
	$current_post = dpsp_get_current_post();

	if ( is_null( $current_post ) ) {
		return;
	}

	/**
	 * Get and set custom post Open Graph and Twitter values (Pro only feature)
	 */
	if ( ! Social_Pug::is_free() ) {
		$custom_og_title       = dpsp_get_post_custom_title( $current_post->ID );
		$custom_og_description = dpsp_get_post_custom_description( $current_post->ID );
		$custom_og_image_data  = dpsp_get_post_custom_image_data( $current_post->ID );
	}

	$custom_twitter_title       = '';
	$custom_twitter_description = '';
	$custom_twitter_image_data  = [];

	/**
	 * Get Yoast SEO set of Open Graph tags
	 *
	 * Given the large number of websites using Yoast, we'll do a check to see
	 * if Yoast is installed and if the user has added meta tags information in Yoast
	 */
	if ( defined( 'WPSEO_VERSION' ) ) {

		if ( empty( $custom_og_title ) || empty( $custom_og_description ) || empty( $custom_og_image_data ) ) {

			// Grab the Open Graph data saved into Yoast
			$yoast_og_title       = get_post_meta( $current_post->ID, '_yoast_wpseo_opengraph-title', true );
			$yoast_og_description = get_post_meta( $current_post->ID, '_yoast_wpseo_opengraph-description', true );

			// Replace the vars
			if ( function_exists( 'wpseo_replace_vars' ) ) {

				$yoast_og_title       = ( ! empty( $yoast_og_title ) ? wpseo_replace_vars( $yoast_og_title, $current_post ) : '' );
				$yoast_og_description = ( ! empty( $yoast_og_description ) ? wpseo_replace_vars( $yoast_og_description, $current_post ) : '' );

			}

			// Grab the Open Graph image data saved into Yoast
			$yoast_og_image_data = [];

			if ( class_exists( 'WPSEO_Image_Utils' ) ) {

				$yoast_og_image_url  = get_post_meta( $current_post->ID, '_yoast_wpseo_opengraph-image', true );
				$yoast_og_image_id   = WPSEO_Image_Utils::get_attachment_by_url( $yoast_og_image_url );
				$yoast_og_image_data = wp_get_attachment_image_src( $yoast_og_image_id, 'full' );

			}

			// Grab the Twitter data saved into Yoast
			$yoast_twitter_title       = get_post_meta( $current_post->ID, '_yoast_wpseo_twitter-title', true );
			$yoast_twitter_description = get_post_meta( $current_post->ID, '_yoast_wpseo_twitter-description', true );

			// Replace the vars
			if ( function_exists( 'wpseo_replace_vars' ) ) {

				$yoast_twitter_title       = ( ! empty( $yoast_twitter_title ) ? wpseo_replace_vars( $yoast_twitter_title, $current_post ) : '' );
				$yoast_twitter_description = ( ! empty( $yoast_twitter_description ) ? wpseo_replace_vars( $yoast_twitter_description, $current_post ) : '' );

			}

			// Grab the Twitter image data saved into Yoast
			$yoast_twitter_image_data = [];
			$yoast_twitter_image_url  = get_post_meta( $current_post->ID, '_yoast_wpseo_twitter-image', true );

			if ( ! empty( $yoast_twitter_image_url ) ) {
				$yoast_twitter_image_data[] = $yoast_og_image_url;
			}

			// Grab the Yoast general meta-data
			$yoast_meta_title       = get_post_meta( $current_post->ID, '_yoast_wpseo_title', true );
			$yoast_meta_description = get_post_meta( $current_post->ID, '_yoast_wpseo_metadesc', true );

			// Replace the vars
			if ( function_exists( 'wpseo_replace_vars' ) ) {

				$yoast_meta_title       = ( ! empty( $yoast_meta_title ) ? wpseo_replace_vars( $yoast_meta_title, $current_post ) : '' );
				$yoast_meta_description = ( ! empty( $yoast_meta_description ) ? wpseo_replace_vars( $yoast_meta_description, $current_post ) : '' );

			}

			// Overwrite the Yoast OG and Twitter if they are empty with the Yoast general meta
			$yoast_og_title       = ( ! empty( $yoast_og_title ) ? $yoast_og_title : $yoast_meta_title );
			$yoast_og_description = ( ! empty( $yoast_og_description ) ? $yoast_og_description : $yoast_meta_description );

			$yoast_twitter_title       = ( ! empty( $yoast_twitter_title ) ? $yoast_twitter_title : $yoast_meta_title );
			$yoast_twitter_description = ( ! empty( $yoast_twitter_description ) ? $yoast_twitter_description : $yoast_meta_description );

			// Overwrite custom data with the Yoast data
			$custom_og_title       = ( ! empty( $custom_og_title ) ? $custom_og_title : $yoast_og_title );
			$custom_og_description = ( ! empty( $custom_og_description ) ? $custom_og_description : $yoast_og_description );
			$custom_og_image_data  = ( ! empty( $custom_og_image_data ) ? $custom_og_image_data : $yoast_og_image_data );

			$custom_twitter_title       = ( ! empty( $custom_twitter_title ) ? $custom_twitter_title : $yoast_twitter_title );
			$custom_twitter_description = ( ! empty( $custom_twitter_description ) ? $custom_twitter_description : $yoast_twitter_description );
			$custom_twitter_image_data  = ( ! empty( $custom_twitter_image_data ) ? $custom_twitter_image_data : $yoast_twitter_image_data );

		}
	}

	/**
	 * Set final Open Graph and Twitter values
	 */
	$og_url = dpsp_get_post_url( $current_post->ID );

	$og_title       = ( ! empty( $custom_og_title ) ? $custom_og_title : dpsp_get_post_title( $current_post->ID ) );
	$og_description = ( ! empty( $custom_og_description ) ? $custom_og_description : dpsp_get_post_description( $current_post->ID ) );
	$og_image_data  = ( ! empty( $custom_og_image_data ) ? $custom_og_image_data : dpsp_get_post_image_data( $current_post->ID ) );

	$twitter_title       = ( ! empty( $custom_twitter_title ) ? $custom_twitter_title : $og_title );
	$twitter_description = ( ! empty( $custom_twitter_description ) ? $custom_twitter_description : $og_description );
	$twitter_image_data  = ( ! empty( $custom_twitter_image_data ) ? $custom_twitter_image_data : $og_image_data );

	// Begin output
	echo '<!-- Grow Social by Mediavine v.' . DPSP_VERSION . ' https://marketplace.mediavine.com/grow-social-pro/ -->';

	/**
	 * Open Graph tags
	 */
	echo PHP_EOL . '<meta property="og:locale" content="' . esc_attr( get_locale() ) . '"/>';
	echo PHP_EOL . '<meta property="og:type" content="article" />';
	echo PHP_EOL . '<meta property="og:title" content="' . esc_attr( sanitize_text_field( $og_title ) ) . '" />';
	echo PHP_EOL . '<meta property="og:description" content="' . esc_attr( sanitize_text_field( $og_description ) ) . '" />';
	echo PHP_EOL . '<meta property="og:url"	content="' . esc_attr( $og_url ) . '" />';
	echo PHP_EOL . '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '" />';
	echo PHP_EOL . '<meta property="og:updated_time" content="' . date( 'c', strtotime( $current_post->post_modified ) ) . '" />';
	echo PHP_EOL . '<meta property="article:published_time" content="' . date( 'c', strtotime( $current_post->post_date ) ) . '" />';
	echo PHP_EOL . '<meta property="article:modified_time" content="' . date( 'c', strtotime( $current_post->post_modified ) ) . '" />';

	if ( ! is_null( $og_image_data ) && is_array( $og_image_data ) ) {

		echo PHP_EOL . '<meta property="og:image" content="' . esc_attr( $og_image_data[0] ) . '" />';

		if ( ! empty( $og_image_data[1] ) ) {
			echo PHP_EOL . '<meta property="og:image:width" content="' . esc_attr( $og_image_data[1] ) . '" />';
		}

		if ( ! empty( $og_image_data[2] ) ) {
			echo PHP_EOL . '<meta property="og:image:height" content="' . esc_attr( $og_image_data[2] ) . '" />';
		}
	}

	/**
	 * Yoast extra Open Graph tags that are not handled by Grow Social by Mediavine
	 */
	$facebook = apply_filters( 'wpseo_opengraph_author_facebook', get_the_author_meta( 'facebook', $current_post->post_author ) );

	if ( $facebook && ( is_string( $facebook ) && '' !== $facebook ) ) {
		echo PHP_EOL . '<meta property="article:author" content ="' . esc_attr( $facebook ) . '" />';
	}

	/**
	 * Facebook specific tags
	 */
	if ( ! empty( $settings['facebook_app_id'] ) ) {
		echo PHP_EOL . '<meta property="fb:app_id" content ="' . esc_attr( $settings['facebook_app_id'] ) . '" />';
	}

	/**
	 * Twitter specific tags
	 */
	echo PHP_EOL . '<meta name="twitter:card" content="summary_large_image" />';
	echo PHP_EOL . '<meta name="twitter:title" content="' . esc_attr( sanitize_text_field( $twitter_title ) ) . '" />';
	echo PHP_EOL . '<meta name="twitter:description" content="' . esc_attr( sanitize_text_field( $twitter_description ) ) . '" />';

	if ( ! is_null( $twitter_image_data ) && is_array( $twitter_image_data ) ) {

		echo PHP_EOL . '<meta name="twitter:image" content="' . esc_attr( $twitter_image_data[0] ) . '" />';

	}

	/**
	 * Yoast extra Twitter tags that are not handled by Social Pug
	 */
	$twitter = apply_filters( 'wpseo_twitter_creator_account', ltrim( trim( get_the_author_meta( 'twitter', $current_post->post_author ) ), '@' ) );

	if ( is_string( $twitter ) && '' !== $twitter ) {
		echo PHP_EOL . '<meta name="twitter:creator" content="' . '@' . esc_attr( $twitter ) . '" />';
	}

	/**
	 * Output extra meta tags
	 */
	do_action( 'dpsp_output_meta_tags' );

	// End output
	echo PHP_EOL . '<!-- Grow Social by Mediavine v.' . esc_attr( DPSP_VERSION ) . ' https://marketplace.mediavine.com/grow-social-pro/ -->' . PHP_EOL;

}


/**
 * Given the importance of Yoast, we will take it into account when printing the meta-tags
 *
 * If it's activated, print the meta-tags in exactly the same place it prints them, as we will remove the ones
 * printed by them
 */
function dpsp_set_hook_output_meta_tags() {

	if ( defined( 'WPSEO_VERSION' ) ) {
		add_action( 'wpseo_head', 'dpsp_output_meta_tags', 30 );

	} else {
		add_action( 'wp_head', 'dpsp_output_meta_tags', 1 );
	}

}

/**
 * Returns the HTML string for the social share buttons
 *
 * @param array $args
 *
 * Arguments array elements
 *
 * 'id'                     - string
 * 'networks'               - array
 * 'networks_labels'        - array
 * 'button_style'           - int (from 1 to 8)
 * 'shape'                  - string (rectangle/rounded/circle)
 * 'size'                   - string (small/medium/large)
 * 'columns'                - string (auto) / int (from 1 to 6),
 * 'show_labels'            - bool
 * 'button_spacing'         - bool
 * 'show_count'             - bool
 * 'show_total_count'       - bool
 * 'total_count_position'   - string (before/after)
 * 'count_round'            - bool
 * 'minimum_count'          - int
 * 'minimum_individual_count'           - int
 * 'show_mobile'            - bool
 * 'overwrite'              - bool
 *
 * @return string
 */
function dpsp_get_share_buttons( $args = [] ) {

	/*
	 * Modify settings based on the attributes
	 *
	 */
	$settings = [];

	// Set networks and network labels
	if ( ! empty( $args['networks'] ) ) {

		$networks        = array_map( 'trim', $args['networks'] );
		$networks_labels = ( ! empty( $args['networks_labels'] ) ? $args['networks_labels'] : [] );

		// Set the array with the networks slug and labels
		foreach ( $networks as $key => $network_slug ) {
			$networks[ $network_slug ]['label'] = ( isset( $networks_labels[ $key ] ) ? $networks_labels[ $key ] : dpsp_get_network_name( $network_slug ) );
			unset( $networks[ $key ] );
		}

		$settings['networks'] = $networks;

	}

	// Set button style
	if ( ! empty( $args['button_style'] ) ) {
		$settings['button_style'] = $args['button_style'];
	}
	// If no style is set, set the default to the first style
	if ( ! isset( $settings['button_style'] ) ) {
		$settings['button_style'] = 1;
	}

	// Set buttons shape
	if ( ! empty( $args['shape'] ) ) {
		$settings['display']['shape'] = $args['shape'];
	}

	// Set buttons size
	if ( ! empty( $args['size'] ) ) {
		$settings['display']['size'] = $args['size'];
	}

	// Set columns
	if ( ! empty( $args['columns'] ) ) {
		$settings['display']['column_count'] = $args['columns'];
	}

	// Show labels
	if ( isset( $args['show_labels'] ) ) {
		$settings['display']['show_labels'] = ( ! empty( $args['show_labels'] ) ? 'yes' : 'no' );
	}

	// Button spacing
	if ( isset( $args['button_spacing'] ) ) {
		$settings['display']['spacing'] = ( ! empty( $args['button_spacing'] ) ? 'yes' : 'no' );
	}

	// Show count
	if ( isset( $args['show_count'] ) ) {
		$settings['display']['show_count'] = ( ! empty( $args['show_count'] ) ? 'yes' : 'no' );
	}

	// Show count total
	if ( isset( $args['show_total_count'] ) ) {
		$settings['display']['show_count_total'] = ( ! empty( $args['show_total_count'] ) ? 'yes' : 'no' );
	}

	// Total count position
	if ( ! empty( $args['total_count_position'] ) ) {
		$settings['display']['total_count_position'] = $args['total_count_position'];
	}

	// Share counts round
	if ( isset( $args['count_round'] ) ) {
		$settings['display']['count_round'] = ( ! empty( $args['count_round'] ) ? 'yes' : 'no' );
	}

	// Share minimum global count
	if ( ! empty( $args['minimum_count'] ) ) {
		$settings['display']['minimum_count'] = (int) $args['minimum_count'];
	}

	// Share minimum individual count
	if ( ! empty( $args['minimum_individual_count'] ) ) {
		$settings['display']['minimum_individual_count'] = (int) $args['minimum_individual_count'];
	}

	// Show on mobile
	if ( isset( $args['show_mobile'] ) ) {
		$settings['display']['show_mobile'] = ( ! empty( $args['show_mobile'] ) ? 'yes' : 'no' );
	}

	// If Overwrite is set to "yes" strip everything
	if ( empty( $args['overwrite'] ) ) {

		// Location settings for the Content location
		$saved_settings = dpsp_get_location_settings( 'content' );

		// Social networks
		$settings['networks'] = ( ! empty( $settings['networks'] ) ? $settings['networks'] : $saved_settings['networks'] );

		// Display settings
		$settings['display'] = array_merge( $saved_settings['display'], $settings['display'] );

	}

	// Remove all display settings that have "no" as a value
	foreach ( $settings['display'] as $key => $value ) {
		if ( 'no' == $value ) {
			unset( $settings['display'][ $key ] );
		}
	}

	// Round counts cannot be changed direcly because they are too dependend
	// on the location settings saved in the database.
	// For the moment removing the filters and adding them again is the only solution
	if ( ! isset( $settings['display']['count_round'] ) ) {
		remove_filter( 'dpsp_get_output_post_shares_counts', 'dpsp_round_share_counts', 10, 2 );
		remove_filter( 'dpsp_get_output_total_share_count', 'dpsp_round_share_counts', 10, 2 );
	}

	/*
	 * Start outputing
	 *
	 */
	$output = '';

	// Classes for the wrapper
	$wrapper_classes   = [ 'dpsp-share-buttons-wrapper' ];
	$wrapper_classes[] = ( isset( $settings['display']['shape'] ) ? 'dpsp-shape-' . $settings['display']['shape'] : '' );
	$wrapper_classes[] = ( isset( $settings['display']['size'] ) ? 'dpsp-size-' . $settings['display']['size'] : 'dpsp-size-medium' );
	$wrapper_classes[] = ( isset( $settings['display']['column_count'] ) ? 'dpsp-column-' . $settings['display']['column_count'] : '' );
	$wrapper_classes[] = ( isset( $settings['display']['spacing'] ) ? 'dpsp-has-spacing' : '' );
	$wrapper_classes[] = ( isset( $settings['display']['show_labels'] ) || isset( $settings['display']['show_count'] ) ? '' : 'dpsp-no-labels' );
	$wrapper_classes[] = ( isset( $settings['display']['show_count'] ) ? 'dpsp-has-buttons-count' : '' );
	$wrapper_classes[] = ( isset( $settings['display']['show_mobile'] ) ? 'dpsp-show-on-mobile' : 'dpsp-hide-on-mobile' );

	// Button total share counts
	$minimum_count    = ( ! empty( $settings['display']['minimum_count'] ) ? (int) $settings['display']['minimum_count'] : 0 );
	$show_total_count = ( $minimum_count <= (int) dpsp_get_post_total_share_count() && ! empty( $settings['display']['show_count_total'] ) ? true : false );

	$wrapper_classes[] = ( $show_total_count ? 'dpsp-show-total-share-count' : '' );
	$wrapper_classes[] = ( $show_total_count ? ( ! empty( $settings['display']['total_count_position'] ) ? 'dpsp-show-total-share-count-' . $settings['display']['total_count_position'] : 'dpsp-show-total-share-count-before' ) : '' );

	// Button styles
	$wrapper_classes[] = ( isset( $settings['button_style'] ) ? 'dpsp-button-style-' . $settings['button_style'] : '' );

	$wrapper_classes = implode( ' ', array_filter( $wrapper_classes ) );

	// Output total share counts
	if ( $show_total_count ) {
		$output .= dpsp_get_output_total_share_count( 'content' );
	}

	// Gets the social network buttons
	if ( isset( $settings['networks'] ) ) {
		$output .= dpsp_get_output_network_buttons( $settings, 'share', 'content' );
	}

	$output = '<div ' . ( ! empty( $args['id'] ) ? 'id="' . esc_attr( $args['id'] ) . '"' : '' ) . ' class="' . $wrapper_classes . '">' . $output . '</div>';

	// Add back the filters
	if ( ! isset( $settings['display']['count_round'] ) ) {
		add_filter( 'dpsp_get_output_post_shares_counts', 'dpsp_round_share_counts', 10, 2 );
		add_filter( 'dpsp_get_output_total_share_count', 'dpsp_round_share_counts', 10, 2 );
	}

	return $output;

}

/**
 * Register hooks for functions-frontend.php
 */
function dpsp_register_functions_frontend() {
	add_action( 'wp_head', 'dpsp_disable_known_meta_tags', 1 );
	add_action( 'wp', 'dpsp_set_hook_output_meta_tags', 10 );
	add_action( 'wp_head', 'dpsp_output_inline_style' );
}
