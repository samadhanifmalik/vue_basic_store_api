<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('register', 'registerUser');
    Route::post('login', 'loginUser');
});
// Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::resource('/category',CategoryController::class)->only('index', 'store', 'show', 'destroy');
    Route::post('category/{category}', [CategoryController::class, 'update'])->name('category.update');
// });ProductController

Route::resource('/product',ProductController::class)->only('index', 'store', 'show', 'destroy');
Route::post('product/{category}', [ProductController::class, 'update'])->name('product.update');

Route::resource('/cart',CartController::class);


// Route::post('/auth/register', [AuthController::class, 'registerUser']);
// Route::post('/auth/login', [AuthController::class, 'loginUser']);

