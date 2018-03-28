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

     <?php $header_cta_1 = get_field('header_cta_1_link'); ?>
     <?php $header_cta_2 = get_field('header_cta_2_link'); ?>

     <a href="#" class="btn btn-secondary btn-block btn-lg mr-2 mb-1">Follow Us on GitHub</a>

     <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-hosting">
        Learn More About Hosting
      </button>

   </div>

</nav>
