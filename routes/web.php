<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubscriptionController;
use Laravel\Cashier\Subscription;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();
Route::get('/', function(){
    return view('welcome');
});
Route::group(['middleware' =>  ['auth']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/subscribe', [SubscriptionController::class, 'showPlans'])->name('subscribe');
    Route::get('/checkout/{id}', [SubscriptionController::class, 'checkout'])->name('checkout');            
    Route::post('/checkout/process', [SubscriptionController::class, 'handelCheckout'])->name('checkout.process');
    Route::get('/view/detail', [SubscriptionController::class, 'subscriptionDetailPage'])->name('view.detail');
    Route::get('/extend/subscription', [SubscriptionController::class, 'extendSubscription'])->name('extend.subscription');
    Route::get('/cancel/subscription', [SubscriptionController::class, 'cancelSubscription'])->name('cancel.subscription');
});
