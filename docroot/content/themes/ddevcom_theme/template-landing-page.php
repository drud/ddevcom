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
  // signup
  get_template_part('templates/landing', 'signup');
endwhile;
