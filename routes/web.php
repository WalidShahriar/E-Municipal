<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ChatbotController;




Route::post('/api/requests', [ServiceRequestController::class, 'store']);
Route::get('/api/requests/{id}', [ServiceRequestController::class, 'show']);


// Public routes - accessible to everyone
Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', function () {
    return view('pages.home');
})->name('home');

Route::post('/chatbot/ask', [ChatbotController::class, 'chat']);

// 2. AJAX UPDATE ROUTE: Handles status updates (POST request).
Route::post('/admin/update-status', [AdminDashboardController::class, 'updateStatus'])->name('admin.update.status');

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

Route::get('/admin_panel', function () {
    return view('pages.admin.admin_panel');
})->name('admin_panel');

Route::post('/api/complaints/submit', [ComplaintController::class, 'store']);
Route::get('/api/complaints/status/{id}', [ComplaintController::class, 'show']);
// Admin routes - require admin role
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin_panel', function () {
        return view('pages.admin.admin_panel');
    })->name('admin_panel');

    // 1. DASHBOARD ROUTE: Calls the Controller method to fetch data.
    Route::get('/dashboard_admin', [AdminDashboardController::class, 'index'])->name('dashboard_admin');


});

use App\Http\Controllers\AdminController;

Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
