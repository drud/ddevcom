<?php
/**
 * Template Name: Landing Page
 */
?>

<section class="product-jumbotron">
  <div class="jumbotron bg-primary-gradient rounded-0 mb-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-9 col-xl-8 mx-auto text-center">
          <header>
            <h1 class="text-white mb-4">
              <?php the_field('product_jumbotron_header'); ?>
            </h1>
          </header>
          <div class="text-white mb-5 lead">
            <?php the_field('product_jumbotron_content'); ?>
          </div>

          <?php $button_1_link = get_field('product_jumbotron_button_1_link'); ?>
          <?php if ($button_1_link): ?>
            <a href="<?= $button_1_link['url']; ?>" class="btn btn-outline-secondary btn-lg">
              <?= $button_1_link['title']; ?>
            </a>
          <?php endif; ?>

          <?php $button_2_link = get_field('product_jumbotron_button_2_link'); ?>
          <?php if ($button_2_link): ?>
            <a href="<?= $button_2_link['url']; ?>" class="btn btn-outline-light btn-lg">
              <?= $button_2_link['title']; ?>
            </a>
          <?php endif; ?>

        </div>
      </div>
    </div>
  </div>
</section>


<section class="product-headline">
  <div class="container-fluid py-1 bg-secondary"></div>
  <div class="container py-5">
    <div class="row">
      <div class="col-md-5 offset-md-1 text-left">
        <h2 class="mb-3"><small>Rethinking the</small><br> Developer Experience</h2>
        <p><b>Your Dev-to-Deploy Unified Toolchain -</b> DDEV-Live is a container-based PaaS hosting platform brought to you by the creators of the DDEV-Local local development environment. Our mission is to make your dev-to-deploy experience as simple and reliable as possible. We like to say, "Our stuff helps you build better stuff," because we get the complexity out of your way so you can do the valuable parts of your job without distraction. If you work with multiple CMSs, DDEV-Local runs them all with a unified set of commands and offers a GUI for the less-technical. DDEV-Live PaaS hosting completes the end-to-end, local-to-live tooling that you need when you’re ready to take on containers, DevOps, or CI/CD processes.</p>
      </div>
      <div class="col-md-6 text-left">
        <ul class="list-group list-group-flush">
          <li class="list-group-item mx-2">
            <h3>
              <span class="rounded-circle bg-secondary">
                <i class="fa fa-desktop" aria-hidden="true"></i>
              </span>
              DDEV-Local <br>
              <small>Local development is finally a 1st-class citizen:</small>
            </h3>
            <ul class="mb-3">
              <li>Containerized</li>
              <li>Open source</li>
              <li>Pluggable</li>
            </ul>
          </li>
          <li class="list-group-item mx-2">
            <h3 class="mt-3">
              <span class="rounded-circle bg-secondary">
                <i class="fa fa-cloud" aria-hidden="true"></i>
              </span>
                DDEV-Live <br>
              <small>Containerized, managed hosting platform:</small>
            </h3>
            <ul class="mb-3">
              <li>Runs, monitors, manages, maintains your isolated DDEV-Live Kubernetes cluster</li>
              <li>On any public cloud or private data center, white-label or OEM</li>
              <li>Expert Technical Account Managers and 24/7 support</li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>



<?php if (get_field('product_headline_header') && get_field('product_headline_content')): ?>
<section class="product-headline">
  <div class="container-fluid py-1 bg-secondary"></div>
  <div class="container-fluid py-5">
    <div class="row">
      <div class="col-lg-9 mx-auto text-center text-primary">
        <div class="py-lg-4">
          <h2 class="mb-4"><?php the_field('product_headline_header'); ?></h2>
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="text-muted">
                <?php the_field('product_headline_content'); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>


<?php if (have_rows('product_alternating_sections')):?>
<section class="product-alternating">
  <div class="container-fluid mb-5">
    <?php
      while (have_rows('product_alternating_sections')) : the_row();
          if (get_row_layout() == 'image_left'): ?>

            <div class="row">
              <div class="col-lg-12 col-xl-10 mx-auto">
                <div class="row">
                  <div class="col-lg-3 px-0">
                    <img src="<?php the_sub_field('image'); ?>" alt="" class="img-fluid">
                    <p class="small mt-2"><?php the_sub_field('image_attribution'); ?></p>
                  </div>
                  <div class="col-lg-9">
                    <div class="py-5 px-lg-5">
                      <h3 class="text-primary my-4 mt-lg-0"><?php the_sub_field('header'); ?></h3>
                      <div class="text-muted mb-5">
                        <?php the_sub_field('content'); ?>
                      </div>
                      <?php $section_left_link = get_sub_field('link'); ?>
                      <?php if ($section_left_link): ?>
                        <a href="<?= $section_left_link['url']; ?>" class="btn btn-outline-primary-light btn-lg mb-4 mb-lg-0">
                          <?= $section_left_link['title']; ?>
                        </a>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <?php elseif (get_row_layout() == 'image_right'): ?>
            <div class="row">
              <div class="col-lg-12 col-xl-10 mx-auto">
                <div class="row">
                  <div class="col-lg-3 order-lg-2 px-0">
                    <img src="<?php the_sub_field('image'); ?>" alt="" class="img-fluid">
                    <p class="small mt-2"><?php the_sub_field('image_attribution'); ?></p>
                  </div>
                  <div class="col-lg-9 order-lg-1">
                    <div class="py-5 px-lg-5">
                      <h3 class="text-primary my-4 mt-lg-0"><?php the_sub_field('header'); ?></h3>
                      <div class="text-muted mb-5">
                        <?php the_sub_field('content'); ?>
                      </div>
                      <?php $section_right_link = get_sub_field('link'); ?>
                      <?php if ($section_right_link): ?>
                        <a href="<?= $section_right_link['url']; ?>" class="btn btn-outline-primary-light btn-lg mb-4 mb-lg-0">
                          <?= $section_right_link['title']; ?>
                        </a>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endif;
        endwhile;?>
  </div>
</section>
<?php endif; ?>
