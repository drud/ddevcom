<?php
// phpcs:ignoreFile

/**
 * Block Name: DDEV Jumbotron
 *
 * This is the template that displays the Jumbtron aka Header.
 */

// create id attribute for specific styling
$id = 'jumbotron-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';

?>
<section id="<?php echo $id; ?>" class="persona-type-jumbotron <?php echo $align_class; ?>">
  <div class="jumbotron bg-primary-gradient rounded-0 mb-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-9 col-xl-8 mx-auto text-center">
          <header>
            <h1 class="text-white mb-4">
              <?php the_field('jumbotron_header'); ?>
            </h1>
          </header>
          <div class="text-white mb-5 lead">
            <?php the_field('jumbotron_content'); ?>
          </div>

          <?php $button_1_link = get_field('jumbotron_button_1_link'); ?>
          <?php if ($button_1_link): ?>
          <a href="<?= $button_1_link['url']; ?>"
            class="btn btn-outline-secondary btn-lg">
            <?= $button_1_link['title']; ?>
          </a>
          <?php endif; ?>

          <?php $button_2_link = get_field('jumbotron_button_2_link'); ?>
          <?php if ($button_2_link): ?>
          <a href="<?= $button_2_link['url']; ?>"
            class="btn btn-outline-light btn-lg">
            <?= $button_2_link['title']; ?>
          </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="container-fluid py-1 bg-secondary mb-5"></div>

<style type="text/css">
  #<?php echo $id; ?> {
    background: #004278;
  }
  #<?php echo $id; ?> * {
    text-align: center;
    color: white;
  }
</style>
