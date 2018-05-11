<div class="card rounded-0 border-0 bg-white py-5 text-center text-lg-left">
  <article class="persona-article">

    <?php
      if(get_field('_social_image_url')) {
        $card_image_url = get_field('_social_image_url');
      } else {
        $card_image_url = get_the_post_thumbnail_url();
      }
    ?>

    <img class="card-img-top mb-4 rounded-0" src="<?= $card_image_url; ?>" alt="<?php the_title(); ?>">
    <header>
      <div class="card-header border-0 py-0 bg-white">
          <h3 class="mb-3">
            <a href="<?php the_permalink(); ?>" class="text-primary-light"><?php the_title(); ?></a>
          </h3>
          <?php get_template_part('templates/entry-meta'); ?>
      </div>
    </header>
    <div class="card-body">
      <div class="text-muted">
        <?php the_excerpt(); ?>
      </div>
    </div>
    <div class="card-footer border-0 bg-white">
      <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-primary-light">View Post</a>
    </div>
  </article>
</div>