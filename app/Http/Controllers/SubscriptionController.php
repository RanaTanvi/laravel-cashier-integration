<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\PlanRepository;
use App\Services\SubscriptionService;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Subscription;


class SubscriptionController extends Controller
{
    protected $planRepository;
    protected $subscriptionService;

    public function __construct(PlanRepository $planRepository, SubscriptionService $subscriptionService)
    {
        $this->planRepository = $planRepository;
        $this->subscriptionService = $subscriptionService;
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
            $subscription = $this->subscriptionService->createSubscription($request->all());
            if($subscription) {
                $data = ['message'=> 'You are successfully subscribed with '];                
                return \Response::json([
                    'data' => $data,
                    'subscription'  => $subscription
                ], '200');
            }else {
                return response()->json(['message'=> 'plan not found'], 404);
            }
        } catch (Exception $e) {
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
            return redirect()->back()->with('error', $e->getMessage());  
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