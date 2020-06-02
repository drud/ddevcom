<?php
// phpcs:ignoreFile

/**
 * Block Name: Icon Title
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
  class="front-page-logos mb-5 <?php echo $align_class; ?>"
>
  <div class="row mt-4">
    <div class="col-lg-12 text-center">
      <p class="text-secondary">Proudly supporting:</p>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-3 py-4 px-4 text-center">
      <img src="/content/themes/ddevcom_theme/dist/images/drupal.svg" alt="Drupal" width="200" class="img-fluid mb-3 mb-lg-0">
    </div>
    <div class="col-lg-3 text-center">
      <img src="/content/themes/ddevcom_theme/dist/images/wordpress.svg" alt="Drupal" width="200" class="img-fluid mt-lg-4 mb-5 mb-lg-0">
    </div>
    <div class="col-lg-3 text-center">
      <img src="/content/themes/ddevcom_theme/dist/images/typo3.svg" alt="Drupal" width="200" class="img-fluid mt-lg-4 mb-3 mb-lg-0">
    </div>
    <div class="col-lg-3 text-center">
      <img src="/content/themes/ddevcom_theme/dist/images/backdrop-cms-logo.svg" alt="Drupal" width="200" class="img-fluid mt-lg-4 mb-3 mb-lg-0">
    </div>
  </div>
</div>
