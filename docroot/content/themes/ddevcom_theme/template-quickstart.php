<?php
/**
 * Template Name: Quickstart Template
 */
?>

<?php while (have_posts()) : the_post(); ?>

<section>
  <div class="container-fluid py-5">
    <div class="row">
      <div class="col-lg-6 col-sm-8 col-md-7 mx-auto">
        <div class="py-lg-5">
          <h1 class="text-primary mt-lg-5 mb-4">Get Started with DDEV</h1>
          <div class="wysiwyg">
            <?php the_content(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php endwhile; ?>
