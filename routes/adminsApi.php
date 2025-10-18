<?php

use App\Http\Controllers\Admins\{AdminController, AuthController, BrandController, CategoryController, FileController, ItemController, LangController, OrderController, SearchController, UserController};
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function () {
    Route::post('/signup', 'signup');
    Route::post('/login', 'Login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

Route::apiResource('/admin', AdminController::class)->middleware('auth:sanctum');
Route::apiResource('/user', UserController::class)->middleware('auth:sanctum');
Route::apiResource('/brand', BrandController::class)->middleware('auth:sanctum');
Route::apiResource('/category', CategoryController::class)->middleware('auth:sanctum');
Route::apiResource('/item', ItemController::class)->middleware('auth:sanctum');
Route::apiResource('/order', OrderController::class)->middleware('auth:sanctum');

Route::controller(FileController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('/file/upload', 'upload');
    Route::get('/file/download/{name}', 'download');
    Route::post('/file/delete/{tableName}', 'destroy');
});

Route::controller(SearchController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/search/categories', 'categories');
    Route::get('/search/brands', 'brands');

});

Route::post('/lang', [LangController::class, 'store'])->middleware('auth:sanctum');
