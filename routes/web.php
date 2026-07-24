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
use App\Http\Controllers\SuperAdmin\AuthController as SuperAdminAuthController;
use App\Http\Controllers\SuperAdmin\CategoryController as SuperAdminCategoryController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\EventController as SuperAdminEventController;
use App\Http\Controllers\SuperAdmin\ProfileController as SuperAdminProfileController;
use App\Http\Controllers\SuperAdmin\TenantController as SuperAdminTenantController;
use App\Http\Controllers\SuperAdmin\TransactionController as SuperAdminTransactionController;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;

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
Route::middleware('auth')->prefix('tickets')->name('tickets.')->group(function () {
    Route::get('history', [\App\Http\Controllers\TicketHistoryController::class, 'index'])->name('history');
    Route::get('history/{transaction}', [\App\Http\Controllers\TicketHistoryController::class, 'show'])->name('history.show');
});
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
    Route::get('register', [PartnerAuthController::class, 'showRegister'])->name('register');
    Route::post('register', [PartnerAuthController::class, 'register'])->name('register.post');
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

Route::prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('login', [SuperAdminAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [SuperAdminAuthController::class, 'login'])->name('login.post');

    Route::middleware(['superadmin'])->group(function () {
        Route::post('logout', [SuperAdminAuthController::class, 'logout'])->name('logout');
        Route::get('dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('users', [SuperAdminUserController::class, 'index'])->name('users.index');
        Route::get('users/{user}', [SuperAdminUserController::class, 'show'])->name('users.show');
        Route::post('users/{user}/suspend', [SuperAdminUserController::class, 'suspend'])->name('users.suspend');
        Route::post('users/{user}/activate', [SuperAdminUserController::class, 'activate'])->name('users.activate');
        Route::get('tenants', [SuperAdminTenantController::class, 'index'])->name('tenants.index');
        Route::get('tenants/{partner}', [SuperAdminTenantController::class, 'show'])->name('tenants.show');
        Route::post('tenants/{partner}/suspend', [SuperAdminTenantController::class, 'suspend'])->name('tenants.suspend');
        Route::post('tenants/{partner}/activate', [SuperAdminTenantController::class, 'activate'])->name('tenants.activate');
        Route::get('events', [SuperAdminEventController::class, 'index'])->name('events.index');
        Route::get('events/{event}', [SuperAdminEventController::class, 'show'])->name('events.show');
        Route::post('events/{event}/disable', [SuperAdminEventController::class, 'disable'])->name('events.disable');
        Route::delete('events/{event}', [SuperAdminEventController::class, 'destroy'])->name('events.destroy');
        Route::resource('categories', SuperAdminCategoryController::class)->except(['show']);
        Route::get('transactions', [SuperAdminTransactionController::class, 'index'])->name('transactions.index');
        Route::get('transactions/{transaction}', [SuperAdminTransactionController::class, 'show'])->name('transactions.show');
        Route::get('profile', [SuperAdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [SuperAdminProfileController::class, 'update'])->name('profile.update');
        Route::put('profile/password', [SuperAdminProfileController::class, 'password'])->name('profile.password');
    });
});
