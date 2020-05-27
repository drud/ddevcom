<?php use Roots\Sage\Titles;

?>
<section class="page-header-jumbotron">
  <div class="jumbotron bg-primary-dark rounded-0 mb-0">
    <div class="container">
      <header>
        <h1 class="text-white"><?php the_title(); ?>
        </h1>
        <?php if (!empty(get_field('page_header_subheader'))) : ?>
        <div class="lead text-white">
          <?php the_field('page_header_subheader'); ?>
        </div>
        <?php endif; ?>
      </header>
    </div>
  </div>
</section>
