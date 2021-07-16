<?php
/**
 * Template Name: People Template
 */
?>

<section class="people-header">
  <div class="container-fluid py-5 bg-white">
    <div class="row">
      <div class="col-lg-12 text-center">
        <div class="pt-5 mt-5">
          <h1 class="text-primary">Meet the Team</h1>
          <p class="text-muted lead">
            Meet the team that make DDEV possible.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="people-loop mb-5">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-9 mx-auto">
        <div class="row">
          <?php
            $team_members = get_users([
              'role__in' => ['editor','administrator'],
              'exclude'  => [1,5,6,7]
            ]);
           ?>
          <?php foreach($team_members as $team_member): ?>
            <div class="col-lg-4">
              <div class="card mb-2">
                <div class="card-body">
                  <img class="rounded-circle" src="<?= get_avatar_url($team_member->data->ID) ?>" alt="<?= $team_member->data->display_name; ?>">
                  <div class="d-inline-block">
                    <span class="d-block ml-2"></span> <?= $team_member->data->display_name; ?>
                    <p class="small">
                      <a href="<?= get_author_posts_url($team_member->data->ID); ?>" class="btn btn-sm btn-link">View Posts</a>
                    </p>
                  </div>

                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>
