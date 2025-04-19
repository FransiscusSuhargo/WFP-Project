<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\HomeController;
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
    Route::prefix('report')->group(function(){
        Route::get('/category', [AdminController::class, 'showReportCategory'])->name('report.category');
        Route::get('/recap', [AdminController::class, 'showReportRecap'])->name('report.recap.form');
        Route::post('/recap', [AdminController::class, 'showReportRecap'])->name('report.recap');
        Route::get('/customer', [AdminController::class, 'showReportCustomer'])->name('report.customer');
        Route::get('/food', [AdminController::class, 'showReportFood'])->name('report.food');
        Route::get('/date', [AdminController::class, 'showReportDate'])->name('report.date');
    });
});

// Route::middleware('role:customer')->prefix('customer')->group(function(){
//     Route::get('/dashboard', [HomeController::class, 'index'])->name('index');
//     Route::prefix('profile')->group(function(){
//         Route::get('/', [HomeController::class, 'showProfile'])->name('profile.index');
//         Route::post('/edit', [HomeController::class, 'updateProfile'])->name('profile.update');
//     });
//     Route::prefix('order')->group(function(){
//         Route::get('/', [HomeController::class, 'showOrder'])->name('order.index');
//         Route::post('/insert', [HomeController::class, 'insertOrder'])->name('order.insert');
//         Route::post('/edit', [HomeController::class, 'updateOrder'])->name('order.update');
        
//         Route::post('/detail', [HomeController::class, 'showOrderDetail'])->name('order.detail');
//         Route::post('/insertDetail', [HomeController::class, 'insertOrderDetail'])->name('order.detail.insert');
//         Route::post('/updateDetail', [HomeController::class, 'updateOrderDetail'])->name('order.detail.update');
//         Route::post('/deleteDetail', [HomeController::class, 'deleteOrderDetail'])->name('order.detail.delete');
//     });
// });
