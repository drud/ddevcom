<?php
/**
 * Day View Template
 * The wrapper template for day view.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/day.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

do_action( 'tribe_events_before_template' );
?>

<div class="container">
  <div class="row col-lg-12">
    <div class="my-2 my-lg-5 w-100">
      <?php tribe_get_template_part( 'modules/bar' ); ?>
      <?php tribe_get_template_part( 'day/content' ); ?>
    </div>
  </div>
</div>

<?php
do_action( 'tribe_events_after_template' );
