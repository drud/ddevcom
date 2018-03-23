<section class="front-page-jumbotron">
  <div class="jumbotron bg-primary-gradient rounded-0 mb-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-8 mx-auto text-center">
          <p class="h1 text-white mb-4">
            <?php the_field('front_page_jumbotron_header'); ?>
          </p>
          <div class="text-white mb-5 lead">
            <?php the_field('front_page_jumbotron_content'); ?>
          </div>

          <?php $button_1_link = get_field('front_page_jumbotron_button_1_link'); ?>
          <?php if ($button_1_link): ?>
            <a href="<?= $button_1_link['url']; ?>" class="btn btn-outline-secondary btn-lg">
              <?= $button_1_link['title']; ?>
            </a>
          <?php endif; ?>

          <?php $button_2_link = get_field('front_page_jumbotron_button_2_link'); ?>
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
<section class="front-page-drupalcon">
  <div class="container-fluid bg-primary-dark py-4">
    <div class="row">
      <div class="col-lg-9 mx-auto text-center">
        <img src="/content/themes/ddevcom_theme/dist/images/drupalcon-2018-logo.svg"
        alt="DrupalCon Nashville 2018"
        class="front-page-drupalcon-logo mr-3" width="80">
          <p class="h3 text-white mb-4 mb-md-0 d-md-inline drupalcon-cta">
            <?php the_field('front_page_drupalcon_cta'); ?>
          </p>
          <?php $drupalcon_link = get_field('front_page_drupalcon_cta_link'); ?>
        <a href="<?= $drupalcon_link['url']; ?>" class="btn btn-outline-secondary btn-lg d-block d-md-inline-block mb-1 ml-md-3">
          <?= $drupalcon_link['title']; ?>
        </a>
      </div>
    </div>
  </div>
</section>
<section class="front-page-headline">
  <div class="container-fluid py-5">
    <div class="row">
      <div class="col-lg-9 mx-auto text-center text-primary">
        <div class="py-lg-4">
          <h3 class="h2 mb-4">Using DDEV will simplify your development workflow.</h3>
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <p class="text-muted">
                Whether you are a provider, a builder, or a teacher, DDEV can
                have a significant impact on your efficiency.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="front-page-alternating">
  <div class="container-fluid mb-5">
    <div class="row">
      <div class="col-lg-12 col-xl-10 mx-auto">
        <div class="row">
          <div class="col-lg-6 px-0">
            <img src="https://placehold.it/960x600" alt="" class="img-fluid">
          </div>
          <div class="col-lg-6">
            <div class="py-5 px-lg-5">
              <h4 class="text-primary h3 my-4 mt-lg-0">Providers</h4>
              <div class="text-muted mb-4">
                <p>
                  Providers are agencies or companies that provide development
                  services to a large number of websites, and
                  usually have larger development teams. Learn more
                  about how utilizing DDEV can show significant boosts
                  in production, save thousands of dollars a year, and
                  simplify your web development workflow.
                </p>
              </div>
              <a href="#" class="btn btn-outline-primary-light btn-lg mb-4 mb-lg-0">
                I'm a Provider
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 col-xl-10 mx-auto">
        <div class="row">
          <div class="col-lg-6 order-lg-2 px-0">
            <img src="https://placehold.it/960x600" alt="" class="img-fluid">
          </div>
          <div class="col-lg-6 order-lg-1">
            <div class="py-5 px-lg-5">
              <h4 class="text-primary h3 my-4 mt-lg-0">Builders</h4>
              <div class="text-muted mb-4">
                <p>
                  Builders are individuals or small teams that spend the
                  most of their time getting their hands dirty in code,
                  working out bugs, and writing markup. Builders working
                  with DDEV are able to push their business forward
                  by spending less time configuring and more time creating
                  for their clientele.
                </p>
              </div>
              <a href="#" class="btn btn-outline-primary-light btn-lg mb-4 mb-lg-0">
                I'm a Builder
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 col-xl-10 mx-auto">
        <div class="row">
          <div class="col-lg-6 px-0">
            <img src="https://placehold.it/960x600" alt="" class="img-fluid">
          </div>
          <div class="col-lg-6">
            <div class="py-5 px-lg-5">
              <h4 class="text-primary h3 my-4 mt-lg-0">Teachers</h4>
              <div class="text-muted mb-4">
                <p>
                  Teachers are individuals or small teams that provide
                  instruction on web design and development. DDEV
                  allows teachers to quickly get their students on the
                  same page, opening up more time to focus more on
                  their curriculum and less on troubleshooting and debugging
                  their students’ computers.
                </p>
              </div>
              <a href="#" class="btn btn-outline-primary-light btn-lg mb-4 mb-lg-0">
                I'm a Teacher
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="front-page-testimonials testimonials">
  <div class="container-fluid bg-primary-dark py-5">

    <?php if ( have_rows('front_page_testimonials') ): ?>
        <?php while ( have_rows('front_page_testimonials') ) : the_row(); ?>

          <?php $testimonial = get_sub_field('testimonial'); ?>

          <div class="row">
            <div class="col-lg-6 mx-auto">
              <div class="py-4">
                <img  width="80" src="<?= get_field('testimonial_image', $testimonial->ID); ?>" alt="" class="rounded-circle d-block mx-auto mb-4">
                <div class="h4 text-light text-center">
                  <?= get_field('testimonial_body', $testimonial->ID); ?>
                </div>
                <p class="text-white text-center">
                  - <?= get_field('testimonial_name', $testimonial->ID); ?>, <a href="<?= get_field('testimonial_company_link', $testimonial->ID); ?>" class="text-secondary-light"><?= get_field('testimonial_company', $testimonial->ID); ?></a>
                </p>
              </div>
            </div>
          </div>

        <?php endwhile; ?>
    <?php endif; ?>

  </div>
</section>
