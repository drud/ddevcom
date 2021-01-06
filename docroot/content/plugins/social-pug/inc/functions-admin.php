<?php

	/**
	 * Displays the HTML of the plugin admin header
	 *
	 */
	function dpsp_admin_header() {

		if ( empty( $_GET['page'] ) ) {
			return;
		}

		if ( strpos( $_GET['page'], 'dpsp' ) === false ) {
			return;
		}

		$page = trim( $_GET['page'] );

		echo '<div class="dpsp-page-header">';
			echo '<span class="dpsp-logo">';
				echo '<svg version="1.1" class="mv-grow-logo" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 20 20" fill="white" xml:space="preserve">
				<path d="M0 7.2c0 .1-.6 4.7 2 7.2 1.7 1.8 4.3 2 5.9 2h.9A12.7 12.7 0 014.4 14a6.7 6.7 0 01-1.6-2.3c-.3-.9-.5-1.9-.4-3 0-.7.2-1.6.5-2.4h-2l-.7.1-.1.8zM4.7 3.4l-.4.6-.8 1.8 2.4.5 1.3-2c-1-.5-1.7-.7-1.8-.7l-.7-.2z"/>
				<path d="M3.3 11.5c1.1 2.8 4.3 4 5.5 4.4l-.5-.4-.4-.4a10.7 10.7 0 01-2.2-3c-.4-1-.6-1.9-.6-2.8 0-.7.2-1.4.4-2.1l.1-.2.1-.3a10.8 10.8 0 00-2.1-.4h-.3v.4a7.4 7.4 0 000 4.8zM10.6 2.8l-.6-.4-.6.4L8 4.2l2 1.3c.6-.5 1.3-1 2-1.3l-1.4-1.4zM6.5 6.6h.2l1.6 1.1a6.4 6.4 0 011.4-1.9L8 4.8l-.2-.2-.2-.1-.2.2-.1.2c-.4.4-.8 1-1 1.6h.1z"/>
				<path d="M6 7.1v.2a6 6 0 00-.4 2c0 3 2.4 5.4 3.4 6.2l-.3-.5-.2-.6a12.5 12.5 0 01-.8-3.4A7 7 0 018 8.4l.1-.3a6 6 0 00-1.6-1L6.3 7h-.2V7zM15.3 3.5l-.7.1s-.8.2-1.8.7c.5.7 1 1.3 1.3 2l.5-.1a11 11 0 011.9-.4l-.8-1.7-.4-.6zM13.4 6.6l.3-.1-1-1.6-.2-.2-.2-.2-.2.1-.2.1-1.6 1.1.2.2.1.2c.5.4.8 1 1 1.5a6.6 6.6 0 011.8-1.1zM10.3 6.5l-.2-.2-.1-.1-.2.1-.1.2a5.8 5.8 0 00-1 1.6v.1h.1l.2.2c.4.5.7 1.1 1 1.8a7 7 0 011-1.8l.1-.2.2-.2c-.2-.6-.6-1-1-1.5z"/>
				<path d="M8.7 8.9v-.2h-.1l-.2-.2V9h-.1c-.6 2.5.5 5 1 6.1v-.6-.6-1.1l.2-1 .1-.5.1-.4a6.9 6.9 0 00-1-2zM17 6.3h-.4c-.7 0-1.5.2-2.3.4l-.2.1-.3.1h-.2l-.2.2A6 6 0 0012 8l-.2.2-.2.2-.2.2-.1.2c-.5.6-.8 1.3-1 2l-.1.4-.1.3v.2l-.1.5v.2a12 12 0 000 3V16.4h.5l.2.1H12c1.6 0 4.2-.2 6-2 2.5-2.5 1.8-7 1.8-7.3v-.7H19a10.2 10.2 0 00-2-.1zm-.4 6.8c-1.3 1.2-3.3 1.4-4.6 1.4h-.3c0-1.3.1-3.6 1.4-4.9 1.2-1.2 3.3-1.4 4.5-1.4h.4c0 1.2 0 3.5-1.4 4.9z"/>
			  </svg>
			  ';
				echo '<span class="dpsp-logo-inner">Grow Social by Mediavine</span>';
				echo '<small class="dpsp-version">v.' . DPSP_VERSION . '</small>';
			echo '</span>';

			echo '<nav>';
				echo '<a href="' . dpsp_get_documentation_link( $page ) . '" target="_blank"><i class="dashicons dashicons-book"></i>Documentation</a>';
			echo '</nav>';
		echo '</div>';

	}

	/*
	 * Returns the link to the docs depending on the page the user is on
	 *
	 */
	function dpsp_get_documentation_link( $page ) {

		$page = str_replace( 'dpsp-', '', $page );

		switch ( $page ) {

			case 'sidebar':
				$url = 'https://help.mediavine.com/en/articles/3625801-how-to-add-social-sharing-buttons-as-a-floating-sidebar';
				break;

			case 'content':
				$url = 'https://help.mediavine.com/en/articles/3667466-how-to-add-social-share-buttons-before-and-after-your-post-s-content';
				break;

			case 'sticky-bar':
			case 'mobile':
				$url = 'https://help.mediavine.com/en/articles/3667616-sticky-bar-sharing-buttons';
				break;

			case 'pinterest-images':
				$url = 'https://help.mediavine.com/en/articles/3667495-how-to-add-a-pin-it-button-to-your-post-s-images';
				break;

			case 'import-export':
			case 'follow-widget':
			case 'pop-up':
			default:
				$url = 'https://help.mediavine.com/en/collections/2071158-grow-by-mediavine';
				break;
		}

		return $url;

	}


	/**
	 * Displays the HTML for a given tool
	 *
	 * @param array $tool
	 *
	 */
	function dpsp_output_tool_box( $tool_slug, $tool ) {
		$grow_url = 'https://marketplace.mediavine.com/grow-social-pro/';
		$is_extension = empty( $tool['admin_page'] );
		$box_class = Social_Pug::is_free() && ! $is_extension  ? 'dpsp-col-3-8' : 'dpsp-col-1-4';
		echo '<div class="' . $box_class . '">';
			echo '<div class="dpsp-tool-wrapper dpsp-card ' . ( $is_extension ? 'dpsp-unavailable' : '' ) . '">';


				if( $is_extension ) {
					if( empty( $tool['url'] ) )
						$tool['url'] = $grow_url;

					echo '<a href="' . $tool['url'] . '">';
				}

				// Tool image
				echo '<img src="' . ( strpos( $tool['img'], 'http' ) === false ? DPSP_PLUGIN_DIR_URL . $tool['img'] : $tool['img'] ) . '" />';

				if( $is_extension ) {
					echo '</a>';
				}

				// Tool name
				echo '<h4 class="dpsp-tool-name">' . $tool['name'] . '</h4>';

				if( !empty( $tool['desc'] ) ) {
					echo '<p class="dpsp-description">' . $tool['desc'] . '</p>';
				}

				$tool_active = dpsp_is_tool_active( $tool_slug );

				// Tool actions
				echo '<div class="dpsp-tool-actions dpsp-card-footer dpsp-' . ( $tool_active ? 'active' : 'inactive' ) . '">';

				if (! $is_extension) {
					// Tool admin page
					echo '<a class="dpsp-tool-settings" href="' . admin_url( $tool['admin_page'] ) . '"><i class="dashicons dashicons-admin-generic"></i>' . __( 'Settings', 'social-pug' ) . '</a>';

					// Tool activation switch
					echo '<div class="dpsp-switch small">';

					echo( $tool_active ? '<span>' . __( 'Active', 'social-pug' ) . '</span>' : '<span>' . __( 'Inactive', 'social-pug' ) . '</span>' );

					echo '<input id="dpsp-' . $tool_slug . '-active" data-tool="' . esc_attr( $tool_slug ) . '" data-tool-activation="' . esc_attr( ! empty( $tool['activation_setting'] ) ? $tool['activation_setting'] : '' ) . '" class="cmn-toggle cmn-toggle-round" type="checkbox" value="1"' . ( $tool_active ? 'checked' : '' ) . ' />';
					echo '<label for="dpsp-' . $tool_slug . '-active"></label>';

					echo '</div>';
				} else {
					if( empty( $tool['url'] ) )
						$tool['url'] = $grow_url;

					echo '<a href="' . $tool['url'] . '" class="dpsp-button-primary">' . __( 'Learn More', 'social-pug' ) . '</a>';

				}
				echo '</div>';

			echo '</div>';
		echo '</div>';

	}


	/**
	 * Function that displays the HTML for a settings field
	 *
	 */
	function dpsp_settings_field( $type, $name, $saved_value = '', $label = '', $options = [], $tooltip = '', $editor_settings = [], $disabled = '' ) {

		$settings_field_slug = ( ! empty( $label ) ? strtolower( str_replace( ' ', '-', $label ) ) : '' );

		echo '<div class="dpsp-setting-field-wrapper dpsp-setting-field-' . $type . ( is_array( $options ) && count( $options ) == 1 ? ' dpsp-single' : ( is_array( $options ) && count( $options ) > 1 ? ' dpsp-multiple' : '' ) ) . ' ' . ( ! empty( $label ) ? 'dpsp-has-field-label dpsp-setting-field-' . $settings_field_slug : '' ) . '">';

		switch ( $type ) {

			// Display input type text
			case 'text':
				echo ! empty( $label ) ? '<label for="' . esc_attr( $name ) . '" class="dpsp-setting-field-label">' . $label . '</label>' : '';

				echo '<input type="text" ' . ( isset( $label ) ? 'id="' . esc_attr( $name ) . '"' : '' ) . ' name="' . esc_attr( $name ) . '" value="' . esc_attr( $saved_value ) . '" ' . $disabled . ' />';
				break;

			// Display textareas
			case 'textarea':
				echo ! empty( $label ) ? '<label for="' . esc_attr( $name ) . '" class="dpsp-setting-field-label">' . $label . '</label>' : '';

				echo '<textarea ' . ( isset( $label ) ? 'id="' . esc_attr( $name ) . '"' : '' ) . ' name="' . esc_attr( $name ) . '">' . $saved_value . '</textarea>';

				break;

			// Display wp_editors
			case 'editor':
				echo ! empty( $label ) ? '<label for="' . esc_attr( $name ) . '" class="dpsp-setting-field-label">' . $label . '</label>' : '';

				wp_editor( $saved_value, $name, $editor_settings );

				break;

			// Display input type radio
			case 'radio':
				echo ! empty( $label ) ? '<label class="dpsp-setting-field-label">' . $label . '</label>' : '';

				if ( ! empty( $options ) ) {
					foreach ( $options as $option_value => $option_name ) {
						echo '<input type="radio" id="' . esc_attr( $name ) . '[' . esc_attr( $option_value ) . ']' . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $option_value ) . '" ' . checked( $option_value, $saved_value, false ) . ' />';
						echo '<label for="' . esc_attr( $name ) . '[' . esc_attr( $option_value ) . ']' . '" class="dpsp-settings-field-radio">' . ( isset( $option_name ) ? $option_name : $option_value ) . '<span></span></label>';
					}
				}
				break;

			// Display input type checkbox
			case 'checkbox':
				// If no options are passed make the main label as the label for the checkbox
				if ( count( $options ) == 1 ) {

					if ( is_array( $saved_value ) ) {
						$saved_value = $saved_value[0];
					}

					echo '<input type="checkbox" ' . ( isset( $label ) ? 'id="' . esc_attr( $name ) . '"' : '' ) . ' name="' . esc_attr( $name ) . '" value="' . esc_attr( $options[0] ) . '" ' . checked( $options[0], $saved_value, false ) . ' />';
					echo ! empty( $label ) ? '<label for="' . esc_attr( $name ) . '" class="dpsp-setting-field-label">' . $label . '<span></span></label>' : '';

				// Else display checkboxes just like radios
				} else {

					echo ! empty( $label ) ? '<label class="dpsp-setting-field-label">' . $label . '</label>' : '';

					if ( ! empty( $options ) ) {
						foreach ( $options as $option_value => $option_name ) {
							echo '<input type="checkbox" id="' . esc_attr( $name ) . '[' . esc_attr( $option_value ) . ']' . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $option_value ) . '" ' . ( in_array( $option_value, $saved_value ) ? 'checked' : '' ) . ' />';
							echo '<label for="' . esc_attr( $name ) . '[' . esc_attr( $option_value ) . ']' . '" class="dpsp-settings-field-checkbox">' . ( isset( $option_name ) ? $option_name : $option_value ) . '<span></span></label>';
						}
					}
}
				break;

			// Display switch
			case 'switch':
				if ( count( $options ) == 1 ) {

					if ( is_array( $saved_value ) ) {
						$saved_value = $saved_value[0];
					}

					echo '<div class="dpsp-switch">';
						echo '<input type="checkbox" ' . ( isset( $label ) ? 'id="' . esc_attr( $name ) . '"' : '' ) . ' name="' . esc_attr( $name ) . '" class="cmn-toggle cmn-toggle-round" value="' . esc_attr( $options[0] ) . '" ' . checked( $options[0], $saved_value, false ) . ' />';
						echo ! empty( $label ) ? '<label for="' . esc_attr( $name ) . '"></label>' : '';
					echo '</div>';

					echo ! empty( $label ) ? '<label for="' . esc_attr( $name ) . '" class="dpsp-setting-field-label">' . $label . '<span></span></label>' : '';

				}

				/*
				$echo .= '<div class="oih-switch small">';

					$echo .= '<input id="' . esc_attr( $field['name'] ) . '" name="' . esc_attr( $field['name'] ) . '" class="oih-toggle oih-toggle-round ' . ( ! empty( $field['input_class'] ) ? esc_attr( $field['input_class'] ) : '' ) . '" type="checkbox" value="1" ' . ( ! empty( $value ) ? 'checked' : '' ) . ' />';
					$echo .= '<label for="' . esc_attr( $field['name'] ) . '"></label>';

				$echo .= '</div>';
				*/

				break;

			case 'select':
				echo ! empty( $label ) ? '<label for="' . esc_attr( $name ) . '" class="dpsp-setting-field-label">' . $label . '</label>' : '';
				echo '<select id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '"' . $disabled . '>';

					foreach ( $options as $option_value => $option_name ) {
						echo '<option value="' . esc_attr( $option_value ) . '" ' . selected( $saved_value, $option_value, false ) . '>' . $option_name . '</option>';
					}

				echo '</select>';

				break;

			case 'color-picker':
				echo ! empty( $label ) ? '<label for="' . esc_attr( $name ) . '" class="dpsp-setting-field-label">' . $label . '</label>' : '';

				echo '<input class="dpsp-color-picker" type="text" ' . ( isset( $label ) ? 'id="' . esc_attr( $name ) . '"' : '' ) . ' name="' . esc_attr( $name ) . '" value="' . esc_attr( $saved_value ) . '" />';
				break;

			case 'image':
				echo ! empty( $label ) ? '<label for="' . esc_attr( $name ) . '" class="dpsp-setting-field-label">' . $label . '</label>' : '';

				echo '<div>';

					if ( ! empty( $saved_value['id'] ) ) {
						$thumb_details = wp_get_attachment_image_src( $saved_value['id'], 'medium' );
						$image_details = wp_get_attachment_image_src( $saved_value['id'], 'full' );
					}

					if ( ! empty( $thumb_details[0] ) && ! empty( $image_details[0] ) ) {
						$thumb_src = $thumb_details[0];
						$image_src = $image_details[0];
					} else {
						$thumb_src         = '';
						$image_src         = '';
						$saved_value['id'] = '';
					}

					echo '<div>';
						echo '<img src="' . esc_attr( $thumb_src ) . '">';
					echo '</div>';

					echo '<a class="dpsp-image-select button button-primary ' . ( ! empty( $saved_value['id'] ) ? 'hidden' : '' ) . '" href="#">' . __( 'Select Image', 'social-pug' ) . '</a>';
					echo '<a class="dpsp-image-remove button button-secondary ' . ( empty( $saved_value['id'] ) ? 'hidden' : '' ) . '" href="#">' . __( 'Remove Image', 'social-pug' ) . '</a>';

					echo '<input class="dpsp-image-id" type="hidden" name="' . esc_attr( $name ) . '[id]" value="' . esc_attr( $saved_value['id'] ) . '" />';
					echo '<input class="dpsp-image-src" type="hidden" name="' . esc_attr( $name ) . '[src]" value="' . esc_attr( $image_src ) . '" />';

				echo '</div>';

				break;

		} // end of switch

		// Tooltip
		if ( ! empty( $tooltip ) ) {

			dpsp_output_backend_tooltip( $tooltip );

		}

		do_action( 'dpsp_inner_after_settings_field', $settings_field_slug, $type, $name );

		echo '</div>';

	}


	/**
	 * Set the column_count option to 1 when displaying the buttons inside the WP dashboard admin
	 *
	 * @param array $settings   - the settings array for the current location
	 * @param string $action    - the current type of action ( share/follow )
	 * @param string $location  - the display location for the buttons
	 *
	 * @return array
	 *
	 */
	function dpsp_admin_buttons_display_column_count_to_one( $settings, $action, $location ) {

		if ( empty( $settings['display']['column_count'] ) ) {
			return $settings;
		}

		if ( ! is_admin() ) {
			return $settings;
		}

		$settings['display']['column_count'] = 1;

		return $settings;

	}

	/**
	 * Returns the HTML output with the selectable networks
	 *
	 * @param array $networks - the networks available to be sorted
	 * @param array $settings_networks - the networks saved for the location
	 *
	 */
	function dpsp_output_selectable_networks( $networks = [], $settings_networks ) {

		$output = '<div id="dpsp-networks-selector-wrapper">';

			$output .= '<ul id="dpsp-networks-selector">';

				if ( ! empty( $networks ) ) {
					foreach ( $networks as $network_slug => $network_name ) {
						$output         .= '<li>';
							$output     .= '<div class="dpsp-network-item" data-network="' . $network_slug . '" data-network-name="' . $network_name . '" ' . ( isset( $settings_networks[ $network_slug ] ) ? 'data-checked="true"' : '' ) . '>';
							$output     .= '<div class="dpsp-network-item-checkbox dpsp-icon-ok"></div>';
							$output     .= '<div class="dpsp-network-item-name-wrapper dpsp-network-' . $network_slug . ' dpsp-background-color-network-' . $network_slug . '">';
								$output .= '<span class="dpsp-list-icon dpsp-list-icon-social dpsp-icon-' . $network_slug . ' dpsp-background-color-network-' . $network_slug . '"><!-- --></span>';
								$output .= '<h4>' . $network_name . '</h4>';
							$output     .= '</div>';
						$output         .= '</li>';
					}
				}

			$output .= '</ul>';

			$output     .= '<div id="dpsp-networks-selector-footer" class="dpsp-card-footer">';
				$output .= '<a href="#" class="dpsp-button-primary">' . __( 'Apply Selection', 'social-pug' ) . '</a>';
			$output     .= '</div>';

		$output .= '</div>';

		return $output;
	}


	/*
	 * Returns the HTML output with the sortable networks
	 *
	 */
	function dpsp_output_sortable_networks( $networks, $settings_name ) {

		$output = '<ul class="dpsp-social-platforms-sort-list sortable">';

			$current_network = 1;

			if ( ! empty( $networks ) ) {

				foreach ( $networks as $network_slug => $network ) {

					$output .= '<li data-network="' . $network_slug . '" ' . ( $current_network == count( $networks ) ? 'class="dpsp-last"' : '' ) . '>';

						// The sort handle
						$output .= '<div class="dpsp-sort-handle"><!-- --></div>';

						// The social network icon
						$output .= '<div class="dpsp-list-icon dpsp-list-icon-social dpsp-icon-' . $network_slug . ' dpsp-background-color-network-' . $network_slug . '"><!-- --></div>';

						// The label edit field
						$output     .= '<div class="dpsp-list-input-wrapper">';
							$output .= '<input type="text" placeholder="' . __( 'This button has no label text.', 'social-pug' ) . '" name="' . $settings_name . '[networks][' . $network_slug . '][label]" value="' . ( isset( $network['label'] ) ? esc_attr( $network['label'] ) : dpsp_get_network_name( $network_slug ) ) . '" />';
						$output     .= '</div>';

						// List item actions
						$output     .= '<div class="dpsp-list-actions">';
							$output .= '<a class="dpsp-list-edit-label" href="#"><span class="dashicons dashicons-edit"></span>' . __( 'Edit Label' ) . '</a>';
							$output .= '<a class="dpsp-list-remove" href="#"><span class="dashicons dashicons-no-alt"></span>' . __( 'Remove' ) . '</a>';
						$output     .= '</div>';
					$output         .= '</li>';

					$current_network++;

				}
}

		$output .= '</ul>';

		return $output;
	}


	/*
	 * Outputs the HTML of the tooltip
	  *
	 * @param string tooltip - the text of the tooltip
	 * @param bool $return 	 - wether to return or to output the HTML
	 *
	 */
	function dpsp_output_backend_tooltip( $tooltip = '', $return = false ) {

		$output      = '<div class="dpsp-setting-field-tooltip-wrapper ' . ( ( strpos( $tooltip, '</a>' ) !== false ) ? 'dpsp-has-link' : '' ) . '">';
			$output .= '<span class="dpsp-setting-field-tooltip-icon"></span>';
			$output .= '<div class="dpsp-setting-field-tooltip dpsp-transition">' . $tooltip . '</div>';
		$output     .= '</div>';

		if ( $return ) {
			return $output;
		} else {
echo $output;
		}

	}

	/*
	 * Registers an extra column for the shares with all active custom post types
	 *
	 */
	function dpsp_register_custom_post_type_columns() {

		$active_post_types = dpsp_get_active_post_types();

		if ( ! empty( $active_post_types ) ) {
			foreach ( $active_post_types as $post_type ) {
				add_filter( 'manage_' . $post_type . '_posts_columns', 'dpsp_set_shares_column' );
				add_filter( 'manage_edit-' . $post_type . '_sortable_columns', 'dpsp_set_shares_column_sortable' );
				add_action( 'manage_' . $post_type . '_posts_custom_column', 'dpsp_output_shares_column', 10, 2 );
			}
		}
	}

	/**
	 * Adds the Shares column to all active post types
	 *
	 * @param array $columns
	 *
	 * @return array
	 *
	 */
	function dpsp_set_shares_column( $columns ) {

		$column_output = '<span class="dpsp-list-table-shares"><i class="dashicons dashicons-share"></i><span>' . __( 'Shares', 'social-pug' ) . '</span></span>';

		if ( isset( $columns['date'] ) ) {

			$array = array_slice( $columns, 0, array_search( 'date', array_keys( $columns ) ) );

			$array['dpsp_shares'] = $column_output;

			$columns = array_merge( $array, $columns );

		} else {
			$columns['dpsp_shares'] = $column_output;
		}

		return $columns;
	}


	/**
	 * Defines the total shares column as sortable
	 *
	 * @param array $columns
	 *
	 * @return array
	 *
	 */
	function dpsp_set_shares_column_sortable( $columns ) {

		$columns['dpsp_shares'] = 'dpsp_shares';

		return $columns;
	}


	/**
	 * Outputs the share counts in the Shares columns
	 *
	 * @param string $column_name
	 * @param int $post_id
	 *
	 */
	function dpsp_output_shares_column( $column_name, $post_id ) {

		if ( $column_name == 'dpsp_shares' ) {

			echo  '<span class="dpsp-list-table-post-share-count">' . dpsp_get_post_total_share_count( $post_id ) . '</span>';

		}

	}


	/**
	 * Check to see if the user selected to order the posts by share counts and
	 * changes the query accordingly
	 *
	 * @param WP_Query $query
	 *
	 */
	function dpsp_pre_get_posts_shares_query( $query ) {

		if ( ! is_admin() ) {
			return;
		}

		$orderby = $query->get( 'orderby' );

		if ( $orderby == 'dpsp_shares' ) {
			$query->set( 'meta_key', 'dpsp_networks_shares_total' );
			$query->set( 'orderby', 'meta_value_num' );
		}

	}

	/**
	 * Makes a call to Facebook to scrape the post's Open Graph data after the post has been saved
	 *
	 * @param int $post_id
	 * @param WP_Post $post
	 *
	 */
	function dpsp_save_post_facebook_scrape_url( $post_id, $post ) {

		if ( ! is_admin() ) {
			return;
		}

		$not_allowed_post_statuses = [ 'draft', 'auto-draft', 'future', 'pending', 'trash' ];

		if ( in_array( $post->post_status, $not_allowed_post_statuses ) ) {
			return;
		}

		$post_url = get_permalink( $post );
		$post_url = rawurlencode( $post_url );

		$url = add_query_arg(
			[
				'id'     => $post_url,
				'scrape' => 'true',
			],
			'https://graph.facebook.com/'
		);

		$response = wp_remote_post( $url );
	}

	/*
	 * Display admin notices for our pages
	 *
	 */
	function dpsp_admin_notices() {

		// Exit if settings updated is not present
		if ( ! isset( $_GET['settings-updated'] ) ) {
			return;
		}

		$admin_page = ( isset( $_GET['page'] ) ? $_GET['page'] : '' );

		// Show these notices only on dpsp pages
		if ( strpos( $admin_page, 'dpsp' ) === false || $admin_page == 'dpsp-register-version' ) {
			return;
		}

		// Get messages
		$message_id = ( isset( $_GET['dpsp_message_id'] ) ? $_GET['dpsp_message_id'] : 0 );
		$message    = dpsp_get_admin_notice_message( $message_id );

		$class = ( isset( $_GET['dpsp_message_class'] ) ? $_GET['dpsp_message_class'] : 'updated' );

		if ( isset( $message ) ) {

			echo '<div class="dpsp-admin-notice notice is-dismissible ' . esc_attr( $class ) . '">';
				echo '<p>' . esc_attr( $message ) . '</p>';
			echo '</div>';
		}

	}

	/**
	 * Returns a human readable message given a message id
	 *
	 * @param int $message_id
	 *
	 */
	function dpsp_get_admin_notice_message( $message_id ) {

		$messages = apply_filters(
			'dpsp_get_admin_notice_message',
			[
				__( 'Settings saved.', 'social-pug' ),
				__( 'Settings imported.', 'social-pug' ),
				__( 'Please select an import file.', 'social-pug' ),
				__( 'Import file is not valid.', 'social-pug' ),
				__( 'Grow Social by Mediavine App authorized successfully.', 'social-pug' ),
			]
		);

		return $messages[ $message_id ];
	}


	/*
	 * Adds admin notifications for entering the license serial key
	 *
	 */
	function dpsp_serial_admin_notification() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$dpsp_settings = Mediavine\Grow\Settings::get_setting( 'dpsp_settings' );

		$serial  = ( ! empty( $dpsp_settings['product_serial'] ) ? $dpsp_settings['product_serial'] : '' );
		$license = ( ! empty( $dpsp_settings['mv_grow_license'] ) ? $dpsp_settings['mv_grow_license'] : '' );
		// Check to see if serial is saved in the database
		if ( empty( $serial ) && empty( $license ) ) {

			$notice_classes = 'dpsp-serial-missing';
			$message        = sprintf( __( 'Your <strong>Grow Social by Mediavine</strong> license key is empty. Please <a href="%1$s">register your copy</a> to receive automatic updates and support. <br /><br /> Need a license key? <a class="dpsp-get-license button button-primary" target="_blank" href="%2$s">Get your license here</a>', 'social-pug' ), admin_url( 'admin.php?page=dpsp-settings' ), 'https://marketplace.mediavine.com/grow-social-pro/' );

		}

		// Display the notice if notice classes have been added
		if ( isset( $notice_classes ) ) {
			echo '<div class="dpsp-admin-notice notice ' . $notice_classes . '">';
				echo '<p>' . $message . '</p>';

				if ( isset( $extra_content ) ) {
					echo $extra_content;
				}

			echo '</div>';
		}
	}

	/**
	 * Add admin notice to let you know the Facebook access token has expired
	 *
	 */
	function dpsp_admin_notice_facebook_access_token_expired() {

		// Do not display this notice if user cannot activate plugins
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$facebook_access_token = Mediavine\Grow\Settings::get_setting( 'dpsp_facebook_access_token' );

		// Do not display the notice if the access token is missing
		if ( empty( $facebook_access_token['access_token'] ) || empty( $facebook_access_token['expires_in'] ) ) {
			return;
		}

		// Do not display the notice if the token isn't expired
		if ( time() < absint( $facebook_access_token['expires_in'] ) ) {
			return;
		}

		$settings = Mediavine\Grow\Settings::get_setting( 'dpsp_settings', [] );

		// Do not display the notice if the Facebook share count provider isn't set to Grow Social by Mediavine's app
		if ( ! empty( $settings['facebook_share_counts_provider'] ) && $settings['facebook_share_counts_provider'] != 'authorized_app' ) {
			return;
		}

		// Echo the admin notice
		echo '<div class="dpsp-admin-notice notice notice-error">';

			echo '<h4>' . __( 'Grow Social by Mediavine Important Notification', 'social-pug' ) . '</h4>';

			echo '<p>' . __( 'Your Grow Social by Mediavine Facebook app authorization has expired. Please reauthorize the app for continued Facebook share counts functionality.', 'social-pug' ) . '</p>';

			echo '<p><a class="dpsp-button-primary" href="' . add_query_arg( [ 'page' => 'dpsp-settings' ], admin_url( 'admin.php' ) ) . '#dpsp-card-misc">' . __( 'Reauthorize Grow Social by Mediavine App', 'social-pug' ) . '</a></p>';

		echo '</div>';

	}

	/**
	 * Add admin notice to anounce the removal of Google+
	 *
	 */
	function dpsp_admin_notice_google_plus_removal() {

		// Do not display this notice if user cannot activate plugins
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		// Don't show this if the plugin has been activated after 29th of July 2018
		$first_activation = Mediavine\Grow\Settings::get_setting( 'dpsp_first_activation', '' );

		if ( empty( $first_activation ) ) {
			return;
		}

		if ( $first_activation > strtotime( '2019-04-10 00:00:00' ) ) {
			return;
		}

		// Do not display this notice for users that have dismissed it
		if ( get_user_meta( get_current_user_id(), 'dpsp_admin_notice_google_plus_removal', true ) != '' ) {
			return;
		}

		// Echo the admin notice
		echo '<div class="dpsp-admin-notice notice notice-error">';

			echo '<h4>' . __( 'Grow Social by Mediavine Important Notification', 'social-pug' ) . '</h4>';

			echo '<p>' . __( 'As you may already know, Google+ has shut down on April 2nd. As a result, with this latest update, Grow Social by Mediavine no longer supports Google+ functionality.', 'social-pug' ) . '</p>';

			echo '<p>' . __( 'Please make sure to verify your settings, your widgets, your shortcodes, and remove any Google+ buttons you may have placed within your website.', 'social-pug' ) . '</p>';

			echo '<p><a href="' . add_query_arg( [ 'dpsp_admin_notice_google_plus_removal' => 1 ] ) . '">' . __( 'Thank you, I understand.', 'social-pug' ) . '</a></p>';

		echo '</div>';

	}

	/**
	 * Add admin notice to anounce the name change
	 *
	 */
	function dpsp_admin_notice_grow_name_change() {

		// Do not display this notice if user cannot activate plugins
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		// Don't show this if the plugin has been activated after 30th of Nov 2019
		$first_activation = Mediavine\Grow\Settings::get_setting( 'dpsp_first_activation', '' );

		if ( empty( $first_activation ) ) {
			return;
		}

		if ( $first_activation > strtotime( '2019-11-30 00:00:00' ) ) {
			return;
		}

		// Do not display this notice for users that have dismissed it
		if ( get_user_meta( get_current_user_id(), 'dpsp_admin_notice_grow_name_change', true ) != '' ) {
			return;
		}

		// Echo the admin notice
		echo '<div class="dpsp-admin-notice dpsp-admin-grow-notice notice notice-info">';
		echo '<div class="notice-img-wrap" >';
		echo '<img src="' . DPSP_PLUGIN_DIR_URL . 'assets/dist/grow-logo-sq-navy.' . DPSP_VERSION . '.png" />';
		echo '</div>';
		echo '<div class="notice-text-wrap">';

			echo '<h4>' . __( 'Social Pug is now Grow Social by Mediavine!', 'social-pug' ) . '</h4>';

			echo '<p>' . __( 'You\'re going to notice some new paint and a new name today and we wanted to let you know what that\'s all about. The short version is that Grow Social by Mediavine is the same plugin you know and love but with a new, larger development team!', 'social-pug' ) . '</p>';

			echo '<p><a href="https://www.mediavine.com/social-pug-is-now-grow-mediavines-new-social-sharing-buttons-marketplace-more/" target="_blank">' . __( 'Check out the blog post', 'social-pug' ) . '</a>' . __( ' for all the details on this development and our exciting plans to continue Growing an already awesome plugin.', 'social-pug' ) . '</p>';

			echo '<p class="notice-subtext">' . __( '(Those who are familiar with Mediavine for our full-service ad management, rest assured that this plugin is totally independent of ads and available to anyone and everyone who wants to Grow their social presence.)', 'social-pug' ) . '</p>';

			echo '<p><a href="' . add_query_arg( [ 'dpsp_admin_notice_grow_name_change' => 1 ] ) . '">' . __( 'Thank you, I understand.', 'social-pug' ) . '</a></p>';

			echo '</div>';
		echo '</div>';
	}

	/**
	 * Add admin notice for needed Facebook App authorization
	 *
	 */
	function dpsp_admin_notice_facebook_app_authorized() {

		// Do not display this notice if user cannot activate plugins
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$settings = Mediavine\Grow\Settings::get_setting( 'dpsp_settings', [] );

		if ( ! empty( $settings['facebook_app_access_token'] ) ) {
			return;
		}

		$facebook_access_token = Mediavine\Grow\Settings::get_setting( 'dpsp_facebook_access_token' );

		if ( ! empty( $facebook_access_token['access_token'] ) && ! empty( $facebook_access_token['expires_in'] ) ) {
			return;
		}

		// Do not display this notice for users that have dismissed it
		if ( get_user_meta( get_current_user_id(), 'dpsp_admin_notice_facebook_app_authorized', true ) != '' ) {
			return;
		}

		// Echo the admin notice
		echo '<div class="dpsp-admin-notice notice notice-warning">';

			echo '<a class="notice-dismiss" href="' . add_query_arg( [ 'dpsp_admin_notice_facebook_app_authorized' => 1 ] ) . '"></a>';

			echo '<h4>' . __( 'Grow Social by Mediavine Notification', 'social-pug' ) . '</h4>';

			echo '<p>' . __( 'To activate social share counts for Facebook, connecting Grow Social by Mediavine to a Facebook App is required. Please click the button below for a step-by-step guide on how to achieve this.', 'social-pug' ) . '</p>';

			echo '<p><a class="dpsp-button-primary" target="_blank" href="https://help.mediavine.com/en/articles/3667605-how-to-activate-facebook-share-count">Learn how to activate Facebook share counts</a></p>';

		echo '</div>';
	}


	/**
	 * Handle admin notices dismissals
	 *
	 */
	function dpsp_admin_notice_dismiss() {

		if ( isset( $_GET['dpsp_admin_notice_twitter_counts'] ) ) {
			add_user_meta( get_current_user_id(), 'dpsp_admin_notice_twitter_counts', 1, true );
		}

		if ( isset( $_GET['dpsp_admin_notice_renew_1'] ) ) {
			add_user_meta( get_current_user_id(), 'dpsp_admin_notice_renew_1', 1, true );
		}

		if ( isset( $_GET['dpsp_admin_notice_recovery_system'] ) ) {
			add_user_meta( get_current_user_id(), 'dpsp_admin_notice_recovery_system', 1, true );
		}

		if ( isset( $_GET['dpsp_admin_notice_major_update_2_6_0'] ) ) {
			add_user_meta( get_current_user_id(), 'dpsp_admin_notice_major_update_2_6_0', 1, true );
		}

		if ( isset( $_GET['dpsp_admin_notice_google_plus_removal'] ) ) {
			add_user_meta( get_current_user_id(), 'dpsp_admin_notice_google_plus_removal', 1, true );
		}

		if ( isset( $_GET['dpsp_admin_notice_facebook_app_authorized'] ) ) {
			add_user_meta( get_current_user_id(), 'dpsp_admin_notice_facebook_app_authorized', 1, true );
		}

		if ( isset( $_GET['dpsp_admin_notice_grow_name_change'] ) ) {
			add_user_meta( get_current_user_id(), 'dpsp_admin_notice_grow_name_change', 1, true );
		}
	}

	/**
	 * Remove dpsp query args from the URL
	 *
	 * @param array $removable_query_args   - the args that WP will remove
	 *
	 */
	function dpsp_removable_query_args( $removable_query_args ) {

		$new_args = [ 'dpsp_message_id', 'dpsp_message_class', 'dpsp_admin_notice_dismiss_button_icon_animation', 'dpsp_admin_notice_activate_button_icon_animation', 'dpsp_admin_notice_activate_button_icon_animation_done' ];

		return array_merge( $new_args, $removable_query_args );
	}

