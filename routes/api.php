<?php

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
Route::get('products', 'ProductController@index');
Route::get('products/{id}', 'ProductController@show');
Route::get('catproduct/{id}', 'ProductController@searchbycat');
Route::get('categories', 'CategoryController@index');
Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');
Route::delete('products/delete/{id}', 'ProductController@destroy');
Route::get('products/edit/{id}', 'ProductController@edit');
Route::group(['middleware' => 'auth:api'], function(){
    Route::get('details', 'UserController@details');
    Route::get('productuser', 'ProductController@getProduct');
    Route::get('productmessage', 'NotificationController@getMessage');
    Route::resource('fileupload', 'ImageuploadController');
    Route::post('products/store', 'ProductController@store');
    Route::post('products/update/{id}', 'ProductController@update');
    Route::post('profiles/store', 'ProfileController@store');
    Route::post('notifications/store', 'NotificationController@store');
    Route::post('user/update', 'UserController@update');

});


