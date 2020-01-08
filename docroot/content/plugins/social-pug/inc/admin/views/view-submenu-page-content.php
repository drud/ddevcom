<form method="post" action="options.php">

	<?php
	 	$dpsp_location_content = get_option( 'dpsp_location_content', 'not_set' );
		settings_fields( 'dpsp_location_content' );
	?>
	
	<div class="dpsp-page-wrapper dpsp-page-content wrap">

		<!-- Page Title -->
		<h1 class="dpsp-page-title">
			<?php _e('Configure Content Sharing Buttons', 'social-pug'); ?>

			<input type="hidden" name="dpsp_buttons_location" value="dpsp_location_content" />
			<input type="hidden" name="dpsp_location_content[active]" value="<?php echo ( isset( $dpsp_location_content["active"] ) ? 1 : '' ); ?>" <?php echo ( !isset( $dpsp_location_content["active"] ) ? 'disabled' : '' ); ?> />
		</h1>


		<!-- Networks Selectable and Sortable Panels -->
		<div id="dpsp-social-platforms-wrapper" class="dpsp-card">

			<div class="dpsp-card-header">
				<?php _e( 'Social Networks', 'social-pug' ); ?>
				<a id="dpsp-select-networks" class="dpsp-button-secondary" href="#"><?php echo __( 'Select Networks', 'social-pug' ) ?></a>
			</div>

			<div id="dpsp-sortable-networks-empty" class="dpsp-card-inner <?php echo ( empty( $dpsp_location_content['networks'] ) ? 'dpsp-active' : '' ); ?>">
				<p><?php _e( 'Select which social buttons to display', 'social-pug' ); ?></p>
			</div>

			<?php echo dpsp_output_sortable_networks( ( ! empty( $dpsp_location_content['networks'] ) ? $dpsp_location_content['networks'] : array() ), 'dpsp_location_content' ); ?>

			<?php
				$available_networks = dpsp_get_networks();
				echo dpsp_output_selectable_networks( $available_networks, ( ! empty( $dpsp_location_content['networks'] ) ? $dpsp_location_content['networks'] : array() ) ); 
			?>

		</div>


		<!-- General Display Settings -->
		<div class="dpsp-card">

			<div class="dpsp-card-header">
				<?php _e( 'Display Settings', 'social-pug' ); ?>
			</div>

			<div class="dpsp-card-inner">

				<?php dpsp_settings_field( 'select', 'dpsp_location_content[display][shape]', ( isset($dpsp_location_content['display']['shape']) ? $dpsp_location_content['display']['shape'] : '' ), __( 'Button shape', 'social-pug' ), array( 'rectangular' => __( 'Rectangular', 'social-pug' ), 'rounded' => __( 'Rounded', 'social-pug' ), 'circle' => __( 'Circle', 'social-pug' ) ) ); ?>

				<?php dpsp_settings_field( 'switch', 'dpsp_location_content[display][icon_animation]', ( isset( $dpsp_location_content['display']['icon_animation']) ? $dpsp_location_content['display']['icon_animation'] : '' ), __( 'Show icon animation', 'social-pug' ), array('yes'), __( 'Will animate the social media icon when the user hovers over the button.', 'social-pug' ) ); ?>
				
				<?php dpsp_settings_field( 'select', 'dpsp_location_content[display][position]', ( isset($dpsp_location_content['display']['position']) ? $dpsp_location_content['display']['position'] : '' ), __( 'Buttons position', 'social-pug' ), array( 'top' => __( 'Above Content', 'social-pug' ), 'bottom' => __( 'Below Content', 'social-pug' ), 'both' => __( 'Above and Below', 'social-pug' ) ) ); ?>

				<?php dpsp_settings_field( 'select', 'dpsp_location_content[display][column_count]', ( isset($dpsp_location_content['display']['column_count']) ? $dpsp_location_content['display']['column_count'] : '' ), __( 'Number of columns', 'social-pug' ), array( 'auto' => __( 'Width Auto', 'social-pug' ), '1' => __( '1 column', 'social-pug' ), '2' => __( '2 columns', 'social-pug' ), '3' => __( '3 columns', 'social-pug' ), '4' => __( '4 columns', 'social-pug' ), '5' => __( '5 columns', 'social-pug' ), '6' => __( '6 columns', 'social-pug' ) ) ); ?>

				<?php dpsp_settings_field( 'text', 'dpsp_location_content[display][message]', ( isset( $dpsp_location_content['display']['message']) ? $dpsp_location_content['display']['message'] : 'Sharing is caring!' ), __( 'Share text', 'social-pug' ), '' ); ?>

				<?php dpsp_settings_field( 'switch', 'dpsp_location_content[display][show_labels]', ( isset( $dpsp_location_content['display']['show_labels']) ? $dpsp_location_content['display']['show_labels'] : '' ), __( 'Show button labels', 'social-pug' ), array('yes') ); ?>

				<?php dpsp_settings_field( 'switch', 'dpsp_location_content[display][spacing]', ( isset( $dpsp_location_content['display']['spacing']) ? $dpsp_location_content['display']['spacing'] : '' ), __( 'Button spacing', 'social-pug' ), array('yes') ); ?>

				<?php dpsp_settings_field( 'switch', 'dpsp_location_content[display][show_mobile]', ( isset( $dpsp_location_content['display']['show_mobile']) ? $dpsp_location_content['display']['show_mobile'] : '' ), __( 'Show on mobile', 'social-pug' ), array('yes') ); ?>

				<?php dpsp_settings_field( 'text', 'dpsp_location_content[display][screen_size]', ( isset( $dpsp_location_content['display']['screen_size']) ? $dpsp_location_content['display']['screen_size'] : '' ), __( 'Mobile screen width (pixels)', 'social-pug' ), '', __( 'For screen widths smaller than this value ( in pixels ) the buttons will be displayed on screen if the show on mobile option is checked.', 'social-pug' ) ); ?>

			</div>

		</div>


		<!-- Share Counts -->
		<div class="dpsp-card">

			<div class="dpsp-card-header">
				<?php _e( 'Buttons Share Counts', 'social-pug' ); ?>
			</div>

			<div class="dpsp-card-inner">

				<?php dpsp_settings_field( 'switch', 'dpsp_location_content[display][show_count]', ( isset( $dpsp_location_content['display']['show_count']) ? $dpsp_location_content['display']['show_count'] : '' ), __( 'Show share count', 'social-pug' ), array('yes'), __( 'Display the share count for each social network.', 'social-pug' ) ); ?>

				<?php dpsp_settings_field( 'switch', 'dpsp_location_content[display][show_count_total]', ( isset( $dpsp_location_content['display']['show_count_total']) ? $dpsp_location_content['display']['show_count_total'] : '' ), __( 'Show total share count', 'social-pug' ), array('yes'), __( 'Display the share count for all social networks.', 'social-pug' ) ); ?>

				<?php dpsp_settings_field( 'select', 'dpsp_location_content[display][total_count_position]', ( isset( $dpsp_location_content['display']['total_count_position'] ) ? $dpsp_location_content['display']['total_count_position'] : '' ), __( 'Total count position', 'social-pug' ), array( 'before' => __( 'Before Buttons', 'social-pug' ), 'after' => __( 'After Buttons', 'social-pug' ) ) ); ?>

				<?php dpsp_settings_field( 'switch', 'dpsp_location_content[display][count_round]', ( isset( $dpsp_location_content['display']['count_round']) ? $dpsp_location_content['display']['count_round'] : '' ), __( 'Share count round', 'social-pug' ), array('yes'), __( 'If the share count for each network is bigger than 1000 it will be rounded to one decimal ( eg. 1267 will show as 1.2k ). Applies to Total Share Counts as well.', 'social-pug' ) ); ?>

			</div>

		</div>


		<!-- Post Type Display Settings -->
		<div class="dpsp-card">

			<div class="dpsp-card-header">
				<?php _e( 'Post Type Display Settings', 'social-pug' ); ?>
			</div>

			<div class="dpsp-card-inner">

				<?php dpsp_settings_field( 'checkbox', 'dpsp_location_content[post_type_display][]', ( isset( $dpsp_location_content['post_type_display']) ? $dpsp_location_content['post_type_display'] : array() ), '', dpsp_get_post_types() ); ?>
			
			</div>

		</div>


		<!-- Save Changes Button -->
		<input type="hidden" name="action" value="update" />
		<p class="submit"><input type="submit" class="dpsp-button-primary" value="<?php _e( 'Save Changes' ); ?>" /></p>
	
	</div>

</form>
<?php do_action( 'dpsp_submenu_page_bottom' ); ?>