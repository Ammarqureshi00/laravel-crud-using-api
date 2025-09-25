<?php

use App\Http\Controllers\API\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('login');   // your Blade form
});
Route::get('/dashboard', function () {
    return view('dashboard');   // your Blade formRoute::resource('posts', PostController::class);
});
Route::resource('allposts', PostController::class);
