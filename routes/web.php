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

Route::get('/service', function () {
    return view('pages.user.Service');
})->name('Service');