<?php
/**
 * Template Name: DDEV Live Template
 */
?>


<div class="product-navigation-wrapper">
  <div class="container d-flex">
    <div class="product-name">
      <p class="h1">Live</p>
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
        <div class="col-lg-6">
          <p class="product__main-header-heading">Deploy your Local to Live from command line.</p>
          <p class="product__main-header-lead lead mb-4 mb-lg-5">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
          </p>
          <a href="#" class="btn btn-success btn-lg mr-2">Join Now</a>
          <a href="#" class="btn btn-outline-success btn-lg">Request Demo</a>
        </div>
        <div class="col-lg-6">
          <img class="product__screenshot" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/screenshot-ddev-live.png" alt="DDEV Live Screenshot">
        </div>
      </div>
    </div>
  </section>
  <section class="product__feature-cards">

  </section>
</div>

