<?php
/**
 * List View Template
 * The wrapper template for a list of events. This includes the Past Events and Upcoming Events views
 * as well as those same views filtered to a specific category.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list.php
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
      <?php tribe_get_template_part( 'list/content' ); ?>
    </div>
  </div>
</div>

<?php
do_action( 'tribe_events_after_template' );
