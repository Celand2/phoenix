<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [Admin\AuthController::class, 'login'])->name('login.store');
    Route::match(['get', 'post'], '/logout', [Admin\AuthController::class, 'logout'])->name('logout');

    Route::middleware('IsAdmin')->group(function () {
        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('/categories', Admin\CategoryController::class)->except(['show']);
        Route::resource('/trades', Admin\TradeController::class)->except(['show']);
        Route::get('/user-trades', [Admin\UserTradeController::class, 'index'])->name('user-trades.index');
        Route::patch('/user-trades/{userTrade}/expire', [Admin\UserTradeController::class, 'expire'])->name('user-trades.expire');
        Route::delete('/user-trades/{userTrade}', [Admin\UserTradeController::class, 'destroy'])->name('user-trades.destroy');

        Route::get('/deposits', [Admin\DepositController::class, 'index'])->name('deposits.index');
        Route::patch('/deposits/{deposit}/approve', [Admin\DepositController::class, 'approve'])->name('deposits.approve');
        Route::patch('/deposits/{deposit}/reject', [Admin\DepositController::class, 'reject'])->name('deposits.reject');
        Route::delete('/deposits/{deposit}', [Admin\DepositController::class, 'destroy'])->name('deposits.destroy');

        Route::get('/withdrawals', [Admin\WithdrawalController::class, 'index'])->name('withdrawals.index');
        Route::patch('/withdrawals/{withdrawal}/approve', [Admin\WithdrawalController::class, 'approve'])->name('withdrawals.approve');
        Route::patch('/withdrawals/{withdrawal}/reject', [Admin\WithdrawalController::class, 'reject'])->name('withdrawals.reject');
        Route::delete('/withdrawals/{withdrawal}', [Admin\WithdrawalController::class, 'destroy'])->name('withdrawals.destroy');

        Route::resource('/payment-methods', Admin\PaymentMethodController::class)->except(['show']);
        Route::resource('/bonus-codes', Admin\BonusCodeController::class)->only(['index', 'create', 'store', 'destroy']);

        Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [Admin\UserController::class, 'show'])->name('users.show');
        Route::patch('/users/{user}/balance', [Admin\UserController::class, 'updateBalance'])->name('users.balance');
        Route::patch('/users/{user}/status', [Admin\UserController::class, 'updateStatus'])->name('users.status');
        Route::patch('/users/{user}/password', [Admin\UserController::class, 'updatePassword'])->name('users.password');
        Route::delete('/users/{user}', [Admin\UserController::class, 'destroy'])->name('users.destroy');

        Route::get('/referrals', [Admin\ReferralController::class, 'index'])->name('referrals.index');
        Route::delete('/referrals/{referral}', [Admin\ReferralController::class, 'destroy'])->name('referrals.destroy');

        Route::resource('/messages', Admin\MessageController::class)->only(['index', 'store', 'show', 'destroy']);
        Route::resource('/exchange-rates', Admin\ExchangeRateController::class)->only(['index', 'store', 'update', 'destroy']);

        Route::get('/notifications', [Admin\NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/send', [Admin\NotificationController::class, 'send'])->name('notifications.send');
        Route::delete('/notifications/{notification}', [Admin\NotificationController::class, 'destroy'])->name('notifications.destroy');
    });
});

Route::get('/logout', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
});

Route::prefix('client')->name('client.')->middleware('IsClient')->group(function () {
    Route::get('/dashboard', [Client\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/categories', [Client\CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{category}', [Client\CategoryController::class, 'show'])->name('categories.show');
    Route::get('/trades', [Client\TradeController::class, 'index'])->name('trades.index');
    Route::post('/trades/{trade}/buy', [Client\TradeController::class, 'buy'])->name('trades.buy');
    Route::get('/my-trades', [Client\UserTradeController::class, 'index'])->name('my-trades.index');
    Route::post('/my-trades/{userTrade}/claim', [Client\UserTradeController::class, 'claim'])->name('my-trades.claim');
    Route::get('/deposits', [Client\DepositController::class, 'index'])->name('deposits.index');
    Route::post('/deposits', [Client\DepositController::class, 'store'])->name('deposits.store');
    Route::get('/withdrawals', [Client\WithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::post('/withdrawals', [Client\WithdrawalController::class, 'store'])->name('withdrawals.store');
    Route::get('/referrals', [Client\ReferralController::class, 'index'])->name('referrals.index');
    Route::get('/messages', [Client\MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages', [Client\MessageController::class, 'store'])->name('messages.store');
    Route::get('/notifications', [Client\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [Client\NotificationController::class, 'markRead'])->name('notifications.read');
    Route::get('/profile', [Client\ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [Client\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/bonus-codes/redeem', [Client\BonusCodeController::class, 'redeem'])->name('bonus-codes.redeem');
});
