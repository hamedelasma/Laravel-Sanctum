<?php

use App\Http\Controllers\ProductController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::resource('product', ProductController::class);
//Public Routes
Route::get('product',[ProductController::class,'index']);
Route::get('product/{id}',[ProductController::class,'show']);
Route::get('product/search/{search}',[ProductController::class,'search']);


//Private Routes
Route::group(['middleware'=>['auth:sanctum']], function () {
    Route::post('product',[ProductController::class,'store']);
    Route::match(['put','patch'],'product/{product}',[ProductController::class,'update']);
    Route::delete('product/{product}',[ProductController::class,'destroy']);

});
