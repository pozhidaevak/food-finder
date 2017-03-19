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
use  \App\Http\Controllers\RestaurantController;
use \App\Models\Restaurant;

Route::get('/', function () {
    $locale = Cookie::get('lang', App::getLocale());
    return redirect($locale);
});
Route::get('{locale}/', 'RestaurantController@index');

Route::get('{locale}/{id}', 'RestaurantController@show');
