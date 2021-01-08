<section class="blog-posts">
  <div class="container">
    <div class="row">
      <div class="col mx-auto">
        <div class="py-lg-5 mt-lg-5">
          <h1 class="text-dark display-4 mt-5 mb-4 mb-lg-0"><?php echo single_cat_title(); ?></h1>
        </div>
        <div class="row">
          <div class="col-lg-8">
            <div class="row">
              <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <!-- post -->
                <div class="col-lg-6 d-flex">
                  <?php get_template_part('templates/content', 'card'); ?>
                </div>
              <?php endwhile; ?>
              <div class="col-12 py-5">
                <?php the_posts_pagination(); ?>
              </div>
            <?php else: ?>
              <!-- no posts found -->
            <?php endif; ?>
            </div>
          </div>
          <div class="col-lg-4">
            <?php get_template_part('templates/sidebar');  ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
