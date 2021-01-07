<?php while (have_posts()) : the_post(); ?>

  <article <?php post_class(); ?>>
    <div class="container">
      <div class="row">
        <div class="col-lg-9">
        <header>
            <h1 class="text-primary single-post-header mb-3"><?php the_title(); ?></h1>
            <p>
                <?php the_field('event_start_date'); ?> - <?php the_field('event_end_date'); ?>
            </p>
            <p>
                <?php the_field('event_location'); ?>
            </p>
            <?php
                echo wp_get_attachment_image(get_post_thumbnail_id(), 'full', false, [
                    'class' => 'event__header-image img-fluid'
                ]);
            ?>
        </header>
              <div class="entry-content my-5">
                <div class="wysiwyg">
                  <?php the_content(); ?>
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
