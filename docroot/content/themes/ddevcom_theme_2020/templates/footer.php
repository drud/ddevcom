
<?php get_template_part('templates/modal', 'video'); ?>

<footer class="content-info">
  <div class="container">
    <div class="row">
      <div class="col-lg-9">
        <div class="row">
          <div class="col-lg-3">
            <?php if (is_active_sidebar('footer-1')) : ?>
              <?php dynamic_sidebar('footer-1'); ?>
            <?php endif; ?>
          </div>
          <div class="col-lg-3">
          <?php if (is_active_sidebar('footer-2')) : ?>
              <?php dynamic_sidebar('footer-2'); ?>
            <?php endif; ?>
          </div>
          <div class="col-lg-3">
            <?php if (is_active_sidebar('footer-3')) : ?>
              <?php dynamic_sidebar('footer-3'); ?>
            <?php endif; ?>
          </div>
          <div class="col-lg-3">
            <?php if (is_active_sidebar('footer-4')) : ?>
              <?php dynamic_sidebar('footer-4'); ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="footer-newsletter">
          <h4 class="h5 mb-3">
            Stay up-to-date with the DDEV Newsletter.
          </h4>
          <p class="mb-4">
            Receive occasional notifications via email regarding updates, features, and fixes within our toolset.
          </p>
          <a href="http://eepurl.com/dlqkUD" class="btn btn-light">
            Join our newsletter
          </a>
        </div>
        <div class="footer-social-icons py-3 d-flex mt-3">
          <div class="mr-3">
            <a href="https://twitter.com/ddevHQ">
              <i class="fa fa-twitter fa-2x text-light"></i>
            </a>
          </div>
          <div>
            <a href="https://linkedin.com/company/drud">
              <i class="fa fa-linkedin fa-2x text-light"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php if (is_active_sidebar('footer-bottom')) : ?>

  <div class="container-fluid py-2 bg-dark">
    <div class="row">
      <div class="col-lg-12 text-center text-white">
        <?php dynamic_sidebar('footer-bottom'); ?>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 text-center text-white">
        <p class="mb-0 small">© <?= date('Y'); ?> Drud Technology, LLC</p>
      </div>
    </div>
  </div>

  <?php endif; ?>
</footer>
