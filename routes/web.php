<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceRequestController; // <-- ADD THIS LINE


// --- NEW API ROUTES FOR SERVICE REQUESTS ---
Route::post('/api/requests', [ServiceRequestController::class, 'store']);
Route::get('/api/requests/{id}', [ServiceRequestController::class, 'show']);
// ------------------------------------------


Route::get('/home', function () {
    return view('pages.home');
});

Route::get('/test', function () {
    return view('pages.test');
});
Route::get('/Service', function () {
    return view('pages.user.Service');
})->name('Service');