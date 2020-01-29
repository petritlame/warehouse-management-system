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
    Route::group(['middleware' => ['admin']], function () {
        //products
        Route::get('/', 'ProductsController@index');
        Route::get('/product/{category}', 'ProductsController@show')->name('magazina');
        Route::get('/show_product/{id}', 'ProductsController@edit');
        Route::post('/product/add', 'ProductsController@store')->name('add_product');
        Route::post('/product/update', 'ProductsController@update')->name('update_product');
        Route::get('/product/delete/{id}', 'ProductsController@destroy')->name('delete_product');

        //category
        Route::get('/categories', 'CategoriesController@index')->name('categories');
        Route::post('/categories/add', 'CategoriesController@store')->name('add_category');
        Route::get('/categories/{id}', 'CategoriesController@show');
        Route::get('/categories/delete/{id}', 'CategoriesController@destroy')->name('delete_category');
        Route::get('/categories/edit', 'CategoriesController@destroy')->name('delete_category');
        Route::post('/categories/update', 'CategoriesController@update')->name('update_category');

        //arka
        Route::get('/arka', 'ArkaController@index')->name('arka');
        Route::post('/arka/add', 'ArkaController@store')->name('add_arka');
        Route::get('/arka/{month}', 'ArkaController@show')->name('show_arka');

        //agjenti
        Route::post('/agent/add', 'AgentController@store')->name('add_agent');
        Route::get('/agent/{id}', 'AgentController@show')->name('show_agent');
        Route::post('/agent/update', 'AgentController@update')->name('update_agent');
        Route::get('/agent/delete/{id}', 'AgentController@destroy')->name('delete_agent');
        Route::get('/agent/generate_invoice/{id}', 'AgentController@generateInvoice')->name('generateAgentInvoice');


        //makinat
        Route::get('/makinat', 'MakinaController@index')->name('makinat');
        Route::post('/makina/add', 'MakinaController@store')->name('add_makina');
        Route::get('/makina/delete/{id}', 'MakinaController@destroy')->name('delete_makina');

        //makinat produkte
        Route::get('/products/makina', 'CarProductsController@index')->name('products');
        Route::get('/products/makina/category/{id}', 'CarProductsController@productByCategory');
        Route::get('/products/makina/{id}', 'CarProductsController@showCar')->name('add_products');
        Route::post('/product/makina/add', 'CarProductsController@store')->name('add_products');
        Route::post('/product/makina/update/', 'CarProductsController@updateSasia')->name('update_products');
        Route::get('/product/makina/delete/{id}', 'CarProductsController@destroy')->name('delete_products');
        Route::get('/product/makina/delete/{id}', 'CarProductsController@destroy')->name('delete_products');
        Route::get('/product/makina/invoice', 'CarProductsController@generateInvoice')->name('generateInvoice');
        Route::post('/product/makina/invoice_item/', 'CarProductsController@addInvoiceItem')->name('addInvoiceItem');
    });

        Route::get('/agents', 'AgentController@index')->name('agents');
        Route::get('/agent/show/{id}', 'AgentController@singleAgent')->name('singleAgent');
});

