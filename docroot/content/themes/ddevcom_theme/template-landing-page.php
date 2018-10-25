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
      <div class="col-md-5 offset-md-1">
        <h2 class="mb-3"><small>Rethinking the</small><br> Developer Experience</h2>
        <p><b>Your Dev-to-Deploy Unified Toolchain -</b> DDEV-Live is a container-based PaaS hosting platform brought to you by the creators of the DDEV-Local local development environment. Our mission is to make your dev-to-deploy experience as simple and reliable as possible. We like to say, "Our stuff helps you build better stuff," because we get the complexity out of your way so you can do the valuable parts of your job without distraction. If you work with multiple CMSs, DDEV-Local runs them all with a unified set of commands and offers a GUI for the less-technical. DDEV-Live PaaS hosting completes the end-to-end, local-to-live tooling that you need when you’re ready to take on containers, DevOps, or CI/CD processes.</p>
      </div>
      <div class="col-md-6">
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

<section class="product-">
  <div class="container-fluid py-1 bg-primary"></div>
  <div class="container py-5 my-5">
    <div class="row my-5">
      <div class="col-md-7 offset-md-2">
        <h2 class="mb-3"><small>One PaaS</small><br> Any Open Source CMS</h2>
        <p><b>Run open source CMSs with confidence:</b> The DDEV dev-to-deploy container-based PaaS hosting platform currently supports Drupal, TYPO3 CMS, Wordpress, and can be configured to run many more.</p>
      </div>
    </div>
    <div class="row my-4">

      <div class="col-md-4">
        <div class="card h-100">
            <div class="row no-gutters h-100">
                <div class="col-4 rounded-left p-3 text-center" style="background-color: #3877AF;">
                    <img src="<?= get_stylesheet_directory_uri(); ?>/dist/images/Drupal.png" class="img-fluid" alt="Drupal">
                </div>
                <div class="col-8">
                    <div class="card-block px-3 py-3">
                        <h5 class="card-title">Drupal</h5>
                        <p class="card-text small">Drupal is free, open source software that can be used by individuals or groups of users -- even those lacking technical skills -- to easily create and manage many types of Web sites. The application includes a content management platform and a development framework.</p>
                    </div>
                </div>
            </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100">
            <div class="row no-gutters h-100">
                <div class="col-4 rounded-left p-3 text-center" style="background-color: #21759B;">
                <img src="<?= get_stylesheet_directory_uri(); ?>/dist/images/WordPress.png" class="img-fluid" alt="WordPress">
                </div>
                <div class="col-8">
                    <div class="card-block px-3 py-3">
                        <h5 class="card-title">WordPress</h5>
                        <p class="card-text small">WordPress is software designed for everyone, emphasizing accessibility, performance, security, and ease of use. We believe great software should work with minimum set up, so you can focus on sharing your story, product, or services freely. The basic WordPress software is simple and predictable so you can easily get started. It also offers powerful features for growth and success.</p>
                    </div>
                </div>
            </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100">
            <div class="row no-gutters h-100">
                <div class="col-4 rounded-left p-3 text-center" style="background-color: #F49800;">
                <img src="<?= get_stylesheet_directory_uri(); ?>/dist/images/Typo3.png" class="img-fluid" alt="Typo3">
                </div>
                <div class="col-8">
                    <div class="card-block px-3 py-3">
                        <h5 class="card-title">Typo3 CMS</h5>
                        <p class="card-text small">TYPO3 CMS is an Open Source Enterprise Content Management System with a large global community, backed by the approximately 900 members of the TYPO3 Association.</p>
                    </div>
                </div>
            </div>
        </div>
      </div>

    </div>



    <div class="row my-4">

      <div class="col-md-4">
        <div class="card h-100">
            <div class="row no-gutters h-100">
                <div class="col-4 rounded-left p-3 text-center" style="background-color: #8892BF;">
                <img src="<?= get_stylesheet_directory_uri(); ?>/dist/images/PHP.png" class="img-fluid" alt="PHP">
                </div>
                <div class="col-8">
                    <div class="card-block px-3 py-3">
                        <h5 class="card-title">Vanilla PHP Application</h5>
                        <p class="card-text small">Hypertext Preprocessor (or simply PHP) is a server-side scripting language designed for Web development, but also used as a general-purpose programming language. PHP code may also be executed with a command-line interface (CLI) and can be used to implement standalone graphical applications.</p>
                    </div>
                </div>
            </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100">
            <div class="row no-gutters h-100">
                <div class="col-4 rounded-left p-3 text-center" style="background-color: #CB3837;">
                  <img src="<?= get_stylesheet_directory_uri(); ?>/dist/images/NPM.png" class="img-fluid" alt="NPM">
                </div>
                <div class="col-8">
                    <div class="card-block px-3 py-3">
                        <h5 class="card-title">Static Sites / Flat file CMS</h5>
                        <p class="card-text small">Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit vitae sed commodi impedit nam inventore at ducimus facilis ipsa illum iste a veritatis voluptates mollitia blanditiis, hic, consequatur, dolores laborum!</p>
                    </div>
                </div>
            </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100 coming-soon">
            <div class="row no-gutters h-100">
                <div class="col-4 rounded-left p-3 text-center" style="background-color: #CFDE56;">
                  <img src="<?= get_stylesheet_directory_uri(); ?>/dist/images/Backdrop.png" class="img-fluid" alt="Backdrop">
                </div>
                <div class="col-8">
                    <div class="card-block px-3 py-3">
                        <h5 class="card-title">Backdrop</h5>
                        <p class="card-text small">The core Backdrop CMS package aims to include many useful features, but only those that are necessary for the majority of sites using it. Backdrop's world of Add-Ons can be used to meet less common needs. Backdrop can be easily extended with the addition of modules, themes, and layouts.</p>
                    </div>
                </div>
            </div>
        </div>
      </div>

    </div>
    <div class="row my-4">

      <div class="col-md-4">
        <div class="card h-100 coming-soon">
            <div class="row no-gutters h-100">
                <div class="col-4 rounded-left p-3 text-center" style="background-color: #EF533F;">
                  <img src="<?= get_stylesheet_directory_uri(); ?>/dist/images/Laravel.png" class="img-fluid" alt="Laravel">
                </div>
                <div class="col-8">
                    <div class="card-block px-3 py-3">
                        <h5 class="card-title">Laravel</h5>
                        <p class="card-text small">An open-source PHP framework, which is robust and easy to understand. It follows a model-view-controller design pattern. Laravel reuses the existing components of different frameworks which helps in creating a web application. The web application thus designed is more structured and pragmatic.</p>
                    </div>
                </div>
            </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100 coming-soon">
            <div class="row no-gutters h-100">
                <div class="col-4 rounded-left p-3" style="background-color: #000000;">
                  <img src="<?= get_stylesheet_directory_uri(); ?>/dist/images/Symfony.png" class="img-fluid" alt="Symfony">
                </div>
                <div class="col-8">
                    <div class="card-block px-3 py-3">
                        <h5 class="card-title">Symfony</h5>
                        <p class="card-text small">An Open Source PHP framework for developing web applications. It was originally conceived by the interactive agency SensioLabs for the development of web sites for its own customers.</p>
                    </div>
                </div>
            </div>
        </div>
      </div>

      <div class="col-md-4">
        <p class="em text-left">Laravel, Symfony, and other PHP applications coming soon!</p>
      </div>

    </div>


  </div>
