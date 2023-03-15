<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Stripe\PaymentMethod;
use Tests\TestCase;

class ExtendSubscription extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_extend_subscription(): void
    {                
        $user = User::factory()->create();  
        $subscription = $user->newSubscription('default', 'price_1MlpwqLdWwDLvxaWzevqwsyp')
                        ->trialDays(30)
                        ->create(); 

         $trialEndsAt = $subscription->trial_ends_at->addDays(30);

         $subscription->extendTrial($trialEndsAt);
         $this->assertEquals(Carbon::parse($subscription->trial_ends_at)->format('Y-m-d'), Carbon::now()->addDays(60)->format('Y-m-d') );

    }

}
