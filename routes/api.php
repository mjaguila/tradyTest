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

Route::post('accounts/create', 'App\Http\Controllers\AccountController@store');
Route::post('accounts/transfer', 'App\Http\Controllers\AccountController@transfer');
Route::get('accounts/balance/{id}', 'App\Http\Controllers\AccountController@balance');


