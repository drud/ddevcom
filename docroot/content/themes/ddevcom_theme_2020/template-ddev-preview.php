<?php
/**
 * Template Name: DDEV Preview Template
 */
?>


<div class="product-navigation-wrapper">
  <div class="container d-flex">
    <div class="product-name">
      <h1 class="h1 text-primary-light">Preview</h1>
    </div>
    <nav class="product-navigation">
      <?php
        if (has_nav_menu('ddev_preview_navigation')) :
          wp_nav_menu([
            'theme_location' => "ddev_preview_navigation",
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
            Sites instantly built from your pull or merge requests.
          </h1>
          <p class="product__main-header-lead p lead mb-5">
            Discover how leveraging GitOps through the DDEV platform can reduce friction in your development lifecycle, empowering your developers to focus on what they do best: writing code.
          </p>
          <div class="mb-5">
            <a href="<?php echo home_url('contact'); ?>" class="btn btn-primary-light btn-lg mr-2">Request a Demo</a>
            <a href="https://docs.ddev.com" class="btn btn-outline-primary-light btn-lg" target="_blank" rel="noreferrer noopener">Documentation</a>
          </div>
        </div>
        <div class="col-lg-5">
          <img class="product__screenshot" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/ddev-preview.png" alt="DDEV Preview Screenshot">
        </div>
      </div>
    </div>
  </section>
  <section class="product__features">
      <div class="container">
        <div class="row">
          <div class="col col-lg-89mx-auto text-center">
            <p class="h2 mb-3">
              Preview is now included in every DDEV Live subscription.
            </p>
            <p class="lead text-muted mb-5">
              Plans starting at just $15 a month.
            </p>
            <a href="<?php echo home_url('/pricing') ?>" class="btn btn-lg btn-primary-light">
              Choose a Plan
            </a>
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
                    <i class="fa fa-2x fa-files-o text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                  Site Clones
                  </h3>
                  <p class="product__feature-description">
                    DDEV-Live includes a set of features that allow a developer to quickly spin up preview sites on our hosting infrastructure. A Preview site is an unpublished site built from code in a pull or merge request you have made against a Git branch that is deployed on DDEV-Live.
                  </p>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-github-square text-dark"></i>
                    <i class="fa fa-2x fa-gitlab text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Preview Bot
                  </h3>
                  <p class="product__feature-description">
                    Preview uses the <a href="https://docs.ddev.com/preview-bot">DDEV Preview bot</a> to create sites. Reduce time spent on context switches: call the bot with a comment directly on your GitHub pull request or GitLab merge request against a branch referenced by DDEV-Live. The bot returns a URL for a temporary site.
                  </p>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-flash text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Enhanced PR Reviews
                  </h3>
                  <p class="product__feature-description">
                    Share new features with anyone, anywhere: Preview sites are available via URL for the lifespan of the PR they are created on. Share with reviewers and stakeholders for high fidelity feature previews.
                  </p>
                </div>
              </div>
              <div class="row mb-lg-5">
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-trash text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Automatic Cleanup
                  </h3>
                  <p class="product__feature-description">
                    No orphaned projects to count against your workspace limits: Preview sites are deleted when the associated PR is closed, keeping your DDEV workspace tidy.
                  </p>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-clock-o text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Site Expirations
                  </h3>
                  <p class="product__feature-description">
                    Manage and maintain an automated workflow: Set an <a href="https://docs.ddev.com/sites/#setting-expiration-on-your-site">expiration</a> timer for any site. Automatically delete sites at a configured interval from the creation timestamp.
                  </p>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="product__feature-icon mb-2">
                    <i class="fa fa-2x fa-tags text-dark"></i>
                  </div>
                  <h3 class="product__feature-heading mb-4">
                    Site Tags
                  </h3>
                  <p class="product__feature-description">
                    Quickly identify projects in your sites list by client, lifecycle stage, or another taxonomy that suits your process. Set <a href="https://docs.ddev.com/site-tags/">tags</a> on your deployed sites in order to sort and identify projects quickly.
                  </p>
                </div>
              </div>
            </div>
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

