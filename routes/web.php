<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\PageController;
use App\Http\Controllers\Site\SubscriptionController;
use App\Http\Controllers\Site\TrackController;
use App\Http\Controllers\Site\WorkController;
use App\Http\Middleware\TrackVisitor;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Analytics beacon (sendBeacon, CSRF-exempt).
Route::post('track', [TrackController::class, 'store'])->name('track');

/*
|--------------------------------------------------------------------------
| Public site (localized: "/" = English, "/ar" = Arabic)
|--------------------------------------------------------------------------
*/
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', TrackVisitor::class],
], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('about', [PageController::class, 'about'])->name('about');
    Route::get('services', [PageController::class, 'services'])->name('services');
    Route::get('work', [WorkController::class, 'index'])->name('work.index');
    Route::get('work/{project}', [WorkController::class, 'show'])->name('work.show');
    Route::get('contact', [ContactController::class, 'show'])->name('contact');
    Route::post('contact', [ContactController::class, 'store'])->name('contact.store');
    Route::post('subscribe', [SubscriptionController::class, 'store'])->name('subscribe');
});

/*
|--------------------------------------------------------------------------
| Authenticated account (Breeze)
|--------------------------------------------------------------------------
*/
Route::redirect('/dashboard', '/admin')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
