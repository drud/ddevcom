<section class="landing-jumbotron">
  <div class="jumbotron bg-primary-gradient rounded-0 mb-0">
    <div class="container-fluid pt-5 pb-3">
      <div class="row">
        <div class="col-lg-9 col-xl-8 mx-auto text-center">
          <header>
            <h1 class="text-white mb-5 display-4">
              <?php the_field('product_jumbotron_header'); ?>
            </h1>
          </header>
          <div class="text-white mb-5 lead">
            <?php the_field('product_jumbotron_content'); ?>
          </div>

          <?php $button_1_link = get_field('product_jumbotron_button_1_link'); ?>
          <?php if ($button_1_link) : ?>
          <a href="<?= $button_1_link['url']; ?>" class="btn btn-outline-secondary btn-lg my-1 px-5">
            <?= $button_1_link['title']; ?>
          </a>
          <?php endif; ?>

          <?php $button_2_link = get_field('product_jumbotron_button_2_link'); ?>
          <?php if ($button_2_link) : ?>
          <a href="<?= $button_2_link['url']; ?>" class="btn btn-outline-light btn-lg">
            <?= $button_2_link['title']; ?>
          </a>
          <?php endif; ?>

        </div>
      </div>
    </div>
  </div>
</section>
