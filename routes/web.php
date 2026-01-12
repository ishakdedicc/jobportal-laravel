<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\GeocodeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

Route::get('/jobs/search', [JobController::class, 'search'])->name('jobs.search');

Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');

Route::middleware('auth')->group(function () {
    Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
});

Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

Route::middleware('auth')->group(function () {
    Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])
        ->middleware('can:update,job')
        ->name('jobs.edit');

    Route::put('/jobs/{job}', [JobController::class, 'update'])
        ->middleware('can:update,job')
        ->name('jobs.update');

    Route::delete('/jobs/{job}', [JobController::class, 'destroy'])
        ->middleware('can:delete,job')
        ->name('jobs.destroy');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks/{job}', [BookmarkController::class, 'store'])->name('bookmarks.store');
    Route::delete('/bookmarks/{job}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');
});

Route::get('/geocode', [GeocodeController::class, 'geocode']);
