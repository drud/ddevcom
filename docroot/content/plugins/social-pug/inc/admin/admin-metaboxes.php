<?php
/**
 * Meta-boxes file
 */

/**
 * Individual posts share statistics meta-box.
 */
function dpsp_meta_boxes() {

	$screens  = get_post_types( [ 'public' => true ] );
	$settings = Mediavine\Grow\Settings::get_setting( 'dpsp_settings', [] );

	if ( empty( $screens ) ) {
		return;
	}

	// Remove the attachment post type
	if ( ! empty( $screens['attachment'] ) ) {
		unset( $screens['attachment'] );
	}

	foreach ( $screens as $screen ) {
		// Share option meta-box (Pro only)
		if ( ! Social_Pug::is_free() ) {
			add_meta_box( 'dpsp_share_options', __( 'Grow: Share Options', 'social-pug' ), 'dpsp_share_options_output', $screen, 'normal', 'core' );
		}

		// Share statistics meta-box
		add_meta_box( 'dpsp_share_statistics', __( 'Grow: Share Statistics', 'social-pug' ), 'dpsp_share_statistics_output', $screen, 'normal', 'core' );

		// Add debugger metabox
		if ( ! empty( $settings['debugger_enabled'] ) ) {
			add_meta_box( 'dpsp_post_debugger', __( 'Grow: Debug Log', 'social-pug' ), 'dpsp_post_debugger_output', $screen, 'normal', 'core' );
		}
	}

}

/**
 * Callback for the Share Options meta box
 *
 */
