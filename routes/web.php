<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home.index');

Auth::routes();

//Admin specific routes
Route::group(['prefix' => 'admin'], function () {
    Route::get('/details/{id}', 'App\Http\Controllers\AdminController@details')->name('codeTemplate.details');
    Route::post('/add', 'App\Http\Controllers\AdminController@addCode')->name('codeTemplate.addCode');
    Route::get('/create', 'App\Http\Controllers\AdminController@create')->name('codeTemplate.create');
    Route::get('/codeTemplates', 'App\Http\Controllers\AdminController@list')->name('codeTemplate.list');
    Route::post('/save', 'App\Http\Controllers\AdminController@save')->name('codeTemplate.save');
    Route::delete('/delete/{id}', 'App\Http\Controllers\AsminController@delete')->name('codeTemplate.delete');
    Route::get('/update', 'App\Http\Controllers\AdminController@update')->name('codeTemplate.update');
    Route::post('/update', 'App\Http\Controllers\AdminController@saveUpdate')->name('codeTemplate.saveUpdate');
    Route::get('/orders', 'App\Http\Controllers\AdminController@listOrders')->name('orders.list');
});

//Code routes for general use
Route::group(['prefix' => 'code'], function () {
    Route::get('/list', 'App\Http\Controllers\CodeTemplateController@list')->name('code.list');
    Route::get('/random', 'App\Http\Controllers\CodeTemplateController@random')->name('code.random');
    Route::get('/details/{id}', 'App\Http\Controllers\CodeTemplateController@details')->name('code.details');
    Route::get('/search/', 'App\Http\Controllers\CodeTemplateController@search')->name('code.search');
});

Route::group(['prefix' => 'cart'], function () {
    Route::get('/index', 'App\Http\Controllers\ShoppingController@index')->name('cart.index');
    Route::get('/add/{id}', 'App\Http\Controllers\ShoppingController@addOne')->name('cart.addOne');
    Route::post('/add', 'App\Http\Controllers\ShoppingController@add')->name('cart.add');
    Route::get('/removeItem/{id}', 'App\Http\Controllers\ShoppingController@removeItem')->name('cart.removeItem');
    Route::get('/removeAll', 'App\Http\Controllers\ShoppingController@removeAll')->name('cart.removeAll');
    Route::get('/buy', 'App\Http\Controllers\ShoppingController@buy')->name('cart.buy');
});

Route::group(['prefix' => 'payment'], function () {
    Route::post('/buy', 'App\Http\Controllers\PayHistoryController@createPayment')->name('payhistory.create');
    Route::post('/finish', 'App\Http\Controllers\PayHistoryController@finishPayment')->name('payhistory.finish');
    Route::get('/{payment_id}', 'App\Http\Controllers\PayHistoryController@showOne')->name('payhistory.showOne');
    Route::get('/pdf/{payment_id}', 'App\Http\Controllers\PayHistoryController@createPDF')->name('payhistory.createPDF');
});

Route::group(['prefix' => 'user'], function () {
    Route::group(['prefix' => 'payhistory'], function () {
        Route::get('/', 'App\Http\Controllers\PayHistoryController@showAll')->name('payhistory.showAll');
    });
});

Route::group(['prefix' => 'responses'], function () {
    Route::get('/animes', 'App\Http\Controllers\ApisController@animes')->name('responses.animes');
});
