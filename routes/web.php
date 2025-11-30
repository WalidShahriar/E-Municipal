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

Route::get('/admin_panel', function () {
    return view('pages.admin.admin_panel');
})->name('admin_panel');
