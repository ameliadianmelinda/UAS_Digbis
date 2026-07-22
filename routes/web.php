<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Partner\AuthController as PartnerAuthController;
use App\Http\Controllers\Partner\DashboardController as PartnerDashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\Auth\BuyerAuthController;

// Rute User Area
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events/{event}', [\App\Http\Controllers\EventController::class, 'show'])->name('events.show');
Route::get('/checkout/{event}', [App\Http\Controllers\CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
Route::get('transactions', [\App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('transactions.index');
Route::get('/payment/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');
Route::get('/success/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransWebhookController::class, 'handle']);
Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
Route::post('/logout', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('home');
})->name('logout');

Route::prefix('auth/google')->name('auth.google.')->group(function () {
    Route::get('redirect', [GoogleAuthController::class, 'redirect'])->name('redirect');
    Route::get('checkout/{event}', [GoogleAuthController::class, 'redirectForCheckout'])->name('checkout');
    Route::get('callback', [GoogleAuthController::class, 'callback'])->name('callback');
});

Route::get('/login', [BuyerAuthController::class, 'showPortal'])->name('login');
Route::get('/register', [BuyerAuthController::class, 'showRegister'])->name('register');
Route::post('/login', [BuyerAuthController::class, 'login'])->name('login.post');
Route::post('/register', [BuyerAuthController::class, 'register'])->name('register.post');

Route::prefix('partner')->name('partner.')->group(function () {
    Route::get('login', [PartnerAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [PartnerAuthController::class, 'login'])->name('login.post');
    Route::post('logout', [PartnerAuthController::class, 'logout'])->name('logout');

    Route::middleware(['partner'])->group(function () {
        Route::get('dashboard', [PartnerDashboardController::class, 'index'])->name('dashboard');
    });
});

Route::prefix('admin')->name('admin.')->group(function () {
    // Login (public)
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Protected admin area
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Admin events: use Admin\EventController resource (index,create,store,show,edit,update,destroy)
        Route::resource('events', AdminEventController::class);

        // Transactions list (use existing DashboardController implementation)
        Route::get('transactions', [DashboardController::class, 'indexTransaction'])->name('transactions.index');

        // Partners & Categories (moved inside admin middleware to avoid collision)
        Route::resource('partners', PartnerController::class)->except(['show']);
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
    });
});
