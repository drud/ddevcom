<div class="modal fade" id="modal-video" tabindex="-1" role="dialog" aria-labelledby="modal-video-label" aria-hidden="true">
  <div class="modal-dialog my-0 mx-0 h-100" role="document">
    <div class="modal-content rounded-0">
      <div class="modal-body py-lg-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="py-5">
                    <img src="/content/themes/ddevcom_theme/dist/images/modal-close.svg" alt="" class="close" data-dismiss="modal" width="20">
                </div>
                <div class="video-wrapper">
                    <iframe width="560" height="315" src="<?php the_field('front_page_video_embed_url', 33); ?>?modestbranding=1&showinfo=0&rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>
                <button type="button" class="btn btn-outline-primary d-block mt-3 mx-auto" data-dismiss="modal">Close</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
