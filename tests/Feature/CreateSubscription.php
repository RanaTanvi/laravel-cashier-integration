<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateSubscription extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create_userSubscription(): void
    {        
        $user = User::factory()->create();        
        $subscription = $user->newSubscription('default', 'price_1MlpwqLdWwDLvxaWzevqwsyp')
            ->trialDays(30)
            ->create();        
        $this->assertEquals('trialing', $subscription->stripe_status);
    }
    
}
