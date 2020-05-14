<?php $navClasses = is_page('ddev-live') || is_page('ddev-local') ? 'is-product' : ''; ?>
<div class="<?php echo $navClasses; ?> main-navigation-wrapper d-flex bg-primary-dark">
  <nav class="main-navigation p-4">
    <a class="main-navigation__logo" href="<?= home_url('/'); ?>">
      <img src="/content/themes/ddevcom_theme/dist/images/ddev-logo.svg" width="200" alt="DDEV">
    </a>
    <div class="main-navigation__menu-wrapper">

      <?php
        if (has_nav_menu('primary_navigation')) :
          wp_nav_menu([
            'theme_location' => 'primary_navigation',
            'menu_class' => 'main-navigation__menu mr-auto'
          ]);
        endif;

        // if ('template-product.php' === get_page_template_slug()) {
        //   wp_nav_menu([
        //     'theme_location' => 'ddev_live_navigation',
        //     'menu_class' => 'navbar-nav mr-auto ml-lg-4 mt-2 mt-lg-0'
        //   ]);
        // }
       ?>

    </div>
  </nav>
  <?php $burgerClass = is_page('ddev-live') || is_page('ddev-local') ? '' : 'd-md-none' ?>
  <div class="<?php echo $burgerClass; ?>">
      <button class="main-navigation-toggle hamburger hamburger--collapse" type="button">
        <span class="hamburger-box">
          <span class="hamburger-inner"></span>
        </span>
      </button>
  </div>
</div>

