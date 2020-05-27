<?php use Roots\Sage\Titles; ?>
<section class="page-header-jumbotron">
  <div class="jumbotron bg-primary-gradient rounded-0 mb-0">
    <div class="container">
      <div class="row">
        <div class="col-lg-9">
          <header>
            <h1 class="text-white"><?php the_title(); ?></h1>
            <div class="lead text-white"><?php the_field('page_header_subheader'); ?></div>
          </header>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid py-1 bg-secondary"></div>
</section>
