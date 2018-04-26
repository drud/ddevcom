<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <a class="navbar-brand" href="<?= home_url('/'); ?>">
    <img src="/content/themes/ddevcom_theme/dist/images/ddev-logo.svg" width="200" alt="">
  </a>
  <button class="navbar-toggler text-primary border-0 bg-secondary" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">

    <?php
      if (has_nav_menu('primary_navigation')) :
        wp_nav_menu([
          'theme_location' => 'primary_navigation',
          'menu_class' => 'navbar-nav mr-auto ml-lg-4 mt-2 mt-lg-0'
        ]);
      endif;
     ?>


      <div class="ml-auto">
        <button class="btn btn-secondary btn-lg d-block mb-1" data-toggle="modal" data-target="#modal-video">
          Watch a 90-Second Video
        </button>

        <?php if( get_field('company_facebook_url','option') || get_field('company_twitter_url','option') || get_field('company_linkedin_url','option') ): ?>

        <div class="btn-group justify-content-center w-100" role="group">

          <?php if(get_field('company_facebook_url','option')): ?>
            <a class="btn btn-link" href="<?php the_field('company_facebook_url','option'); ?>">
              <i class="fa fa-facebook text-white"></i>
            </a>
          <?php endif; ?>

          <?php if(get_field('company_twitter_url','option')): ?>
            <a class="btn btn-link" href="<?php the_field('company_twitter_url','option'); ?>">
              <i class="fa fa-twitter text-white"></i>
            </a>
          <?php endif; ?>

          <?php if(get_field('company_linkedin_url','option')): ?>
            <a class="btn btn-link" href="<?php the_field('company_linkedin_url','option'); ?>">
              <i class="fa fa-linkedin text-white"></i>
            </a>
          <?php endif; ?>

        </div>

        <?php endif; ?>

      </div>


  </div>
</nav>
