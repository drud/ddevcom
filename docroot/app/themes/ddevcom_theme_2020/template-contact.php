<?php
/**
 * Template Name: Contact Template
 */
?>
<?php get_template_part('templates/page', 'header'); ?>

<?php while (have_posts()) : the_post(); ?>
  <?php the_content(); ?>
  <?php wp_link_pages([
    'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'),
    'after' => '</p></nav>'
  ]); ?>
<?php endwhile; ?>

<?php while (have_posts()) : the_post(); ?>
  <div class="container py-5">
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

<?php endwhile; ?>
