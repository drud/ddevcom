<?php
// phpcs:ignoreFile

/**
 * Block Name: Events Banner
 *
 * This is the template that displays the testimonial block.
 */

// get image field (array)
$avatar = get_field('avatar');

// create id attribute for specific styling
$id = 'event-banner-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';

?>
<section
  id="<?php echo $id; ?>"
  class="persona-type-events events m-0 <?php echo $align_class; ?>"
>
  <div class="container-fluid bg-primary-gradient py-5">
    <?php if (is_active_sidebar('front-page-events')): ?>
      <?php dynamic_sidebar('front-page-events'); ?>
    <?php endif; ?>
  </div>
</section>



