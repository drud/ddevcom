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
          <div class="wysiwyg">
            <?php the_content(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php endwhile;
