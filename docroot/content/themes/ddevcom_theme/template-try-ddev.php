<?php
/**
 * Template Name: Try DDEV
 */

while (have_posts()) : the_post(); ?>

<?php get_template_part('templates/page', 'header'); ?>

<section>
  <div class="container-fluid py-5">
    <div class="row">
      <div class="col-lg-6 col-sm-8 col-md-7 mx-auto">
        <div class="py-lg-5">
          <header>
            <h1 class="text-primary mt-lg-5 my-4">Get Started with DDEV</h1>
          </header>
          <div class="wysiwyg">
            <?php the_content(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php endwhile;