</section>






<section class="product-headline">
  <div class="container-fluid py-1 bg-secondary"></div>
  <div class="container py-5">
    <div class="row">
        <div class="col-md-6 offset-md-1">
            <h2 class="mb-3"><small>Open Source</small><br> Cloud-Native</h2>
            <p>DDEV is a Cloud-Native-Foundation-friendly, best-of-breed platform, built on the shoulders of giants using open source technologies backed by active open source communities. The DDEV dev-to-deploy toolset is licensed under the open source Apache 2.0 license.</p>

            <p class="text-center py-5"><img class="img-fluid" src="<?= get_stylesheet_directory_uri(); ?>/dist/images/CNCF-project-icons.png" alt=""></p>

        </div>

        <div class="col-md-5 offest-md-1">
            <h2 class="mb-3">Built & Guaranteed<br> <small>by DRUD Tech</small></h2>
            <p><b>24x7 Service and Support SLAs</b> guarantee your success on our platform. DRUD Tech has deep expertise and experience in digital agencies and open source CMS communities.</p>
            <ul class="list-group list-group-flush">
              <li class="list-group-item mx-2">
                <h5>
                  <span class="rounded-circle bg-secondary">
                    <i class="fa fa-desktop" aria-hidden="true"></i>
                  </span>
                  99.90% proactive uptime guarantee:
                </h5>
                <p>We fix issues before they become your problem.</p>
              </li>
              <li class="list-group-item mx-2">
                <h5>
                  <span class="rounded-circle bg-secondary">
                    <i class="fa fa-desktop" aria-hidden="true"></i>
                  </span>
                  Dedicated TAMs:
                </h5>
                <p>Technical Account Managers know your projects and provide direct product usage and problem resolution support.</p>
              </li>
              <li class="list-group-item mx-2">
                <h5>
                  <span class="rounded-circle bg-secondary">
                    <i class="fa fa-desktop" aria-hidden="true"></i>
                  </span>
                  Production support
                </h5>
                <p>for our managed hosting offerings. Engineering support of our platform and products. Consultative support for tuning, best practice recommendations, code reviews, issues relating to a specific deployment, & CI/CD processes and workflows.</p>
              </li>
              <li class="list-group-item mx-2">
                <h5>
                  <span class="rounded-circle bg-secondary">
                    <i class="fa fa-desktop" aria-hidden="true"></i>
                  </span>
                  Training and Professional Services:
                </h5>
                <p>DevOps, workflows, custom integrations, OEM versions, and more.</p>
              </li>
            </ul>
        </div>
    </div>
  </div>
  <a name="signup">
