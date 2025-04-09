<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\PriceCodeController;
use App\Http\Controllers\CustomerCategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductCategoryController;
use Illuminate\Support\Facades\Route;

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
    });

    Route::controller(AgentController::class)->group(function(){
        Route::post('agents', 'store');
        Route::get('agents', 'index');
    });


    Route::controller(ProductCategoryController::class)->group(function(){
        Route::post('product-categories', 'store');
        Route::get('product-categories', 'index');
        Route::put('product-categories/{id}', 'update');
        Route::delete('product-categories/{id}', 'destroy');
    });

    Route::controller(OrderController::class)->group(function(){
        Route::post('orders', 'save_order');
        Route::get('orders', 'index');
    });

    Route::controller(PriceCodeController::class)->group(function(){
        Route::post('price-codes', 'store');
        Route::get('orders', 'index');
    });

});
