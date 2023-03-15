@extends('layouts.app')

@section('content')
<section class="container">
    <div class="card card-padded" style="padding: 20px;">        
        <p>You are successfully subscribed with {{$subscription->name}}. 
        @if($subscription->stripe_status == 'active')
            Your next billing date is {{\Carbon\Carbon::parse($subscription->asStripeSubscription()->current_period_end)->format('Y-m-d')}}         
        @else
            Your trial ends at {{$date}} 
        @endif
            , {{$days}} days are remaining
        </p>
        
        <a href="/extend/subscription" class="btn btn-success w-25" id="card-button" type="submit">Extend Subscription</a>           
    </div>
</section>
@endsection