</section>






<section class="early-access-signup bg-light">
  <div class="container-fluid py-1 bg-secondary"></div>
  <div class="container py-5">
      <div class="row">
        <div class="col-md-5">
          <h2>Sign Up for Early Access Today!</h2>
          <p>You’re invited to apply for early adopter access to try our full local-to-live, dev-to-deploy platform.</p>
          <?php gravity_form(3, false, false, false); ?>
        </div>

        <div class="col-md-6 offset-md-1">
          <p class="text-center pt-5 pb-2">
            <img class="img-fluid" src="<?= get_stylesheet_directory_uri(); ?>/dist/images/GoldenTicket.jpg" alt="DDEV-Live Golden Ticket">
          </p>
          <h4 class="mb-3">Did you get a DDEV-Live early adopter access Golden Ticket recently?</h4>
          <h6 class="mb-3">DDEV-Live hosting is coming and we have great things in store for you!</h6>
          <p class="small">Try DDEV-Live in production on us. For early adopters, we will host one production installation of a supported CMS (at our discretion, technical limitations apply) on DDEV-Live, up to a value of $150 US dollars. We’ll extend your early access a further $150 in value if you file a support ticket, referring a friend or colleague who signs up for our trial, or if you contribute to our DDEV open source tooling and/or the improvement of our platform in the form of patches, pull requests, bug reports, or feature requests.</p>
          <p class="small">We’ll give you a hand getting started. Ticket-based migration, onboarding assistance, and support included.</p>
        </div>
      </div>
  </div>
</section>
