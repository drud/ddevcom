<?php
/**
 * Template Name: DDEV Live Template
 */
?>


<div class="product-navigation-wrapper">
  <div class="container d-flex">
    <div class="product-name">
      <h1 class="h1 text-success">Live</h1>
    </div>
    <nav class="product-navigation">
      <?php
        if (has_nav_menu('ddev_live_navigation')) :
          wp_nav_menu([
            'theme_location' => "ddev_live_navigation",
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
          <h1 class="product__main-header-heading">
            Where scalable web hosting meets simplicity.
          </h1>
          <p class="product__main-header-lead p lead mb-5">
            Host Drupal, WordPress and TYPO3 sites on scalable, flexible infrastructure that just works. DDEV-Live reduces the complexity of hosting modern websites so you can focus on delivering great projects using your favorite workflows.
          </p>
          <div class="mb-5">
            <a href="https://dash.ddev.com/notice" class="btn btn-success btn-lg mr-2" target="_blank" rel="noreferrer noopener">NOTICE: DDEV-Live is closing</a>
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
        <div class="row product__testimonial">
          <div class="col col-lg-9 text-center mx-auto">

            <?php if( have_rows('testimonials') ): ?>
              <div class="testimonials-carousel">

                  <?php while( have_rows('testimonials') ): the_row(); ?>

                    <div class="testimonial">
                      
                      <?php $testimonial_image = get_sub_field('testimonial_image'); ?>
                      <?php echo wp_get_attachment_image( $testimonial_image['ID'], 'testimonial-image', '', [
                        'class' => 'testimonial__image rounded-circle d-block m-auto'
                      ]); ?>
                      
                      <?php if( get_sub_field('testimonial_name') ): ?>
                        <p class="h4 mt-2 mb-4"><?php the_sub_field('testimonial_name'); ?></p>
                      <?php endif; ?>

                      <?php if( get_sub_field('testimonial_content') ): ?>
                        <p class="lead text-muted mb-4">
                          <?php the_sub_field('testimonial_content'); ?>
                        </p>
                      <?php endif; ?>

                      <?php if( get_sub_field('testimonial_link') ): ?>
                        <?php $testimonial_link = get_sub_field('testimonial_link'); ?>
                        <?php $link_target = $testimonial_link['target'] ? $testimonial_link['target'] : '_self'; ?>
                        <a class="btn btn-lg btn-primary-dark mb-5" href="<?php echo $testimonial_link['url']; ?>" target="<?php echo esc_attr( $link_target ); ?>">
                        <?php echo $testimonial_link['title']; ?>
                        </a>
                      <?php endif; ?>

                    </div>
                    
                  <?php endwhile; ?>
              </div>
            <?php endif; ?>

          </div>
        </div>
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
                <img class="product__supporting-logo" data-toggle="popover"  data-content="TYPO3" data-placement="top" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/2020-typo3.svg" alt="TYPO3">
              </div>
              <div class="col-3 col-lg">
                <img class="product__supporting-logo" data-toggle="popover" data-content="PHP" data-placement="top"  src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/2020-php.svg" alt="PHP">
              </div>
            </div>
          </div>
          <div class="col-lg-7 pl-lg-5">
            <p class="h4 text-center mb-4">On the horizon:</p>
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
                    <i class="fa fa-2x fa-github-alt text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Git Integration
                  </h3>
                  <p class="product__feature-description">
                    Connect directly to your GitHub or other <a href="https://docs.ddev.com/providers/" target="_blank" rel="noopen noreferrer">Git repository provider</a>. This allows you to directly move code within your Git workflow and include DDEV-Live where you need it.
                  </p>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-eye text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Real-time Collaboration
                  </h3>
                  <p class="product__feature-description">
                    DDEV allows anyone — anywhere — to develop and test on their own machine, quickly deploy to a staging environment, rapidly deliver code, and share projects with clients and team members.
                  </p>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-exchange text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Consistency & Parity
                  </h3>
                  <p class="product__feature-description">
                    DDEV-Live drives consistency across dev-to-deploy workflows to provide increased reliability and repeatability. Teams can all be on the same page wherever they are thanks to automated builds and environment parity.
                  </p>
                </div>
              </div>
              <div class="row mb-lg-5">
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-code text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Dev, Test, Prod
                  </h3>
                  <p class="product__feature-description">
                    Reduce the firefighting, increase reliability at scale, and deliver engaging digital experiences faster than the competition. DDEV-Live continues the pattern from DDEV-Local to help your teams develop, deploy, and maintain web applications using repeatable standards.
                  </p>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-cloud-upload text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Automated Backups
                  </h3>
                  <p class="product__feature-description">
                    Backups are configurable from the DDEV-Live CLI for each site. Set the number of backups to retain for each project.
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
                    DDEV-Local and DDEV-Live currently support Drupal, TYPO3,  WordPress, and other PHP applications with the flexibility to support even more project types.
                  </p>
                </div>
              </div>
            </div>
            <div class="py-5 mb-lg-5 bg-primary-dark">
                <div class="col text-center">
                  <a href="https://www.ddev.com/notice/" class="btn btn-success btn-lg mr-2">NOTICE: DDEV-Live is closing</a>
                </div>
              </div>
            <div class="card-body py-5">
              <div class="row mb-lg-5">
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-cubes text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Enjoy Kubernetes
                  </h3>
                  <p class="product__feature-description">
                    Massively scalable industry standard open-source system for automating deployment, scaling, and management of containerized applications. Designed on the same principles that allow Google and others to run billions of containers a week.
                  </p>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-code text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Monitoring
                  </h3>
                  <p class="product__feature-description">
                  All our infrastructure, websites and servers, are monitored continuously, allowing us to detect and proactively address issues before they escalate.
                  </p>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-check-circle text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Continuous Integration
                  </h3>
                  <p class="product__feature-description">
                    Deployments to our environments are as simple as pushing a branch to your GitHub or other hosted version control system. DDEV-Live also can serve as a testing or QA stage in your <a href="<?php echo home_url('ddev-live/ci-cd'); ?>">CI/CD</a> pipelines.
                  </p>
                </div>
              </div>
              <div class="row mb-lg-5">
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-heartbeat text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Self-healing & load balancing
                  </h3>
                  <p class="product__feature-description">
                    Kubernetes manages nodes and balances traffic according to needs, replacing failed containers and ensuring traffic increases (and decreases) are handled automatically, or the way you need it to be configured.
                  </p>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-terminal text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Open Source Ecosystem
                  </h3>
                  <p class="product__feature-description">
                  We’re committed to open source opportunities and projects, just like you. That’s why we built DDEV using proven technologies like Docker, Kubernetes, Helm, Prometheus, Jenkins, and more.
                  </p>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-handshake-o text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Ongoing Support
                  </h3>
                  <p class="product__feature-description">
                  DDEV-Live is backed by specific service guarantees for enterprise level accounts, product engineering team access for sudden bug fixes and issues, and performance tuning. We’re committed to continuing to improve the platform and add the features you need, and always welcome conversations with our customers.
                  </p>
                </div>
              </div>
              <div class="row mt-5">
                <div class="col text-lg-center">
                  <a href="https://www.ddev.com/notice/" class="btn btn-lg btn-success mr-2">
                    NOTICE: DDEV-Live is closing
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>
  <section class="product__features bg-primary-dark" id="ddev-preview">
      <div class="container">
        <div class="row">
          <div class="col-8 text-center mx-auto">
            <h2 class="text-white mb-4">
              ✨ <br class="d-lg-none" />Introducing:<br class="d-lg-none" /> DDEV Preview
            </h2>
            <p class="text-light lead mb-5">
              Preview is a feature set available in every plan on the DDEV platform. These features will facilitate collaboration, testing, and review without the need to configure an additional environment.
            </p>
            <a href="<?php echo home_url('ddev-preview') ?>" class="btn btn-primary btn-lg">
              Learn more
            </a>
          </div>
        </div>
      </div>
  </section>
  <section class="product__posts bg-light">
    <div class="container">
      <h2 class="text-dark text-center mb-4">Recent Posts</h2>

      <?php
        $args = [
          'posts_per_page' => 3,
          'post_type' => 'post',
          'tax_query' => [
            [
              'taxonomy' => 'category',
              'field' => 'slug',
              'terms' => 'ddev-live',
            ]
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
                    <h3 class="h4 post-card__title card-title">
                      <a class="text-primary-light" href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                      </a>
                    </h3>
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
          <a href="http://eepurl.com/dlqkUD" class="btn btn-lg btn-primary" target="_blank" rel="noopen noreferrer">
            Join Our Newsletter
          </a>
        </div>
      </div>
    </div>
  </section>
</div>

