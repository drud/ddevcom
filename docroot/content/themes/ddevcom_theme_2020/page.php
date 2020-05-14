<?php while (have_posts()) : the_post(); ?>
  <?php
    if (get_field('display_header') !== false)
      get_template_part('templates/page', 'header');
  ?>
  <?php get_template_part('templates/content', 'page'); ?>
<?php endwhile; ?>
