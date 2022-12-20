<?php

use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ListingController::class, "index"])->name('listings');
Route::get('/listings/create', [ListingController::class, 'create'])->name('create')->middleware('auth');
Route::post('/listings/create', [ListingController::class, 'store'])->name('store')->middleware('auth');
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->name('edit')->middleware('auth');

Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->name('destroy')->middleware('auth');
Route::get('/listings/{listing}', [ListingController::class, "show"])->name('listing');
Route::put('/listings/{listing}', [ListingController::class, 'update'])->name('update')->middleware('auth');

Route::get('/register', [UserController::class, "create"])->name('register')->middleware('guest');
Route::post('/register', [UserController::class, "store"]);
Route::post('/logout', [UserController::class, "logout"])->name('logout')->middleware('auth');

Route::get('/login', [UserController::class, "login"])->name('login')->middleware('guest');
Route::post('/login', [UserController::class, "authenticate"]);

Route::get('/dashboard', [UserController::class, "dashboard"])->name('dashboard')->middleware('auth');


// Route::get('/{id}', function($id) {
//     return $id;
// })->where('id', '[0-9]+');
