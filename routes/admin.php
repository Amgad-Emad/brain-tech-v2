<?php

use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LocaleController;
use App\Http\Controllers\Admin\PreviewController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\VisibilityController;
use App\Http\Middleware\SetCmsLocale;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', SetCmsLocale::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics');

        Route::get('brand', [BrandController::class, 'edit'])->name('brand.edit');
        Route::put('brand', [BrandController::class, 'update'])->name('brand.update');
        Route::post('brand/reset', [BrandController::class, 'reset'])->name('brand.reset');

        Route::get('locale/{locale}', [LocaleController::class, 'switch'])->name('locale');
        Route::post('visibility/{section}', [VisibilityController::class, 'toggle'])->name('visibility.toggle');
        Route::get('export', [BackupController::class, 'export'])->name('export');
        Route::post('import', [BackupController::class, 'import'])->name('import');

        Route::get('messages', [ContactMessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [ContactMessageController::class, 'show'])->name('messages.show');
        Route::delete('messages/{message}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');

        Route::get('subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
        Route::get('subscribers/export', [SubscriberController::class, 'export'])->name('subscribers.export');
        Route::delete('subscribers/{subscriber}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');

        Route::get('section/{section}', [SectionController::class, 'edit'])->name('section.edit');
        Route::put('section/{section}', [SectionController::class, 'update'])->name('section.update');
        Route::post('section/{section}/preview', [PreviewController::class, 'render'])->name('section.preview');
    });
