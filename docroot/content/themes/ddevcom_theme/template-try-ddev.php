<?php
/**
 * Template Name: Try DDEV
 */

while (have_posts()) : the_post();
  // jumbotron
  get_template_part('templates/landing', 'jumbotron'); ?>

<section class="landing-signup bg-light">
  <div class="container-fluid py-1 bg-secondary"></div>
  <div class="container py-5">
    <div class="row py-5">
      <div class="col-md-12">
        <?php the_content(); ?>
      </div>
      <div class="col-md-12 offset-md-1">
        <div class="p-5">
          <h2 class="my-5">Sign Up Now</h2>
          <?php gravity_form(8, false, false, false, null, true);?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
endwhile;
