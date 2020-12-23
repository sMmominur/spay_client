<?php

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

Route::get('/', function () {
    return view('index');
});

Route::post('/send','App\Http\Controllers\SPClientController@send')->name('sp_send');
Route::post('/spay_response', 'App\Http\Controllers\SPClientController@response')->name('sp_response');