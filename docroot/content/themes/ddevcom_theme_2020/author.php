<section class="category-posts">
  <div class="container py-5">


      <?php
        $current_author = get_query_var('author_name') ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
      ?>

      <div class="row">
        <div class="col-lg-4">
          <div class="mb-4">
            <img class="rounded-circle" src="<?php echo get_avatar_url($current_author->data->ID); ?>" alt="<?= get_the_author_meta('display_name'); ?>">
            <h1 class="text-primary d-inline"><?= $current_author->data->display_name; ?></h1>
          </div>
        </div>
        <div class="col-lg-8">
            <p class="text-muted"><?= get_the_author_meta('description', $current_author->data->ID); ?></p>
        </div>
      </div>

      <?php if (have_posts()) : ?>
        <h3 class="text-dark mb-4">Posts by <?= $current_author->data->display_name; ?>:</h3>
        <div class="row">
          <?php while (have_posts()) : the_post(); ?>
            <div class="col-lg-4 d-flex">
                <?php get_template_part('templates/content', 'card'); ?>
            </div>
          <?php endwhile; ?>
        </div>
        <div class="mb-5">
          <?php the_posts_pagination(); ?>
        </div>
      <?php endif; ?>
  </div>
</section>

