<?php

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

Route::controller(App\Api\V1\Http\Controllers\ShoppingCart\ShoppingCartController::class)
->middleware('auth:sanctum')
->prefix('/shopping-cart')
->as('shopping_cart.')
->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::put('/update', 'update')->name('update');
    Route::delete('/delete', 'delete')->name('delete');
});

//product category
Route::prefix('/product-category')
->as('product_category.')
->group(function () {
    Route::controller(App\Api\V1\Http\Controllers\ProductCategory\ProductCategoryController::class)
    ->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/show/{id}', 'show')->name('show');
    });
});

//product
Route::prefix('/product')
->as('product.')
->group(function () {
    Route::controller(App\Api\V1\Http\Controllers\Product\ProductController::class)
    ->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/show/{id}', 'show')->name('show');
    });
});

//category
Route::controller(App\Api\V1\Http\Controllers\Category\CategoryController::class)
->prefix('/categories')
->as('category.')
->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/show/{id}', 'show')->name('show');
});


//posts
Route::controller(App\Api\V1\Http\Controllers\Post\PostController::class)
->prefix('/posts')
->as('post.')
->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/show/{id}', 'show')->name('show');
    Route::get('/related/{id}', 'related')->name('related');
});

//auth
Route::controller(App\Api\V1\Http\Controllers\Auth\AuthController::class)
->group(function () {
    Route::middleware('auth:sanctum')->prefix('/auth')->as('auth.')->group(function(){
        Route::get('/', 'show')->name('show');
        Route::put('/', 'update')->name('update');
        Route::put('/update-password', 'updatePassword')->name('update_password');
    });
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
});

Route::controller(App\Api\V1\Http\Controllers\Auth\ResetPasswordController::class)
->prefix('/reset-password')
->as('reset_password.')
->group(function(){
    Route::post('/', 'checkAndSendMail')->name('check_and_send_mail');
});

Route::fallback(function(){
    return response()->json([
        'status' => 404,
        'message' => __('Không tìm thấy đường dẫn.')
    ], 404);
});