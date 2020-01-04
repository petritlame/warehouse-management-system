<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    //products
    Route::get('/', 'ProductsController@index');
    Route::get('/{category}', 'ProductsController@show')->name('magazina');
    Route::get('/product/{id}', 'ProductsController@edit');
    Route::post('/product/add', 'ProductsController@store')->name('add_product');
    Route::post('/product/update', 'ProductsController@update')->name('update_product');
    Route::get('/product/delete/{id}', 'ProductsController@destroy')->name('delete_product');
});

