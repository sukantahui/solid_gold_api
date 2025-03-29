<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\CustomerCategoryController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CustomerController;
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

    Route::controller(CustomerCategoryController::class)->group(function(){
        Route::post('customerCategories', 'store');
        Route::get('customerCategories', 'index');
        Route::delete('customerCategories/{id}', 'destroy');
    });


});