function dpsp_share_options_output( $post ) {

	// Get general settings
	$settings           = Mediavine\Grow\Settings::get_setting( 'dpsp_settings', [] );
	$pinterest_settings = Mediavine\Grow\Settings::get_setting( 'dpsp_pinterest_share_images_setting', [] );

	// Pull share options meta data
	$share_options = dpsp_maybe_unserialize( get_post_meta( $post->ID, 'dpsp_share_options', true ) );

	if ( empty( $share_options ) || ! is_array( $share_options ) ) {
		$share_options = [];
	}

	// Nonce field
	wp_nonce_field( 'dpsp_meta_box', 'dpsptkn' );

	/**
	 * New version
	 *
	 */
	echo '<div id="dpsp_share_options_content">';

		// General social media content
		echo '<div class="dpsp-section">';

			// Social media image
			echo '<div class="dpsp-setting-field-wrapper dpsp-setting-field-image">';
				echo '<label for="dpsp_share_options[custom_image]">' . '<span class="dpsp-icon-share"></span>' . __( 'Social Media Image', 'social-pug' );
					echo dpsp_output_backend_tooltip( __( 'Add an image that will populate the "og:image" Open Graph meta tag. For maximum exposure on Facebook, Google+ or LinkedIn we recommend an image size of 1200px X 630px.', 'social-pug' ) );
				echo '</label>';
				echo '<div>';

					$thumb_details = [];
					$image_details = [];

					if ( ! empty( $share_options['custom_image']['id'] ) ) {
						$thumb_details = wp_get_attachment_image_src( $share_options['custom_image']['id'], 'high' );
						$image_details = wp_get_attachment_image_src( $share_options['custom_image']['id'], 'full' );
					}

					if ( ! empty( $thumb_details[0] ) && ! empty( $image_details[0] ) ) {
						$thumb_src = $thumb_details[0];
						$image_src = $image_details[0];
					} else {
						$thumb_src = DPSP_PLUGIN_DIR_URL . 'assets/dist/custom-social-media-image.' . DPSP_VERSION . '.png';
						$image_src = '';
					}

					echo '<div>';
						echo '<img src="' . esc_attr( $thumb_src ) . '" data-pin-nopin="true" />';
						echo '<span class="dpsp-field-image-placeholder" data-src="' . DPSP_PLUGIN_DIR_URL . 'assets/dist/custom-social-media-image.' . DPSP_VERSION . '.png"></span>';
					echo '</div>';

					echo '<a class="dpsp-image-select dpsp-button-primary ' . ( ! empty( $share_options['custom_image']['id'] ) ? 'dpsp-hidden' : '' ) . '" href="#">' . __( 'Select Image', 'social-pug' ) . '</a>';
					echo '<a class="dpsp-image-remove dpsp-button-secondary ' . ( empty( $share_options['custom_image']['id'] ) ? 'dpsp-hidden' : '' ) . '" href="#">' . __( 'Remove Image', 'social-pug' ) . '</a>';

					echo '<input class="dpsp-image-id" type="hidden" name="dpsp_share_options[custom_image][id]" value="' . ( ! empty( $share_options['custom_image']['id'] ) ? esc_attr( $share_options['custom_image']['id'] ) : '' ) . '" />';
					echo '<input class="dpsp-image-src" type="hidden" name="dpsp_share_options[custom_image][src]" value="' . esc_attr( $image_src ) . '" />';

				echo '</div>';
			echo '</div>';

			// Social media title
			echo '<div class="dpsp-setting-field-wrapper">';

				$maximum_count   = 70;
				$current_count   = ( ! empty( $share_options['custom_title'] ) ? strlen( wp_kses_post( $share_options['custom_title'] ) ) : 0 );
				$remaining_count = $maximum_count - $current_count;

				echo '<label for="dpsp_share_options[custom_title]">' . '<span class="dpsp-icon-share"></span>' . __( 'Social Media Title', 'social-pug' ) . '<span class="dpsp-textarea-characters-remaining-wrapper" data-maximum-count="' . $maximum_count . '"><span class="dpsp-textarea-characters-remaining">' . $remaining_count . '</span> ' . __( 'Characters Remaining', 'social-pug' ) . '</span>';
					echo dpsp_output_backend_tooltip( __( 'Add a title that will populate the "og:title" Open Graph meta tag. This will be used when users share your content on Facebook, Google+ or LinkedIn. The title of the post will be used if this field is empty.', 'social-pug' ) );
				echo '</label>';
				echo '<textarea id="dpsp_share_options[custom_title]" name="dpsp_share_options[custom_title]" placeholder="' . __( 'Write a social media title...', 'social-pug' ) . '">' . ( isset( $share_options['custom_title'] ) ? wp_kses_post( $share_options['custom_title'] ) : '' ) . '</textarea>';
			echo '</div>';

			// Social media description
			echo '<div class="dpsp-setting-field-wrapper">';

				$maximum_count   = 200;
				$current_count   = ( ! empty( $share_options['custom_description'] ) ? strlen( wp_kses_post( $share_options['custom_description'] ) ) : 0 );
				$remaining_count = $maximum_count - $current_count;

				echo '<label for="dpsp_share_options[custom_description]">' . '<span class="dpsp-icon-share"></span>' . __( 'Social Media Description', 'social-pug' ) . '<span class="dpsp-textarea-characters-remaining-wrapper" data-maximum-count="' . $maximum_count . '"><span class="dpsp-textarea-characters-remaining">' . $remaining_count . '</span> ' . __( 'Characters Remaining', 'social-pug' ) . '</span>';
					echo dpsp_output_backend_tooltip( __( 'Add a description that will populate the "og:description" Open Graph meta tag. This will be used when users share your content on Facebook, Google+ or LinkedIn.', 'social-pug' ) );
				echo '</label>';
				echo '<textarea id="dpsp_share_options[custom_description]" name="dpsp_share_options[custom_description]" placeholder="' . __( 'Write a social media description...', 'social-pug' ) . '">' . ( isset( $share_options['custom_description'] ) ? wp_kses_post( $share_options['custom_description'] ) : '' ) . '</textarea>';
			echo '</div>';

		echo '</div>';

		// Individual networks social media content
		echo '<div class="dpsp-section">';

			// Pinterest image
			echo '<div class="dpsp-setting-field-wrapper dpsp-setting-field-image">';
				echo '<label for="dpsp_share_options[custom_image_pinterest]">' . '<span class="dpsp-icon-pinterest"></span>' . __( 'Pinterest Image', 'social-pug' );
					echo dpsp_output_backend_tooltip( __( 'Add an image that will be used when this post is shared on Pinterest. For maximum exposure we recommend using an image that has a 2:3 aspect ratio, for example 800px X 1200px.', 'social-pug' ) );
				echo '</label>';
				echo '<div>';

					$thumb_details = [];
					$image_details = [];

					if ( ! empty( $share_options['custom_image_pinterest']['id'] ) ) {
						$thumb_details = wp_get_attachment_image_src( $share_options['custom_image_pinterest']['id'], 'high' );
						$image_details = wp_get_attachment_image_src( $share_options['custom_image_pinterest']['id'], 'full' );
					}

					if ( ! empty( $thumb_details[0] ) && ! empty( $image_details[0] ) ) {
						$thumb_src = $thumb_details[0];
						$image_src = $image_details[0];
					} else {
						$thumb_src = DPSP_PLUGIN_DIR_URL . 'assets/dist/custom-social-media-image-pinterest.' . DPSP_VERSION . '.png';
						$image_src = '';
					}

					echo '<div>';
						echo '<img src="' . esc_attr( $thumb_src ) . '" data-pin-nopin="true" />';
						echo '<span class="dpsp-field-image-placeholder" data-src="' . DPSP_PLUGIN_DIR_URL . 'assets/dist/custom-social-media-image-pinterest.' . DPSP_VERSION . '.png"></span>';
					echo '</div>';

					echo '<a class="dpsp-image-select dpsp-button-primary ' . ( ! empty( $share_options['custom_image_pinterest']['id'] ) ? 'dpsp-hidden' : '' ) . '" href="#">' . __( 'Select Image', 'social-pug' ) . '</a>';
					echo '<a class="dpsp-image-remove dpsp-button-secondary ' . ( empty( $share_options['custom_image_pinterest']['id'] ) ? 'dpsp-hidden' : '' ) . '" href="#">' . __( 'Remove Image', 'social-pug' ) . '</a>';

					echo '<input class="dpsp-image-id" type="hidden" name="dpsp_share_options[custom_image_pinterest][id]" value="' . ( ! empty( $share_options['custom_image_pinterest']['id'] ) ? esc_attr( $share_options['custom_image_pinterest']['id'] ) : '' ) . '" />';
					echo '<input class="dpsp-image-src" type="hidden" name="dpsp_share_options[custom_image_pinterest][src]" value="' . esc_attr( $image_src ) . '" />';

				echo '</div>';
			echo '</div>';

			// Pinterest title
			echo '<div class="dpsp-setting-field-wrapper">';

				$maximum_count   = 70;
				$current_count   = ( ! empty( $share_options['custom_title_pinterest'] ) ? strlen( wp_kses_post( $share_options['custom_title_pinterest'] ) ) : 0 );
				$remaining_count = $maximum_count - $current_count;

				echo '<label for="dpsp_share_options[custom_title_pinterest]">' . '<span class="dpsp-icon-pinterest"></span>' . __( 'Pinterest Title', 'social-pug' ) . '<span class="dpsp-textarea-characters-remaining-wrapper" data-maximum-count="' . $maximum_count . '"><span class="dpsp-textarea-characters-remaining">' . $remaining_count . '</span> ' . __( 'Characters Remaining', 'social-pug' ) . '</span></label>';
				echo '<textarea id="dpsp_share_options[custom_title_pinterest]" name="dpsp_share_options[custom_title_pinterest]" placeholder="' . __( 'Write a custom Pinterest title...', 'social-pug' ) . '">' . ( isset( $share_options['custom_title_pinterest'] ) ? wp_kses_post( $share_options['custom_title_pinterest'] ) : '' ) . '</textarea>';
				echo '<p class="description">' . __( "Please note: Pinterest does not yet support pin titles. Pinterest is still in the process of releasing this feature. We've added the field in advance, to make sure you're ready for when the feature rolls out.", 'social-pug' ) . '</p>';
			echo '</div>';

			// Pinterest description
			echo '<div class="dpsp-setting-field-wrapper">';

				$maximum_count   = 500;
				$current_count   = ( ! empty( $share_options['custom_description_pinterest'] ) ? strlen( wp_kses_post( $share_options['custom_description_pinterest'] ) ) : 0 );
				$remaining_count = $maximum_count - $current_count;

				echo '<label for="dpsp_share_options[custom_description_pinterest]">' . '<span class="dpsp-icon-pinterest"></span>' . __( 'Pinterest Description', 'social-pug' ) . '<span class="dpsp-textarea-characters-remaining-wrapper" data-maximum-count="' . $maximum_count . '"><span class="dpsp-textarea-characters-remaining">' . $remaining_count . '</span> ' . __( 'Characters Remaining', 'social-pug' ) . '</span>';
					echo dpsp_output_backend_tooltip( __( 'Add a customized message that will be used when this post is shared on Pinterest.', 'social-pug' ) );
				echo '</label>';
				echo '<textarea id="dpsp_share_options[custom_description_pinterest]" name="dpsp_share_options[custom_description_pinterest]" placeholder="' . __( 'Write a custom Pinterest description...', 'social-pug' ) . '">' . ( isset( $share_options['custom_description_pinterest'] ) ? wp_kses_post( $share_options['custom_description_pinterest'] ) : '' ) . '</textarea>';
			echo '</div>';

			// Twitter custom tweet
			echo '<div class="dpsp-setting-field-wrapper">';

				$has_via   = ! empty( $settings['twitter_username'] ) && ! empty( $settings['tweets_have_username'] );
				$tweet_via = $has_via ? ' via @' . $settings['twitter_username'] : '';

				$tweet_meta_content_length = 24 + strlen( $tweet_via ); /* 23 is the lenth of the URL as Twitter sees it + 1 for the empty space before it */

				$maximum_count   = apply_filters( 'dpsp_tweet_maximum_count', 280 ) - $tweet_meta_content_length;
				$current_count   = ( ! empty( $share_options['custom_tweet'] ) ? strlen( wp_kses_post( $share_options['custom_tweet'] ) ) : 0 );
				$remaining_count = $maximum_count - $current_count;

				echo '<label for="dpsp_share_options[custom_tweet]">' . '<span class="dpsp-icon-twitter"></span>' . __( 'Custom Tweet', 'social-pug' ) . '<span class="dpsp-textarea-characters-remaining-wrapper" data-maximum-count="' . $maximum_count . '"><span class="dpsp-textarea-characters-remaining">' . $remaining_count . '</span> ' . __( 'Characters Remaining', 'social-pug' ) . '</span>';
					echo dpsp_output_backend_tooltip( __( 'Add a customized tweet that will be used when this post is shared on Twitter.', 'social-pug' ) );
				echo '</label>';
				echo '<textarea id="dpsp_share_options[custom_tweet]" name="dpsp_share_options[custom_tweet]" placeholder="' . __( 'Write a custom tweet...', 'social-pug' ) . '">' . ( isset( $share_options['custom_tweet'] ) ? wp_kses_post( $share_options['custom_tweet'] ) : '' ) . '</textarea>';
				echo '<p class="description">' . __( 'Maximum characters is based off of the Twitter maximum, the post permalink, and whether your Twitter username is included in the tweet.', 'social-pug' ) . '</p>';
			echo '</div>';

		echo '</div>';

		// Multiple hidden Pinterest images section
		if ( ! empty( $pinterest_settings['share_image_post_multiple_hidden_pinterest_images'] ) ) {

			// Add nonce
			wp_nonce_field( 'dpsp_save_multiple_pinterest_images', 'dpsp_save_multiple_pinterest_images', false );

			echo '<div id="dpsp-meta-box-section-multiple-pinterest-images" class="dpsp-section">';

				echo '<div class="dpsp-setting-field-wrapper">';

					echo '<label>' . '<span class="dpsp-icon-pinterest"></span>' . __( 'Pinterest Hidden Images', 'social-pug' ) . '</label>';

					$hidden_images = dpsp_maybe_unserialize( get_post_meta( $post->ID, 'dpsp_pinterest_hidden_images', true ) );
					$hidden_images = ( ! empty( $hidden_images ) && is_array( $hidden_images ) ? $hidden_images : [] );

					// Add the image thumbnails
					foreach ( $hidden_images as $image_id ) {

						$image_src = wp_get_attachment_image_src( $image_id, 'thumbnail' );

						if ( empty( $image_src[0] ) ) {
							continue;
						}

						echo '<div class="dpsp-hidden-image-wrapper" data-image-id="' . absint( $image_id ) . '">';

							// Image thumbnail
							echo '<img src="' . esc_url( $image_src[0] ) . '" data-pin-nopin="true" />';

							// Remove image button
							echo '<a href="#" class="dpsp-button-secondary" title="' . __( 'Remove image', 'social-pug' ) . '"><span class="dashicons dashicons-no-alt"></span></a>';

							// Add hidden field with the image_id
							echo '<input type="hidden" name="dpsp_pinterest_hidden_images[]" value="' . absint( $image_id ) . '" />';

						echo '</div>';

					}

					// Add the add new images button
					echo '<div class="dpsp-hidden-image-add-new dpsp-button-secondary">';
						echo '<span class="dashicons dashicons-plus"></span>';
						echo  '<div>' . __( 'Add images', 'social-pug' ) . '</div>';
					echo '</div>';

				echo '</div>';

			echo '</div>';

		}

	echo '</div>';

	// Overwrite options
	echo '<h4 class="dpsp-section-title">' . __( 'Display Options', 'social-pug' ) . '</h4>';
	echo '<div>';
		dpsp_settings_field( 'checkbox', 'dpsp_share_options[locations_overwrite][]', ( isset( $share_options['locations_overwrite'] ) ? $share_options['locations_overwrite'] : [] ), __( 'Hide buttons for the', 'social-pug' ), dpsp_get_network_locations( 'all', false ) );
	echo '</div>';
	echo '<div>';
		dpsp_settings_field( 'checkbox', 'dpsp_share_options[locations_overwrite_show][]', ( isset( $share_options['locations_overwrite_show'] ) ? $share_options['locations_overwrite_show'] : [] ), __( 'Show buttons for the', 'social-pug' ), dpsp_get_network_locations( 'all', false ) );
	echo '</div>';

}


