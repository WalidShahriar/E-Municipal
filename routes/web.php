<?php

use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return view('pages.home');
});

Route::get('/test', function () {
    return view('pages.test');
});

Route::get('/admin_panel', function () {
    return view('pages.admin.admin_panel');
})->name('admin_panel');