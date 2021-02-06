<?php

use Illuminate\Support\Facades\Route;

// Redirect to dashboard
Route::get('/', function(){
    return redirect(route('admin.home'));
});
// Reset Password
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('admin.password.update');

Route::middleware(['admin.auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', 'HomeController@index')->name('admin.home');
    // Logout
    Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout');
});

Route::middleware(['admin.guest'])->group(function () {
    // Login
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Auth\LoginController@login');
});
