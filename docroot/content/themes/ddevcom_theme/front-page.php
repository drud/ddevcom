<section class="front-page-jumbotron">
  <div class="jumbotron bg-primary-gradient rounded-0 mb-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-9 col-xl-8 mx-auto text-center">
          <p class="h1 text-white mb-4">
            <?php the_field('front_page_jumbotron_header'); ?>
          </p>
          <div class="text-white lead mb-2">
            <?php the_field('front_page_jumbotron_content'); ?>
          </div>
          <div class="front-page-logos mb-5">
            <div class="row mt-4">
              <div class="col-lg-12 text-center">
                <p class="text-secondary">Proudly supporting:</p>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-4 py-4 px-4 text-center">
                <img src="/content/themes/ddevcom_theme/dist/images/drupal.svg" alt="Drupal" width="200" class="img-fluid mb-3 mb-lg-0">
              </div>
              <div class="col-lg-4 text-center">
                <img src="/content/themes/ddevcom_theme/dist/images/wordpress.svg" alt="Drupal" width="200" class="img-fluid mt-lg-4 mb-5 mb-lg-0">
              </div>
              <div class="col-lg-4 text-center">
                <img src="/content/themes/ddevcom_theme/dist/images/typo3.svg" alt="Drupal" width="200" class="img-fluid mt-lg-4 mb-3 mb-lg-0">
              </div>
            </div>
          </div>

          <?php $button_1_link = get_field('front_page_jumbotron_button_1_link'); ?>
          <?php if ($button_1_link): ?>
            <a href="<?= $button_1_link['url']; ?>" class="btn btn-outline-secondary btn-lg">
              <?= $button_1_link['title']; ?>
            </a>
          <?php endif; ?>

          <?php $button_2_link = get_field('front_page_jumbotron_button_2_link'); ?>
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
<section class="drupalcon">
  <div class="container-fluid py-1 bg-secondary rounded-1"></div>
  <div class="container-fluid bg-primary-dark py-4">
    <div class="row">
      <div class="col-lg-9 mx-auto text-center">
        <img src="/content/themes/ddevcom_theme/dist/images/drupalcon-2018-logo.svg"
        alt="DrupalCon Nashville 2018"
        class="front-page-drupalcon-logo mr-3" width="80">
          <p class="h3 text-white mb-4 mb-md-0 d-md-inline drupalcon-cta">
            <?php the_field('front_page_drupalcon_cta'); ?>
          </p>
          <?php $drupalcon_link = get_field('front_page_drupalcon_cta_link'); ?>
        <a href="#" data-toggle="modal" data-target="#modal-newsletter" class="btn btn-outline-secondary btn-lg d-block d-md-inline-block mb-1 ml-md-3">
          <?= $drupalcon_link['title']; ?>
        </a>
      </div>
    </div>
  </div>
</section>
<section class="front-page-headline">
  <div class="container-fluid pt-5">
    <div class="row">
      <div class="col-lg-9 col-xl-6 mx-auto text-center text-primary">
        <div class="py-lg-4">
          <h3 class="h2 mb-4"><?php the_field('front_page_headline_header'); ?></h3>
          <div class="row">
            <div class="col-lg-12 mx-auto">
              <div class="text-muted">
                <?php the_field('front_page_headline_content'); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php if(get_field('front_page_video_embed_url')): ?>
<section class="front-page-video">
  <div class="container-fluid mb-5">
    <div class="row">
      <div class="col-lg-8 mx-auto">
        <div class="video-wrapper">
          <iframe width="560" height="315" src="<?php the_field('front_page_video_embed_url'); ?>?modestbranding=1&showinfo=0&rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>
<section class="front-page-recent-posts">
  <div class="container-fluid py-5">
    <div class="row">
      <?php $slug = get_post_field( 'post_name', get_post() ); ?>
      <div class="col-lg-12 mx-auto">
        <h2 class="text-primary text-center">Recent Posts</h2>
        <div class="card-deck">
          <?php
            $args = [
              'post_type' => 'post',
              'posts_per_page' => 3
            ];
            $query = new WP_Query($args);
          ?>

          <?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>

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
<section class="front-page-events events">
  <div class="container-fluid py-1 bg-secondary"></div>
  <div class="container-fluid bg-primary-dark py-5">

    <?php if (is_active_sidebar('front-page-events')): ?>
      <?php dynamic_sidebar('front-page-events'); ?>
    <?php endif; ?>

  </div>
</section>

<section>
  <div class="container-fluid bg-primary py-4">
    <div class="row">
    </div>
  </div>
</section>
