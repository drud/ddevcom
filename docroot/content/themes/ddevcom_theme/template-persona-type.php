<?php
/**
 * Template Name: Persona Type Template
 */
?>

<section class="persona-type-jumbotron">
  <div class="jumbotron bg-primary-gradient rounded-0 mb-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-9 col-xl-8 mx-auto text-center">
          <header>
            <h1 class="text-white mb-4">
              <?php the_field('persona_type_jumbotron_header'); ?>
            </h1>
          </header>
          <div class="text-white mb-5 lead">
            <?php the_field('persona_type_jumbotron_content'); ?>
          </div>

          <?php $button_1_link = get_field('persona_type_jumbotron_button_1_link'); ?>
          <?php if ($button_1_link): ?>
          <a href="<?= $button_1_link['url']; ?>"
            class="btn btn-outline-secondary btn-lg">
            <?= $button_1_link['title']; ?>
          </a>
          <?php endif; ?>

          <?php $button_2_link = get_field('persona_type_jumbotron_button_2_link'); ?>
          <?php if ($button_2_link): ?>
          <a href="<?= $button_2_link['url']; ?>"
            class="btn btn-outline-light btn-lg">
            <?= $button_2_link['title']; ?>
          </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="persona-type-headline">
  <div class="container-fluid py-1 bg-secondary"></div>
  <div class="container-fluid py-5">
    <div class="row">
      <div class="col-lg-9 col-xl-6 mx-auto text-center text-primary">
        <div class="py-lg-4">
          <h3 class="h2 mb-4"><?php the_field('persona_type_headline_header'); ?>
          </h3>
          <div class="row">
            <div class="col-lg-12 mx-auto">
              <div class="text-muted mb-5">
                <?php the_field('persona_type_headline_content'); ?>
              </div>

              <?php $headline_link = get_field('persona_type_headline_link'); ?>
              <?php if ($headline_link): ?>
              <a href="<?= $headline_link['url']; ?>"
                class="btn btn-outline-primary-light btn-lg">
                <?= $headline_link['title']; ?>
              </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="persona-type-alternating">
  <div class="container-fluid mb-5">

    <?php
      if (have_rows('persona_type_alternating_section')):
          while (have_rows('persona_type_alternating_section')) : the_row();
              if (get_row_layout() == 'image_left'): ?>

    <div class="row">
      <div class="col-lg-12 col-xl-10 mx-auto">
        <div class="row">
          <div class="col-lg-6 px-0">
            <img
              src="<?php the_sub_field('image'); ?>"
              alt="" class="img-fluid">
            <p class="small mt-2 ml-2 ml-lg-0"><?php the_sub_field('image_attribution'); ?>
            </p>
          </div>
          <div class="col-lg-6">
            <div class="py-5 px-lg-5">
              <header>
                <h3 class="text-primary my-4 mt-lg-0"><?php the_sub_field('header'); ?>
                </h3>
              </header>
              <div class="text-muted mb-5">
                <?php the_sub_field('content'); ?>
              </div>
              <?php $section_left_link = get_sub_field('link'); ?>
              <a href="<?= $section_left_link['url']; ?>"
                class="btn btn-outline-primary-light btn-lg mb-4 mb-lg-0">
                <?= $section_left_link['title']; ?>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php elseif (get_row_layout() == 'image_right'): ?>
    <div class="row">
      <div class="col-lg-12 col-xl-10 mx-auto">
        <div class="row">
          <div class="col-lg-6 order-lg-2 px-0">
            <img
              src="<?php the_sub_field('image'); ?>"
              alt="" class="img-fluid">
            <p class="small mt-2"><?php the_sub_field('image_attribution'); ?>
            </p>
          </div>
          <div class="col-lg-6 order-lg-1">
            <div class="py-5 px-lg-5">
              <header>
                <h3 class="text-primary my-4 mt-lg-0"><?php the_sub_field('header'); ?>
                </h3>
              </header>
              <div class="text-muted mb-5">
                <?php the_sub_field('content'); ?>
              </div>
              <?php $section_right_link = get_sub_field('link'); ?>
              <a href="<?= $section_right_link['url']; ?>"
                class="btn btn-outline-primary-light btn-lg mb-4 mb-lg-0">
                <?= $section_right_link['title']; ?>
              </a>
            </div>
          </div>
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

