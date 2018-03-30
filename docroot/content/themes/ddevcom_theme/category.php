<section class="page-header-jumbotron">
  <div class="jumbotron bg-primary-gradient rounded-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-9 px-0 mx-auto">
          <header>
            <h1 class="text-white"><?php single_cat_title(); ?></h1>
            <div class="lead text-white"><?php the_field('page_header_subheader'); ?></div>
          </header>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="category-posts">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-9 mx-auto">
        <div class="row">
          <div class="col-lg-8">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
              <!-- post -->
              <?php get_template_part('templates/content'); ?>
            <?php endwhile; ?>
            <!-- post navigation -->
          <?php else: ?>
            <!-- no posts found -->
          <?php endif; ?>
          </div>
          <div class="col-lg-4">
            <?php get_template_part('templates/sidebar');  ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
