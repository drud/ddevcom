
<?php get_template_part('templates/modal', 'video'); ?>

<footer class="content-info">
  <?php if (is_active_sidebar('footer-bottom')) : ?>
  <div class="bg-dark">
    <div class="container py-2">
      <div class="row">
        <div class="col-lg-12 text-center text-white">
          <?php dynamic_sidebar('footer-bottom'); ?>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 text-center text-white">
          <p class="mb-0 small">© <?= date('Y'); ?> Fruition Growth, LLC</p>
          <p class="mb-0 small">616 E. Speer Blvd Denver CO 80203 USA | +01 303 395 1880</p>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>
</footer>
