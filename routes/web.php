<?php

use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Front\Auth\TwoFactorAuthenticationController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CategoryController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\CurrencyConverterController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Front\PaymentsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\SocialController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    // 'prefix' => "{locale}",
    'prefix' => LaravelLocalization::setLocale(),
], function () {
    // Get Home Page
    Route::get('/', [HomeController::class, 'index'])->name('home');
    //Show Category with its products
    Route::get('/category/{category}', [CategoryController::class, 'show'])
    ->name('front.category.show');
    // Products
    Route::get('/products/index', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
    //  Cart
    Route::resource('/cart', CartController::class);
    // checkout
    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    // 2 Factor Authentication
    Route::get('auth/user/2fa', [TwoFactorAuthenticationController::class, 'index'])
        ->name('front.2fa');
    // Currency Api 3rd party Api
    Route::post('currency', [CurrencyConverterController::class, 'store'])
        ->name('currency.store');
});
// Get Data For User How Sign From SocialProvider Using provider_token
Route::get('auth/{provider}/index',[SocialController::class,'index']);

// redirect to login page from social provider
Route::get('auth/{provider}/redirect',[SocialLoginController::class,'redirect'])
->name('auth.socilaite.redirect');

Route::get('auth/{provider}/callback',[SocialLoginController::class,'callback'])
->name('auth.socilaite.callback');

Route::get('orders/{order}/pay',[PaymentsController::class,'create'])
->name('orders.payments.create');

Route::post('orders/{order}/stripe/paymeny-intent',[PaymentsController::class,'createStripePaymentIntent'])
->name('stripe.paymentIntent.create');

Route::get('orders/{order}/stripe/pay/callback',[PaymentsController::class,'confirm'])
->name('stripe.return');

Route::get('orders/{order}',[OrderController::class,'show'])
->name('order.return');

require __DIR__ . '/dashboard.php';
