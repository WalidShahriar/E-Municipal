<?php

use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return view('pages.home');
});

Route::get('/test', function () {
    return view('pages.test');
});
Route::get('/Service', function () {
    return view('pages.user.Service');
})->name('Service');