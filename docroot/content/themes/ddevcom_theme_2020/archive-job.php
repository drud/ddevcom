<section class="category-posts">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-9 mx-auto">
        <div class="py-lg-5 mt-lg-5">
          <h1 class="text-primary display-4 mt-lg-5">Jobs</h1>
        </div>
        <div class="row">
          <div class="col-lg-8">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
              <!-- post -->
              <?php get_template_part('templates/content', 'job'); ?>
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
