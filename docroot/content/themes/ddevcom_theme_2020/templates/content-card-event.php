<div class="post-card card mb-4">
  <a href="<?php the_permalink(); ?>">
    <?php
      echo wp_get_attachment_image(get_post_thumbnail_id(), 'post-card-header', false, [
        'class' => 'post-card__header-image card-img-top img-fluid'
      ]);
    ?>
  </a>
  <div class="card-body">
    <p class="post-card__date"><?php the_field('event_start_date'); ?> - <?php the_field('event_end_date'); ?></p>
    <h4 class="post-card__title card-title">
      <a class="text-primary-light" href="<?php the_permalink(); ?>">
        <?php the_title(); ?>
      </a>
    </h4>
  </div>
</div>
