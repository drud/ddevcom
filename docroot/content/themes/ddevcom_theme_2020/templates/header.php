<?php $navClasses = is_page('ddev-live') || is_page('ddev-local') ? 'is-product' : ''; ?>
<div class="<?php echo $navClasses; ?> main-navigation-wrapper d-flex bg-primary-dark py-2">
  <div class="container d-flex">
    <nav class="main-navigation">
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
         ?>

      </div>
    </nav>
    <?php $burgerClass = is_page('ddev-live') || is_page('ddev-local') ? '' : 'd-md-none' ?>
    <div class="main-navigation-toggle-wrapper <?php echo $burgerClass; ?>">
        <button class="main-navigation-toggle hamburger hamburger--collapse" type="button">
          <span class="hamburger-box">
            <span class="hamburger-inner"></span>
          </span>
        </button>
    </div>
  </div>
</div>

