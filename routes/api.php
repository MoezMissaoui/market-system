<?php

use App\Http\Controllers\API\V1\Buyer\BuyerCategoryController;
use App\Http\Controllers\API\V1\Buyer\BuyerProductController;
use App\Http\Controllers\API\V1\Buyer\BuyerSellerController;
use App\Http\Controllers\API\V1\Buyer\BuyerTransactionController;
use App\Http\Controllers\API\V1\Transaction\TransactionCategoryController;
use App\Http\Controllers\API\V1\Transaction\TransactionSellerController;
use App\Http\Controllers\API\V1\Category\CategoryController;
use App\Http\Controllers\API\V1\Product\ProductController;
use App\Http\Controllers\API\V1\Seller\SellerController;
use App\Http\Controllers\API\V1\Buyer\BuyerController;
use App\Http\Controllers\API\V1\User\UserController;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
Route::get('buyers/{buyer}/transactions', BuyerTransactionController::class);
Route::get('buyers/{buyer}/sellers', BuyerSellerController::class);
Route::get('buyers/{buyer}/products', BuyerProductController::class);
Route::get('buyers/{buyer}/categories', BuyerCategoryController::class);


Route::apiResource('sellers', SellerController::class)
        ->only(['index', 'show']);

Route::apiResource('products', ProductController::class)
        ->only(['index', 'show']);

Route::get('transactions/{transaction}categories', TransactionCategoryController::class);
Route::get('transactions/{transaction}/sellers', TransactionSellerController::class);