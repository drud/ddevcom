<div class="modal fade" id="modal-hosting" tabindex="-1" role="dialog" aria-labelledby="modal-newsletter-label" aria-hidden="true">
  <div class="modal-dialog my-0 mx-0 h-100" role="document">
    <div class="modal-content rounded-0">
      <div class="modal-body py-lg-5">
        <div class="row">
          <div class="col-lg-6 mx-auto">
            <img src="/app/themes/ddevcom_theme_2020/dist/images/modal-close.svg" alt="" class="close" data-dismiss="modal" width="20">
            <div class="align-middle">
              <p class="h3 mt-lg-5 mb-4">
                <?php the_field('hosting_modal_form_header', 'option'); ?>
              </p>
              <div class="text-muted mb-5">
                <?php the_field('hosting_modal_form_introduction', 'option'); ?>
              </div>
              <?= do_shortcode( get_field('hosting_modal_form_shortcode', 'option') );  ?>
            </div>
            <button type="button" class="btn btn-outline-primary ml-auto" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
