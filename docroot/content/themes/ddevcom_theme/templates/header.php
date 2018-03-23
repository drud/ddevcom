<nav class="navbar navbar-dark fixed-top">
  <?php if (is_admin_bar_showing()): ?>
    <div style="height: 32px;"></div>
  <?php endif; ?>

  <a class="navbar-brand" href="<?= home_url('/'); ?>">
    <img src="/content/themes/ddevcom_theme/dist/images/ddev-logo.svg" width="200" alt="">
  </a>

  <?php
    if (has_nav_menu('primary_navigation')) :
      wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
    endif;
   ?>
   <div class="ml-auto">
     <a href="#" class="btn btn-secondary btn-block btn-lg mr-2">Get Started with DDEV Local</a>
     <a href="#" class="btn btn-link btn-block text-secondary-light mt-1">Learn About DDEV Live</a>
   </div>
</nav>
