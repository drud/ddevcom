<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <a class="navbar-brand" href="<?= home_url('/'); ?>">
    <img src="/content/themes/ddevcom_theme/dist/images/ddev-logo.svg" width="200" alt="">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
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

     <?php $cta_link = get_field('header_cta_link', 'option'); ?>
     <a href="<?= $cta_link['url'];  ?>" class="btn btn-secondary btn-lg ml-auto">
       <?= isset($cta_link['title']) ? $cta_link['title'] : 'Follow Us on GitHub';  ?>
     </a>
  </div>
</nav>
