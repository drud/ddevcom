<section class="category-posts">
  <div class="container mb-5">
    <div class="row">
      <div class="py-lg-5 mt-lg-5">
        <h1 class="text-dark display-4 mt-lg-5">Events</h1>
      </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
          <div class="row">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
              <!-- post -->
              <div class="col-lg-6">
                <?php get_template_part('templates/content', 'card-event'); ?>
              </div>
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
</section>
