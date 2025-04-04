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

Route::middleware('role:admin,employee')->prefix('admin')->group(function() {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('index');
    Route::prefix('food')->group(function(){
        Route::get('/', [AdminController::class, 'showFood'])->name('food.index');
        Route::get('/add', [AdminController::class, 'addFood'])->name('food.add');
        Route::post('/insert', [AdminController::class, 'insertFood'])->name('food.insert');
        Route::get('/{id}', [AdminController::class, 'editFood'])->name('food.edit');
        Route::post('/update', [AdminController::class, 'updateFood'])->name('food.update');
        Route::delete('/delete/{id}', [AdminController::class, 'deleteFood'])->name('food.delete');
    });

    Route::prefix('category')->group(function(){
        Route::get('/', [AdminController::class, 'showCategory'])->name('category.index');
        Route::get('/add', [AdminController::class, 'addCategory'])->name('category.add');
        Route::post('/insert', [AdminController::class, 'insertCategory'])->name('category.insert');
        Route::get('/{id}', [AdminController::class, 'editCategory'])->name('category.edit');
        Route::post('/update', [AdminController::class, 'updateCategory'])->name('category.update');
        Route::delete('/delete/{id}', [AdminController::class, 'deleteCategory'])->name('category.delete');

    });

    Route::prefix('customer')->group(function(){
        Route::get('/', [AdminController::class, 'showCustomer'])->name('customer.index');
        Route::get('/add', [AdminController::class, 'addCustomer'])->name('customer.add');
        Route::post('/insert', [AdminController::class, 'insertCustomer'])->name('customer.insert');
        Route::get('/{id}', [AdminController::class, 'editCustomer'])->name('customer.edit');
        Route::post('/update', [AdminController::class, 'updateCustomer'])->name('customer.update');
        Route::delete('/delete/{id}', [AdminController::class, 'deleteCustomer'])->name('customer.delete');
    });

    Route::prefix('order')->group(function(){
        Route::get('/', [AdminController::class, 'showOrder'])->name('order.index');
        Route::get('/add', [AdminController::class, 'addOrder'])->name('order.add');
        Route::post('/insert', [AdminController::class, 'insertOrder'])->name('order.insert');
        Route::get('/{id}', [AdminController::class, 'editOrder'])->name('order.edit');
        Route::post('/update', [AdminController::class, 'updateOrder'])->name('order.update');
        Route::delete('/delete/{id}', [AdminController::class, 'deleteOrder'])->name('order.delete');
    });
});
