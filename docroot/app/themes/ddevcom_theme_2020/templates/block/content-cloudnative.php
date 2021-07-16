<?php
// phpcs:ignoreFile

/**
 * Block Name: Cloud Native
 *
 * This is the template that displays the testimonial block.
 */

// create id attribute for specific styling
$id = 'icontitle-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';

?>
<div
  id="<?php echo $id; ?>"
  class="<?php echo $align_class; ?>"
>
  <h2 class="mb-3"><small class="text-uppercase d-block">Open Source</small>Cloud-Native</h2>
  <p>DDEV is a Cloud-Native-Foundation-friendly, best-of-breed platform, built on the shoulders of giants using
    open source technologies backed by active open source communities. The DDEV dev-to-deploy toolset is licensed
    under the open source Apache 2.0 license.</p>

  <p class="text-center text-md-left pb-0 pt-3">
    <img class="img-fluid" src="<?= get_stylesheet_directory_uri(); ?>/dist/images/CNCF-project-icons.png"
      alt="">
  </p>
</div>
