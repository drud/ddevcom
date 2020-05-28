<?php while (have_posts()) : the_post(); ?>
  <?php the_content(); ?>
  <?php wp_link_pages([
    'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'),
    'after' => '</p></nav>'
  ]); ?>
<?php endwhile; ?>
<section class="front-page-jumbotron">
  <div class="jumbotron bg-primary-dark rounded-0 mb-0">
    <div class="container">
      <div class="row">
          <div class="col-lg-7">
            <header>
              <h1 class="text-white mb-4 display-4">
                <?php the_field('front_page_jumbotron_header'); ?>
              </h1>
            </header>
            <div class="text-light lead mb-5">
              <?php the_field('front_page_jumbotron_content'); ?>
            </div>

            <div class="buttons mb-5">
              <?php $button_1_link = get_field('front_page_jumbotron_button_1_link'); ?>
              <?php $button_2_link = get_field('front_page_jumbotron_button_2_link'); ?>

              <?php if ($button_1_link) : ?>
                <a href="<?= $button_1_link['url']; ?>" class="btn btn-success btn-lg <?php echo $button_2_link ? 'mr-2' : ''; ?>">
                  <?= $button_1_link['title']; ?>
                </a>
              <?php endif; ?>

              <?php if ($button_2_link) : ?>
                <a href="<?= $button_2_link['url']; ?>" class="btn btn-primary btn-lg">
                  <?= $button_2_link['title']; ?>
                </a>
              <?php endif; ?>
            </div>
          </div>
          <div class="col-lg-5 d-lg-flex flex-direction-lg-column">
            <div class="my-auto w-100">
              <?php if (get_field('front_page_video_embed_url')) : ?>
                <div class="video-wrapper mb-4">
                  <iframe width="560" height="315" src="<?php the_field('front_page_video_embed_url'); ?>?modestbranding=1&showinfo=0&rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>
              <?php endif; ?>
              <p class="text-light text-center">Proudly supporting:</p>
              <div class="row mb-3">
                <div class="col-3 text-center">
                  <img src="/content/themes/ddevcom_theme_2020/dist/images/2020-drupal-light.svg" alt="Drupal" class="img-fluid">
                </div>
                <div class="col-3 text-center">
                  <img src="/content/themes/ddevcom_theme_2020/dist/images/2020-wordpress-light.svg" alt="WordPress" class="img-fluid">
                </div>
                <div class="col-3 text-center">
                  <img src="/content/themes/ddevcom_theme_2020/dist/images/2020-typo3-light.svg" alt="Typo3" class="img-fluid">
                </div>
                <div class="col-3 text-center">
                  <img src="/content/themes/ddevcom_theme_2020/dist/images/2020-php-light.svg" alt="PHP" class="img-fluid">
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</section>

<section class="front-page-recent-posts">
  <div class="container py-5">
    <div class="row">
      <?php $slug = get_post_field('post_name', get_post()); ?>
      <div class="col-lg-12 mx-auto">
        <header>
          <h2 class="text-primary text-center mb-4">Recent Posts</h2>
        </header>
        <div class="row">
          <?php
          $args = [
            'post_type' => 'post',
            'posts_per_page' => 6
          ];
          $query = new WP_Query($args);
          ?>

          <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>

            <div class="col-lg-4 d-flex">
              <?php get_template_part('templates/content', 'card'); ?>
            </div>

          <?php endwhile; ?>
          <!-- post navigation -->
        <?php else : ?>
          <!-- no posts found -->
        <?php endif; ?>

        <?php wp_reset_query(); ?>

        </div>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col text-center">
        <a class="btn btn-lg btn-primary-dark" href="http://eepurl.com/dlqkUD">
          Join Our Newsletter
        </a>
      </div>
    </div>
  </div>
</section>

<section class="front-page-events events bg-primary-dark">
  <div class="container py-5">

    <?php if (is_active_sidebar('front-page-events')) : ?>
      <?php dynamic_sidebar('front-page-events'); ?>
    <?php endif; ?>

  </div>
</section>

<?php if (get_field('front_page_tweets')) : ?>

<section class="front-page-tweets bg-light py-5">
  <div class="container">
    <div class="row">


        <?php if (get_field('front_page_tweets_header')) : ?>
          <h3 class="text-primary text-center mb-4 mx-auto"><?php the_field('front_page_tweets_header'); ?></h3>
        <?php endif; ?>

        <div class="card-deck">

          <?php if (have_rows('front_page_tweets')) : ?>
            <?php while (have_rows('front_page_tweets')) : ?>
              <?php the_row(); ?>

                <div class="card rounded-0 border-0 bg-light">
                  <?php the_sub_field('tweet_embed_code'); ?>
                </div>

            <?php endwhile; ?>
          <?php endif; ?>



      </div>
    </div>
  </div>
</section>

<?php endif; ?>
