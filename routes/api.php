<?php

use App\Http\Controllers\API\V1\Category\CategoryController;
use App\Http\Controllers\API\V1\Seller\SellerController;
use App\Http\Controllers\API\V1\Buyer\BuyerController;
use App\Http\Controllers\API\V1\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('users', UserController::class);

Route::apiResource('categories', CategoryController::class);

Route::apiResource('buyers', BuyerController::class)
        ->only(['index', 'show']);

Route::apiResource('sellers', SellerController::class)
        ->only(['index', 'show']);
