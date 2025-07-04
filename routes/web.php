<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeeController;
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

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::post('/submit', [HomeController::class, "checkout"])->name('checkout')->middleware('auth');

Route::middleware('role:admin')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('index');
    Route::prefix('food')->group(function () {
        Route::get('/', [AdminController::class, 'showFood'])->name('food.index');
        Route::get('/add', [AdminController::class, 'addFood'])->name('food.add');
        Route::post('/insert', [AdminController::class, 'insertFood'])->name('food.insert');
        Route::get('/{id}', [AdminController::class, 'editFood'])->name('food.edit');
        Route::post('/update', [AdminController::class, 'updateFood'])->name('food.update');
        Route::delete('/delete/{id}', [AdminController::class, 'deleteFood'])->name('food.delete');
    });

    Route::prefix('category')->group(function () {
        Route::get('/', [AdminController::class, 'showCategory'])->name('category.index');
        Route::get('/add', [AdminController::class, 'addCategory'])->name('category.add');
        Route::post('/insert', [AdminController::class, 'insertCategory'])->name('category.insert');
        Route::get('/{id}', [AdminController::class, 'editCategory'])->name('category.edit');
        Route::post('/update', [AdminController::class, 'updateCategory'])->name('category.update');
        Route::delete('/delete/{id}', [AdminController::class, 'deleteCategory'])->name('category.delete');
    });

    Route::prefix('customer')->group(function () {
        Route::get('/', [AdminController::class, 'showCustomer'])->name('customer.index');
        Route::get('/add', [AdminController::class, 'addCustomer'])->name('customer.add');
        Route::post('/insert', [AdminController::class, 'insertCustomer'])->name('customer.insert');
        Route::get('/{id}', [AdminController::class, 'editCustomer'])->name('customer.edit');
        Route::post('/update', [AdminController::class, 'updateCustomer'])->name('customer.update');
        Route::delete('/delete/{id}', [AdminController::class, 'deleteCustomer'])->name('customer.delete');
    });

    Route::prefix('order')->group(function () {
        Route::get('/', [AdminController::class, 'showOrder'])->name('order.index');
        Route::get('/add', [AdminController::class, 'addOrder'])->name('order.add');
        Route::post('/insert', [AdminController::class, 'insertOrder'])->name('order.insert');
        Route::get('/{id}', [AdminController::class, 'editOrder'])->name('order.edit');
        Route::post('/update', [AdminController::class, 'updateOrder'])->name('order.update');
        Route::delete('/delete/{id}', [AdminController::class, 'deleteOrder'])->name('order.delete');
    });
    Route::prefix('report')->group(function () {
        Route::get('/category', [AdminController::class, 'showReportCategory'])->name('report.category');
        Route::get('/recap', [AdminController::class, 'showReportRecap'])->name('report.recap.form');
        Route::post('/recap', [AdminController::class, 'showReportRecap'])->name('report.recap');
        Route::get('/customer', [AdminController::class, 'showReportCustomer'])->name('report.customer');
        Route::get('/food', [AdminController::class, 'showReportFood'])->name('report.food');
        Route::get('/date', [AdminController::class, 'showReportDate'])->name('report.date');
    });
});

Route::middleware('role:customer')->prefix('customer')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('index');
    Route::prefix('profile')->group(function () {
        Route::get('/', [HomeController::class, 'showProfile'])->name('profile.index');
        Route::get('/edit/profile', [HomeController::class, 'editProfile'])->name('profile.edit');
        Route::post('/update/profile', [HomeController::class, 'updateProfile'])->name('profile.update');
    });
    Route::prefix('order')->group(function () {
        Route::get('/', [HomeController::class, 'showOrder'])->name('customer.order.index');
//        Route::post('/insert', [HomeController::class, 'insertOrder'])->name('order.insert');
//        Route::post('/edit', [HomeController::class, 'updateOrder'])->name('order.update');

//        Route::post('/detail', [HomeController::class, 'showOrderDetail'])->name('order.detail');
//        Route::post('/insertDetail', [HomeController::class, 'insertOrderDetail'])->name('order.detail.insert');
//        Route::post('/updateDetail', [HomeController::class, 'updateOrderDetail'])->name('order.detail.update');
//        Route::post('/deleteDetail', [HomeController::class, 'deleteOrderDetail'])->name('order.detail.delete');

        Route::get('/cart', [HomeController::class, "cart"])->name('cart');
        Route::get('/detail/{id}', [HomeController::class, "detailMenu"])->name('detailmenu');
        Route::put('/goto-cart/{food}', [HomeController::class, "putCart"])->name('putCart');
        Route::delete('/goto-cart/{food}', [HomeController::class, "deleteCart"])->name('deleteCart');

        Route::post('/show/customize/{id}',[HomeController::class, "showCustomizeOrder"])->name('show.customize.order');
        Route::post('/customize/{id}',[HomeController::class, "customizeOrder"])->name('customize.order');

        // Payment
        Route::get('orders', [PaymentController::class, 'listOrders'])
            ->name('customer.order.index');
        Route::post('/checkout', [PaymentController::class, 'checkout'])
            ->name('customer.order.checkout');
        Route::post('/checkout/success', [PaymentController::class, 'onSuccessCheckout'])
            ->name('customer.order.checkout.success');
        Route::post('/checkout/failed', [PaymentController::class, 'onFailedCheckout'])
            ->name('customer.order.checkout.failed');

    });
});

Route::middleware('role:employee')->prefix('employee')->group(function () {
    // Dashboard
    Route::get('/', [EmployeeController::class, 'index'])
        ->name('employee.index');
//    Route::post('/refresh-order', [EmployeeController::class, 'refreshOrder'])
//        ->name('employee.refresh');
    Route::get('/set-ready', [EmployeeController::class, 'index']);
    Route::post('/set-ready', [EmployeeController::class, 'setReady'])
        ->name('employee.set-ready');

    Route::get('/set-finish', [EmployeeController::class, 'readyOrder'])
        ->name('employee.finish');
    Route::post('/set-finish', [EmployeeController::class, 'setFinish'])
        ->name('employee.set-finish');

    // Detail
    Route::get('/order/{order_id}', [EmployeeController::class, 'detailOrder'])
        ->name('employee.order');


    // Tracking
    Route::get('/tracking', [EmployeeController::class, 'tracking'])
        ->name('employee.tracking');
    Route::post('/refresh-tracking', [EmployeeController::class, 'refreshOrderTracking'])
        ->name('employee.tracking.refresh');

    Route::post('/test-tracking', [EmployeeController::class, 'testPusher'])
        ->name('employee.tracking.test');

});