/**
 * Output settings sidebar — CTA to upgrade to Pro.
 */
function dpsp_add_submenu_page_sidebar() {
	$icon = '<span class="dpsp-dashicons"><span class="dashicons dashicons-yes"></span></span>';
	$url = 'https://marketplace.mediavine.com/grow-social-pro/?utm_source=plugin&utm_medium=sidebar&utm_campaign=social-pug';

	echo '<div class="dpsp-settings-sidebar">';
	echo '<div id="dpsp-settings-sidebar-social-pug-pro" class="dpsp-card">';
	echo '<div class="dpsp-card-inner">';

	echo '<img data-pin-nopin="true" src="' . DPSP_PLUGIN_DIR_URL . 'assets/dist/social-pug-upgrade.' . DPSP_VERSION . '.png" />';

	echo '<h3>' . __( 'Skyrocket your social media marketing', 'social-pug' ) . '</h3>';
	echo '<p>' . $icon . __( 'Force a custom image to be shared on Pinterest when using the Pinterest button.', 'social-pug' ) . '</p>';
	echo '<p>' . $icon . __( 'Add unlimited hidden Pinterest images to your posts and pages.', 'social-pug' ) . '</p>';
	echo '<p>' . $icon . __( 'Add a "Pin It" button that appears when visitors hover your in-post images.', 'social-pug' ) . '</p>';
	echo '<p>' . $icon . __( 'Add custom pin descriptions and repin IDs to your in-post images.', 'social-pug' ) . '</p>';
	echo '<p>' . $icon . __( "Recover your lost social share counts if you've ever changed your permalink structure.", 'social-pug' ) . '</p>';
	echo '<p>' . $icon . __( 'Add unlimited "Click to Tweet" boxes so that your users can share your content on Twitter with just one click.', 'social-pug' ) . '</p>';
	echo '<p>' . $icon . __( 'Get immediate help with priority support.', 'social-pug' ) . '</p>';
	echo '<p>' . $icon . __( 'And much, much more...', 'social-pug' ) . '</p>';

	echo '</div>';
	echo '<div class="dpsp-card-footer"><a class="dpsp-button-primary" href="' . $url . '" target="_blank">' . __( 'Upgrade to Pro', 'social-pug' ) . '</a></div>';
	echo '</div>';
}

/**
 * Register hooks for functions-admin.php
 */
function dpsp_register_functions_admin() {
	add_action( 'admin_notices', 'dpsp_admin_header', 1 );
	add_filter( 'dpsp_network_buttons_outputter_settings', 'dpsp_admin_buttons_display_column_count_to_one', 10, 3 );
	add_action( 'admin_init', 'dpsp_register_custom_post_type_columns' );
	add_action( 'pre_get_posts', 'dpsp_pre_get_posts_shares_query' );
	add_action( 'save_post', 'dpsp_save_post_facebook_scrape_url', 99, 2 );
	add_action( 'admin_notices', 'dpsp_admin_notices' );
	add_action( 'admin_notices', 'dpsp_admin_notice_facebook_access_token_expired' );
	add_action( 'admin_notices', 'dpsp_admin_notice_google_plus_removal' );
	add_action( 'admin_notices', 'dpsp_admin_notice_grow_name_change' );
	add_action( 'admin_notices', 'dpsp_admin_notice_facebook_app_authorized' );
	add_action( 'admin_init', 'dpsp_admin_notice_dismiss' );
	add_filter( 'removable_query_args', 'dpsp_removable_query_args' );
}
