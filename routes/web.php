<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    JobController,
    HomeController,
    LoginController,
    RegisterController,
    DashboardController,
    ProfileController,
    BookmarkController,
    ApplicantController,
    GeocodeController
};

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs/search', [JobController::class, 'search'])->name('jobs.search');
Route::resource('jobs', JobController::class)->except(['create', 'edit', 'update', 'destroy']);

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('jobs', JobController::class)->only(['create', 'edit', 'update', 'destroy']);

    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks/{job}', [BookmarkController::class, 'store'])->name('bookmarks.store');
    Route::delete('/bookmarks/{job}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');

    Route::post('/jobs/{job}/apply', [ApplicantController::class, 'store'])->name('applicant.store');
    Route::delete('/applicants/{applicant}', [ApplicantController::class, 'destroy'])->name('applicant.destroy');

    Route::get('/geocode', [GeocodeController::class, 'geocode']);
});

