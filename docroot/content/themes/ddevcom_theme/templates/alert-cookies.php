<?php if(get_field('cookie_display', 'option')): ?>
    <div id="cookie-alert" class="alert alert-warning alert-dismissible fade mb-0 py-4 px-lg-4 rounded-0" role="alert">
        <div class="row">
            <div class="col-lg-10">
                <div class="small">
                    <?php the_field('cookie_warning_content', 'option'); ?>
                </div>
            </div>
            <div class="col-lg-2">
                <a href="#" id="accept-cookies" class="btn btn-outline-primary d-block" class="close" data-dismiss="alert" aria-label="Close">Accept Cookies</a>
            </div>
        </div>
    </div>
<?php endif; ?>