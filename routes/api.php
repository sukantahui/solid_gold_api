<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PriceCodeController;
use App\Http\Controllers\CustomerCategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GoldTransactionController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\TransactionTypeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::get('test', 'test');
});




// token is required
Route::group(['middleware' => 'auth:sanctum'], function(){
    //under Auth Controller
    Route::controller(AuthController::class)->group(function(){
        Route::get('me', 'getCurrentUser');
        Route::post('logout', 'logout');
        Route::get('revokeAll', 'revoke_all');

    });

    Route::controller(CustomerCategoryController::class)->group(function(){
        Route::post('customer-categories', 'store');
        Route::get('customer-categories', 'index');
        Route::put('customer-categories/{id}', 'update');
        Route::delete('customer-categories/{id}', 'destroy');
    });
    //under CustomerController
    Route::controller(CustomerController::class)->group(function(){
        Route::post('customers', 'store');
        Route::get('customers', 'index');
        Route::get('customers/{id}', 'get_customer');
        Route::put('customers/{id}', 'update');
        Route::delete('customers/{id}', 'destroy');
    });

    Route::controller(AgentController::class)->group(function(){
        Route::post('agents', 'store');
        Route::get('agents', 'index');
    });


    Route::controller(ProductCategoryController::class)->group(function(){
        Route::get('product-categories', 'index');
        Route::get('product-categories/{productCategoryId}', 'show');
        Route::post('product-categories', 'store');
        Route::put('product-categories/{productCategoryId}', 'update');
        Route::delete('product-categories/{productCategoryId}', 'destroy');
    });
    

    Route::controller(OrderController::class)->group(function(){
        Route::post('orders', 'save_order');
        Route::get('orders', 'index');
    });

    Route::controller(PriceCodeController::class)->group(function(){
        Route::post('price-codes', 'store');
        Route::get('price-codes', 'index');
        Route::put('price-codes/{priceCodeId}', 'update');
        Route::delete('price-codes/{priceCodeId}', 'destroy');
    });

    Route::controller(GoldTransactionController::class)->group(function(){
        Route::post('gold-transactions', 'store');
        Route::get('gold-transactions', 'index');
    });
    Route::controller(TransactionTypeController::class)->group(function(){
        Route::get('transaction-types','index');
        Route::post('transaction-types','store');
    });
    //department
    Route::controller(DepartmentController::class)->group(function(){
        Route::get('departments','index');
        Route::post('departments','store');
        Route::put('departments','update');
    });
    Route::controller(ProductController::class)->group(function(){
        Route::get('products','index');
        Route::get('products/category/{productCategoryId}','products_by_category');
        Route::post('products','store');
        Route::get('products/customer/{customerId}','getProductsByCustomer');
    });

    // for employees
    
    Route::controller(EmployeeController::class)->prefix('employees')->group(function(){
        Route::get('/','index');
        Route::get('/{id}','show');
        Route::post('/','store');
        Route::put('/{employeeId}','update');
        Route::delete('/{employeeId}','destroy');
    });
});
