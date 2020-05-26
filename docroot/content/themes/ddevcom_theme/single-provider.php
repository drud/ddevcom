<?php while(have_posts()): the_post(); ?>
<section class="single-builder-header">
  <div class="jumbotron bg-primary-gradient rounded-0 mb-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-6 mx-auto">
          <div class="py-lg-5">
            <img  width="80" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="rounded-circle d-block mx-auto mb-4">
            <h1 class="text-white text-center mt-lg-4"><?php the_title(); ?></h1>
            <?php $post_type = get_post_type_object( get_post_type() ); ?>
            <p class="text-center text-secondary-light lead"><?= $post_type->labels->singular_name; ?></p>
            <div class="testimonial py-2">
              <div class="h4 text-light text-center">
                <?php the_field('builder_featured_quote'); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="newsletter">
  <div class="container-fluid bg-primary py-4">
    <div class="row">
      <div class="col-lg-9 mx-auto text-center">
          <p class="h3 text-white mb-4 mb-md-0 d-md-inline drupalcon-cta">
            Join our newsletter!
          </p>
        <a href="http://eepurl.com/dlqkUD" class="btn btn-outline-secondary btn-lg d-block d-md-inline-block mb-1 ml-md-3">
          Join Newsletter
        </a>
      </div>
    </div>
  </div>
</section>
<section class="single-builder-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-7 mx-auto">
        <div class="py-lg-5">
          <div class="wysiwyg">
            <?php the_content(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php endwhile; ?>
