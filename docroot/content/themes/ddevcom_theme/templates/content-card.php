<div class="card rounded-0 border-0 bg-white py-5 text-center text-lg-left">
  <article class="persona-article">


    <?php if ($img = get_the_post_thumbnail(get_the_ID(), 'post-thumbnail', ['class' => 'card-img-top mb-4 rounded-0 img-fluid'])) : ?>
      <?= $img; ?>
    <?php endif;?>

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
