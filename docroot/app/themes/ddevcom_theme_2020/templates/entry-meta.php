<time class="updated d-block mb-2" datetime="<?= get_post_time('c', true); ?>"><?= get_the_date(); ?></time>
<p class="byline author vcard">

  <?php get_the_author_meta('ID'); ?>
  <img class="rounded-circle" width="50" src="<?= get_avatar_url( get_the_author_meta('ID') ); ?>" alt="<?= get_the_author_meta('display_name'); ?>">

  <?= __('By', 'sage'); ?> <a href="<?= get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn text-primary d-inline-block mt-2"><?= get_the_author_meta('display_name'); ?></a>
</p>
