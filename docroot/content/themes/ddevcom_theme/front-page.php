<section class="front-page-jumbotron">
  <div class="jumbotron bg-primary-gradient rounded-0 mb-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-9 col-xl-8 mx-auto text-center">
          <header>
            <h1 class="text-white mb-4">
              <?php the_field('front_page_jumbotron_header'); ?>
            </h1>
          </header>
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
              <div class="col-lg-3 py-4 px-4 text-center">
                <img src="/content/themes/ddevcom_theme/dist/images/drupal.svg" alt="Drupal" width="200" class="img-fluid mb-3 mb-lg-0">
              </div>
              <div class="col-lg-3 text-center">
                <img src="/content/themes/ddevcom_theme/dist/images/wordpress.svg" alt="Drupal" width="200" class="img-fluid mt-lg-4 mb-5 mb-lg-0">
              </div>
              <div class="col-lg-3 text-center">
                <img src="/content/themes/ddevcom_theme/dist/images/typo3.svg" alt="Drupal" width="200" class="img-fluid mt-lg-4 mb-3 mb-lg-0">
              </div>
              <div class="col-lg-3 text-center">
                <img src="/content/themes/ddevcom_theme/dist/images/backdrop-cms-logo.svg" alt="Drupal" width="200" class="img-fluid mt-lg-4 mb-3 mb-lg-0">
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
<section class="newsletter">
  <div class="container-fluid py-1 bg-secondary rounded-1"></div>
  <div class="container-fluid bg-primary-dark py-4">
    <div class="row">
      <div class="col-lg-9 mx-auto text-center">
        <?php if(get_field('front_page_newsletter_cta_image')): ?>
          <img src="<?= get_field('front_page_newsletter_cta_image'); ?>"
          alt="DDEV Newsletter"
          class="mr-3" width="80">
        <?php endif; ?>
          <p class="h3 text-white mb-4 mb-md-0 d-md-inline newsletter-cta">
            <?php the_field('front_page_newsletter_cta'); ?>
          </p>
        <a href="http://eepurl.com/dlqkUD" class="btn btn-outline-secondary btn-lg d-block d-md-inline-block mb-1 ml-md-3">
          Join Newsletter
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
          <h2 class="mb-4"><?php the_field('front_page_headline_header'); ?></h2>
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
      <div class="col-lg-9 mx-auto">
        <div class="video-wrapper mb-4">
          <iframe width="560" height="315" src="<?php the_field('front_page_video_embed_url'); ?>?modestbranding=1&showinfo=0&rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        </div>
        <div class="front-page-video-summary p text-muted">
          <?php the_field('front_page_video_summary'); ?>
        </div>
        <div class="text-center mx-auto py-3">
          <?php if(get_field('front_page_video_link_1')): ?>
            <?php $video_link_1 = get_field('front_page_video_link_1'); ?>
            <a href="<?= $video_link_1['url']; ?>" class="btn btn-outline-primary-light">
              <?= $video_link_1['title']; ?>
            </a>
          <?php endif; ?>
          <?php if(get_field('front_page_video_link_2')): ?>
            <?php $video_link_2 = get_field('front_page_video_link_2'); ?>
            <a href="<?= $video_link_2['url']; ?>" class="btn btn-outline-dark">
              <?= $video_link_2['title']; ?>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php endif; ?>

<?php if(get_field('front_page_tweets')): ?>

<section class="front-page-tweets bg-light py-5">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-9 mx-auto py-lg-5">

        <?php if(get_field('front_page_tweets_header')): ?>
          <h3 class="text-primary text-center mb-4"><?php the_field('front_page_tweets_header'); ?></h3>
        <?php endif; ?>

        <div class="card-deck">

          <?php if(have_rows('front_page_tweets')): ?>
            <?php while(have_rows('front_page_tweets')):  ?>
              <?php the_row(); ?>

                <div class="card rounded-0 border-0 bg-light">
                  <?php the_sub_field('tweet_embed_code'); ?>
                </div>

            <?php endwhile; ?>
          <?php endif; ?>

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
        <header>
          <h2 class="text-primary text-center">Recent Posts</h2>
        </header>
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
