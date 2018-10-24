<?php
/**
 * Template Name: Product Template
 */
?>

<section class="product-jumbotron">
  <div class="jumbotron bg-primary-gradient rounded-0 mb-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-9 col-xl-8 mx-auto text-center">
          <header>
            <h1 class="text-white mb-4">
              <?php the_field('product_jumbotron_header'); ?>
            </h1>
          </header>
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
<?php if (get_field('product_headline_header') && get_field('product_headline_content')): ?>
<section class="product-headline">
  <div class="container-fluid py-1 bg-secondary"></div>
  <div class="container-fluid py-5">
    <div class="row">
      <div class="col-lg-9 mx-auto text-center text-primary">
        <div class="py-lg-4">
          <h2 class="mb-4"><?php the_field('product_headline_header'); ?></h2>
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
<?php endif; ?>
<section class="product-alternating">
  <div class="container-fluid mb-5">

    <?php
      if (have_rows('product_alternating_sections')):
          while (have_rows('product_alternating_sections')) : the_row();
              if (get_row_layout() == 'image_left'): ?>

                <div class="row">
                  <div class="col-lg-12 col-xl-10 mx-auto">
                    <div class="row">
                      <div class="col-lg-3 px-0">
                        <img src="<?php the_sub_field('image'); ?>" alt="" class="img-fluid">
                        <p class="small mt-2"><?php the_sub_field('image_attribution'); ?></p>
                      </div>
                      <div class="col-lg-9">
                        <div class="py-5 px-lg-5">
                          <h3 class="text-primary my-4 mt-lg-0"><?php the_sub_field('header'); ?></h3>
                          <div class="text-muted mb-5">
                            <?php the_sub_field('content'); ?>
                          </div>
                          <?php $section_left_link = get_sub_field('link'); ?>
                          <?php if ($section_left_link): ?>
                            <a href="<?= $section_left_link['url']; ?>" class="btn btn-outline-primary-light btn-lg mb-4 mb-lg-0">
                              <?= $section_left_link['title']; ?>
                            </a>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <?php elseif (get_row_layout() == 'image_right'): ?>
                <div class="row">
                  <div class="col-lg-12 col-xl-10 mx-auto">
                    <div class="row">
                      <div class="col-lg-3 order-lg-2 px-0">
                        <img src="<?php the_sub_field('image'); ?>" alt="" class="img-fluid">
                        <p class="small mt-2"><?php the_sub_field('image_attribution'); ?></p>
                      </div>
                      <div class="col-lg-9 order-lg-1">
                        <div class="py-5 px-lg-5">
                          <h3 class="text-primary my-4 mt-lg-0"><?php the_sub_field('header'); ?></h3>
                          <div class="text-muted mb-5">
                            <?php the_sub_field('content'); ?>
                          </div>
                          <?php $section_right_link = get_sub_field('link'); ?>
                          <?php if ($section_right_link): ?>
                            <a href="<?= $section_right_link['url']; ?>" class="btn btn-outline-primary-light btn-lg mb-4 mb-lg-0">
                              <?= $section_right_link['title']; ?>
                            </a>
                          <?php endif; ?>
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
<section class="newsletter">
  <div class="container-fluid bg-primary py-4">
    <div class="row">
      <div class="col-lg-9 mx-auto text-center">
          <p class="h3 text-white mb-4 mb-md-0 d-md-inline drupalcon-cta">
            <?php the_field('product_newsletter_cta'); ?>
          </p>
        <a href="http://eepurl.com/dlqkUD" class="btn btn-outline-secondary btn-lg d-block d-md-inline-block mb-1 ml-md-3">
          Join Newsletter
        </a>
      </div>
    </div>
  </div>
</section>
<section class="product-recent-posts">
  <div class="container-fluid py-5">
    <div class="row">
      <?php $slug = get_post_field('post_name', get_post()); ?>
      <div class="col-lg-12 mx-auto">
        <h2 class="text-primary text-center mb-4">Related Posts</h2>
        <div class="card-deck">
          <?php
            $args = [
              'post_type' => 'post',
              'posts_per_page' => 3,
              'category_name' => $slug,
            ];
            $query = new WP_Query($args);
          ?>

          <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>

            <?php get_template_part('templates/content', 'card'); ?>

          <?php endwhile; ?>
          <!-- post navigation -->
        <?php else: ?>
          <!-- no posts found -->
        <?php endif; ?>

        <?php wp_reset_query(); ?>

        </div>
      </div>
    </div>
  </div>
</section>

