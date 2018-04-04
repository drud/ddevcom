<?php while (have_posts()) : the_post(); ?>

  <article <?php post_class(); ?>>
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-9 mx-auto">
          <div class="row">
            <div class="col-lg-8">
              <header>
                <h1 class="text-primary single-post-header mb-3"><?php the_title(); ?></h1>
              </header>
              <div class="entry-content">
                <div class="wysiwyg">
                  <?php the_content(); ?>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="" style="margin-top: 10rem">
                <?php dynamic_sidebar('single-post-sidebar'); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer>
      <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
    </footer>
  </article>

<?php endwhile; ?>
