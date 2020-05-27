<div class="container py-5">
  <div class="row">
    <div class="col-lg-9">
      <div class="wysiwyg">
        <?php the_content(); ?>
        <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
      </div>
    </div>
  </div>
</div>

