<div class="post-card card mb-4">
  <div class="card-body">
    <p class="post-card__date"><?php the_date(); ?></p>
    <h4 class="post-card__title card-title">
      <a class="text-primary-light" href="<?php the_permalink(); ?>">
        <?php the_title(); ?>
      </a>
    </h4>
  </div>
</div>
