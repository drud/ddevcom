<?php
/**
 * Template Name: People Template
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <?php the_content(); ?>
  <?php wp_link_pages([
    'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'),
    'after' => '</p></nav>'
  ]); ?>
<?php endwhile; ?>
