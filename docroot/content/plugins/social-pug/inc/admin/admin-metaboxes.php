<?php
/*
 * Meta-boxes file
 *
 */

	/*
	 * Individual posts share statistics meta-box
	 *
	 */
	function dpsp_meta_boxes() {
		
		$screens = get_post_types( array( 'public' => true ) );

		if( empty( $screens ) )
			return;

		foreach( $screens as $screen ) {

			// Share statistics meta-box
			add_meta_box( 'dpsp_share_statistics', __( 'Share Statistics', 'social-pug' ), 'dpsp_share_statistics_output', $screen, 'normal', 'core' );

		}

	}
	add_action( 'add_meta_boxes', 'dpsp_meta_boxes' );


	/*
	 * Callback for the share statistics meta-box
	 *
	 */
	function dpsp_share_statistics_output( $post ) {

		$networks = dpsp_get_active_networks();

		if( !empty( $networks ) ) {

			echo '<div class="dpsp-statistic-bars-wrapper">';

			$networks_shares = get_post_meta( $post->ID, 'dpsp_networks_shares', true );
			$networks_shares = ( !empty( $networks_shares ) ? $networks_shares : array() );

			// Get total share counts
			$total_shares = dpsp_get_post_total_share_count( $post->ID );

			// Shares header
			echo '<div class="dpsp-statistic-bar-wrapper dpsp-statistic-bar-header">';
				echo '<label>' . __( 'Network', 'social-pug' ) . '</label>';
				echo '<div class="dpsp-network-share-count"><span class="dpsp-count">' . __( 'Shares', 'social-pug' ) . '</span><span class="dpsp-divider">|</span><span class="dpsp-percentage">%</span></div>';
			echo '</div>';

			// Actual shares per network
			foreach( $networks as $network_slug ) {

				// Jump to the next one if the network by some chance does not support
				// share count
				if( !in_array( $network_slug, dpsp_get_networks_with_social_count() ) )
					continue;

				// Get current network social share count
				$network_shares = ( isset($networks_shares[$network_slug]) ? $networks_shares[$network_slug] : 0 );

				// Get the percentage of the total shares for current network
				$share_percentage = ( $total_shares != 0 ? (float)($network_shares / $total_shares * 100) : 0 );

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
				echo '<a id="dpsp-refresh-share-counts" class="button-secondary" href="#">' . __( 'Refresh shares', 'social-pug' ) . '</a>';
				echo '<span class="spinner"></span>';
				echo wp_nonce_field( 'dpsp_refresh_share_counts', 'dpsp_refresh_share_counts', false, false );
			echo '</div>';

			echo '</div>';

		}
		
	}


	/**
	 * Ajax callback action that refreshes the social counts for the "Share Statistics"
	 * meta-box from each single edit post admin screen
	 *
	 */
	function dpsp_refresh_share_counts() {

		if( empty( $_POST['action'] ) || empty( $_POST['nonce'] ) || empty( $_POST['post_id'] ) )
			return;

		if( $_POST['action'] != 'dpsp_refresh_share_counts' )
			return;

		if( ! wp_verify_nonce( $_POST['nonce'], 'dpsp_refresh_share_counts' ) )
			return;

		$post_id = (int)$_POST['post_id'];

		if( ! in_array( $post->post_status, array( 'future', 'draft', 'pending', 'trash', 'auto-draft' ) ) ) {

			// Flush existing shares before pulling a new set
			update_post_meta( $post_id, 'dpsp_networks_shares', '' );

			// Get social shares from the networks
			$share_counts   = dpsp_pull_post_share_counts( $post_id );

			// Update share counts in the db
			$shares_updated = dpsp_update_post_share_counts( $post_id, $share_counts );
			
		}

		// Echos the share statistics 
		dpsp_share_statistics_output( get_post( $post_id ) );

		wp_die();

	}
	add_action( 'wp_ajax_dpsp_refresh_share_counts', 'dpsp_refresh_share_counts' );