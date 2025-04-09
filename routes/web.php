<?php

use App\Models\User;
use Livewire\Volt\Volt;
use App\Livewire\TenantLanding;
use App\Livewire\TenantDashboard;
use Illuminate\Support\Facades\Route;

Route::domain(config('app.main_domain'))->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', TenantDashboard::class)
            ->middleware(['verified'])
            ->name('dashboard');
        Route::redirect('settings', 'settings/profile');

        Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
        Volt::route('settings/password', 'settings.password')->name('settings.password');
        Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    });

    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    require __DIR__ . '/auth.php';
});

Route::domain('{tenant}' . '.' . config('app.main_domain'))->middleware(['tenant'])->group(function () {
    Route::get('/', TenantLanding::class);
});