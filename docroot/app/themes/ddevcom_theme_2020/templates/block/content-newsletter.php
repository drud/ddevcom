<?php
// phpcs:ignoreFile

/**
 * Block Name: Testimonial
 *
 * This is the template that displays the testimonial block.
 */

// create id attribute for specific styling
$id = 'testimonial-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';

?>
<section
  id="<?php echo $id; ?>"
  class="newsletter <?php echo $align_class; ?>"
>
  <div class="container-fluid bg-primary-dark py-4 m-0">
    <div class="row">
      <div class="col-lg-9 mx-auto text-center">
          <p class="h3 text-white mb-4 mb-md-0 d-md-inline newsletter-cta">
            Receive news and updates as we roll out hosting access:
          </p>
        <a href="http://eepurl.com/dlqkUD" class="btn btn-outline-secondary btn-lg d-block d-md-inline-block mb-1 ml-md-3">
          Join Newsletter
        </a>
      </div>
    </div>
  </div>
</section>
