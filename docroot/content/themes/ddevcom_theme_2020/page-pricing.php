<section class="pricing py-5">
    <div class="container container-xl mb-3">
        <div class="row">
            <div class="col-12 text-center">
                <p class="h1 font-family-heading">
                    Choose a Plan
                </p>
                <p class="lead text-muted">
                    All plans come with our stellar support, CI/CD pipelines, and our local development tools!
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-check d-inline-block mr-3">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input plan-type-radio" name="planType" id="plan-type-monthly" value="monthly" checked>
                        Monthly Pricing
                    </label>
                </div>
                <div class="form-check d-inline-block">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input plan-type-radio" name="planType" id="plan-type-yearly" value="yearly">
                        Annual Pricing
                    </label>
                </div>
            </div>
        </div>
    </div>
  <div class="container container-xl plans">
    <div class="row">
            <?php
                $stripe = new DDEV\Stripe();
                $plans = $stripe->get_plans(); 
            ?>
            <?php foreach( $plans as $plan_id => $plan ): ?>
                    <div class="col-12 col-md-6 col-lg-3 d-flex flex-column justify-content-end px-2">

                            <div class="card monthly mb-4 mb-lg-0 text-center">
                                <div class="card-header">
                                    <h4 class="card-title h6 mb-0">
                                        <?php echo $plan->monthly->nickname; ?>
                                    </h4>
                                </div>  
                                <ul class="list-group list-group-flush">
                                    <?php if(isset($plan->is_trial)): ?>
                                        <li class="list-group-item bg-success">
                                            <p class="text-white mb-0 font-family-heading">
                                                <?php echo $plan->trial_days; ?>-day Free Trial
                                            </p>
                                        </li>
                                    <?php endif; ?>
                                    <li class="list-group-item">
                                        <p class="h4 mb-0">
                                            <?php echo $plan->monthly->amount; ?>
                                        </p>
                                        <p class="small text-muted uppercase mb-0">
                                            Monthly
                                        </p>
                                    </li>
                                    <?php 
                                        $site_cpu = array_pop($plan->monthly->description);
                                        $site_memory = array_pop($plan->monthly->description);
                                    ?>
                                    <?php foreach( $plan->monthly->description as $description_item): ?>
                                        <li class="list-group-item"><?php echo $description_item; ?></li>
                                    <?php endforeach; ?>
                                    <li class="list-group-item bg-light py-1">Site specs:</li>
                                    <li class="list-group-item"><?php echo $site_cpu; ?></li>
                                    <li class="list-group-item"><?php echo $site_memory; ?></li>
                                </ul>
                                <div class="card-footer">
                                    <a
                                        href="https://dash.ddev.com/account/login?pid=<?php echo $plan->monthly->id; ?>"
                                        class="btn btn-block <?php echo $plan->is_trial ? "btn-success" : "btn-primary"; ?>"
                                    >
                                        <?php echo isset($plan->is_trial) ? "Start Free Trial" : "Get Started"; ?>
                                    </a>
                                </div>
                            </div>

                            <div class="card yearly mb-4 mb-lg-0 text-center d-none">
                                <div class="card-header">
                                    <h4 class="card-title h6 mb-0">
                                        <?php echo $plan->yearly->nickname; ?>
                                    </h4>
                                </div>  
                                <ul class="list-group list-group-flush">
                                    <?php if(isset($plan->is_trial)): ?>
                                        <li class="list-group-item bg-success">
                                            <p class="text-white mb-0 font-family-heading">
                                                <?php echo $plan->trial_days; ?>-day Free Trial
                                            </p>
                                        </li>
                                    <?php endif; ?>
                                    <li class="list-group-item">
                                        <p class="h4 mb-0">
                                            <?php echo $plan->yearly->amount; ?>
                                        </p>
                                        <p class="small text-muted uppercase mb-0">
                                            Annually
                                        </p>
                                    </li>
                                    <?php 
                                        $site_cpu = array_pop($plan->yearly->description);
                                        $site_memory = array_pop($plan->yearly->description);
                                    ?>
                                    <?php foreach( $plan->yearly->description as $description_item): ?>
                                        <li class="list-group-item"><?php echo $description_item; ?></li>
                                    <?php endforeach; ?>
                                    <li class="list-group-item bg-light py-1">Site specs:</li>
                                    <li class="list-group-item"><?php echo $site_cpu; ?></li>
                                    <li class="list-group-item"><?php echo $site_memory; ?></li>
                                </ul>
                                <div class="card-footer">
                                    <a
                                        href="https://dash.ddev.com/account/login?pid=<?php echo $plan->yearly->id; ?>"
                                        class="btn btn-block <?php echo $plan->is_trial ? "btn-success" : "btn-primary"; ?>"
                                    >
                                        <?php echo isset($plan->is_trial) ? "Start Free Trial" : "Get Started"; ?>
                                    </a>
                                </div>
                            </div>

                    </div>
            <?php endforeach; ?>
    </div>
  </div>
  <div class="container py-5">
      <div class="row">
          <div class="col-12 text-center">
                <h2>
                  DDEV for Agencies & Enterprises
                </h2>
                <p class="lead mb-4 text-muted">
                  Reach out to us with any questions, customized pricing requests, or demos.
                </p>
                <a href="<?php echo home_url('/contact/agencies-enterprises') ?>" class="btn btn-primary">
                    Contact Us Today
                </a>
          </div>
      </div>
  </div>
</section>