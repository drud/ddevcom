<article <?php post_class('mb-5'); ?>>
  <header>
    <h2 class="entry-title mb-4">
        <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
    </h2>
    <p><?php the_field('event_start_date'); ?> - <?php the_field('event_start_date'); ?></p>
    <p><?php the_field('event_location'); ?></p>
  </header>
  <div class="entry-summary">
    <?php the_excerpt(); ?>
  </div>
</article>
