<?php
// phpcs:ignoreFile

/**
 * Block Name: Built & Guaranteed
 *
 * This is the template that displays the testimonial block.
 */

// create id attribute for specific styling
$id = 'icontitle-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';

?>
<div
  id="<?php echo $id; ?>"
  class="row my-4 <?php echo $align_class; ?>"
>
  <h2 class="mb-3">Built & Guaranteed<small class="d-block">by DRUD Tech</small></h2>
  <p class="mb-5"><b>24x7 Service and Support SLAs</b> guarantee your success on our platform. DRUD Tech has deep
    expertise
    and experience in digital agencies and open source CMS communities.</p>
  <ul class="list-group list-group-flush">
    <li class="list-group-item mx-0 px-1">
      <h5>
        <span class="rounded-circle bg-dark text-white">
          <i class="fa fa-line-chart" aria-hidden="true"></i>
        </span>
        99.90% proactive uptime guarantee:
      </h5>
      <p>We fix issues before they become your problem.</p>
    </li>
    <li class="list-group-item mx-0 px-1">
      <h5>
        <span class="rounded-circle bg-dark text-white">
          <i class="fa fa-user-secret" aria-hidden="true"></i>
        </span>
        Dedicated TAMs:
      </h5>
      <p>Technical Account Managers know your projects and provide direct product usage and problem resolution
        support.</p>
    </li>
    <li class="list-group-item mx-0 px-1">
      <h5>
        <span class="rounded-circle bg-dark text-white">
          <i class="fa fa-life-ring" aria-hidden="true"></i>
        </span>
        Production support
      </h5>
      <p>for our managed hosting offerings. Engineering support of our platform and products. Consultative
        support for tuning, best practice recommendations, code reviews, issues relating to a specific
        deployment, & CI/CD processes and workflows.</p>
    </li>
    <li class="list-group-item mx-0 px-1">
      <h5>
        <span class="rounded-circle bg-dark text-white">
          <i class="fa fa-graduation-cap" aria-hidden="true"></i>
        </span>
        Training and Professional Services:
      </h5>
      <p>DevOps, workflows, custom integrations, OEM versions, and more.</p>
    </li>
  </ul>
</div>
