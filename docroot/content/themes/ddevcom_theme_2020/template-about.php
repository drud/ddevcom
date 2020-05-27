<?php
/**
 * Template Name: About Template
 */
?>

<section class="about-jumbotron">
  <div class="jumbotron bg-primary-dark rounded-0 mb-0">
    <div class="container">
      <div class="row">
        <div class="col-lg-9">
          <header>
            <h1 class="text-white mb-4">
              <?php the_field('about_jumbotron_header'); ?>
            </h1>
          </header>
          <div class="lead mb-5">
            <?php the_field('about_jumbotron_content'); ?>
          </div>

          <?php $button_1_link = get_field('about_jumbotron_button_1_link'); ?>
          <?php if ($button_1_link): ?>
            <a href="<?= $button_1_link['url']; ?>" class="btn btn-light btn-lg mr-2">
              <?= $button_1_link['title']; ?>
            </a>
          <?php endif; ?>

          <?php $button_2_link = get_field('about_jumbotron_button_2_link'); ?>
          <?php if ($button_2_link): ?>
            <a href="<?= $button_2_link['url']; ?>" class="btn btn-primary btn-lg">
              <?= $button_2_link['title']; ?>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="about-headline">
  <div class="container py-5">
    <div class="row py-lg-5">
      <div class="col-lg-8 mx-auto text-center">
          <header>
            <h2 class="text-dark my-4"><?php the_field('about_headline_header'); ?></h2>
          </header>
          <div class="mb-5 text-muted">
            <?php the_field('about_headline_content'); ?>
          </div>
          <?php $headline_link_1 = get_field('about_headline_link_1'); ?>
          <?php $headline_link_2 = get_field('about_headline_link_2'); ?>

          <?php if($headline_link_1): ?>
            <a href="<?= $headline_link_1['url']; ?>" class="btn btn-lg btn-primary-dark mr-2">
              <?= $headline_link_1['title']; ?>
            </a>
          <?php endif; ?>

          <?php if($headline_link_2): ?>
            <a href="<?= $headline_link_2['url']; ?>" class="btn btn-lg btn-outline-primary-dark">
              <?= $headline_link_2['title']; ?>
            </a>
          <?php endif; ?>

      </div>
    </div>
  </div>
</section>

<section class="about-alternating bg-light">
  <div class="container py-5">
    <?php
      if( have_rows('about_alternating_sections') ):
          while ( have_rows('about_alternating_sections') ) : the_row();
              if( get_row_layout() == 'image_left' ): ?>

                <div class="row">
                  <div class="col-lg-6 px-0 d-flex flex-direction-column">
                    <div class="my-auto">
                      <img src="<?php the_sub_field('image'); ?>" alt="" class="img-fluid">
                      <p class="small mt-2"><?php the_sub_field('image_attribution'); ?></p>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="py-5 px-lg-5">
                      <h3 class="text-dark h3 my-4 mt-lg-0"><?php the_sub_field('header'); ?></h3>
                      <div class="text-muted mb-5">
                        <?php the_sub_field('content'); ?>
                      </div>
                      <?php $section_left_link = get_sub_field('link'); ?>
                      <a href="<?= $section_left_link['url']; ?>" class="btn btn-primary-dark btn-lg mb-4 mb-lg-0">
                        <?= $section_left_link['title']; ?>
                      </a>
                    </div>
                  </div>
                </div>

                <?php elseif( get_row_layout() == 'image_right' ): ?>
                <div class="row">
                  <div class="col-lg-6 order-lg-2 px-0 d-flex flex-direction-column">
                    <div class="my-auto">
                      <img src="<?php the_sub_field('image'); ?>" alt="" class="img-fluid">
                      <p class="small mt-2"><?php the_sub_field('image_attribution'); ?></p>
                    </div>
                  </div>
                  <div class="col-lg-6 order-lg-1">
                    <div class="py-5 px-lg-5">
                      <h3 class="text-dark my-4 mt-lg-0"><?php the_sub_field('header'); ?></h3>
                      <div class="text-muted mb-5">
                        <?php the_sub_field('content'); ?>
                      </div>
                      <?php $section_right_link = get_sub_field('link'); ?>
                      <a href="<?= $section_right_link['url']; ?>" class="btn btn-primary-dark btn-lg mb-4 mb-lg-0">
                        <?= $section_right_link['title']; ?>
                      </a>
                    </div>
                  </div>
                </div>

        <?php
              endif;
            endwhile;
          endif;
         ?>
  </div>
</section>
