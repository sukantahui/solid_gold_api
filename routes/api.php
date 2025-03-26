<?php

use App\Http\Controllers\Api\AuthController;

use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

// token is required
Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('/me', function(Request $request) {
        return auth()->user();
    });
    Route::controller(AuthController::class)->group(function(){
        Route::get('me', 'getCurrentUser');
        Route::get('logout', 'logout');
    });
});
