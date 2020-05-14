<section class="category-posts">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-9 mx-auto">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <div class="pt-lg-5 mt-lg-5 mb-lg-5">
            <?php
              $current_author = get_query_var('author_name') ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
            ?>
              <div class="d-block mt-lg-5 mb-4">
                <img class="rounded-circle" src="<?= get_avatar_url($current_author->data->id); ?>" alt="<?= $current_author->data->display_name; ?>">
                <h1 class="text-primary d-inline"><?= $current_author->data->display_name; ?></h1>
              </div>
              <p class="text-muted"><?= get_the_author_description($current_author->data->id); ?></p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <h3 class="text-primary-light mb-4">Posts by <?= $current_author->data->display_name; ?>:</h3>
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
              <!-- post -->
              <?php get_template_part('templates/content'); ?>
            <?php endwhile; ?>
            <div class="py-5">
              <?php the_posts_pagination(); ?>
            </div>
          <?php else: ?>
            <!-- no posts found -->
          <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
