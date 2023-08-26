<?php

use App\Http\Controllers\API\V1\Buyer\BuyerTransactionController;
use App\Http\Controllers\API\V1\Buyer\BuyerCategoryController;
use App\Http\Controllers\API\V1\Buyer\BuyerProductController;
use App\Http\Controllers\API\V1\Buyer\BuyerSellerController;
use App\Http\Controllers\API\V1\Buyer\BuyerController;

use App\Http\Controllers\API\V1\Category\CategoryTransactionController;
use App\Http\Controllers\API\V1\Category\CategoryProductController;
use App\Http\Controllers\API\V1\Category\CategorySellerController;
use App\Http\Controllers\API\V1\Category\CategoryBuyerController;
use App\Http\Controllers\API\V1\Category\CategoryController;

use App\Http\Controllers\API\V1\Product\ProductBuyerTransactionController;
use App\Http\Controllers\API\V1\Product\ProductTransactionController;
use App\Http\Controllers\API\V1\Product\ProductCategoryController;
use App\Http\Controllers\API\V1\Product\ProductBuyerController;
use App\Http\Controllers\API\V1\Product\ProductController;

use App\Http\Controllers\API\V1\Seller\SellerTransactionController;
use App\Http\Controllers\API\V1\Seller\SellerCategoryController;
use App\Http\Controllers\API\V1\Seller\SellerProductController;
use App\Http\Controllers\API\V1\Seller\SellerBuyerController;
use App\Http\Controllers\API\V1\Seller\SellerController;

use App\Http\Controllers\API\V1\Transaction\TransactionCategoryController;
use App\Http\Controllers\API\V1\Transaction\TransactionController;
use App\Http\Controllers\API\V1\Transaction\TransactionSellerController;

use App\Http\Controllers\API\V1\User\UserController;

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

/**
 * Users
 */
Route::apiResource('users', UserController::class);
Route::name('verify')->get('users/verify/{token}', [UserController::class, 'verify']);
Route::name('resend')->get('users/{user}/resend', [UserController::class, 'resend']);

/**
 * Categories
 */
Route::apiResource('categories', CategoryController::class);

Route::name('categories.transactions.index')
->get('categories/{category}/transactions', CategoryTransactionController::class);

Route::name('categories.sellers.index')
->get('categories/{category}/sellers', CategorySellerController::class);

Route::name('categories.products.index')
->get('categories/{category}/products', CategoryProductController::class);

Route::name('categories.buyers.index')
->get('categories/{category}/buyers', CategoryBuyerController::class);

/**
 * Buyers
 */
Route::apiResource('buyers', BuyerController::class)
        ->only(['index', 'show']);

Route::name('buyers.transactions.index')
->get('buyers/{buyer}/transactions', BuyerTransactionController::class);

Route::name('buyers.sellers.index')
->get('buyers/{buyer}/sellers', BuyerSellerController::class);

Route::name('buyers.products.index')
->get('buyers/{buyer}/products', BuyerProductController::class);

Route::name('buyers.categories.index')
->get('buyers/{buyer}/categories', BuyerCategoryController::class);

/**
 * Sellers
 */
Route::apiResource('sellers', SellerController::class)
        ->only(['index', 'show']);

Route::name('sellers.transactions.index')
->get('sellers/{seller}/transactions', SellerTransactionController::class);

Route::name('sellers.categories.index')
->get('sellers/{seller}/categories', SellerCategoryController::class);

Route::name('sellers.buyers.index')
->get('sellers/{seller}/buyers', SellerBuyerController::class);

Route::apiResource('sellers.products', SellerProductController::class)
        ->only(['index', 'store', 'update', 'destroy']);

/**
 * Products
 */
Route::apiResource('products', ProductController::class)
        ->only(['index', 'show']);

Route::name('products.transactions.index')
->get('products/{product}/transactions', ProductTransactionController::class);

Route::name('products.buyers.index')
->get('products/{product}/buyers', ProductBuyerController::class);

Route::apiResource('products.categories', ProductCategoryController::class)
        ->only(['index', 'update', 'destroy']);

Route::post('products/{product}/buyers/{buyer}/transactions', ProductBuyerTransactionController::class);

/**
 * Transactions
 */
Route::apiResource('transactions', TransactionController::class)
        ->only(['index', 'show']);

Route::name('transactions.categories.index')
->get('transactions/{transaction}categories', TransactionCategoryController::class);

Route::name('transactions.sellers.index')
->get('transactions/{transaction}/sellers', TransactionSellerController::class);


Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');