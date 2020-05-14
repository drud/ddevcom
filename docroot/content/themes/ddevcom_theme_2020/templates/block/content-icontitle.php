<?php
// phpcs:ignoreFile

/**
 * Block Name: Icon Title
 *
 * This is the template that displays the testimonial block.
 */

// get image field (array)
$title_header = get_field('title_w_icon_header');
$title_class = get_field('title_w_icon_class');

// create id attribute for specific styling
$id = 'icontitle-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';

?>
<h3
  id="<?php echo $id; ?>"
  class="<?php echo $align_class; ?>"
>
  <span class="rounded-circle bg-info text-white">
    <i class="fa <?php echo $title_class; ?>" aria-hidden="true"></i>
  </span>
  <?php echo $title_header; ?>
</h3>
