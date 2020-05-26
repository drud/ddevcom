<?php
/**
 * Template Name: DDEV Local Template
 */
?>


<div class="product-navigation-wrapper">
  <div class="container d-flex">
    <div class="product-name">
      <p class="h1 text-success">Local</p>
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
          <p class="product__main-header-heading">
            Deploy anywhere. Deploy in seconds.
          </p>
          <p class="product__main-header-lead lead mb-5">
            DDEV simplifies integrating the power and consistency of containerization into your workflows. Set up environments in minutes; switch contexts and projects quickly and easily; speed your time to deployment. We handle the complexity. You get on with the valuable part of your job.
          </p>
          <div class="mb-5">
            <a href="#" class="btn btn-success btn-lg mr-2">Get Started</a>
            <a href="#" class="btn btn-outline-success btn-lg">Documentation</a>
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
            <div class="row pb-lg-5 mb-5 mb-lg-0">
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
            <div class="row mb-5">
              <div class="col-3 col-lg mx-auto">
                <img class="product__supporting-logo" data-toggle="popover" data-content="Coming Soon: Magento" data-placement="top" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/2020-magento.svg" alt="Magento">
              </div>
              <div class="col-3 col-lg mx-auto">
                <img class="product__supporting-logo" data-toggle="popover" data-content="Coming Soon: Node" data-placement="top" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/2020-node.svg" alt="Node">
              </div>
              <div class="col-3 col-lg mx-auto">
                <img class="product__supporting-logo" data-toggle="popover" data-content="Coming Soon: React" data-placement="top" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/2020-react.svg" alt="React">
              </div>
              <div class="col-3 col-lg mx-auto">
                <img class="product__supporting-logo" data-toggle="popover" data-content="Coming Soon: Vue.js" data-placement="top" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/2020-vue.svg" alt="Vue.js">
              </div>
              <div class="col-3 col-lg mx-auto">
                <img class="product__supporting-logo" data-toggle="popover" data-content="Coming Soon: Python" data-placement="top" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/2020-python.svg" alt="Python">
              </div>
              <div class="col-3 col-lg mx-auto">
                <img class="product__supporting-logo" data-toggle="popover" data-content="Coming Soon: Ember" data-placement="top" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/2020-ember.svg" alt="Ember">
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-3 mt-lg-5">
          <div class="product__feature-card card w-100">
            <div class="card-header">
              <h2>Key Features</h2>
            </div>
            <div class="card-body py-5">
              <div class="row mb-lg-5">
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-clock-o text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Simplify your workflow
                  </h3>
                  <p class="product__feature-description">
                    Make your changes, check in your code, dispose of the environment, move on to the next one!
                  </p>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-long-arrow-right text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Deployment in seconds
                  </h3>
                  <p class="product__feature-description">
                    Rapid, simple deployment leads to 100-200X increases in developer code deployment frequency to real production projects.
                  </p>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-bolt text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Onboarding made easy
                  </h3>
                  <p class="product__feature-description">
                    Shorten the time to first production commit from days or weeks to mere hours under real-world agency conditions.
                  </p>
                </div>
              </div>
              <div class="row mb-lg-5">
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-code text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Multiple deployment
                  </h3>
                  <p class="product__feature-description">
                    DDEV and all of DRUD’s tools can be integrated with the services, hosting providers, and deployment scenario of your choice, including cloud, in-house, or hybrid models.
                  </p>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-cloud-upload text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Open source for open source
                  </h3>
                  <p class="product__feature-description">
                    You chose to work with open source CMSs for good reasons. DRUD’s full toolset, from local development to hosting stack, is licensed with the open source Apache 2.0 license and is free to use, modify, and pass on to others.
                  </p>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-certificate text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Multiple CMS Platform Support
                  </h3>
                  <p class="product__feature-description">
                  DDEV currently comes with preconfigured environments for Drupal 6/7/8, TYPO3 CMS, Backdrop CMS, WordPress, and Java applications.
                  </p>
                </div>
              </div>
            </div>
            <div class="py-5 mb-lg-5 bg-primary-dark">
                <div class="col text-center">
                  <a href="#" class="btn btn-success btn-lg mr-2">Get Started</a>
                  <a href="#" class="btn btn-outline-success btn-lg">Documentation</a>
                </div>
              </div>
            <div class="card-body py-5">
              <div class="row mb-lg-5">
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-code text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Reduce complexity
                  </h3>
                  <p class="product__feature-description">
                    Docker configuration, development environments, and dependency management—fully supported. We’ve got your back.
                  </p>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-check-circle text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Tool consistency
                  </h3>
                  <p class="product__feature-description">
                    Make your whole dev-to-deploy workflow faster, more efficient, and more reliable.
                  </p>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-cubes text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Identical environments
                  </h3>
                  <p class="product__feature-description">
                  From your local machine, to testing/QA, to live production (if your hosting supports Docker in production like DDEV-Live).
                  </p>
                </div>
              </div>
              <div class="row mb-lg-5">
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-heartbeat text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Dedicated support and maintenance
                  </h3>
                  <p class="product__feature-description">
                    Backed by an experienced team of CMS, DevOps, and agency experts at DRUD.
                  </p>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-diamond text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Battle-tested
                  </h3>
                  <p class="product__feature-description">
                  Built on strong, industry-standard technologies, including Docker and Kubernetes.
                  </p>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-certificate text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Focused on simplicity
                  </h3>
                  <p class="product__feature-description">
                  Opinionated architecture, with a focus on getting the jobs you need to do every day done quickly and easily, but flexible enough to adapt to meet tough challenges and special cases, too.
                  </p>
                </div>
              </div>
              <div class="row mt-5">
                <div class="col text-lg-center">
                  <a href="#" class="btn btn-success btn-lg mr-2">Get Started</a>
                  <a href="#" class="btn btn-outline-success btn-lg">Documentation</a>
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
                  Sign up for your <a class="text-success" href="#">free trial</a>
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
  <section class="product__posts bg-light">
    <div class="container">
      <?php
        $args = [
          'posts_per_page' => 3,
          'post_type' => 'post',
          'tax_query' => [
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => 'ddev-local',
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
  <section class="product__connect bg-primary-dark">
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
  </section>
</div>

