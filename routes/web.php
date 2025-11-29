<?php

use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return view('pages.home');
});

Route::get('/login', function () {
    return view('pages.user.login');
});

Route::get('/signup', function () {
    return view('pages.user.signup');
});
Route::get('/Service', function () {
    return view('pages.user.Service');
})->name('Service');
Route::get('/complaint_portal', function () {
    return view('pages.user.complaint_portal');
})->name('complaint_portal');