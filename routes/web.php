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

//CodeTemplate routes that only admins shall use
Route::group(['prefix' => 'codeTemplate'], function () {
    Route::get('/details/{id}', 'App\Http\Controllers\CodeTemplateController@details_admin')->name('codeTemplate.details');
    Route::post('/add', 'App\Http\Controllers\CodeTemplateController@add_code')->name('codeTemplate.add_code');
    Route::get('/create', 'App\Http\Controllers\CodeTemplateController@create')->name('codeTemplate.create');
    Route::get('/list', 'App\Http\Controllers\CodeTemplateController@list_admin')->name('codeTemplate.list');
    Route::post('/save', 'App\Http\Controllers\CodeTemplateController@save')->name('codeTemplate.save');
    Route::delete('/delete/{id}', 'App\Http\Controllers\CodeTemplateController@delete')->name('codeTemplate.delete');
});

//Code routes for general use
Route::group(['prefix' => 'code'], function () {
    Route::get('/list', 'App\Http\Controllers\CodeTemplateController@list')->name('code.list');
    Route::get('/details/{id}', 'App\Http\Controllers\CodeTemplateController@details')->name('code.details');
});

Route::group(['prefix' => 'cart'], function () {
    Route::get('/index', 'App\Http\Controllers\ShoppingController@index')->name('cart.index');
    Route::get('/add/{id}', 'App\Http\Controllers\ShoppingController@add_one')->name('cart.addOne');
    Route::post('/add', 'App\Http\Controllers\ShoppingController@add')->name('cart.add');
    Route::get('/removeItem/{id}', 'App\Http\Controllers\ShoppingController@removeItem')->name('cart.removeItem');
    Route::get('/removeAll', 'App\Http\Controllers\ShoppingController@removeAll')->name('cart.removeAll');
    Route::get('/buy', 'App\Http\Controllers\ShoppingController@buy')->name('cart.buy');
});

Route::group(['prefix' => 'payment'], function () {
    Route::post('/buy', 'App\Http\Controllers\PayHistoryController@createPayment')->name('payhistory.create');
    Route::post('/finish', 'App\Http\Controllers\PayHistoryController@finishPayment')->name('payhistory.finish');
});

Route::group(['prefix' => 'user'], function () {
    
});