/**
 * Callback for the share statistics meta-box.
 */
function dpsp_share_statistics_output( $post ) {

	$networks = dpsp_get_active_networks();

	if ( ! empty( $networks ) ) {

		echo '<div class="dpsp-statistic-bars-wrapper">';

		// Get share counts
		$networks_shares = dpsp_get_post_share_counts( $post->ID );

		// Get total share counts
		$total_shares = dpsp_get_post_total_share_count( $post->ID );

		// Shares header
		echo '<div class="dpsp-statistic-bar-wrapper dpsp-statistic-bar-header">';
			echo '<label>' . __( 'Network', 'social-pug' ) . '</label>';
			echo '<div class="dpsp-network-share-count"><span class="dpsp-count">' . __( 'Shares', 'social-pug' ) . '</span><span class="dpsp-divider">|</span><span class="dpsp-percentage">%</span></div>';
		echo '</div>';

		// Actual shares per network
		foreach ( $networks as $network_slug ) {

			// Jump to the next one if the network by some chance does not support
			// share count
			if ( ! in_array( $network_slug, dpsp_get_networks_with_social_count() ) ) {
				continue;
			}

			// Get current network social share count
			$network_shares = ( isset( $networks_shares[ $network_slug ] ) ? $networks_shares[ $network_slug ] : 0 );

			// Get the percentage of the total shares for current network
			$share_percentage = ( $total_shares != 0 ? (float) ( $network_shares / $total_shares * 100 ) : 0 );

			echo '<div class="dpsp-statistic-bar-wrapper dpsp-statistic-bar-wrapper-network">';
				echo '<label>' . dpsp_get_network_name( $network_slug ) . '</label>';

				echo '<div class="dpsp-statistic-bar dpsp-statistic-bar-' . $network_slug . '">';
					echo '<div class="dpsp-statistic-bar-inner" style="width:' . round( $share_percentage, 1 ) . '%"></div>';
				echo '</div>';

				echo '<div class="dpsp-network-share-count"><span class="dpsp-count">' . $network_shares . '</span><span class="dpsp-divider">|</span><span class="dpsp-percentage">' . round( $share_percentage, 2 ) . '</span></div>';
			echo '</div>';

		}

		// Shares footer with total count
		echo '<div class="dpsp-statistic-bar-wrapper dpsp-statistic-bar-footer">';
			echo '<label>' . __( 'Total shares', 'social-pug' ) . '</label>';
			echo '<div class="dpsp-network-share-count"><span class="dpsp-count">' . $total_shares . '</span></div>';
		echo '</div>';

		// Refresh counts button
		echo '<div id="dpsp-refresh-share-counts-wrapper">';
			echo '<a id="dpsp-refresh-share-counts" class="dpsp-button-secondary" href="#">' . __( 'Refresh shares', 'social-pug' ) . '</a>';
			echo '<span class="spinner"></span>';
			echo wp_nonce_field( 'dpsp_refresh_share_counts', 'dpsp_refresh_share_counts', false, false );
		echo '</div>';

		echo '</div>';

		/**
		 * Share recovery links
		 *
		 * Because the share statistics meta-box is rendered both on load and through
		 * AJAX when the Refresh Shares button is clicked, we need to only add it on pageload
		 *
		 */
		if ( ! wp_doing_ajax() ) {

			echo '<div id="dpsp-shares-recovery-post-previous-urls">';

				$urls = dpsp_maybe_unserialize( get_post_meta( $post->ID, 'dpsp_post_single_previous_urls', true ) );

				echo '<h4>' . __( 'Social Shares Recovery', 'social-pug' ) . dpsp_output_backend_tooltip( __( 'If you have modified the permalink for this particular post, add the previous URL variations for the post, so that Grow can recover the social shares for each individual URL.', 'social-pug' ), true ) . '</h4>';

				// Add the empty placeholder with a message, when previous URLs don't exist
				echo '<div id="dpsp-shares-recovery-post-previous-urls-empty" ' . ( ! empty( $urls ) ? 'style="display: none;"' : '' ) . '>';
					echo '<p>' . __( 'If you have ever modified the permalink for this particular post and want to recover lost shares for any previous links this post had, add the old links by pressing the Add Link button.', 'social-pug' ) . '</p>';
				echo '</div>';

				// Add each previous URL for the post
				if ( ! empty( $urls ) ) {

					foreach ( $urls as $url ) {

						echo '<div class="dpsp-post-previous-url">';

							echo '<input type="text" name="dpsp_post_single_previous_urls[]" placeholder="eg. http://www.domain.com/sample-post/" value="' . esc_attr( $url ) . '" />';

							echo '<a href="#" class="dpsp-button-secondary">' . __( 'Remove', 'social-pug' ) . '</a>';

						echo '</div>';

					}
				}

				echo '<a href="#" id="dpsp-add-post-previous-url" class="dpsp-button-secondary">' . __( 'Add Link', 'social-pug' ) . '</a>';

			echo '</div>';

			// Hidden URL field used to add new fields through JS
			echo '<div class="dpsp-post-previous-url dpsp-hidden">';

				echo '<input type="text" name="dpsp_post_single_previous_urls[]" placeholder="eg. http://www.domain.com/sample-post/" value="" />';

				echo '<a href="#" class="dpsp-button-secondary">' . __( 'Remove', 'social-pug' ) . '</a>';

			echo '</div>';
		}
	}
}

