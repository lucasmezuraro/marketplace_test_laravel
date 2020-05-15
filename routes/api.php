<?php

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
Route::group(['middleware' => ['json.response']], function () {
    Route::get('products', 'ProductController@index');
    Route::post('product', 'ProductController@create');
    Route::put('product/{id}', 'ProductController@update');
    Route::delete('product/{id}', 'ProductController@destroy');

    Route::get('categories', 'CategoryController@index');
    Route::post('category', 'CategoryController@create');
    Route::put('category/{id}', 'CategoryController@update');
    Route::delete('category/{id}','CategoryController@delete');    
});

