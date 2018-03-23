<!-- Just an image -->
<nav class="navbar navbar-dark bg-primary fixed-top">
  <?php if (is_admin_bar_showing()): ?>
    <div style="height: 32px;"></div>
  <?php endif; ?>

  <a class="navbar-brand" href="#">
    <img src="/content/themes/ddevcom_theme/dist/images/ddev-logo.svg" width="200" alt="">
  </a>

  <?php
    if (has_nav_menu('primary_navigation')) :
      wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
    endif;
   ?>

  <a href="#" class="btn btn-secondary btn-lg d-none d-md-block ml-auto">Get Started</a>
</nav>
