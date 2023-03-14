<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(BookController::class)->prefix('book')->group(function () {
    Route::get('list/{id}','list')->name('list');
    Route::post('create', 'create')->name('create');
    Route::get('show','show')->name('show');
    Route::post('update','update')->name('update');
    Route::get('delete/{id}','delete')->name('delete');
});

Route::controller(AuthorController::class)->prefix('author')->group(function(){
    Route::get('list/{id}','list')->name('list');
    Route::post('create', 'create')->name('create');
    Route::get('show','show')->name('show');
    Route::post('update','update')->name('update');
    Route::get('delete/{id}','delete')->name('delete');
});

Route::controller(CustomerController::class)->prefix('customer')->group(function(){
    Route::get('list/{id}','list')->name('list');
    Route::post('create', 'create')->name('create');
    Route::get('show','show')->name('show');
    Route::post('update','update')->name('update');
    Route::get('delete/{id}','delete')->name('delete');
});

Route::controller(ReviewController::class)->prefix('review')->group(function(){
    Route::post('create', 'create')->name('create');
    Route::get('show','show')->name('show');
    Route::post('update','update')->name('update');
    Route::get('delete/{id}','delete')->name('delete');
});
