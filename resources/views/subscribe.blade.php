@extends('layouts.app')

@section('content')

<!-- <div class="hero">
    <div class="hero-content">
        <h1>You're Joining!</h1>
        <h2>Hooray!</h2>
    </div>
</div> -->

<section class="container">
    <div class="card card-padded" style="padding: 20px;">
        <div class="row">
            @foreach($plans as $plan)
            <div class="col-md-4">
                <div class="card" style="text-align: center;font-size: 25px;">
                    <div class="card-heading" style="text-transform: capitalize;">
                        {{$plan->name}}
                    </div>
                    <div class="card-body">
                        <p>${{$plan->amount}} / Month</p>
                        <a href="/checkout/{{$plan->id}}" class="btn btn-success">Checkout</a>
                    </div>
                </div>
            </div> 
            @endforeach
        </div>
    </div>
</section>

@endsection