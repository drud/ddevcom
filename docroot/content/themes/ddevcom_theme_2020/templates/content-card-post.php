<div class="post-card card mb-4 d-flex">
  <a href="<?php the_permalink(); ?>">
    <?php
      echo wp_get_attachment_image(get_post_thumbnail_id(), 'post-card-header', false, [
        'class' => 'post-card__header-image card-img-top img-fluid'
      ]);
    ?>
  </a>
  <div class="card-body">
    <p class="post-card__date"><?php the_date(); ?></p>
    <h4 class="post-card__title card-title">
      <a class="text-primary-light" href="<?php the_permalink(); ?>">
        <?php the_title(); ?>
      </a>
    </h4>
  </div>
  <div class="post-card__footer card-footer text-muted">
    <img class="rounded-circle" width="30" src="<?php echo get_avatar_url(get_the_author_meta('ID')); ?>" alt="<?= get_the_author_meta('display_name'); ?>">
    <?= __('By', 'sage'); ?> <a href="<?= get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="text-muted d-inline-block mt-2"><?= get_the_author_meta('display_name'); ?></a>
  </div>
</div>
