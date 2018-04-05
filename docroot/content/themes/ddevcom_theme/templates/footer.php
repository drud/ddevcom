
<?php get_template_part('templates/modal','newsletter'); ?>
<?php get_template_part('templates/modal','hosting'); ?>

<footer class="content-info">
  <div class="container-fluid py-4 bg-primary">
    <div class="row">
      <div class="col-lg-9 mx-auto">
        <div class="row">
          <div class="col-lg-3">
            <img src="/content/themes/ddevcom_theme/dist/images/ddev-logo.svg" alt="DDEV" class="mb-4">
            <?php if(is_active_sidebar('footer-1')): ?>
              <?php dynamic_sidebar( 'footer-1' ); ?>
            <?php endif; ?>
          </div>
          <div class="col-lg-3">
          <?php if(is_active_sidebar('footer-2')): ?>
              <?php dynamic_sidebar( 'footer-2' ); ?>
            <?php endif; ?>
          </div>
          <div class="col-lg-3">
          <?php if(is_active_sidebar('footer-3')): ?>
              <?php dynamic_sidebar( 'footer-3' ); ?>
            <?php endif; ?>
          </div>
          <div class="col-lg-3">
          <?php if(is_active_sidebar('footer-4')): ?>
              <?php dynamic_sidebar( 'footer-4' ); ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid py-1 bg-primary-dark">
      <div class="row">
        <div class="col-lg-12 text-center text-white"></div>
      </div>
  </div>
</footer>
