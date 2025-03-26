<?php

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


Route::controller(CustomerController::class)->group(function(){
    Route::post('save', 'store');
});

// token is required
Route::group(['middleware' => 'auth:sanctum'], function(){
    //under Auth Controller
    Route::controller(AuthController::class)->group(function(){
        Route::get('me', 'getCurrentUser');
        Route::get('logout', 'logout');
        Route::get('revokeAll', 'revoke_all');

    });
});
