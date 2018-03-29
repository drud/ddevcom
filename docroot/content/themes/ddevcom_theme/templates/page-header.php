<?php use Roots\Sage\Titles; ?>
<section class="page-header-jumbotron">
  <div class="jumbotron bg-primary-gradient rounded-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-9 mx-auto">
          <header>
            <h1 class="text-white"><?= Titles\title(); ?></h1>
            <div class="lead text-white"><?php the_field('page_header_subheader'); ?></div>
          </header>
        </div>
      </div>
    </div>
  </div>
</section>


<div class="page-header">
</div>
