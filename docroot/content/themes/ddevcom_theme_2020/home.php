<section class="blog-posts">
  <div class="container">
    <div class="row">
      <div class="col mx-auto">
        <div class="py-lg-5 mt-lg-5">
          <h1 class="text-dark display-4 mt-5 mb-4 mb-lg-0">Blog</h1>
        </div>
        <div class="row">
          <div class="col-lg-8">
            <div class="row">
              <div class="col">
                <form action="/" class="mb-4">
                  <div class="input-group input-group-lg mb-2">
                    <span class="input-group-addon" id="sizing-addon1">
                      <i class="fa fa-search"></i>
                    </span>
                    <input type="text" class="form-control" name="s"/>
                    <span class="input-group-btn">
                      <button class="btn btn-secondary" type="submit">Search</button>
                    </span>
                  </div>
                </form>
              </div>
            </div>
            <div class="row">
              <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <!-- post -->
                <div class="col-lg-6 d-flex">
                  <?php get_template_part('templates/content', 'card-post'); ?>
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