/**
 * Callback for the debugger meta-box.
 */
function dpsp_post_debugger_output( $post ) {

	$post_meta = get_post_meta( $post->ID );

	echo '<textarea readonly style="width: 100%; min-height: 600px;">';

	// Add post data
	echo '----------------------------------------------------------------------------------' . PHP_EOL;
	echo 'post_id' . PHP_EOL;
	echo '----------------------------------------------------------------------------------' . PHP_EOL;
	echo $post->ID;
	echo PHP_EOL . PHP_EOL;

	echo '----------------------------------------------------------------------------------' . PHP_EOL;
	echo 'post_permalink' . PHP_EOL;
	echo '----------------------------------------------------------------------------------' . PHP_EOL;
	echo get_permalink( $post->ID );
	echo PHP_EOL . PHP_EOL;

	// Add Social Pug related meta-data
	foreach ( $post_meta as $meta_key => $meta_value ) {

		if ( false === strpos( $meta_key, 'dpsp' ) ) {
			continue;
		}

		echo '----------------------------------------------------------------------------------' . PHP_EOL;
		echo $meta_key . PHP_EOL;
		echo '----------------------------------------------------------------------------------' . PHP_EOL;

		if ( is_serialized( $meta_value[0] ) ) {
			print_r( unserialize( $meta_value[0] ) );
		} else {
			print_r( $meta_value[0] . PHP_EOL );
		}

		echo PHP_EOL;
	}

	echo '</textarea>';
}


