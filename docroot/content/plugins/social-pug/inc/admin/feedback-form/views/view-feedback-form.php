<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<!-- Feedback form button -->
<div id="dpsp-feedback-button" class="dpsp-inactive">
	
	<img src="<?php echo DPSP_PLUGIN_DIR_URL . 'inc/admin/feedback-form/assets/img/corgi-100x100.png' ?>" />
	<span class="dpsp-close dashicons dashicons-no-alt"></span>

</div>

<!-- Feedback form -->
<div id="dpsp-feedback-form-wrapper" class="dpsp-inactive">

	<!-- Form Header -->
	<div id="dpsp-feedback-form-header">

		<div id="dpsp-feedback-form-header-image">
			<img src="<?php echo DPSP_PLUGIN_DIR_URL . 'inc/admin/feedback-form/assets/img/corgi-100x100.png' ?>" />
		</div>

		<strong><?php echo __( "I'm here to help", 'social-pug' ); ?></strong>

	</div>

	<!-- Form Inner -->
	<div id="dpsp-feedback-form-inner">
		
		<!-- Panel 1 -->
		<div id="dpsp-feedback-form-panel-1" class="dpsp-feedback-form-panel dpsp-doing">

			<label class="dpsp-feedback-form-panel-label"><?php echo __( 'Hey there! How can I help you?', 'social-pug' ); ?></label>

			<input id="dpsp-feedback-form-radio-bug" type="radio" name="issue" value="Bug" />
			<label for="dpsp-feedback-form-radio-bug" class="dpsp-selection-label"><?php echo __( 'I think I found a bug. Something is not working right.', 'social-pug' ); ?></label>

			<input id="dpsp-feedback-form-radio-setup" type="radio" name="issue" value="Setup" />
			<label for="dpsp-feedback-form-radio-setup" class="dpsp-selection-label"><?php echo __( "I don't know how to set up the plugin.", 'social-pug' ); ?></label>

			<input id="dpsp-feedback-form-radio-feature" type="radio" name="issue" value="Feature" />
			<label for="dpsp-feedback-form-radio-feature" class="dpsp-selection-label"><?php echo __( 'I want to propose a new feature for the plugin.', 'social-pug' ); ?></label>

			<input id="dpsp-feedback-form-radio-other" type="radio" name="issue" value="Other" />
			<label for="dpsp-feedback-form-radio-other" class="dpsp-selection-label"><?php echo __( 'Some other thing...', 'social-pug' ); ?></label>

		</div>

		<!-- Panel 2 -->
		<div id="dpsp-feedback-form-panel-2" class="dpsp-feedback-form-panel dpsp-todo">

			<label class="dpsp-feedback-form-panel-label"><?php echo __( 'Please detail a bit more:', 'social-pug' ); ?></label>

			<textarea placeholder="<?php echo __( 'Write the details here...', 'social-pug' ); ?>"></textarea>

			<p id="dpsp-feedback-form-description-char-count-1" class="description"><?php echo __( 'Minimum 80 characters', 'social-pug' ); ?></p>
			<p id="dpsp-feedback-form-description-char-count-2" class="description"><?php echo sprintf( __( '%s characters remaining', 'social-pug' ), '<span id="dpsp-feedback-form-char-count">80</span>' ); ?></p>

		</div>

		<!-- Panel 3 -->
		<div id="dpsp-feedback-form-panel-3" class="dpsp-feedback-form-panel dpsp-todo">

			<label class="dpsp-feedback-form-panel-label"><?php echo __( 'Please enter your email address:', 'social-pug' ); ?></label>

			<input type="email" value="" placeholder="<?php echo __( 'Write the email address here...', 'social-pug' ); ?>" />

			<p class="description"><?php echo __( "Let us know where to contact you regarding your request.", 'social-pug' ); ?></p>

		</div>

		<!-- Panel 4 - Success message -->
		<div id="dpsp-feedback-form-panel-4" class="dpsp-feedback-form-panel dpsp-todo">

			<span class="dashicons dashicons-yes"></span>
			<p><?php echo __( 'Thank you for reaching out! We will get back to you as soon as possible.', 'social-pug' ); ?></p>

		</div>

	</div>

	<!-- Form Navigation -->
	<div id="dpsp-feedback-form-navigation">

		<a id="dpsp-feedback-form-back" href="#"><?php echo __( 'Back', 'social-pug' ); ?></a>
		<a id="dpsp-feedback-form-next" class="dpsp-inactive" href="#"><?php echo __( 'Next', 'social-pug' ); ?></a>
		<a id="dpsp-feedback-form-send" class="dpsp-inactive" href="#"><?php echo __( 'Send', 'social-pug' ); ?></a>

		<div class="spinner"><!-- --></div>

	</div>

	<!-- Nonce -->
	<?php wp_nonce_field( 'dpsp_feedback_form', 'dpsp_token', false ); ?>

</div>