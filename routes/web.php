<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
=======
use App\Http\Controllers\ServiceRequestController; 

>>>>>>> af703c74cca72f18624ac9391d8ca394844907c5

// --- NEW API ROUTES FOR SERVICE REQUESTS ---
Route::post('/api/requests', [ServiceRequestController::class, 'store']);
Route::get('/api/requests/{id}', [ServiceRequestController::class, 'show']);
// ------------------------------------------

// Public routes - accessible to everyone
Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', function () {
    return view('pages.home');
})->name('home');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes - require authentication
Route::middleware(['auth'])->group(function () {
    // User routes - accessible to all authenticated users
    Route::get('/Service', function () {
        return view('pages.user.Service');
    })->name('Service');

    Route::get('/complaint_portal', function () {
        return view('pages.user.complaint_portal');
    })->name('complaint_portal');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin routes - require admin role
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin_panel', function () {
        return view('pages.admin.admin_panel');
    })->name('admin_panel');
});
