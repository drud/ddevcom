<div class="container-fluid py-5">
  <div class="row">
    <div class="col-lg-6 col-sm-8 col-md-7 mx-auto">
      <div class="py-lg-5">
        <div class="wysiwyg">
          <?php the_content(); ?>
          <?php wp_link_pages([
            'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'),
            'after' => '</p></nav>'
          ]); ?>
        </div>
      </div>
    </div>
  </div>
</div>
