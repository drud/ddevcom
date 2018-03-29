<div class="modal fade" id="modal-newsletter" tabindex="-1" role="dialog" aria-labelledby="modal-newsletter-label" aria-hidden="true">
  <div class="modal-dialog my-0 mx-0 h-100" role="document">
    <div class="modal-content rounded-0">
      <div class="modal-body py-lg-5">
        <div class="row">
          <div class="col-lg-6 mx-auto">
            <img src="/content/themes/ddevcom_theme/dist/images/modal-close.svg" alt="" class="close" data-dismiss="modal" width="20">
            <div class="align-middle">
              <p class="h3 mt-lg-5">
                <?php the_field('newsletter_form_header', 'option'); ?>
              </p>
              <p class="lead mb-4">
                <?php the_field('newsletter_form_introduction', 'option'); ?>
              </p>
              <?= do_shortcode( get_field('newsletter_form_shortcode', 'option') );  ?>
            </div>
            <hr>
            <button type="button" class="btn btn-outline-primary ml-auto" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
