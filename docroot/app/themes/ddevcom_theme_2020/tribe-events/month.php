<?php
/**
 * Month View Template
 * The wrapper template for month view.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/month.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
} ?>

<?php do_action( 'tribe_events_before_template' ); ?>

<div class="container">
  <div class="row col-lg-12">
    <div class="my-2 my-lg-5">
      <?php tribe_get_template_part( 'modules/bar' ); ?>
      <?php tribe_get_template_part( 'month/content' ); ?>
    </div>
  </div>
</div>


<?php do_action( 'tribe_events_after_template' ); ?>