/**
 * Ajax callback action that refreshes the social counts for the "Share Statistics"
 * meta-box from each single edit post admin screen.
 */
function dpsp_refresh_share_counts() {

	if ( empty( $_POST['action'] ) || empty( $_POST['nonce'] ) || empty( $_POST['post_id'] ) ) {
		return;
	}

	if ( $_POST['action'] != 'dpsp_refresh_share_counts' ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['nonce'], 'dpsp_refresh_share_counts' ) ) {
		return;
	}

	$post_id = (int) $_POST['post_id'];
	$post    = get_post( $post_id );

	if ( ! in_array( $post->post_status, [ 'future', 'draft', 'pending', 'trash', 'auto-draft' ] ) ) {

		// Flush existing shares before pulling a new set
		update_post_meta( $post_id, 'dpsp_networks_shares', '' );

		// Get social shares from the networks
		$share_counts = dpsp_pull_post_share_counts( $post_id );

		// Update share counts in the db
		$shares_updated = dpsp_update_post_share_counts( $post_id, $share_counts );

	}

	// Echos the share statistics
	dpsp_share_statistics_output( $post );
	wp_die();
}

/**
 * Save meta data for Social Pug meta boxes.
 */
function dpsp_save_post_meta( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['dpsptkn'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['dpsptkn'], 'dpsp_meta_box' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	// Clear cached shortened links
	delete_post_meta( $post_id, 'dpsp_short_link_bitly' );

	// Save information for the Share Options meta-box
	if ( isset( $_POST['dpsp_share_options'] ) ) {
		$share_options = $_POST['dpsp_share_options'];
	} else {
		$share_options = '';
	}

	update_post_meta( $post_id, 'dpsp_share_options', $share_options );

	// Save information for the Pinterest hidden images
	if ( ! empty( $_POST['dpsp_save_multiple_pinterest_images'] ) && wp_verify_nonce( $_POST['dpsp_save_multiple_pinterest_images'], 'dpsp_save_multiple_pinterest_images' ) ) {

		// Remove the images if none are present
		if ( ! empty( $_POST['dpsp_pinterest_hidden_images'] ) ) {

			// Sanitize the values
			$hidden_images = array_map( 'absint', $_POST['dpsp_pinterest_hidden_images'] );
			$hidden_images = array_filter( $hidden_images );

		} else {
			$hidden_images = '';
		}

		// Update hidden images value
		update_post_meta( $post_id, 'dpsp_pinterest_hidden_images', $hidden_images );
	}

	// Save information for the Share Statistics meta-box
	if ( ! empty( $_POST['dpsp_post_single_previous_urls'] ) ) {

		$previous_urls = ( is_array( $_POST['dpsp_post_single_previous_urls'] ) ? $_POST['dpsp_post_single_previous_urls'] : [] );

		foreach ( $previous_urls as $key => $previous_url ) {
			// Sanitize the URL
			$previous_urls[ $key ] = wp_http_validate_url( sanitize_text_field( $previous_url ) );
		}

		// Exclude invalid and empty values
		$previous_urls = array_filter( $previous_urls );

		// Make sure there are no duplicates
		$previous_urls = array_unique( $previous_urls );

	} else {
		$previous_urls = '';
	}

	// Update previous URL's
	update_post_meta( $post_id, 'dpsp_post_single_previous_urls', $previous_urls );
}

/**
 *
 */
function dpsp_refresh_all_share_counts_ajax() {
	if ( empty( $_POST['action'] ) || empty( $_POST['nonce'] ) ) {
		return;
	}

	if ( $_POST['action'] != 'dpsp_refresh_all_share_counts' ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['nonce'], 'dpsp_refresh_all_share_counts' ) ) {
		return;
	}

	dpsp_invalidate_all_share_counts();
	wp_die();
}

/**
 * Register hooks for admin-metaboxes.php
 */
function dpsp_register_admin_metaboxes() {
	add_action( 'add_meta_boxes', 'dpsp_meta_boxes' );
	add_action( 'wp_ajax_dpsp_refresh_share_counts', 'dpsp_refresh_share_counts' );
	add_action( 'save_post', 'dpsp_save_post_meta' );
	add_action( 'wp_ajax_dpsp_refresh_all_share_counts', 'dpsp_refresh_all_share_counts_ajax' );
}