<section>
  <!-- Begin Mailchimp Signup Form -->
  <link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
  <style type="text/css">
    #mc_embed_signup {
      background: #fff;
      clear: left;
      font: 14px Helvetica, Arial, sans-serif;
    }

    /* Add your own Mailchimp form style overrides in your site stylesheet or in this style block.
       We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
  </style>
  <div id="mc_embed_signup">
    <form action="https://drud.us16.list-manage.com/subscribe/post?u=2b53563d5170f6f4ace3119cb&amp;id=b715029d8b"
      method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank"
      novalidate>
      <div id="mc_embed_signup_scroll">
        <h2>Subscribe</h2>
        <div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
        <div class="mc-field-group">
          <label for="mce-EMAIL">Email Address <span class="asterisk">*</span>
          </label>
          <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
        </div>
        <div class="mc-field-group">
          <label for="mce-FNAME">First Name <span class="asterisk">*</span>
          </label>
          <input type="text" value="" name="FNAME" class="required" id="mce-FNAME">
        </div>
        <div class="mc-field-group">
          <label for="mce-LNAME">Last Name <span class="asterisk">*</span>
          </label>
          <input type="text" value="" name="LNAME" class="required" id="mce-LNAME">
        </div>
        <div id="mce-responses" class="clear">
          <div class="response" id="mce-error-response" style="display:none"></div>
          <div class="response" id="mce-success-response" style="display:none"></div>
        </div>
        <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
        <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text"
            name="b_2b53563d5170f6f4ace3119cb_b715029d8b" tabindex="-1" value=""></div>
        <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe"
            class="button"></div>
      </div>
    </form>
  </div>
  <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script>
  <script type='text/javascript'>
    (function($) {
      window.fnames = new Array();
      window.ftypes = new Array();
      fnames[0] = 'EMAIL';
      ftypes[0] = 'email';
      fnames[1] = 'FNAME';
      ftypes[1] = 'text';
      fnames[2] = 'LNAME';
      ftypes[2] = 'text';
      fnames[3] = 'ADDRESS';
      ftypes[3] = 'address';
      fnames[4] = 'PHONE';
      ftypes[4] = 'phone';
    }(jQuery));
    var $mcj = jQuery.noConflict(true);
  </script>
  <!--End mc_embed_signup-->
</section>

<section class="newsletter">
  <div class="container-fluid bg-primary py-4">
    <div class="row">
      <div class="col-lg-9 mx-auto text-center">
        <img src="/content/themes/ddevcom_theme/dist/images/drupalcon-2018-logo.svg" alt="DrupalCon Nashville 2018"
          class="persona-type-drupalcon-logo mr-3" width="80">
        <p class="h3 text-white mb-4 mb-md-0 d-md-inline drupalcon-cta">
          <?php the_field('persona_type_drupalcon_cta'); ?>
        </p>
        <?php $drupalcon_link = get_field('persona_type_drupalcon_cta_link'); ?>
        <a href="http://eepurl.com/dlqkUD"
          class="btn btn-outline-secondary btn-lg d-block d-md-inline-block mb-1 ml-md-3">
          Join Newsletter
        </a>
      </div>
    </div>
  </div>
</section>
<section class="persona-type-recent-posts">
  <div class="container-fluid py-5">
    <div class="row">
      <?php $slug = get_post_field('post_name', get_post()); ?>
      <div class="col-lg-12 mx-auto">
        <h2 class="text-primary text-center mb-4">Related Posts</h2>
        <div class="card-deck">
          <?php
            $args = [
              'post_type' => 'post',
              'posts_per_page' => 3,
              'tag' => $slug,
            ];
            $query = new WP_Query($args);
          ?>

          <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
          <div class="card rounded-0 border-0 bg-white py-5 text-center text-lg-left">
            <article class="persona-article">
              <header>
                <div class="card-header border-0 py-0 bg-white">
                  <h3 class="mb-2">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                  </h3>
                </div>
              </header>
              <div class="card-body">
                <div class="text-muted">
                  <?php the_excerpt(); ?>
                </div>
              </div>
              <div class="card-footer border-0 bg-white">
                <a href="<?php the_permalink(); ?>"
                  class="btn btn-sm btn-outline-primary-light">View Post</a>
              </div>
            </article>
          </div>

          <?php endwhile; ?>
          <!-- post navigation -->
          <?php else: ?>
          <!-- no posts found -->
          <?php endif; ?>

          <?php wp_reset_query(); ?>

        </div>
      </div>
    </div>
  </div>
</section>
<section class="persona-type-events events">
  <div class="container-fluid bg-primary-gradient py-5">

    <?php if (is_active_sidebar('front-page-events')): ?>
    <?php dynamic_sidebar('front-page-events'); ?>
    <?php endif; ?>

  </div>
</section>