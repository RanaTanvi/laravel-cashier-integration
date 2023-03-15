<?php

namespace App\Services;

use App\Repositories\PlanRepository;

class SubscriptionService 
{
    protected $planRepository;

    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository= $planRepository;
    }
    public function createSubscription($data) 
    {
        $user = auth()->user();

        $plan = $this->planRepository->getPlanById($data['plan_id']);           
        if($plan){
            if (is_null($user->stripe_id)) {
                $stripeCustomer = $user->createAsStripeCustomer();
            }

            \Stripe\Customer::createSource(
                $user->stripe_id,
                ['source' => $data['card_token']]
            );
            
            $subscription = $user->newSubscription('default', $plan->stripe_plan_id)
            ->trialDays(30)      
            ->create();

            return $subscription;
        } else {
            return false;
        }
    }


}

