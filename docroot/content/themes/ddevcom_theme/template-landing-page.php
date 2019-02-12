<?php
/**
 * Template Name: Landing Page
 */

while (have_posts()) : the_post();
  // jumbotron
  get_template_part('templates/landing', 'jumbotron');
  // rethink
  get_template_part('templates/landing', 'rethink');
  // one PaaS
  get_template_part('templates/landing', 'onepaas');
  // open-source
  get_template_part('templates/landing', 'opensource');

  $formID = get_field('product_newsletter_form_id');
  if ($formID) {
      // signup
      get_template_part('templates/landing', 'signup-acf');
  } else {
      // signup
      get_template_part('templates/landing', 'signup');
  }
endwhile;
