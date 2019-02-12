<section class="landing-signup bg-light">
  <div class="container-fluid py-1 bg-secondary"></div>
  <div class="container py-5">
    <div class="row py-5">
      <div class="col-md-5">
        <?= get_field('product_newsletter_form_text'); ?>
        <?php
        if ($formID = get_field('product_newsletter_form_id')) {
            gravity_form(intval($formID), false, false, false);
        } ?>
      </div>
      <div class="col-md-6 offset-md-1">
        <?php
        $formImgArr = get_field('product_newsletter_image');
        if ($formImgArr && isset($formImgArr['url'])) {
            ?>
        <p class="text-center pb-2">
          <img class="img-fluid" src="<?= $formImgArr['url']; ?>"
            alt="<?= isset($formImgArr['title']) ? $formImgArr['title'] : ''; ?>">
        </p>
        <?php
        } ?>

        <?= get_field('product_newsletter_sales_copy'); ?>

      </div>
    </div>
  </div>
</section>
