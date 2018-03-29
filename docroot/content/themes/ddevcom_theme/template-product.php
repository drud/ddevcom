<?php
/**
 * Template Name: Product Template
 */
?>

<section class="product-jumbotron">
  <div class="jumbotron bg-primary-light rounded-0 mb-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-9 mx-auto text-center">
          <p class="h1 text-white mb-4">
            <?php the_field('product_jumbotron_header'); ?>
          </p>
          <div class="text-white mb-5 lead">
            <?php the_field('product_jumbotron_content'); ?>
          </div>

          <?php $button_1_link = get_field('product_jumbotron_button_1_link'); ?>
          <?php if ($button_1_link): ?>
            <a href="<?= $button_1_link['url']; ?>" class="btn btn-outline-secondary btn-lg">
              <?= $button_1_link['title']; ?>
            </a>
          <?php endif; ?>

          <?php $button_2_link = get_field('product_jumbotron_button_2_link'); ?>
          <?php if ($button_2_link): ?>
            <a href="<?= $button_2_link['url']; ?>" class="btn btn-outline-light btn-lg">
              <?= $button_2_link['title']; ?>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="product-headline">
  <div class="container-fluid py-5">
    <div class="row">
      <div class="col-lg-9 mx-auto text-center text-primary">
        <div class="py-lg-4">
          <h3 class="h2 mb-4"><?php the_field('product_headline_header'); ?></h3>
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="text-muted">
                <?php the_field('product_headline_content'); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="product-alternating">
  <div class="container-fluid mb-5">

    <?php
      if( have_rows('product_alternating_section') ):
          while ( have_rows('product_alternating_section') ) : the_row();
              if( get_row_layout() == 'image_left' ): ?>

                <div class="row">
                  <div class="col-lg-12 col-xl-10 mx-auto">
                    <div class="row">
                      <div class="col-lg-6 px-0">
                        <img src="<?php the_sub_field('image'); ?>" alt="" class="img-fluid">
                        <p class="small mt-2"><?php the_sub_field('image_attribution'); ?></p>
                      </div>
                      <div class="col-lg-6">
                        <div class="py-5 px-lg-5">
                          <h4 class="text-primary h3 my-4 mt-lg-0"><?php the_sub_field('header'); ?></h4>
                          <div class="text-muted mb-5">
                            <?php the_sub_field('content'); ?>
                          </div>
                          <?php $section_left_link = get_sub_field('link'); ?>
                          <a href="<?= $section_left_link['url']; ?>" class="btn btn-outline-primary-light btn-lg mb-4 mb-lg-0">
                            <?= $section_left_link['title']; ?>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <?php elseif( get_row_layout() == 'image_right' ): ?>
                <div class="row">
                  <div class="col-lg-12 col-xl-10 mx-auto">
                    <div class="row">
                      <div class="col-lg-6 order-lg-2 px-0">
                        <img src="<?php the_sub_field('image'); ?>" alt="" class="img-fluid">
                        <p class="small mt-2"><?php the_sub_field('image_attribution'); ?></p>
                      </div>
                      <div class="col-lg-6 order-lg-1">
                        <div class="py-5 px-lg-5">
                          <h4 class="text-primary h3 my-4 mt-lg-0"><?php the_sub_field('header'); ?></h4>
                          <div class="text-muted mb-5">
                            <?php the_sub_field('content'); ?>
                          </div>
                          <?php $section_right_link = get_sub_field('link'); ?>
                          <a href="<?= $section_right_link['url']; ?>" class="btn btn-outline-primary-light btn-lg mb-4 mb-lg-0">
                            <?= $section_right_link['title']; ?>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

        <?php
              endif;
            endwhile;
          endif;
         ?>
  </div>
</section>
<section class="drupalcon">
  <div class="container-fluid bg-primary py-4">
    <div class="row">
      <div class="col-lg-9 mx-auto text-center">
        <img src="/content/themes/ddevcom_theme/dist/images/drupalcon-2018-logo.svg"
        alt="DrupalCon Nashville 2018"
        class="product-drupalcon-logo mr-3" width="80">
          <p class="h3 text-white mb-4 mb-md-0 d-md-inline drupalcon-cta">
            <?php the_field('product_drupalcon_cta'); ?>
          </p>
          <?php $drupalcon_link = get_field('product_drupalcon_cta_link'); ?>
        <a href="#" data-toggle="modal" data-target="#modal-newsletter" class="btn btn-outline-secondary btn-lg d-block d-md-inline-block mb-1 ml-md-3">
          Join Newsletter
        </a>
      </div>
    </div>
  </div>
</section>
<section class="product-testimonials testimonials">
  <div class="container-fluid bg-primary-dark py-5">

    <?php if ( have_rows('product_testimonials') ): ?>
        <?php while ( have_rows('product_testimonials') ) : the_row(); ?>

          <?php $testimonial = get_sub_field('testimonial'); ?>

          <div class="row">
            <div class="col-lg-6 mx-auto">
              <div class="testimonial py-4">
                <img  width="80" src="<?= get_field('testimonial_image', $testimonial->ID); ?>" alt="" class="rounded-circle d-block mx-auto mb-4">
                <div class="h4 text-light text-center">
                  <?= get_field('testimonial_body', $testimonial->ID); ?>
                </div>
                <p class="text-white text-center">
                  - <?= get_field('testimonial_name', $testimonial->ID); ?>, <a href="<?= get_field('testimonial_company_link', $testimonial->ID); ?>" class="text-secondary-light"><?= get_field('testimonial_company', $testimonial->ID); ?></a>
                </p>
              </div>
            </div>
          </div>

        <?php endwhile; ?>
    <?php endif; ?>

  </div>
</section>
