<?php
  $navClasses = is_page('ddev-live') || is_page('ddev-local') || is_page('ddev-preview') ? 'is-product' : '';
  $searched = get_query_var('s') ?? "";
  $stripe_publishable = getenv('STRIPE_PUBLISHABLE_KEY');
?>
<div class="<?php echo $navClasses; ?> main-navigation-wrapper d-flex bg-primary-dark py-2">
  <div class="container d-flex">
    <nav class="main-navigation">
      <a class="main-navigation__logo" href="<?= home_url('/'); ?>">
        <img src="/content/themes/ddevcom_theme_2020/dist/images/ddev-logo.svg" width="200" alt="DDEV">
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
    <?php $burgerClass = is_page('ddev-live') || is_page('ddev-local') || is_page('ddev-preview') ? '' : 'd-lg-none' ?>
    <?php $searchToggleClass = is_page('ddev-live') || is_page('ddev-local') || is_page('ddev-preview') ? 'mr-5 mr-lg-4 px-2 py-1 py-lg-2' : 'p-4 mr-5 mr-lg-0' ?>
    <div class="main-navigation__search-toggle <?php echo $searchToggleClass; ?>">
      <i class="fa fa-search text-white"></i>
    </div>
    <div class="main-navigation-toggle-wrapper <?php echo $burgerClass; ?>">
        <button class="main-navigation-toggle hamburger hamburger--collapse" type="button" tabindex="0">
          <span class="hamburger-box">
            <span class="hamburger-inner"></span>
          </span>
        </button>
    </div>
  </div>
</div>
<section class="header__search bg-primary-dark" aria-expanded="false">
  <div class="container">
    <div class="row">
      <div class="col-12 text-right">
        <form action="/" class="mb-4">
            <input type="text" class="form-control form-control-lg mb-3" name="s" value="<?php echo $searched ?? ""; ?>"/>
            <button class="btn btn-primary" type="submit">Search</button> 
        </form>
      </div>
    </div>
  </div>
</section>

<section class="bg-primary-light p-3 text-white">
  <div class="container">
    ✨<strong>Save time and money:</strong> Get approval faster and accelerate your team’s workflow with <a class="text-white" href="#ddev-preview">DDEV Preview, now included with DDEV Live.</a>
    <a href="<?php echo home_url('/ddev-live#ddev-preview'); ?>" id="btn-cta-preview" class="btn btn-outline-light btn-sm mg-left-auto float-right">Learn More</a>
  </div>
</section>


