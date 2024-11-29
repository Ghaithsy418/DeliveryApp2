<?php

use App\Http\Controllers\api\v1\ProductController;
use App\Http\Controllers\api\v1\StoreController;
use App\Http\Controllers\api\v1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

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



Route::group(["prefix"=>"v1"],function(){
    Route::group(["middleware" => ["auth:sanctum"]],function(){
        Route::apiResource("stores",StoreController::class);
        Route::delete("/delete-all/{id}",[StoreController::class,"destroyAll"]);
        Route::apiResource("products",ProductController::class);
        Route::apiResource("users",UserController::class);
        Route::post("/logout",[UserController::class,"Logout"]);
        Route::get("/purchases",[UserController::class,"purchasedProducts"]);
        Route::get("/search/{name}",[UserController::class,"search"]);
    });
    Route::post("/register",[UserController::class,"Register"]);
    Route::post("/login",[UserController::class,"Login"]);
});
