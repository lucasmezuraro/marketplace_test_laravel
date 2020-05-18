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

Route::group(['middleware' => ['guest:api']], function () {
    Route::post('/login', 'LoginController@login')->name('login');
    Route::post('register', 'LoginController@register');
});

Route::group(['middleware' => ['json.response', 'auth:api']], function () {
    Route::get('/', function () {
        return \Response::json(['message' => 'Olá'], 200);
    });
    Route::get('products', 'ProductController@index');
    Route::post('product', 'ProductController@create');
    Route::put('product/{id}', 'ProductController@update');
    Route::delete('product/{id}', 'ProductController@destroy');

    Route::get('categories', 'CategoryController@index');
    Route::post('category', 'CategoryController@create');
    Route::put('category/{id}', 'CategoryController@update');
    Route::delete('category/{id}','CategoryController@destroy');
    
    
    Route::get('logout', 'LoginController@logout');

    Route::get('my', 'CustomerController@index');
    Route::post('customer', 'CustomerController@create');
    Route::put('customer/{id}', 'CustomerController@update');
    Route::delete('customer/{id}', 'CustomerController@destroy');
});

