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

Route::get('/', function () {
    return redirect()->route('product.index');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/product/data','ProductController@getData')->name('product.data')->middleware('auth');
Route::post('product/detail/all','ProductController@allDownload')->name('product.all')->middleware('auth');

Route::resource('/product','ProductController')->except('show')->middleware('auth');
Route::get('/product/{product}/{ukuran?}','ProductController@show')->name('product.show')->middleware('auth');


