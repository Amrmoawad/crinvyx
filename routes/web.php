<?php

use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function (): void {
        Route::get('/', function () {
            return redirect()->route('dashboard');
        });

        Route::middleware(['auth'])->group(function (): void {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('/analysis', [AnalysisController::class, 'index'])->name('analysis');

            Route::middleware('manage-users')->group(function (): void {
                Route::resource('users', UserController::class);
            });

            Route::middleware('manage-events')->group(function (): void {
                Route::resource('events', EventController::class);
            });

            Route::middleware('record-attendees')->group(function (): void {
                Route::resource('attendees', AttendeeController::class);
            });
        });

        require __DIR__.'/auth.php';
    }
);
