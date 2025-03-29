<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FoodController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->group(function(){
    Route::get('/dashboard', [AdminController::class, 'index']);
    Route::prefix('food')->group(function(){
        Route::get('/', [AdminController::class, 'showFood'])->name('food.index');
        Route::get('/add', [AdminController::class, 'addFood'])->name('food.add');
        Route::post('/insert', [AdminController::class, 'insertFood'])->name('food.insert');
        Route::get('/{id}', [AdminController::class, 'editFood'])->name('food.edit');
        Route::post('/update', [AdminController::class, 'updateFood'])->name('food.update');
        Route::delete('/delete/{id}', [AdminController::class, 'deleteFood'])->name('food.delete');
    });
});