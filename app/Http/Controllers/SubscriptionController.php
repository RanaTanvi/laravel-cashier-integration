<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\PlanRepository;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Subscription;


class SubscriptionController extends Controller
{
    protected $planRepository;

    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;
    }
    public function showPlans()
    {
        $plans = $this->planRepository->getPlans();
        return view('subscribe', compact('plans'));
    }

    public function checkout($planId)
    {
        $user = auth()->user();
        return view('checkout', compact('planId'));
    }

    public function handelCheckout(Request $request)
    {
        try {                                
            $user = auth()->user();
            $plan = $this->planRepository->getPlanById($request->plan_id);           
            if($plan){
                if (is_null($user->stripe_id)) {
                    $stripeCustomer = $user->createAsStripeCustomer();
                }

                \Stripe\Customer::createSource(
                    $user->stripe_id,
                    ['source' => $request->input('card_token')]
                );
                
                $subscription = $user->newSubscription('default', $plan->stripe_plan_id)
                ->trialDays(30)      
                ->create();

                $data = ['message'=> 'You are successfully subscribed with '];                
                return \Response::json([
                    'data' => $data,
                    'subscription'  => $subscription
                ], '200');
            } else {
                return response()->json(['message'=> 'plan not found'], 404);
            }
        } catch (Exception $e) {
            // dd($e);
            return response()->json(['message'=> $e->getMessage()], 400);
        }
    }

    public function subscriptionDetailPage()
    {       
        $subscription = Auth::user()->subscription('default');
        $getEndDate = Carbon::parse($subscription->trial_ends_at);
        $date  = $getEndDate->format('Y-m-d');        
        $diffInDays =  Carbon::createFromDate($subscription->updated_at)->diffInDays($date);             
        return view('detail', [
            'subscription' => $subscription,
            'date'         => $date,
            'days'         => $diffInDays,
        ]);
    }

    public function extendSubscription()
    {
        try {             
            
            $user = auth()->user();                        
            $subscription = $user->subscription('default');                        
            if ($subscription->onTrial()) {
                $trialEndsAt = $subscription->trial_ends_at->addDays(30);
                $subscription->extendTrial($trialEndsAt);
            } else {                
                $nextBillingDate = Carbon::parse($subscription->asStripeSubscription()->current_period_end)->addDays(30);                  
                $subscription->extendTrial($nextBillingDate);                                
            }
            $subscription->save();
            return redirect()->intended('/view/detail')->with('success', 'successfully extended access!');               
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());  
            // Payment failed, handle the error
        }
    }

    public function cancelSubscription()
    {
        $user = auth()->user();
        $subscription = $user->subscription('default');
        $subscription->cancel();
        return redirect('home')->with('success', 'subscription canceled successfully');
    }
}