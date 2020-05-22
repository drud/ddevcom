<?php
/**
 * Template Name: DDEV Live Template
 */
?>


<div class="product-navigation-wrapper">
  <div class="container d-flex">
    <div class="product-name">
      <p class="h1">Local</p>
    </div>
    <nav class="product-navigation">
      <?php
        if (has_nav_menu('ddev_local_navigation')) :
          wp_nav_menu([
            'theme_location' => "ddev_local_navigation",
            'menu_class' => 'product-navigation__menu mr-auto'
          ]);
        endif;
        ?>
    </nav>
    <div class="product-navigation-toggle">
      <button class="product-navigation-toggle__button">Menu</button>
    </div>
    <div class="product-navigation-mobile-overlay"></div>
  </div>
</div>

<div class="product">
  <section class="product__main-header">
    <div class="container">
      <div class="row">
        <div class="col-lg-7">
          <p class="product__main-header-heading">Deploy anywhere. Deploy in seconds.</p>
          <p class="product__main-header-lead lead mb-5">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
          </p>
          <div class="mb-5 mb-lg-0">
            <a href="#" class="btn btn-cta btn-lg mr-2">Get Started</a>
            <a href="#" class="btn btn-outline-cta btn-lg">Documentation</a>
          </div>
        </div>
        <div class="col-lg-5">
          <img class="product__screenshot" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/ddev-live.gif" alt="DDEV Live Screenshot">
        </div>
      </div>
    </div>
  </section>
  <section class="product__features">
      <div class="container">
        <div class="row product__supporting">
          <div class="col-lg-5 product__supporting-col pr-lg-5">
            <p class="h4 text-center mb-4">Proudly supporting:</p>
            <div class="row pb-lg-5">
              <div class="col-3 col-lg">
                <img data-toggle="popover" data-content="Drupal 7 & 8" data-placement="top" class="product__supporting-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/2020-drupal.svg" alt="Drupal">
              </div>
              <div class="col-3 col-lg">
                <img class="product__supporting-logo" data-toggle="popover"  data-content="WordPress" data-placement="top" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/2020-wordpress.svg" alt="WordPress">
              </div>
              <div class="col-3 col-lg">
                <img class="product__supporting-logo" data-toggle="popover"  data-content="Typo3" data-placement="top" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/2020-typo3.svg" alt="Typo3">
              </div>
              <div class="col-3 col-lg">
                <img class="product__supporting-logo" data-toggle="popover" data-content="PHP" data-placement="top"  src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/2020-php.svg" alt="PHP">
              </div>
            </div>
          </div>
          <div class="col-lg-7 pl-lg-5">
            <p class="h4 text-center mb-4">On the Horizon:</p>
            <div class="row">
              <div class="col-3 col-lg">
                <img class="product__supporting-logo" data-toggle="popover" data-content="Coming Soon: Magento" data-placement="top" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/2020-magento.svg" alt="Magento">
              </div>
              <div class="col-3 col-lg">
                <img class="product__supporting-logo" data-toggle="popover" data-content="Coming Soon: Node" data-placement="top" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/2020-node.svg" alt="Node">
              </div>
              <div class="col-3 col-lg">
                <img class="product__supporting-logo" data-toggle="popover" data-content="Coming Soon: React" data-placement="top" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/2020-react.svg" alt="React">
              </div>
              <div class="col-3 col-lg">
                <img class="product__supporting-logo" data-toggle="popover" data-content="Coming Soon: Vue.js" data-placement="top" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/2020-vue.svg" alt="Vue.js">
              </div>
              <div class="col-3 col-lg">
                <img class="product__supporting-logo" data-toggle="popover" data-content="Coming Soon: Python" data-placement="top" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/2020-python.svg" alt="Python">
              </div>
              <div class="col-3 col-lg">
                <img class="product__supporting-logo" data-toggle="popover" data-content="Coming Soon: Ember" data-placement="top" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/2020-ember.svg" alt="Ember">
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-3 mt-lg-5">
          <div class="product__feature-card card w-100">
            <div class="card-body">
              <div class="row mb-lg-5">
                <div class="col">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-user-circle text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Feature Name
                  </h3>
                  <p class="product__feature-description">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                  </p>
                </div>
                <div class="col">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-thermometer-1 text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Feature Name
                  </h3>
                  <p class="product__feature-description">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                  </p>
                </div>
                <div class="col">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-handshake-o text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Feature Name
                  </h3>
                  <p class="product__feature-description">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                  </p>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-code text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Feature Name
                  </h3>
                  <p class="product__feature-description">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                  </p>
                </div>
                <div class="col">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-cube text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Feature Name
                  </h3>
                  <p class="product__feature-description">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                  </p>
                </div>
                <div class="col">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-certificate text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Feature Name
                  </h3>
                  <p class="product__feature-description">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                  </p>
                </div>
              </div>
              <div class="row mt-5">
                <div class="col text-center">
                  <a href="#" class="btn btn-lg btn-cta mr-2">
                    Start a Free Trial
                  </a>
                  <a href="#" class="btn btn-lg btn-outline-cta">
                    Request Demo
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>
  <!-- <section class="product__demo bg-primary-dark">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <p class="h1 text-light text-center mb-5">
              Nec feugiat in fermentum posuere urna nec tincidunt.
            </p>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-7">
              <ol class="product__demo-steps bg-dark">
                <li>
                  Sign up for your <a class="text-cta" href="#">free trial</a>
                </li>
                <li>
                  Install Local and create a site
                  <div>
                    <h6 class="mb-0 my-3">
                      Install Local on your OS:
                    </h6>
                    <a href="#" class="btn btn-light btn-sm text-primary-light">
                      Mac
                    </a>
                    <a href="#" class="btn btn-light btn-sm text-primary-light">
                      Windows
                    </a>
                    <a href="#" class="btn btn-light btn-sm text-primary-light">
                      Linux
                    </a>
                    <h6 class="mb-0 my-3">
                      Create you new site with Local:
                    </h6>
                    <code>
                      $ ddev create
                    </code>
                  </div>
                </li>
                <li>
                  Install Live and deploy to a live website.
                  <div>
                    <h6 class="mb-0 my-2">
                      Install on your OS:
                    </h6>
                    <a href="#" class="btn btn-light btn-sm text-primary-light">
                      Mac
                    </a>
                    <a href="#" class="btn btn-light btn-sm text-primary-light">
                      Windows
                    </a>
                    <a href="#" class="btn btn-light btn-sm text-primary-light">
                      Linux
                    </a>
                    <h6 class="mb-0 my-3">
                      Create deploy your site with Live:
                    </h6>
                    <code>
                      $ ddev-live create
                    </code>
                  </div>
                </li>
              </ol>
          </div>
          <div class="col-lg-5">

          </div>
        </div>
      </div>
  </section> -->
  <section class="product__posts bg-primary-dark">
    <div class="container">
      <?php
        $args = [
          'posts_per_page' => 3,
          'post_type' => 'post',
          'tax_query' => [
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => 'ddev-live',
          ],
        ];

        $query = new WP_Query($args);
        ?>

        <?php if ($query->have_posts()) : ?>
          <div class="row">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
              <div class="col-lg-4 d-flex">
                <div class="post-card card mb-4">
                  <a href="<?php the_permalink(); ?>">
                    <?php
                      echo wp_get_attachment_image(get_post_thumbnail_id(), 'post-card-header', false, [
                        'class' => 'post-card__header-image card-img-top img-fluid'
                      ]);
                    ?>
                  </a>
                  <div class="card-body">
                    <p class="post-card__date"><?php the_date(); ?></p>
                    <h4 class="post-card__title card-title">
                      <a class="text-primary-light" href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                      </a>
                    </h4>
                  </div>
                  <div class="post-card__footer card-footer text-muted">
                    <img class="rounded-circle" width="30" src="<?php echo get_avatar_url(get_the_author_meta('ID')); ?>" alt="<?= get_the_author_meta('display_name'); ?>">
                    <?= __('By', 'sage'); ?> <a href="<?= get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="text-muted d-inline-block mt-2"><?= get_the_author_meta('display_name'); ?></a>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        <?php endif; ?>
      <div class="row mt-5">
        <div class="col text-center">
          <a href="http://eepurl.com/dlqkUD" class="btn btn-lg btn-primary">
            Join Our Newsletter
          </a>
        </div>
      </div>
    </div>
  </section>
  <!-- <section class="product__connect bg-primary-dark">
    <div class="container">
      <div class="row">
        <div class="col col-lg-4">
          <p>
            <i class="fa fa-2x fa-group product__connect-icon green"></i>
          </p>
          <h3 class="product__connect-heading text-white mb-3">
            Community
          </h3>
          <p class="product__connect-body mb-5">
            Lorem ipsum dolor sit amet.
          </p>
          <a href="#" class="btn btn-lg btn-primary">
            View Community
          </a>
        </div>
        <div class="col col-lg-4">
          <p>
            <i class="fa fa-2x fa-comments-o product__connect-icon blue"></i>
          </p>
          <h3 class="product__connect-heading text-white mb-3">
            Forum
          </h3>
          <p class="product__connect-body mb-5">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
          </p>
          <a href="#" class="btn btn-lg btn-primary">
            View Forum
          </a>
        </div>
        <div class="col col-lg-4">
          <p>
            <i class="fa fa-2x fa-slack product__connect-icon pink"></i>
          </p>
          <h3 class="product__connect-heading text-white mb-3">
            Slack
          </h3>
          <p class="product__connect-body mb-5">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </p>
          <a href="#" class="btn btn-lg btn-primary">
            Join Slack
          </a>
        </div>
      </div>
    </div>
  </section> -->
</div>

