<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryEloquent;
use App\Repositories\PlanRepository;
use App\Repositories\PlanRepositoryEloquent;
use App\Models\User;
use App\Models\Plan;
use stripe\Stripe;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepository::class, function ($app) {
            return new UserRepositoryEloquent(new User());
        });
        $this->app->bind(PlanRepository::class, function ($app) {
            return new PlanRepositoryEloquent(new Plan());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }
}
