<?php
namespace DDEV;

use Stripe\StripeClient;

class Stripe {
     private $publishable_key = 'pk_test_5gUbKmQZUdm8La3qmr923eCP00mPRHQvSc';
     private $secret_key = 'sk_test_T0iZskVLpFLXbe5rKv9C4n6u00txDzexq2';
     private $client;
     private $formatted_plans = [];
     private $product_ids = [
        'personal-site',
        's-pro-site',
        'm-pro-site',
        'l-pro-site',
    ];

    protected $products;

    public function __construct()
    {
        $this->client = new StripeClient($this->secret_key);
        $this->set_products();
        $this->set_formatted_plans();
    }

    /**
     * Set formatted plans for displaying in the theme
     * @return void
     */
    private function set_formatted_plans() : void
    {
        foreach($this->products as $product) {
            $product_plans = $this->get_product_plans($product->id);
            $this->formatted_plans[$product->id] = new \stdClass();

            foreach($product_plans as $plan) {

                $formatted_plan = new \stdClass();
                $formatted_plan->nickname = $plan->nickname;
                $formatted_plan->id = $plan->id;
                $formatted_plan->amount = $this->format_amount_to_dollars($plan->amount);
                $formatted_plan->description = explode(PHP_EOL, $plan->metadata->Description);
                $formatted_plan->is_trial = false;

                if( $plan->trial_period_days ) {
                    $this->formatted_plans[$product->id]->is_trial = true;
                    $this->formatted_plans[$product->id]->trial_days = $plan->trial_period_days;
                }

                if (strpos($formatted_plan->id, 'monthly')) {
                    $this->formatted_plans[$product->id]->monthly = (object) $formatted_plan;
                }

                if (strpos($formatted_plan->id, 'yearly')) {
                    $this->formatted_plans[$product->id]->yearly = (object) $formatted_plan;
                }
            }
        }

        $ordered = [];
        foreach($this->product_ids as $index => $product_id) {
            $ordered[$product_id] = $this->formatted_plans[$product_id];
        }

        $this->formatted_plans = $ordered;
    }

    /**
     * Set products on this class
     * @return void
     */
    private function set_products() : void
    {
        $this->products = $this->client->products->all([
            'active' => true,
            'limit' => 100,
            'ids' => $this->product_ids,
        ]);
    }

    /**
     * Get the plans associated with a particular product
     * @param string $product_id
     * @return \Stripe\Collection
     */
    private function get_product_plans(string $product_id) : \Stripe\Collection
    {
        $plans = $this->client->plans->all([
            'limit' => 2,
            'product' => $product_id,
        ]);
    
        return $plans;
    }

    /**
     * Get Stripe products
     * @return \Stripe\Collection
     */
    public function get_products() : \Stripe\Collection
    {
        return $this->products;
    }

    /**
     * Get our formatted plans
     * @return array
     */
    public function get_plans() : array
    {
        return $this->formatted_plans;
    }

    /**
     * Take the amount in pennies from Stripe and convert it to a readable dollar amount string
     * @return string
     */
    public function format_amount_to_dollars(int $amount) : string
    {
        return '$'.\number_format(($amount / 100), 2);
    }

    /**
     * Dump and die for debugging
     */
    public function dd($var) : void
    {
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
    }
}
