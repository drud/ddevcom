<?php
/**
 * Template Name: Contact Template
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/page', 'header'); ?>

  <div class="container-fluid py-5">
    <div class="row">
      <div class="col-lg-8 mx-auto">
        <div class="row">
          <div class="col-lg-6">
            <?php the_field('contact_form'); ?>
          </div>
          <div class="col-lg-6">
            <address class="contact-address">
              <?php the_field('contact_address'); ?>
            </address>

            <div class="phone">
              <?php the_field('contact_phone'); ?>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

<?php endwhile; ?>
