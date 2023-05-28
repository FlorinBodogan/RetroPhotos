<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/home', [HomeController::class, 'home'])->name('home');

Route::get('/gallery', function () {
    return view('gallery');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/upload', function () {
    return view('upload');
});

Route::view('/upload', 'upload')->name('upload')->middleware('auth');

Route::get('/register', [AuthController::class, 'register'])->name('register')->middleware('notauth');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register');

Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('notauth');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [ImageController::class, 'createForUser'])->name('image')->middleware('auth');
Route::get('/gallery', [ImageController::class, 'create'])->name('image');
Route::post('/image', [ImageController::class, 'store'])->name('image');
Route::delete('/image/{id}', [ImageController::class, 'delete_img'])->name('delete.image');

Route::get('/image/{id}/edit', [ImageController::class, 'edit_img'])->name('image.edit')->middleware('auth');
Route::put('/image/{id}', [ImageController::class, 'update_img'])->name('update.image')->middleware('auth');
Route::get('/search', [ImageController::class, 'search'])->name('image.search')->middleware('auth');










